<?php

namespace App\Http\Controllers;

use App\Models\SppGroup;
use Illuminate\Http\Request;
use App\Models\SppLoan;
use App\Models\SppDisbursement;
use App\Models\SppInstallment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Barryvdh\DomPDF\Facade\Pdf;

class SppLoanController extends Controller
{
    
    public function index() {

        $loans = SppLoan::with('group')->latest()->get();

        return view('Admin.SPP.Loan.index', [
            'loans' => $loans
        ]);

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
      
        return view('Admin.SPP.Loan.show', [
            'loan' => $loan->load(['group', 'installments' => function($constraints) {
                $constraints->orderBy('angsuran_ke', 'asc');
            }])
        ]);

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
            $hariIni = Carbon::now()->startOfDay();
            $jatuhTempo = Carbon::parse($installment->tanggal_jatuh_tempo)->startOfDay();
            $denda = 0;

            // Hitung denda jika hari ini melewati tanggal jatuh tempo
            if ($hariIni->gt($jatuhTempo)) {
                $hariTerlambat = $hariIni->diffInDays($jatuhTempo);
                $denda = $hariTerlambat * 5000;
            }

            // Update data angsuran menjadi Lunas
            $installment->update([
                'status_bayar' => 'lunas',
                'tanggal_bayar' => Carbon::now(),
                'denda_kumulatif' => $denda
            ]);

            // Opsional: Cek apakah ini angsuran terakhir, jika ya, otomatis lunaskan SppLoan induknya
            $loan = $installment->loan;
            $sisaAngsuran = SppInstallment::where('loan_id', $loan->id)
                                        ->where('status_bayar', 'belum_bayar')
                                        ->count();
            
            if ($sisaAngsuran == 0) {
                $loan->update(['status_loan' => 'lunas']);
            }

            return redirect()->back()->with('success', 'Angsuran ke-' . $installment->angsuran_ke . ' berhasil dibayar! ' . ($denda > 0 ? 'Denda keterlambatan Rp' . number_format($denda, 0, ',', '.') . ' telah dibukukan.' : ''));

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function printReceipt($id) {
        $installment = SppInstallment::with(['loan.group'])->findOrFail($id);
        
        if ($installment->status_bayar != 'lunas') {
            return redirect()->back()->with('error', 'Kuitansi belum bisa dicetak karena angsuran belum lunas.');
        }

        // Set ukuran kertas custom untuk kuitansi (A5 Lanskap agar pas)
        $pdf = Pdf::loadView('Admin.SPP.Loan.receipt', compact('installment'))
                ->setPaper('A4', 'portrait');

        return $pdf->stream('Kuitansi_Ags_' . $installment->angsuran_ke . '_' . $installment->loan->group->nama_kelompok . '.pdf');
    }

    public function singleLoanReport($id)
    {
        // Ambil data loan spesifik beserta relasi group dan installments-nya
        $loan = SppLoan::with(['group', 'installments' => function($query) {
            $query->orderBy('angsuran_ke', 'asc');
        }])->findOrFail($id);

        // Hitung total-total untuk footers laporan
        $totalPokok = $loan->installments->sum('jumlah_pokok');
        $totalBunga = $loan->installments->sum('jumlah_bunga');
        $totalDenda = $loan->installments->sum('denda_kumulatif');
        $totalSetoran = $totalPokok + $totalBunga + $totalDenda;

        $pdf = Pdf::loadView('Admin.SPP.Loan.report', compact('loan', 'totalPokok', 'totalBunga', 'totalDenda', 'totalSetoran'))
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
}

