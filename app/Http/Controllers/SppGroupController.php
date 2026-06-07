<?php

namespace App\Http\Controllers;

use App\Models\SppGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\SppMember;
use Illuminate\Support\Str;

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
            'anggota'         => 'required|array|min:1',
            'anggota.*.nama'  => 'required|string|max:255',
            'anggota.*.nik'   => 'required|string|size:16|unique:spp_members,nik',
            'anggota.*.file_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // 2. Simpan Data Induk Kelompok ke tabel spp_groups
            $group = SppGroup::create([
                'nama_kelompok'   => $request->nama_kelompok,
                'nama_ketua'      => $request->nama_ketua,
                'no_hp_ketua'     => $request->no_hp_ketua,
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelompok'   => 'required|string|max:255',
            'nama_ketua'      => 'required|string|max:255',
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
            
            // 1. Update Profil Data Induk Kelompok
            $group->update([
                'nama_kelompok'   => $request->nama_kelompok,
                'nama_ketua'      => $request->nama_ketua,
                'no_hp_ketua'     => $request->no_hp_ketua,
                'alamat_kelompok' => $request->alamat_kelompok,
                'status'          => $request->status,
            ]);

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

                    // Jika ganti berkas foto KTP
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
            // Cari anggota di database yang ID-nya tidak terdaftar di variabel $keptMemberIds
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
}
