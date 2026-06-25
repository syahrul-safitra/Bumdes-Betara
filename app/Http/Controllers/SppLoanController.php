<?php

namespace App\Http\Controllers;

use App\Models\SppGroup;
use Illuminate\Http\Request;
use App\Models\SppLoan;
use App\Models\User;
use App\Models\SppDisbursement;
use App\Models\SppInstallment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use illuminate\Support\Facades\Auth;

use Barryvdh\DomPDF\Facade\Pdf;

class SppLoanController extends Controller
{
    
    public function index(Request $request) {

        $status = $request->get('status', 'review');

        $loans = SppLoan::with('group')
            ->where('status_loan', $status)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Admin.SPP.Loan.index2', [
            'loans' => $loans,
            'status' => $status,
            // 'no_rek' => User::select('no_rek')->where('id', 1)->get()
        ]);

    }

    public function approve(Request $request, SppLoan $loan)
    {

        $request->validate([
            'no_kontrak' => 'required|string|unique:spp_loans,no_kontrak',
            'file_dokumen_perjanjian' => 'required|max:5120', 
            'bukti_transfer' => 'nullable|max:2048'
        ], [
            'no_kontrak.required' => 'Nomor kontrak resmi wajib diisi.',
            'no_kontrak.unique' => 'Nomor kontrak sudah digunakan oleh kelompok lain.',
            'file_dokumen_perjanjian.required' => 'Berkas PDF jaminan/perjanjian wajib diunggah.',
            'file_dokumen_perjanjian.mimes' => 'Format dokumen harus berupa berkas PDF.'
        ]);

        $loan = SppLoan::findOrFail($loan->id);
        $plafon = $loan->nominal_pengajuan;
        $tenor = $loan->tenor_bulan;

        // DB Transaction mengunci integritas 3 tabel sekaligus (loans, disbursements, installments)
        DB::beginTransaction();

        try {
            // 1. Pindahkan berkas PDF ke folder /public/File/ menggunakan metode move
            if ($request->hasFile('file_dokumen_perjanjian')) {
                $file = $request->file('file_dokumen_perjanjian');
                $filename = 'SPK_' . time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                $file->move(public_path('File/SPP/Berkas'), $filename);
                
                // Simpan nama file ke object model/database Anda, contoh:
                // $loan->file_dokumen_perjanjian = $filename;
            }

            $filenameTransfer = 'null';

            // 2. Pindahkan berkas Bukti Transfer ke folder /public/File/ menggunakan metode move
            if ($request->hasFile('bukti_transfer')) {
                $fileTransfer = $request->file('bukti_transfer');
                // Membuat nama unik berkas dengan prefix TF_SPP_
                $filenameTransfer = 'TF_SPP_' . time() . '_' . str_replace(' ', '_', $fileTransfer->getClientOriginalName());
                $fileTransfer->move(public_path('File/SPP/Berkas'), $filenameTransfer);

                // Simpan nama file ke object model/database Anda, contoh:
                // $loan->bukti_transfer = $filenameTransfer;
            }

            // 2. Update data induk pinjaman
            $loan->update([
                'no_kontrak' => $request->no_kontrak,
                'plafon_disetujui' => $plafon,
                'total_dicairkan' => 2000000.00, // Nominal dana awal mutlak 2 Juta
                'file_dokumen_perjanjian' => $filename,
                'bukti_transfer' => $filenameTransfer, // 🔥 REVISI BARU: Menyimpan berkas bukti transfer resmi
                'status_loan' => 'disetujui', // Berubah jadi disetujui (siap melangkah ke angsuran 1)
                'status_pencairan' => 'cair_awal'
            ]);
            
            // 3. Catat transaksi pencairan tahap 1 ke tabel spp_disbursements
            SppDisbursement::create([
                'loan_id' => $loan->id,
                'tahap_ke' => 1,
                'jumlah_cair' => 2000000.00,
                'tanggal_cair' => Carbon::now()->toDateString(),
                'bukti_pencairan' => null 
            ]);

            // 4. LOGIKA OTOMATISASI: Generate jadwal angsuran bulanan (spp_installments)
            $pokokPerBulan = round($plafon / $tenor);
            $jasaPerBulan = round($plafon * 0.005); // Bunga flat 0.5% dari total pinjaman
            
            $tanggalAcuan = Carbon::now(); // Jatuh tempo dihitung dari tanggal persetujuan hari ini

            for ($i = 1; $i <= $tenor; $i++) {
                // Tanggal jatuh tempo bertambah 1 bulan untuk setiap baris angsuran
                $jatuhTempo = $tanggalAcuan->copy()->addMonths($i)->toDateString();

                SppInstallment::create([
                    'loan_id' => $loan->id,
                    'angsuran_ke' => $i,
                    'jumlah_pokok' => $pokokPerBulan,
                    'jumlah_bunga' => $jasaPerBulan,
                    'tanggal_jatuh_tempo' => $jatuhTempo,
                    'tanggal_bayar' => null,
                    'denda_kumulatif' => 0,
                    'status_bayar' => 'belum_bayar'
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Pinjaman disetujui! Dana awal Rp 2.000.000 dicairkan & ' . $tenor . ' bulan jadwal angsuran otomatis terbentuk.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal memproses persetujuan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, SppLoan $loan)
    {

        $request->validate([
            'alasan_penolakan_loan' => 'required|string|max:500'
        ], [
            'alasan_penolakan_loan.required' => 'Anda wajib menyertakan alasan penolakan pinjaman.'
        ]);

        $loan = SppLoan::findOrFail($loan->id);

        $loan->update([
            'status_loan' => 'ditolak',
            'alasan_penolakan_loan' => $request->alasan_penolakan_loan
        ]);

        return redirect()->back()->with('success', 'Pengajuan pinjaman kelompok berhasil ditolak.');
    }

    public function disburseTahap2(Request $request, SppLoan $loan)
    {

        // PROTEKSI 1: Pastikan status loan sudah 'berjalan' (Angsuran 1 harus sudah lunas)
        if ($loan->status_loan !== 'berjalan') {
            return redirect()->back()->with('error', 'Gagal. Gembok Pencairan Tahap 2 masih terkunci hingga kelompok menyelesaikan pembayaran Angsuran Bulan Ke-1.');
        }

        // PROTEKSI 2: Mencegah double klik / pencairan berulang
        if ($loan->status_pencairan === 'cair_semua') {
            return redirect()->back()->with('error', 'Sisa dana modal untuk kelompok ini sudah dicairkan sebelumnya.');
        }

        // Hitung selisih sisa dana (Total Plafon - Rp 2.000.000 dana awal)
        $sisaDana = $loan->plafon_disetujui - 2000000.00;

        // Gunakan DB Transaction demi keamanan mutasi kas database
        DB::beginTransaction();

        try {
            // 1. Mutasikan data plafon yang dicairkan pada tabel induk spp_loans
            $loan->update([
                'total_dicairkan' => $loan->plafon_disetujui, // Set langsung penuh seharga plafon asli
                'status_pencairan' => 'cair_penuh'            // Set status tanda pencairan selesai
            ]);

            // 2. Bukukan riwayat mutasi keluar baru di tabel spp_disbursements sebagai Tahap Ke-2
            SppDisbursement::create([
                'loan_id' => $loan->id,
                'tahap_ke' => 2,
                'jumlah_cair' => $sisaDana,
                'tanggal_cair' => Carbon::now()->toDateString(),
                'bukti_pencairan' => null // Kelak bisa di-update jika ingin fitur upload struk kwitansi bank
            ]);

            DB::commit();
            
            return redirect()->back()->with('success', 'Sisa dana modal kelompok sebesar Rp ' . number_format($sisaDana, 0, ',', '.') . ' berhasil dicairkan! Pembukuan Tahap 2 selesai dilakukan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengeksekusi pencairan tahap 2: ' . $e->getMessage());
        }
    }

    public function sppLoanAll()
    {
        // Ambil data user/kelompok yang sedang login
        $user = Auth::guard('spp')->user(); 

        // Ambil semua riwayat pinjaman milik kelompok ini (dari yang terbaru)
        // Asumsi: Di tabel spp_loans terdapat kolom group_id yang berelasi dengan user/group yang login
        $loans = SppLoan::where('group_id', $user->group_id ?? $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('SPPMember.loanAll', compact('loans'));
    }

    public function showLoan(SppLoan $loan)
    {

        $user = Auth::guard('spp')->user();
        $groupId = $user->group_id ?? $user->id;

        // Tarik data pinjaman dan pastikan pinjaman ini memang milik kelompok yang login (Proteksi Keamanan)
        $loan = SppLoan::where('id', $loan->id)
            ->where('group_id', $groupId)
            ->firstOrFail();
        
        // Tarik semua daftar angsuran bulanannya
        $installments = SppInstallment::where('loan_id', $loan->id)
            ->orderBy('angsuran_ke', 'asc')
            ->get();

        $noRek = User::select('no_rek')->where('id', 1)->get();

        return view('SPPMember.installments', compact('loan', 'installments', 'noRek'));
    }


    // public function payInstallmentRev(Request $request, SppInstallment $installment) {
    
    //         $request->validate([
    //             'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //         ], [
    //             'bukti_pembayaran.required' => 'Bukti transfer wajib diunggah.',
    //             'bukti_pembayaran.image' => 'Berkas harus berupa dokumen gambar.',
    //             'bukti_pembayaran.mimes' => 'Format gambar yang didukung hanya jpeg, png, atau jpg.',
    //             'bukti_pembayaran.max' => 'Ukuran gambar maksimal adalah 2MB.',
    //         ]);

    //         // Cari data angsuran berdasarkan ID transaksi baris tabel
    //         // Keamanan tambahan: Pastikan angsuran yang dipilih memang belum lunas
    //         if ($installment->status_bayar === 'lunas') {
    //             return redirect()->back()->with('error', 'Angsuran bulan ini sudah berstatus lunas sebelumnya.');
    //         }

    //         try {
    //             DB::transaction(function () use ($request, $installment) {
                    
    //                 // ====================================================
    //                 // 🔥 LOGIKA BARU: HITUNG DENDA KETERLAMBATAN NYATA
    //                 // ====================================================
    //                 $dueDate = Carbon::parse($installment->tanggal_jatuh_tempo);
    //                 $today = Carbon::today();
    //                 $nominalDenda = 0;
    //                 $dendaPerHari = 5000; // Sesuai aturan denda sistem Anda

    //                 // Jika hari ini sudah melewati tanggal jatuh tempo, hitung dendanya
    //                 if ($today->gt($dueDate)) {
    //                     $selisihHari = $today->diffInDays($dueDate);
    //                     $nominalDenda = $selisihHari * $dendaPerHari;
    //                 }

    //                 // Proses pemindahan berkas gambar bukti transfer
    //                 if ($request->hasFile('bukti_pembayaran')) {
    //                     $file = $request->file('bukti_pembayaran');
    //                     $filename = 'BAYAR_SPP_' . $installment->loan_id . '_ANGSURAN_' . $installment->angsuran_ke . '_' . time() . '.' . $file->getClientOriginalExtension();
    //                     $file->move(public_path('File/SPP/Berkas'), $filename);

    //                     // Update data angsuran (Simpan juga nilai denda ke database jika ada kolomnya)
    //                     $installment->update([
    //                         'status_bayar' => 'lunas',
    //                         'bukti_pembayaran' => $filename,
    //                         'tanggal_bayar' => Carbon::now(),
                            
    //                         // Sesuaikan nama kolom denda di tabel Anda (misal: 'jumlah_denda' atau 'denda')
    //                         'denda_kumulatif' => $nominalDenda, 
    //                     ]);
    //                 }

    //                 // Cek sisa tenor angsuran
    //                 $sisaAngsuran = SppInstallment::where('loan_id', $installment->loan_id)
    //                     ->where('status_bayar', 'belum_bayar')
    //                     ->count();

    //                 if ($sisaAngsuran === 0) {
    //                     SppLoan::where('id', $installment->loan_id)->update([
    //                         'status_loan' => 'lunas'
    //                     ]);
    //                 }
    //             });

    //             return redirect()->back()->with('success', 'Bukti transfer berhasil diunggah dan status dinyatakan LUNAS!');

    //         } catch (\Exception $e) {
    //             return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
    //         }
    
    // }

    public function payInstallmentRev(Request $request, SppInstallment $installment) 
    {
        // 1. Validasi Input Berkas (Wajib Gambar & Maksimal 2MB)
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'bukti_pembayaran.required' => 'Bukti transfer wajib diunggah.',
            'bukti_pembayaran.image' => 'Berkas harus berupa dokumen gambar.',
            'bukti_pembayaran.mimes' => 'Format gambar yang didukung hanya jpeg, png, atau jpg.',
            'bukti_pembayaran.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        // 2. Proteksi Keamanan: Pastikan angsuran yang dipilih memang belum lunas
        if ($installment->status_bayar === 'lunas') {
            return redirect()->back()->with('error', 'Angsuran bulan ini sudah berstatus lunas sebelumnya.');
        }

        try {
            // Jalankan Database Transaction untuk menjaga keamanan dan konsistensi data keuangan
            DB::transaction(function () use ($request, $installment) {
                
                // ====================================================
                // 💸 LOGIKA HITUNG DENDA KETERLAMBATAN NYATA
                // ====================================================
                $dueDate = Carbon::parse($installment->tanggal_jatuh_tempo);
                $today = Carbon::today();
                $nominalDenda = 0;
                $dendaPerHari = 5000; // Ketetapan denda sistem Rp 5.000 per hari

                // Jika hari ini sudah melewati tanggal jatuh tempo, hitung selisih harinya
                if ($today->gt($dueDate)) {
                    $selisihHari = $today->diffInDays($dueDate);
                    $nominalDenda = $selisihHari * $dendaPerHari;
                }

                // ====================================================
                // 📦 PROSES FILE & UPDATE TRANSAKSI
                // ====================================================
                if ($request->hasFile('bukti_pembayaran')) {
                    $file = $request->file('bukti_pembayaran');
                    
                    // Menyusun nama berkas unik agar tidak bentrok di server
                    $filename = 'BAYAR_SPP_' . $installment->loan_id . '_ANGSURAN_' . $installment->angsuran_ke . '_' . time() . '.' . $file->getClientOriginalExtension();
                    
                    // Pindahkan file fisik secara manual ke direktori publik
                    $file->move(public_path('File/SPP/Berkas'), $filename);

                    // Update baris angsuran menjadi LUNAS beserta nilai denda berjalan
                    $installment->update([
                        'status_bayar' => 'lunas',
                        'bukti_pembayaran' => $filename,
                        'tanggal_bayar' => Carbon::now(),
                        'denda_kumulatif' => $nominalDenda, 
                    ]);

                    // ====================================================
                    // 🔥 SOLUSI UTAMA: AKTIFKAN STATUS PINJAMAN MENJADI BERJALAN
                    // ====================================================
                    // Jika yang dibayar adalah angsuran ke-1, naikkan status pinjaman dari 'disetujui' ke 'berjalan'
                    // Ini pemicu utama agar tombol pencairan kedua muncul otomatis di sisi admin
                    if ($installment->angsuran_ke == 1) {
                        $installment->loan()->update([
                            'status_loan' => 'berjalan'
                        ]);
                    }
                }

                // ====================================================
                // 🔒 PENGECEKAN PELUNASAN TOTAL CONTRACT
                // ====================================================
                // Hitung sisa tenor angsuran pada pinjaman ini yang statusnya masih 'belum_bayar'
                $sisaAngsuran = SppInstallment::where('loan_id', $installment->loan_id)
                    ->where('status_bayar', 'belum_bayar')
                    ->count();

                // Jika seluruh sisa tenor angsuran sudah habis dibayar (bernilai 0), tutup pinjaman utama menjadi Lunas Total
                if ($sisaAngsuran === 0) {
                    $installment->loan()->update([
                        'status_loan' => 'lunas'
                    ]);
                }
            });

            return redirect()->back()->with('success', 'Bukti transfer berhasil diunggah. Angsuran Bulan Ke-' . $installment->angsuran_ke . ' dinyatakan LUNAS!');

        } catch (\Exception $e) {
            // Menangkap galat jika database atau folder gagal beroperasi
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }



    
    public function create() {

        return view('Admin.SPP.Loan.create', [
            'groups' => SppGroup::with('members')->latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_id'          => 'required|exists:spp_groups,id',
            'no_kontrak'        => 'required|string|max:255|unique:spp_loans,no_kontrak',
            'plafon_disetujui'  => 'required|numeric|min:100000',
            'bunga_persen'      => 'required|numeric|min:0',
            'tenor_bulan'       => 'required|integer|min:1',
        ]);

        SppLoan::create([
            'group_id'          => $request->group_id,
            'no_kontrak'        => $request->no_kontrak,
            'plafon_disetujui'  => $request->plafon_disetujui,
            'total_dicairkan'   => 0, // Awal pengajuan belum ada dana keluar
            'bunga_persen'      => $request->bunga_persen,
            'tenor_bulan'       => $request->tenor_bulan,
            'status_loan'       => 'review', // Menunggu persetujuan & pencairan awal
        ]);

        return redirect('/spp-loan')->with('success', 'Kontrak pinjaman baru berhasil diajukan! Silakan lakukan validasi berkas pada halaman detail untuk proses pencairan dana.');
    }

    public function show(SppLoan $loan) {


        // Tarik semua daftar angsuran, urutkan dari bulan ke-1 sampai akhir
        $installments = SppInstallment::where('loan_id', $loan->id)
            ->orderBy('angsuran_ke', 'asc')
            ->get();

        return view('Admin.SPP.Loan.show2', compact('loan', 'installments'));
      
        // return view('Admin.SPP.Loan.show', [
        //     'loan' => $loan->load(['group', 'installments' => function($constraints) {
        //         $constraints->orderBy('angsuran_ke', 'asc');
        //     }])
        // ]);

    }


    // ======================= lama ==================================
    // public function disburse(Request $request, SppLoan $loan)
    // {
    //     // Proteksi: Pastikan hanya status 'review' yang bisa dicairkan
    //     if ($loan->status_loan != 'review') {
    //         return redirect()->back()->with('error', 'Kontrak pinjaman ini sudah dicairkan atau sedang berjalan.');
    //     }

    //     // Gunakan Database Transaction agar jika salah satu proses gagal, data di-rollback (aman)
    //     DB::beginTransaction();

    //     try {
    //         // 1. Update status pinjaman induk menjadi berjalan
    //         $loan->update([
    //             'status_loan' => 'berjalan',
    //             'total_dicairkan' => $loan->plafon_disetujui,
    //             // 'tanggal_pencairan' => Carbon::now() // Aktifkan jika Anda punya kolomnya
    //         ]);

    //         // 2. Hitung Matematika Angsuran Bulanan SPP
    //         // Rumus Pokok: Plafon / Tenor
    //         $angsuranPokok = $loan->plafon_disetujui / $loan->tenor_bulan;
    //         // Rumus Bunga: Plafon * Persen Bunga Bulanan
    //         $bungaBulanan = $loan->plafon_disetujui * ($loan->bunga_persen / 100);
    //         // Total setoran wajib per bulan
    //         $totalAngsuranPerBulan = $angsuranPokok + $bungaBulanan;

    //         // 3. Generate Otomatis Baris Angsuran sesuai Tenor (10 / 12 / 24 Bulan)
    //         for ($i = 1; $i <= $loan->tenor_bulan; $i++) {
    //             // Jatuh tempo di-set berulang setiap bulan ke depan
    //             $jatuhTempo = Carbon::now()->addMonths($i)->startOfDay();

    //             SppInstallment::create([
    //                 'loan_id'             => $loan->id,
    //                 'angsuran_ke'         => $i,
    //                 'jumlah_pokok'        => $angsuranPokok,
    //                 'jumlah_bunga'        => $bungaBulanan,
    //                 'tanggal_jatuh_tempo' => $jatuhTempo,        // Sesuai $fillable Anda
    //                 'status_bayar'        => 'belum_bayar',
    //                 'denda_kumulatif'     => 0,
    //             ]);
    //         }

    //         DB::commit();
    //         return redirect()->back()->with('success', 'Berhasil! Dana plafon telah dicairkan dan seluruh tabel jadwal angsuran kelompok berhasil dibuat.');

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Gagal mencairkan dana: ' . $e->getMessage());
    //     }
    // }


    // ===============================================================

    public function disburse(Request $request, SppLoan $loan)
    {
        $request->validate([
            'nominal_cair' => 'required|numeric|min:100000|max:' . $loan->plafon_disetujui,
        ]);

        if ($loan->status_loan != 'review') {
            return redirect()->back()->with('error', 'Kontrak pinjaman ini sudah aktif.');
        }

        DB::beginTransaction();

        try {
            // 1. Update status menjadi berjalan DAN isi total yang dicairkan sesuai input admin (misal: 2jt)
            $loan->update([
                'status_loan' => 'berjalan',
                'total_dicairkan' => $request->nominal_cair, 
            ]);

            // 2. Hitung Matematika Angsuran Bulanan (Tetap dihitung berdasarkan plafon kontrak penuh atau nominal cair awal?)
            // Umumnya di BUMDes, bunga & pokok tetap dihitung dari total komitmen plafon kontrak (Rp10jt)
            $angsuranPokok = $loan->plafon_disetujui / $loan->tenor_bulan;
            $bungaBulanan = $loan->plafon_disetujui * ($loan->bunga_persen / 100);
            $totalAngsuranPerBulan = $angsuranPokok + $bungaBulanan;

            // 3. Generate Jadwal Angsuran Bulanan
            for ($i = 1; $i <= $loan->tenor_bulan; $i++) {
                $jatuhTempo = Carbon::now()->addMonths($i)->startOfDay();

                SppInstallment::create([
                    'loan_id'             => $loan->id,
                    'angsuran_ke'         => $i,
                    'jumlah_pokok'        => $angsuranPokok,
                    'jumlah_bunga'        => $bungaBulanan,
                    'tanggal_jatuh_tempo' => $jatuhTempo,
                    'status_bayar'        => 'belum_bayar',
                    'denda_kumulatif'     => 0
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Pencairan tahap awal sebesar Rp' . number_format($request->nominal_cair, 0, ',', '.') . ' berhasil diserahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mencairkan dana: ' . $e->getMessage());
        }
    }

    public function disburseNext(Request $request, SppLoan $loan)
    {
        // Hitung berapa sisa plafon yang belum diambil oleh kelompok
        $sisaPlafon = $loan->plafon_disetujui - $loan->total_dicairkan;

        $request->validate([
            'nominal_cair_lanjut' => 'required|numeric|min:100000|max:' . $sisaPlafon,
        ]);

        if ($loan->status_loan != 'berjalan') {
            return redirect()->back()->with('error', 'Pencairan susulan hanya bisa dilakukan untuk kontrak aktif.');
        }

        try {
            // Akumulasikan nominal pencairan baru ke total yang sudah dicairkan sebelumnya
            $nominalBaru = $loan->total_dicairkan + $request->nominal_cair_lanjut;

            $loan->update([
                'total_dicairkan' => $nominalBaru
            ]);

            return redirect()->back()->with('success', 'Pencairan tahap berikutnya sebesar Rp' . number_format($request->nominal_cair_lanjut, 0, ',', '.') . ' berhasil diserahkan ke kelompok!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses pencairan bertahap: ' . $e->getMessage());
        }
    }

    public function payInstallment($id)
    {
        $installment = SppInstallment::findOrFail($id);

        if ($installment->status_bayar == 'lunas') {
            return redirect()->back()->with('error', 'Angsuran ini sudah lunas sebelumnya.');
        }

        try {
            $denda = 0;
            $tanggalJatuhTempo = Carbon::parse($installment->tanggal_jatuh_tempo);
            $hariIni = Carbon::now();

            // Jika telat melewati hari jatuh tempo
            if ($installment->status_bayar === 'belum_bayar' && $hariIni->gt($tanggalJatuhTempo)) {
                $selisihHari = $tanggalJatuhTempo->diffInDays($hariIni);
                $denda = $selisihHari * 5000; // Sesuai tarif Rp 5.000/hari
            }

            // Tambahkan variabel denda ke total yang dibayar
            $totalTagihan = $installment->jumlah_pokok + $installment->jumlah_bunga + $denda;

            $installment->update([
                'tanggal_bayar' => $hariIni->toDateString(),
                'denda_kumulatif' => $denda, // Menyimpan total denda yang dibayar ke database
                'total_dibayar' => $totalTagihan,
                'status_bayar' => 'lunas'
            ]);

            // Ambil data relasi induk SppLoan
            $loan = $installment->loan;

            // =========================================================================
            // PENCATATAN TRIGGERS STATUS INDUK (LOAN)
            // =========================================================================
            
            $pesanTambahan = '';

            // TRIGGER 1: Jika yang dibayar adalah ANGSURAN PERTAMA (Bulan Ke-1)
            // Ubah status_loan menjadi 'berjalan' untuk membuka gembok Pencairan Tahap 2
            if ($installment->angsuran_ke == 1) {
                $loan->update([
                    'status_loan' => 'berjalan'
                ]);
                $pesanTambahan = ' Gembok pencairan sisa dana (Tahap 2) kini telah terbuka!';
            }

            // TRIGGER 2: Cek apakah seluruh angsuran sudah lunas semua
            $sisaAngsuran = SppInstallment::where('loan_id', $loan->id)
                                        ->where('status_bayar', 'belum_bayar')
                                        ->count();
            
            if ($sisaAngsuran == 0) {
                $loan->update([
                    'status_loan' => 'lunas'
                ]);
                $pesanTambahan = ' Selamat! Seluruh angsuran telah terpenuhi, pinjaman kelompok resmi LUNAS TOTAL.';
            }

            // Susun teks notifikasi akhir yang dinamis
            $notifDenda = $denda > 0 ? ' Denda keterlambatan Rp ' . number_format($denda, 0, ',', '.') . ' telah dibukukan.' : '';
            
            return redirect()->back()->with('success', 'Angsuran ke-' . $installment->angsuran_ke . ' berhasil dibayar!' . $notifDenda . $pesanTambahan);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function printReceipt($id) {
        $installment = SppInstallment::with(['loan.group'])->findOrFail($id);

        $nama_admin = User::find(1);

        $nama_admin = $nama_admin->name;
        
        if ($installment->status_bayar != 'lunas') {
            return redirect()->back()->with('error', 'Kuitansi belum bisa dicetak karena angsuran belum lunas.');
        }

        // Set ukuran kertas custom untuk kuitansi (A5 Lanskap agar pas)
        $pdf = Pdf::loadView('Admin.SPP.Loan.receipt', compact('installment', 'nama_admin'))
                ->setPaper('A4', 'portrait');

        return $pdf->stream('Kuitansi_Ags_' . $installment->angsuran_ke . '_' . $installment->loan->group->nama_kelompok . '.pdf');
    }


    public function printLoanReport($id)
    {
        // 1. Tarik data pinjaman beserta seluruh angsurannya
        $loan = SppLoan::with(['group', 'installments' => function($query) {
            $query->orderBy('angsuran_ke', 'asc');
        }])->findOrFail($id);

        // 2. Tarik nama admin pembuku dinamis
        $nama_admin = auth()->user()->name ?? User::find(1)->name ?? 'Petugas BUMDes';

        // 3. Inisialisasi variabel akumulator untuk total di bagian footer
        $totalPokok = 0;
        $totalBunga = 0;
        $totalDenda = 0;
        $totalSetoran = 0;

        // 4. Lakukan looping untuk menghitung akumulasi total secara aman & denda real-time
        foreach ($loan->installments as $ins) {
            $totalPokok += $ins->jumlah_pokok;
            $totalBunga += $ins->jumlah_bunga;

            if ($ins->status_bayar == 'lunas') {
                // Jika lunas, ambil nilai denda baku dari database
                $totalDenda += $ins->denda_kumulatif;
                $totalSetoran += ($ins->jumlah_pokok + $ins->jumlah_bunga + $ins->denda_kumulatif);
            } else {
                // Jika belum bayar, cek apakah melewati jatuh tempo (denda berjalan)
                $dendaBerjalan = 0;
                if (Carbon::now()->gt(Carbon::parse($ins->tanggal_jatuh_tempo))) {
                    $hariTelat = Carbon::parse($ins->tanggal_jatuh_tempo)->diffInDays(Carbon::now());
                    $dendaBerjalan = $hariTelat * 5000;
                }
                $totalDenda += $dendaBerjalan;
                $totalSetoran += ($ins->jumlah_pokok + $ins->jumlah_bunga + $dendaBerjalan);
            }
        }

        // 5. Generate PDF dengan layout Landscape A4 agar tabel data renggang dan rapi
        $pdf = Pdf::loadView('Admin.SPP.Loan.report_single', compact(
            'loan', 
            'nama_admin', 
            'totalPokok', 
            'totalBunga', 
            'totalDenda', 
            'totalSetoran'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream('Laporan_Riwayat_Pinjaman_' . $loan->group->nama_kelompok . '.pdf');
    }


    public function singleLoanReport($id)
    {
        // Ambil data loan spesifik beserta relasi group dan installments-nya
        $loan = SppLoan::with(['group', 'installments' => function($query) {
            $query->orderBy('angsuran_ke', 'asc');
        }])->findOrFail($id);

        $nama_admin = User::find(1);

        $nama_admin = $nama_admin->name;

        // Hitung total-total untuk footers laporan
        $totalPokok = $loan->installments->sum('jumlah_pokok');
        $totalBunga = $loan->installments->sum('jumlah_bunga');
        $totalDenda = $loan->installments->sum('denda_kumulatif');
        $totalSetoran = $totalPokok + $totalBunga + $totalDenda;

        $pdf = Pdf::loadView('Admin.SPP.Loan.report', compact('loan', 'totalPokok', 'totalBunga', 'totalDenda', 'totalSetoran', 'nama_admin'))
                ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_SPP_Kelompok_' . $loan->group->nama_kelompok . '.pdf');
    }

    // Proses pencairan tahap awal : 
    public function cairkanTahapAwal(Request $request, $id) {
        
        $request->validate([
            'tanggal_cair' => 'required|date',
            'bukti_pencarian' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        DB::beginTransaction();


        try {
            $loan = SppLoan::findOrFail($id);

            // Proteksi: Pastikan pinjaman belum berjalan atau sudah dicairkan sebelumnya
            if ($loan->status_loan !== 'review') {
                return redirect()->back()->with('error', 'Pinjaman ini sudah berjalan atau tidak dalam masa review.');
            }

            $nominalCairAwal = 2000000; // Ketentuan tahap awal Rp2.000.000

            // 2. Simpan file bukti pencairan jika ada
            $namaFileBukti = null;
            if ($request->hasFile('bukti_pencairan')) {
                $file = $request->file('bukti_pencairan');
                $namaFileBukti = 'Disburse_Tahap1_' . $loan->no_kontrak . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('File/SPP/Pencairan'), $namaFileBukti);
            }

            // 3. Catat ke tabel Riwayat Pencairan (spp_disbursements)
            SppDisbursement::create([
                'loan_id' => $loan->id,
                'tahap_ke' => 1,
                'jumlah_cair' => $nominalCairAwal,
                'tanggal_cair' => $request->tanggal_cair,
                'bukti_pencairan' => $namaFileBukti
            ]);

            // 4. Update status pinjaman dan jumlah total yang dicairkan di tabel spp_loans
            $loan->update([
                'total_dicairkan' => $nominalCairAwal,
                'status_loan' => 'berjalan' // Status berubah dari review menjadi berjalan
            ]);

            // 5. LOGIKA GENERATE JADWAL ANGSURAN OTOMATIS
            // Sesuai kesepakatan: Angsuran dihitung dari total plafon yang disetujui (pokok) + bunga 0.5% per bulan
            $tenor = $loan->tenor_bulan;
            $pokokPerBulan = $loan->plafon_disetujui / $tenor;
            $bungaPerBulan = $pokokPerBulan * ($loan->bunga_persen / 100); 
            
            $tanggalCair = Carbon::parse($request->tanggal_cair);

            for ($i = 1; $i <= $tenor; $i++) {
                // Jatuh tempo diatur tepat 1 bulan berikutnya secara berurutan (Bulan ke-1, 2, dst)
                $jatuhTempo = $tanggalCair->copy()->addMonths($i);

                SppInstallment::create([
                    'loan_id' => $loan->id,
                    'angsuran_ke' => $i,
                    'jumlah_pokok' => $pokokPerBulan,
                    'jumlah_bunga' => $bungaPerBulan,
                    'tanggal_jatuh_tempo' => $jatuhTempo->format('Y-m-d'),
                    'tanggal_bayar' => null,
                    'denda_kumulatif' => 0,
                    'status_bayar' => 'belum_bayar'
                ]);
            }

            // Jika semua proses berhasil, kunci data ke database
            DB::commit();
            return redirect()->back()->with('success', 'Pencairan tahap awal berhasil dan jadwal angsuran telah dibuat otomatis!');

        } catch (\Exception $e) {
            // Jika ada yang error, batalkan semua perubahan data agar database tidak berantakan
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }

    }

    public function sppLoan() {

        $auth = Auth::guard('spp')->user();

        $loans = SppLoan::where('group_id', $auth->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view("SPPMember.loan", [
            'loans' => $loans, 
            'noHp' => User::select('no_telepon')->where('id', 1)->get()
        ]);
    }

    public function storeLoan(Request $request) {
        // 1. VALIDASI KETAT: Selaras dengan front-end (Min 2 Juta, Max 20 Juta)
        $request->validate([
            'nominal_pengajuan' => 'required|numeric|min:2000000|max:20000000',
            'tenor_bulan'       => 'required|in:6,10,12,24',
            'keperluan'         => 'required|string|max:1000',
            'group_id'          => 'required'
        ], [
            'nominal_pengajuan.required' => 'Nominal pengajuan modal wajib diisi.',
            'nominal_pengajuan.numeric'  => 'Nominal pengajuan harus berupa angka murni.',
            'nominal_pengajuan.min'      => 'Batas minimal pengajuan dana modal adalah Rp 2.000.000.',
            'nominal_pengajuan.max'      => 'Batas maksimal pengajuan dana modal adalah Rp 20.000.000.', // Pengunci celah inspect element
            'tenor_bulan.required'       => 'Jangka waktu tenor wajib dipilih.',
            'tenor_bulan.in'             => 'Pilihan jangka waktu tenor tidak valid.',
            'keperluan.required'         => 'Harap isi penjelasan tujuan penggunaan modal usaha kelompok Anda.'
        ]);

        // 2. PROTEKSI DOUBLE SUBMIT: Cek apakah kelompok masih punya pinjaman aktif/gantung
        $hasActiveLoan = SppLoan::where('group_id', $request->group_id)
            ->whereIn('status_loan', ['review', 'disetujui', 'berjalan', 'macet'])
            ->exists();

        if ($hasActiveLoan) {
            return redirect()->back()
                ->with('error', 'Pengajuan ditolak. Kelompok Anda masih memiliki pinjaman aktif yang sedang ditinjau atau belum lunas.');
        }

        // 3. EKSEKUSI PENYIMPANAN: Data masuk dengan status awal 'review'
        SppLoan::create([
            'group_id'          => $request->group_id,
            'nominal_pengajuan' => $request->nominal_pengajuan,
            'tenor_bulan'       => $request->tenor_bulan,
            'keperluan'         => $request->keperluan,
            'bunga_persen'      => 0.50, // Default ketetapan BUMDes 0.5% flat per bulan
            'status_loan'       => 'review', 
            'status_pencairan'  => 'belum_cair'
        ]);

        return redirect()->back()
            ->with('success', 'Formulir pengajuan modal Anda sebesar Rp ' . number_format($request->nominal_pengajuan, 0, ',', '.') . ' berhasil dikirim! Silakan tunggu proses peninjauan dari tim admin BUMDes.');        
    }

}

