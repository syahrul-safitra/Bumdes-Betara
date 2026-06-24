<?php

namespace App\Http\Controllers;

use App\Models\SppGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SppMember;
use App\Models\SppInstallment;
use App\Models\SppLoan;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SppGroupController extends Controller
{
    public function index() {
        $groups = SppGroup::withCount('members')->latest()->get();

        return view('Admin.SPP.Group.index', [
            'groups' => $groups
        ]);
    }

    public function create() {
        return view('Admin.SPP.Group.create');
    }

    public function store(Request $request)
    {

        // Validasi data induk kelompok & array anggotanya
        $request->validate([
            'nama_kelompok'   => 'required|string|max:255',
            'nama_ketua'      => 'required|string|max:255',
            'no_hp_ketua'     => 'required|string|max:15',
            'alamat_kelompok' => 'required|string',
            'nik_ketua' => 'required|string|size:16|unique:spp_groups,nik_ketua',
            'file_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'anggota'         => 'required|array|min:1',
            'anggota.*.nama'  => 'required|string|max:255',
            'anggota.*.nik'   => 'required|string|size:16|unique:spp_members,nik',
            'anggota.*.file_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->file('file_ktp')) {
            $file = $request->file('file_ktp');

            $namaFileKtpKetua = 'KTP_' . $request->nik_ketua . '_'  . time() . '.' .  $file->getClientOriginalExtension();

            $file->move('File/SPP/KTP', $namaFileKtpKetua);
        }

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // 2. Simpan Data Induk Kelompok ke tabel spp_groups
            $group = SppGroup::create([
                'nama_kelompok'   => $request->nama_kelompok,
                'nama_ketua'      => $request->nama_ketua,
                'no_hp_ketua'     => $request->no_hp_ketua,
                'nik_ketua' => $request->nik_ketua,
                'file_ktp' => $namaFileKtpKetua,
                'alamat_kelompok' => $request->alamat_kelompok,
                'status'          => 'aktif'
            ]);

            // 3. Looping Array Anggota untuk Proses Upload KTP & Simpan ke spp_members
            foreach ($request->anggota as $index => $dataAnggota) {
                $namaFileKtp = null;

                if (isset($dataAnggota['file_ktp'])) {
                    $file = $dataAnggota['file_ktp'];
                    
                    // Format nama file: KTP_NIK_RANDOMSTRING.extension agar unik dan rapi
                    $slugKelompok = Str::slug($request->nama_kelompok);
                    $namaFileKtp = 'KTP_' . $dataAnggota['nik'] . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                    
                    // Pindahkan file ke direktori public/File/SPP/KTP
                    $file->move(public_path('File/SPP/KTP'), $namaFileKtp);
                }

                // Masukkan data anggota ke database dengan relasi group_id yang baru dibuat
                SppMember::create([
                    'group_id'     => $group->id,
                    'nik'          => $dataAnggota['nik'],
                    'nama_anggota' => $dataAnggota['nama'],
                    'file_ktp'     => $namaFileKtp
                ]);
            }

            // Jika semua baris kode di atas sukses tanpa error, kunci perubahan ke database
            DB::commit();

            return redirect('/spp-group')->with('success', 'Kelompok ' . $request->nama_kelompok . ' beserta seluruh anggotanya berhasil didaftarkan!');

        } catch (\Exception $e) {
            // Jika di tengah jalan ada error (misal: storage penuh atau jaringan putus), batalkan semua!
            DB::rollBack();

            // Opsional: Anda bisa menghapus file fisik KTP yang terlanjur ter-upload di folder jika diperlukan

            return redirect()->back()->withInput()->withErrors(['error_sistem' => 'Gagal menyimpan data: ' . $e->getMessage()]);
        }
    }

    public function show(SppGroup $group) {

        return view('Admin.SPP.Group.show', [
            'group' => $group->load(['members', 'loans'])
        ]);
    }

    public function edit(SppGroup $group) {

        // return $group->load(['members', 'loans']);

        return view('Admin.SPP.Group.edit', [
            'group' => $group->load(['members', 'loans'])
        ]);
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'nama_kelompok'   => 'required|string|max:255',
    //         'nama_ketua'      => 'required|string|max:255',
    //         'no_hp_ketua'     => 'required|string|max:15',
    //         'alamat_kelompok' => 'required|string',
    //         'status'          => 'required|in:aktif,non_aktif',
    //         'anggota'         => 'required|array|min:1',
    //         'anggota.*.id'    => 'nullable',
    //         'anggota.*.nama'  => 'required|string|max:255',
    //         'anggota.*.nik'   => 'required|string|size:16',
    //     ]);

    //     DB::beginTransaction();

    //     try {
    //         $group = SppGroup::findOrFail($id);
            
    //         // 1. Update Profil Data Induk Kelompok
    //         $group->update([
    //             'nama_kelompok'   => $request->nama_kelompok,
    //             'nama_ketua'      => $request->nama_ketua,
    //             'no_hp_ketua'     => $request->no_hp_ketua,
    //             'alamat_kelompok' => $request->alamat_kelompok,
    //             'status'          => $request->status,
    //         ]);

    //         // Kumpulkan semua ID Anggota yang dikirim dari form untuk melacak penghapusan
    //         $keptMemberIds = [];

    //         // 2. Olah Data Array Anggota
    //         foreach ($request->anggota as $index => $dataAnggota) {
                
    //             if (!empty($dataAnggota['id'])) {
    //                 // KONDISI A: Anggota Lama (Lakukan Update Data)
    //                 $member = SppMember::where('group_id', $group->id)->findOrFail($dataAnggota['id']);
    //                 $keptMemberIds[] = $member->id;

    //                 $updateData = [
    //                     'nama_anggota' => $dataAnggota['nama'],
    //                     'nik'          => $dataAnggota['nik']
    //                 ];

    //                 // Jika ganti berkas foto KTP
    //                 if (isset($dataAnggota['file_ktp'])) {
    //                     // Hapus file KTP lama dari folder public jika ada
    //                     if ($member->file_ktp && file_exists(public_path('File/SPP/KTP/' . $member->file_ktp))) {
    //                         unlink(public_path('File/SPP/KTP/' . $member->file_ktp));
    //                     }

    //                     $file = $dataAnggota['file_ktp'];
    //                     $namaFileKtp = 'KTP_' . $dataAnggota['nik'] . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
    //                     $file->move(public_path('File/SPP/KTP'), $namaFileKtp);
    //                     $updateData['file_ktp'] = $namaFileKtp;
    //                 }

    //                 $member->update($updateData);

    //             } else {
    //                 // KONDISI B: Anggota Baru yang Ditambahkan Saat Edit (Lakukan Insert Baru)
    //                 $namaFileKtp = null;
    //                 if (isset($dataAnggota['file_ktp'])) {
    //                     $file = $dataAnggota['file_ktp'];
    //                     $namaFileKtp = 'KTP_' . $dataAnggota['nik'] . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
    //                     $file->move(public_path('File/SPP/KTP'), $namaFileKtp);
    //                 }

    //                 $newMember = SppMember::create([
    //                     'group_id'     => $group->id,
    //                     'nik'          => $dataAnggota['nik'],
    //                     'nama_anggota' => $dataAnggota['nama'],
    //                     'file_ktp'     => $namaFileKtp
    //                 ]);

    //                 $keptMemberIds[] = $newMember->id;
    //             }
    //         }

    //         // KONDISI C: Hapus Anggota yang Dibuang oleh Admin dari Form Edit
    //         // Cari anggota di database yang ID-nya tidak terdaftar di variabel $keptMemberIds
    //         $deletedMembers = SppMember::where('group_id', $group->id)->whereNotIn('id', $keptMemberIds)->get();
    //         foreach ($deletedMembers as $delMember) {
    //             // Hapus file fisik KTP-nya
    //             if ($delMember->file_ktp && file_exists(public_path('File/SPP/KTP/' . $delMember->file_ktp))) {
    //                 unlink(public_path('File/SPP/KTP/' . $delMember->file_ktp));
    //             }
    //             // Hapus baris di DB
    //             $delMember->delete();
    //         }

    //         DB::commit();
    //         return redirect('/spp-group')->with('success', 'Data Kelompok ' . $request->nama_kelompok . ' berhasil diperbarui!');

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->withInput()->withErrors(['error_sistem' => 'Gagal mengubah data: ' . $e->getMessage()]);
    //     }
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelompok'   => 'required|string|max:255',
            'nama_ketua'      => 'required|string|max:255',
            'nik_ketua'       => 'required|string|size:16', // Tambahan Validasi NIK Ketua
            'file_ktp'        => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048', // Tambahan Validasi File KTP Ketua (Nullable)
            'no_hp_ketua'     => 'required|string|max:15',
            'alamat_kelompok' => 'required|string',
            'status'          => 'required|in:aktif,non_aktif',
            'anggota'         => 'required|array|min:1',
            'anggota.*.id'    => 'nullable',
            'anggota.*.nama'  => 'required|string|max:255',
            'anggota.*.nik'   => 'required|string|size:16',
        ]);

        DB::beginTransaction();

        try {
            $group = SppGroup::findOrFail($id);
            
            // Siapkan data induk yang akan diupdate
            $updateGroupData = [
                'nama_kelompok'   => $request->nama_kelompok,
                'nama_ketua'      => $request->nama_ketua,
                'nik_ketua'       => $request->nik_ketua, // Simpan NIK Ketua Baru/Lama
                'no_hp_ketua'     => $request->no_hp_ketua,
                'alamat_kelompok' => $request->alamat_kelompok,
                'status'          => $request->status,
            ];

            // Proses Upload Jika Admin Mengganti Berkas KTP Ketua Kelompok
            if ($request->hasFile('file_ktp')) {
                // Hapus file KTP lama milik ketua dari folder jika sebelumnya sudah ada
                if ($group->file_ktp && file_exists(public_path('File/SPP/KTP/' . $group->file_ktp))) {
                    unlink(public_path('File/SPP/KTP/' . $group->file_ktp));
                }

                $fileKetua = $request->file('file_ktp');
                // Format penamaan berkas disamakan dengan sistem KTP Anggota Anda
                $namaFileKtpKetua = 'KTP_KETUA_' . $request->nik_ketua . '_' . time() . '.' . $fileKetua->getClientOriginalExtension();
                $fileKetua->move(public_path('File/SPP/KTP'), $namaFileKtpKetua);
                
                $updateGroupData['file_ktp'] = $namaFileKtpKetua;
            }

            // 1. Update Profil Data Induk Kelompok beserta Atribut Ketua Baru
            $group->update($updateGroupData);

            // Kumpulkan semua ID Anggota yang dikirim dari form untuk melacak penghapusan
            $keptMemberIds = [];

            // 2. Olah Data Array Anggota
            foreach ($request->anggota as $index => $dataAnggota) {
                
                if (!empty($dataAnggota['id'])) {
                    // KONDISI A: Anggota Lama (Lakukan Update Data)
                    $member = SppMember::where('group_id', $group->id)->findOrFail($dataAnggota['id']);
                    $keptMemberIds[] = $member->id;

                    $updateData = [
                        'nama_anggota' => $dataAnggota['nama'],
                        'nik'          => $dataAnggota['nik']
                    ];

                    // Jika ganti berkas foto KTP Anggota
                    if (isset($dataAnggota['file_ktp'])) {
                        // Hapus file KTP lama dari folder public jika ada
                        if ($member->file_ktp && file_exists(public_path('File/SPP/KTP/' . $member->file_ktp))) {
                            unlink(public_path('File/SPP/KTP/' . $member->file_ktp));
                        }

                        $file = $dataAnggota['file_ktp'];
                        $namaFileKtp = 'KTP_' . $dataAnggota['nik'] . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('File/SPP/KTP'), $namaFileKtp);
                        $updateData['file_ktp'] = $namaFileKtp;
                    }

                    $member->update($updateData);

                } else {
                    // KONDISI B: Anggota Baru yang Ditambahkan Saat Edit (Lakukan Insert Baru)
                    $namaFileKtp = null;
                    if (isset($dataAnggota['file_ktp'])) {
                        $file = $dataAnggota['file_ktp'];
                        $namaFileKtp = 'KTP_' . $dataAnggota['nik'] . '_' . time() . '_' . $index . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('File/SPP/KTP'), $namaFileKtp);
                    }

                    $newMember = SppMember::create([
                        'group_id'     => $group->id,
                        'nik'          => $dataAnggota['nik'],
                        'nama_anggota' => $dataAnggota['nama'],
                        'file_ktp'     => $namaFileKtp
                    ]);

                    $keptMemberIds[] = $newMember->id;
                }
            }

            // KONDISI C: Hapus Anggota yang Dibuang oleh Admin dari Form Edit
            $deletedMembers = SppMember::where('group_id', $group->id)->whereNotIn('id', $keptMemberIds)->get();
            foreach ($deletedMembers as $delMember) {
                // Hapus file fisik KTP-nya
                if ($delMember->file_ktp && file_exists(public_path('File/SPP/KTP/' . $delMember->file_ktp))) {
                    unlink(public_path('File/SPP/KTP/' . $delMember->file_ktp));
                }
                // Hapus baris di DB
                $delMember->delete();
            }

            DB::commit();
            return redirect('/spp-group')->with('success', 'Data Kelompok ' . $request->nama_kelompok . ' berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['error_sistem' => 'Gagal mengubah data: ' . $e->getMessage()]);
        }
    }

    // =========================================================================================================================
    // ============ REVISI =====================================================================================================

    public function storeRegistrasiSpp(Request $request)
    {
        // 1. Validasi Input Data Esensial Ketua
        $validated = $request->validate([
            'nama_ketua'   => 'required|string|max:255',
            // 'nik_ketua'    => 'required|string|size:16|unique:spp_groups,nik_ketua',
            'email'        => 'required|string|email|max:255|unique:spp_groups,email',
            'no_hp_ketua'  => 'required|string|max:15',
            'password'     => 'required|string|min:6',
        ], [
            'nik_ketua.unique' => 'NIK ini sudah terdaftar dalam sistem SPP.',
            'email.unique'     => 'Alamat email ini sudah digunakan.',
            'password.min'     => 'Kata sandi minimal harus terdiri dari 6 karakter.',
        ]);

        // 2. Simpan Akun Dasar ke Tabel `spp_groups`
        $group = SppGroup::create([
            'nama_ketua'       => $validated['nama_ketua'],
            // 'nik_ketua'        => $validated['nik_ketua'],
            'email'            => $validated['email'],
            'no_hp_ketua'      => $validated['no_hp_ketua'],
            'password'         => Hash::make($validated['password']),
            
            // Mengisi kolom profil kelompok dengan data default/placeholder terlebih dahulu
            'nama_kelompok'    => 'Kelompok ' . $validated['nama_ketua'], // placeholder nama awal
            'alamat_kelompok'  => '-', // Diisi nanti saat onboarding
            'file_ktp'         => '-', // Diisi nanti saat onboarding
            
            // Status awal wajib diperiksa berkasnya oleh admin
            'status_validasi'  => 'pending',
            'status'           => 'non_aktif',
        ]);

        // 3. Otomatis Login Menggunakan Guard Khusus SPP Group
        // Catatan: Pastikan nama guard 'group' ini sudah didaftarkan di config/auth.php
        Auth::guard('spp')->login($group);

        // 4. Redirect ke Dashboard Onboarding Ketua Kelompok
        return redirect('spp-dashboard')->with('success', 'Akun ketua berhasil dibuat! Silakan lengkapi profil kelompok dan data anggota Anda.');
    }

    public function sppDashboard() {

        $group = Auth::guard('spp')->user();

        // Inisialisasi awal variabel baru
        $tagihanBulanIni = null; // Di-set null agar memicu kondisi @else di blade jika tidak ada tagihan
        $jatuhTempo = '-';
        
        $statusLoan = 'Tidak Ada Pinjaman';
        $sisaHutang = 0;

        if ($group) {
            $activeLoan = SppLoan::where('group_id', $group->id)
                ->whereIn('status_loan', ['disetujui', 'berjalan'])
                ->orderBy('created_at', 'desc')
                ->first();

            if ($activeLoan) {
                // [Logika Sebelumnya] Penentuan status loan
                if ($activeLoan->status_loan == 'disetujui') {
                    $statusLoan = 'Disetujui (Cair Awal)';
                } elseif ($activeLoan->status_loan == 'berjalan') {
                    $statusLoan = $activeLoan->status_pencairan == 'cair_penuh' ? 'Sedang Berjalan' : 'Siap Cair Tahap 2';
                }

                // [Logika Sebelumnya] Hitung sisa total pokok
                $sisaHutang = SppInstallment::where('loan_id', $activeLoan->id)
                    ->where('status_bayar', 'belum_bayar')
                    ->sum('jumlah_pokok');

                // ==========================================
                // 🔥 LOGIKA TERBARU: HITUNG TAGIHAN BULAN INI
                // ==========================================
                
                // Ambil 1 angsuran tertua yang belum dibayar (menghindari lompat bulan)
                $currentInstallment = SppInstallment::where('loan_id', $activeLoan->id)
                    ->where('status_bayar', 'belum_bayar')
                    ->orderBy('angsuran_ke', 'asc')
                    ->first();

                if ($currentInstallment) {
                    $dueDate = Carbon::parse($currentInstallment->tanggal_jatuh_tempo);
                    $today = Carbon::today();
                    $dendaPerHari = 5000;
                    $totalDenda = 0;

                    // Hitung denda jika hari ini sudah melewati tanggal jatuh tempo
                    if ($today->gt($dueDate)) {
                        $selisihHari = $today->diffInDays($dueDate);
                        $totalDenda = $selisihHari * $dendaPerHari;
                    }

                    // Total tagihan = Pokok + Jasa Bunga + Total Denda Berjalan
                    $tagihanBulanIni = $currentInstallment->jumlah_pokok + $currentInstallment->jumlah_bunga + $totalDenda;
                    
                    // Format tanggal jatuh tempo Indonesia (Contoh: 10 Juli 2026)
                    $jatuhTempo = $dueDate->translatedFormat('d F Y');
                }
            } else {
                $checkLunas = SppLoan::where('group_id', $group->id)->where('status_loan', 'lunas')->exists();
                if ($checkLunas) { $statusLoan = 'Lunas Total'; }
            }
        }

        return view('SPPMember.dashboard', [
            'spp' => Auth::guard('spp')->user(),
            'no_telepon' => User::select('no_telepon')->where('id', 1)->get(),
            'statusLoan' => $statusLoan,
            'sisaHutang' => $sisaHutang,
            'tagihanBulanIni' => $tagihanBulanIni,
            'jatuhTempo' => $jatuhTempo
        ]);
    }

    public function sppGroupRev() {
        $spp = Auth::guard('spp')->user();

        return view('SPPMember.group', [
            'spp' => $spp->load('members'),
        ]);
    }

    public function sppGroupRevUpdate(Request $request, SppGroup $group) {

        // 1. Validasi Inputan
        $request->validate([
            'nama_ketua' => 'required|string|max:255',
            'nik_ketua' => 'required|string|size:16|unique:spp_groups,nik_ketua,' . $group->id,
            'email' => 'required|email|max:255|unique:spp_groups,email,' . $group->id,
            'no_hp_ketua' => 'required|string|max:15',
            'nama_kelompok' => 'required|string|max:255',
            'alamat_kelompok' => 'required|string',
            'password' => 'nullable|string|min:8',
            'file_ktp' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048', // Maksimal 2MB
            'no_rek' => 'nullable|string|max:100'
        ], [
            'nik_ketua.unique' => 'NIK Ketua sudah terdaftar di kelompok lain.',
            'email.unique' => 'Email ini sudah digunakan.',
            'file_ktp.mimes' => 'Berkas harus format JPG, PNG, atau PDF.',
            'file_ktp.max' => 'Ukuran berkas maksimal adalah 2 Megabytes.',
        ]);


        // 2. Map data yang akan diupdate
        $data = [
            'nama_ketua' => $request->nama_ketua,
            'nik_ketua' => $request->nik_ketua,
            'email' => $request->email,
            'no_hp_ketua' => $request->no_hp_ketua,
            'nama_kelompok' => $request->nama_kelompok,
            'no_rek' => $request->no_rek,
            'alamat_kelompok' => $request->alamat_kelompok,
        ];

        // 3. Logika Mengubah Password (Hanya jika diisi)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // 4. Logika Upload Berkas Kolektif / KTP Ketua
        if ($request->hasFile('file_ktp')) {
            // Hapus file lama jika ada dan bukan strip (-)
            if ($group->file_ktp && $group->file_ktp != '-' && file_exists(public_path('File/SPP/KTP/' . $group->file_ktp))) {
                unlink(public_path('File/SPP/KTP/' . $group->file_ktp));
            }

            $file = $request->file('file_ktp');
            // Membuat nama file unik: ktp_kelompok_nama_timestamp.ekstensi
            $filename = 'ktp_kelompok_' . strtolower(str_replace(' ', '_', $request->nama_kelompok)) . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Simpan manual menggunakan metode move ke direktori public/File
            $file->move(public_path('File/SPP/KTP/'), $filename);
            $data['file_ktp'] = $filename;
        }

        // 5. Eksekusi Update ke Database
        $group->update($data);

        return redirect()->back()->with('success', 'Profil kelompok dan akun login berhasil diperbarui!');
    }

    public function sppGroupMember(Request $request) {
        $request->validate([
            'nama_anggota'   => 'required|string|max:255',
            'nik'    => 'required|string|size:16|unique:spp_members,nik',
            'file_ktp'       => 'required|image|mimes:jpg,jpeg,png|max:2048', // Wajib gambar, maks 2MB,
            'group_id' => 'required',
        ], [
            'nik.unique'   => 'NIK Anggota ini sudah terdaftar dalam sistem SPP.',
            'nik.size'     => 'NIK Anggota harus tepat berukuran 16 digit.',
            'file_ktp.required'    => 'Foto KTP anggota wajib diunggah.',
            'file_ktp.image'       => 'Berkas KTP harus berupa gambar (JPG/PNG).',
            'file_ktp.max'         => 'Ukuran foto KTP maksimal adalah 2 Megabytes.',
        ]);

        // 2. Logika Unggah Foto KTP Anggota (Menggunakan metode manual move)
        $filename = null;
        if ($request->hasFile('file_ktp')) {
            $file = $request->file('file_ktp');
            
            // Format nama berkas: ktp_anggota_nik_timestamp.ekstensi
            $filename = 'ktp_anggota_' . $request->nik . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Pindahkan langsung ke public/File/KtpAnggota
            $file->move(public_path('File/SPP/KTP'), $filename);
        }
        
        // 3. Simpan Informasi Anggota ke Database
        SppMember::create([
            'group_id'       => $request->group_id, // Otomatis terikat dengan ketua kelompok yang sedang login
            'nama_anggota'   => $request->nama_anggota,
            'nik'    => $request->nik,
            'file_ktp'       => $filename,
        ]);

        return redirect()->back()->with('success', 'Anggota kelompok baru berhasil ditambahkan!');
    }

    public function sppGroupMemberUpdate(Request $request, SppMember $member) {
        // 1. Validasi Data
        $request->validate([
            'nama_anggota'   => 'required|string|max:255',
            'nik'    => 'required|string|size:16|unique:spp_members,nik,' . $member->id,
            'file_ktp'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Nullable karena boleh tidak ganti foto
        ], [
            'nik_anggota.unique'   => 'NIK Anggota ini sudah terdaftar dalam sistem SPP.',
            'file_ktp.image'       => 'Berkas KTP harus berupa gambar (JPG/PNG).',
            'file_ktp.max'         => 'Ukuran foto KTP maksimal adalah 2 Megabytes.',
        ]);

        // Jika validasi gagal, kita kirimkan flash session penanda bahwa yang error adalah modal edit
        if($errors = json_decode(session()->get('errors'))){
            return redirect()->back()->withInput()->with('error_modal', 'edit');
        }

        // 2. Siapkan Array Data
        $data = [
            'nama_anggota'  => $request->nama_anggota,
            'nik'   => $request->nik,
        ];

        // 3. Jika Ketua Mengunggah Foto KTP Baru
        if ($request->hasFile('file_ktp')) {
            // Hapus KTP lama jika fisiknya ada
            if ($member->file_ktp && file_exists(public_path('File/SPP/KTP/' . $member->file_ktp))) {
                unlink(public_path('File/SPP/KTP/' . $member->file_ktp));
            }

            $file = $request->file('file_ktp');
            $filename = 'ktp_anggota_' . $request->nik_anggota . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('File/SPP/KTP/'), $filename);
            
            $data['file_ktp'] = $filename;
        }

        // 4. Update Database
        $member->update($data);

        return redirect()->back()->with('success', 'Data informasi anggota berhasil diperbarui!');
    }

    public function sppGroupMemberDelete(SppMember $member) {
        if ($member->file_ktp && file_exists(public_path('File/SPP/KTP/' . $member->file_ktp))) {
            unlink(public_path('File/SPP/KTP/' . $member->file_ktp));
        }

        // Hapus data dari record tabel database
        $member->delete();

        return redirect()->back()->with('success', 'Data anggota kelompok berhasil dihapus secara permanen.');
    }

    public function allGroup(Request $request) {

        $status = $request->query('status', 'pending');

        // 2. Ambil semua data kelompok untuk kebutuhan hitung total statistik di atas halaman
        $allGroups = SppGroup::withCount('members')->get();

        // 3. Filter data kelompok spesifik yang akan ditampilkan pada tabel utama sesuai tab aktif
        $filteredGroups = SppGroup::where('status_validasi', $status)
            ->withCount('members') // Mengambil total jumlah anggota (akan menghasilkan atribut members_count)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('Admin.SPP.Rev.Group.index', [
            'groups'         => $allGroups,
            'filteredGroups' => $filteredGroups
        ]);
    }

    public function showGroup(SppGroup $group) {

        return view('Admin.SPP.Rev.Group.show', [
            'group' => $group
        ]);
    }

    public function approve(SppGroup $group) {
    
    $group->update([
        'status_validasi' => 'valid',
        'alasan_ditolak'  => null
    ]);

    // Kembali ke halaman tabel utama dengan filter 'valid' agar admin bisa melihat hasilnya
    return redirect('/spp-group-admin?status=valid')->with('success', 'Kelompok ' . $group->nama_kelompok . ' berhasil disetujui dan telah aktif!');
    }

    public function reject(Request $request, SppGroup $group) {
    

        $request->validate([
            'alasan_ditolak' => 'required|string|max:500'
        ], [
            'alasan_ditolak.required' => 'Anda wajib memberikan alasan penolakan berkas.'
        ]);


        // Perbarui status menjadi ditolak dan simpan alasannya
        $group->update([
            'status_validasi' => 'ditolak',
            'alasan_ditolak'  => $request->alasan_ditolak
        ]);

        return redirect('/spp-group-admin?status=valid')->with('success', 'Kelompok ' . $group->nama_kelompok . ' telah ditolak dengan alasan yang dikirim!');
    }
}
