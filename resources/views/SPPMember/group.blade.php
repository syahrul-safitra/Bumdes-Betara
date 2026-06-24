@extends('SPPMember.Layouts.main')


@section('content')
    <main class="flex-1 p-6 md:p-10 space-y-10">

        {{-- Header Halaman --}}
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Data Kelompok & Anggota</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola informasi akun ketua, legalitas kelompok, dan data seluruh anggota
                dalam satu panel.</p>
        </div>

        {{-- Notifikasi Sukses / Error --}}
        @if (session('success'))
            <div class="alert alert-success rounded-2xl shadow-sm text-sm font-bold text-white bg-emerald-500 border-none">
                <i class="fa-solid fa-circle-check text-base"></i> {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-error rounded-2xl shadow-sm text-sm font-bold text-white bg-red-500 border-none">
                <i class="fa-solid fa-circle-exclamation text-base"></i> Mohon periksa kembali inputan Anda.
            </div>
        @endif

        {{-- ================= BAGIAN 1: PROFIL LENGKAP KELOMPOK & KETUA ================= --}}
        <div class="bg-white p-8 rounded-[3rem] border border-slate-200 shadow-sm">
            <div class="mb-8 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600"><i
                        class="fa-solid fa-id-card-clip"></i></div>
                <div>
                    <h3 class="text-lg font-black text-slate-800">Profil & Autentikasi Pengurus</h3>
                    <p class="text-xs text-slate-400">Perbarui data identitas Anda selaku ketua beserta informasi legalitas
                        kelompok.</p>
                </div>
            </div>

            <form action="{{ url('/spp-group-rev-update/' . $spp->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    {{-- SUB-KOLOM KIRI: DATA PERSONAL KETUA & AKUN LOGIN --}}
                    <div class="space-y-5 p-6 bg-slate-50/60 rounded-3xl border border-slate-100">
                        <h4 class="text-xs font-black text-indigo-600 uppercase tracking-wider mb-2"><i
                                class="fa-solid fa-user-gear mr-1"></i> Data Akun & Ketua</h4>

                        {{-- Nama Ketua --}}
                        <div class="form-control">
                            <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Nama Lengkap Ketua</label>
                            <input type="text" name="nama_ketua" value="{{ old('nama_ketua', $spp->nama_ketua) }}"
                                class="input input-bordered w-full rounded-2xl bg-white @error('nama_ketua') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500 transition-all">
                            @error('nama_ketua')
                                <p class="text-[11px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- NIK Ketua --}}
                        <div class="form-control">
                            <label class="label text-xs font-bold text-slate-600 uppercase ml-1">NIK Ketua (16
                                Digit)</label>
                            <input type="text" name="nik_ketua" maxlength="16"
                                value="{{ old('nik_ketua', $spp->nik_ketua) }}"
                                class="input input-bordered w-full rounded-2xl bg-white @error('nik_ketua') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500 transition-all">
                            @error('nik_ketua')
                                <p class="text-[11px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Email --}}
                            <div class="form-control">
                                <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Email Login</label>
                                <input type="email" name="email" value="{{ old('email', $spp->email) }}"
                                    class="input input-bordered w-full rounded-2xl bg-white @error('email') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500 transition-all">
                                @error('email')
                                    <p class="text-[11px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- No HP --}}
                            <div class="form-control">
                                <label class="label text-xs font-bold text-slate-600 uppercase ml-1">No. HP/WhatsApp</label>
                                <input type="text" name="no_hp_ketua" value="{{ old('no_hp_ketua', $spp->no_hp_ketua) }}"
                                    class="input input-bordered w-full rounded-2xl bg-white @error('no_hp_ketua') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500 transition-all">
                                @error('no_hp_ketua')
                                    <p class="text-[11px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Ubah Password --}}
                        <div class="form-control">
                            <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Kata Sandi Baru (Kosongkan
                                jika tidak diganti)</label>
                            <input type="password" name="password" placeholder="••••••••"
                                class="input input-bordered w-full rounded-2xl bg-white @error('password') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500 transition-all">
                            @error('password')
                                <p class="text-[11px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- SUB-KOLOM KANAN: DATA STRUKTURAL KELOMPOK --}}
                    <div
                        class="space-y-5 p-6 bg-slate-50/60 rounded-3xl border border-slate-100 flex flex-col justify-between">
                        <div class="space-y-5">
                            <h4 class="text-xs font-black text-indigo-600 uppercase tracking-wider mb-2"><i
                                    class="fa-solid fa-users-gear mr-1"></i> Data Kelompok</h4>

                            {{-- Nama Kelompok --}}
                            <div class="form-control">
                                <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Nama Kelompok
                                    SPP</label>
                                <input type="text" name="nama_kelompok"
                                    value="{{ old('nama_kelompok', $spp->nama_kelompok) }}"
                                    class="input input-bordered w-full rounded-2xl bg-white @error('nama_kelompok') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500 transition-all">
                                @error('nama_kelompok')
                                    <p class="text-[11px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Alamat Kelompok --}}
                            <div class="form-control">
                                <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Alamat Lengkap
                                    Kelompok</label>
                                <textarea name="alamat_kelompok" rows="3" placeholder="Tulis alamat berkumpul atau domisili utama kelompok..."
                                    class="textarea textarea-bordered w-full rounded-2xl bg-white @error('alamat_kelompok') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500 transition-all">{{ old('alamat_kelompok', $spp->alamat_kelompok == '-' ? '' : $spp->alamat_kelompok) }}</textarea>
                                @error('alamat_kelompok')
                                    <p class="text-[11px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Upload Berkas Kolektif / KTP Ketua --}}
                        <div class="form-control pt-2">
                            <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Upload Berkas Kolektif /
                                KTP Ketua (PDF/JPG)</label>
                            <input type="file" name="file_ktp"
                                class="file-input file-input-bordered w-full rounded-2xl bg-white border-slate-200 focus:border-indigo-500 text-sm">
                            @if ($spp->file_ktp && $spp->file_ktp != '-')
                                <p class="mt-2 ml-1 text-xs text-indigo-600 font-bold flex items-center gap-1.5">
                                    <i class="fa-solid fa-paperclip"></i>
                                    <a href="{{ asset('File/SPP/KTP/' . $spp->file_ktp) }}" target="_blank"
                                        class="hover:underline">Lihat berkas aktif saat ini</a>
                                </p>
                            @endif
                            @error('file_ktp')
                                <p class="text-[11px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>

                {{-- Tombol Submit di Bawah Tengah/Kanan --}}
                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="btn h-14 bg-indigo-600 hover:bg-indigo-700 border-none text-white font-black px-8 rounded-2xl text-sm transition-all shadow-xl shadow-indigo-100">
                        <i class="fa-solid fa-user-check mr-1.5"></i> Perbarui Semua Profil & Akun
                    </button>
                </div>
            </form>
        </div>

        {{-- ================= BAGIAN 2: DATA ANGGOTA KELOMPOK ================= --}}
        <div class="bg-white p-8 rounded-[3rem] border border-slate-200 shadow-sm">
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600"><i
                            class="fa-solid fa-users"></i></div>
                    <div>
                        <h3 class="text-lg font-black text-slate-800">Daftar Anggota Kelompok</h3>
                        <p class="text-xs text-slate-400">Total terdaftar: {{ $spp->members->count() }} orang anggota
                            perempuan.
                        </p>
                    </div>
                </div>
                <button onclick="modal_tambah_anggota.showModal()"
                    class="btn btn-sm bg-slate-900 hover:bg-slate-800 border-none text-white font-bold rounded-xl px-4 text-xs">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah Anggota
                </button>
            </div>

            {{-- Tabel Anggota --}}
            <div class="overflow-x-auto">
                <table class="table w-full border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-slate-400 border-none text-xs uppercase tracking-wider">
                            <th class="bg-transparent pl-4">No</th>
                            <th class="bg-transparent">Nama Anggota</th>
                            <th class="bg-transparent">NIK</th>
                            <th class="bg-transparent text-center">Berkas KTP</th>
                            <th class="bg-transparent text-center pr-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm font-semibold text-slate-700">
                        @forelse($spp->members as $member)
                            <tr class="bg-slate-50/70 border border-slate-100 transition-all hover:bg-slate-50">
                                <td class="rounded-l-2xl pl-4 py-4">{{ $loop->iteration }}</td>
                                <td class="font-bold text-slate-800">{{ $member->nama_anggota }}</td>
                                <td>{{ $member->nik }}</td>
                                {{-- <td>{{ $member->no_hp_anggota ?? '-' }}</td> --}}
                                <td class="text-center">
                                    @if ($member->file_ktp)
                                        <a href="{{ asset('File/SPP/KTP/' . $member->file_ktp) }}" target="_blank"
                                            class="badge badge-indigo border-none bg-indigo-50 text-indigo-600 font-bold hover:underline py-3 px-3 rounded-lg text-xs">
                                            <i class="fa-solid fa-image mr-1"></i> Lihat KTP
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Belum upload</span>
                                    @endif
                                </td>
                                <td class="rounded-r-2xl text-center pr-4 flex items-center justify-center gap-3 py-4">
                                    {{-- Tombol Trigger Edit dengan Data Atribut --}}
                                    <button type="button" onclick="bukaModalEdit(this)" data-id="{{ $member->id }}"
                                        data-nama="{{ $member->nama_anggota }}" data-nik="{{ $member->nik }}"
                                        class="text-indigo-600 hover:text-indigo-800 transition-colors">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    {{-- Form Hapus (Tetap Sama Seperti Sebelumnya) --}}
                                    <form action="{{ url('/spp-group-rev-member/' . $member->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus anggota ini?')">
                                        @csrf
                                        @method('DELETE')
                                        {{-- Tombol Trigger Modal Konfirmasi Hapus --}}
                                        <button type="button" onclick="konfirmasiHapus(this)"
                                            data-id="{{ $member->id }}" data-nama="{{ $member->nama_anggota }}"
                                            class="text-red-500 hover:text-red-700 transition-colors">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="text-center py-10 text-slate-400 italic bg-slate-50 rounded-2xl">
                                    Belum ada data anggota. Klik tombol "Tambah Anggota" di atas untuk memasukkan pengurus
                                    kelompok.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    {{-- MODAL TAMBAH ANGGOTA --}}
    {{-- Deteksi jika ada error spesifik dari form tambah anggota, maka buka modal otomatis --}}
    <dialog id="modal_tambah_anggota" class="modal" @if (
        $errors->has('nama_anggota') ||
            $errors->has('nik_anggota') ||
            $errors->has('no_hp_anggota') ||
            $errors->has('foto_ktp')) open @endif>

        <div class="modal-box max-w-md rounded-[2.5rem] p-8 border border-slate-100 shadow-2xl bg-white">
            <h3 class="font-black text-xl text-slate-800 mb-2">Tambah Anggota Kelompok</h3>
            <p class="text-xs text-slate-400 mb-6">Pastikan data identitas sesuai dengan KTP asli yang bersangkutan.</p>

            <form action="{{ url('/spp-group-rev-member') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf

                <input type="hidden" name="group_id" value="{{ $spp->id }}">

                {{-- Nama Anggota --}}
                <div class="form-control">
                    <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Nama Lengkap Anggota</label>
                    <input type="text" name="nama_anggota" value="{{ old('nama_anggota') }}" required
                        placeholder="Contoh: Ibu Herlina"
                        class="input input-bordered w-full rounded-2xl bg-slate-50 @error('nama_anggota') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500">
                    @error('nama_anggota')
                        <p class="text-[11px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- NIK Anggota --}}
                <div class="form-control">
                    <label class="label text-xs font-bold text-slate-600 uppercase ml-1">NIK Anggota (16 Digit)</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" maxlength="16" required
                        placeholder="Masukkan NIK Anggota"
                        class="input input-bordered w-full rounded-2xl bg-slate-50 @error('nik') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500">
                    @error('nik')
                        <p class="text-[11px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Foto KTP --}}
                <div class="form-control">
                    <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Foto KTP Anggota</label>
                    <input type="file" name="file_ktp" required
                        class="file-input file-input-bordered w-full rounded-2xl bg-slate-50 @error('file_ktp') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500 text-sm">
                    @error('file_ktp')
                        <p class="text-[11px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="modal-action pt-4 gap-2">
                    {{-- Tombol Batal Menggunakan Form Method Dialog untuk Menutup Modal Secara Alami --}}
                    <button type="button" onclick="window.location.reload();"
                        class="btn btn-ghost rounded-2xl font-bold text-xs">Batal</button>
                    <button type="submit"
                        class="btn bg-indigo-600 hover:bg-indigo-700 text-white font-black px-6 rounded-2xl text-xs border-none">
                        Simpan Anggota
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- ================= MODAL EDIT ANGGOTA ================= --}}
    <dialog id="modal_edit_anggota" class="modal" @if (session('error_modal') == 'edit') open @endif>
        <div class="modal-box max-w-md rounded-[2.5rem] p-8 border border-slate-100 shadow-2xl bg-white">
            <h3 class="font-black text-xl text-slate-800 mb-2">Ubah Data Anggota</h3>
            <p class="text-xs text-slate-400 mb-6">Perbarui informasi data identitas pengurus kelompok.</p>

            {{-- Action URL akan diisi secara dinamis melalui JavaScript --}}
            <form id="form_edit_anggota" action="" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Nama Anggota --}}
                <div class="form-control">
                    <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Nama Lengkap Anggota</label>
                    <input type="text" name="nama_anggota" id="edit_nama" required
                        class="input input-bordered w-full rounded-2xl bg-slate-50 border-slate-200 focus:border-indigo-500">
                    @error('nama_anggota')
                        @if (session('error_modal') == 'edit')
                            <p class="text-[11px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                        @endif
                    @enderror
                </div>

                {{-- NIK Anggota --}}
                <div class="form-control">
                    <label class="label text-xs font-bold text-slate-600 uppercase ml-1">NIK Anggota (16 Digit)</label>
                    <input type="text" name="nik" id="edit_nik" maxlength="16" required
                        class="input input-bordered w-full rounded-2xl bg-slate-50 border-slate-200 focus:border-indigo-500">
                    @error('nik')
                        @if (session('error_modal') == 'edit')
                            <p class="text-[11px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                        @endif
                    @enderror
                </div>


                {{-- Foto KTP --}}
                <div class="form-control">
                    <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Foto KTP Anggota (Kosongkan jika
                        tidak diganti)</label>
                    <input type="file" name="file_ktp"
                        class="file-input file-input-bordered w-full rounded-2xl bg-slate-50 border-slate-200 focus:border-indigo-500 text-sm">
                    @error('file_ktp')
                        @if (session('error_modal') == 'edit')
                            <p class="text-[11px] text-red-500 font-bold mt-1 ml-1">{{ $message }}</p>
                        @endif
                    @enderror
                </div>

                <div class="modal-action pt-4 gap-2">
                    <button type="button" onclick="window.location.reload();"
                        class="btn btn-ghost rounded-2xl font-bold text-xs">Batal</button>
                    <button type="submit"
                        class="btn bg-indigo-600 hover:bg-indigo-700 text-white font-black px-6 rounded-2xl text-xs border-none">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- ================= MODAL KONFIRMASI HAPUS ANGGOTA ================= --}}
    <dialog id="modal_hapus_anggota" class="modal">
        <div class="modal-box max-w-sm rounded-[2.5rem] p-8 border border-slate-100 shadow-2xl bg-white text-center">

            {{-- Ikon Peringatan Minimalis --}}
            <div
                class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>

            <h3 class="font-black text-xl text-slate-800 mb-2">Hapus Anggota?</h3>
            <p class="text-xs text-slate-500 leading-relaxed px-2">
                Apakah Anda yakin ingin menghapus <strong id="hapus_nama_text" class="text-slate-800"></strong> dari
                kelompok SPP ini? Tindakan ini juga akan menghapus berkas KTP fisik mereka secara permanen.
            </p>

            {{-- Form Action Dinamis --}}
            <form id="form_hapus_anggota" action="" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex gap-3 mt-6 justify-center">
                    {{-- Tombol Batal --}}
                    <button type="button" onclick="modal_hapus_anggota.close()"
                        class="btn btn-ghost flex-1 rounded-2xl font-bold text-xs">
                        Batal
                    </button>
                    {{-- Tombol Eksekusi Hapus --}}
                    <button type="submit"
                        class="btn bg-red-500 hover:bg-red-600 border-none text-white font-black flex-1 rounded-2xl text-xs shadow-lg shadow-red-100">
                        Ya, Hapus
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Cek apakah ada error dari salah satu input form tambah anggota
            @if ($errors->has('nama_anggota') || $errors->has('nik') || $errors->has('file_ktp'))
                const modalAnggota = document.getElementById('modal_tambah_anggota');
                if (modalAnggota) {
                    modalAnggota.showModal();
                }
            @endif
        });
    </script>

    <script>
        // Fungsi untuk memindahkan data dari baris tabel ke dalam Modal Edit
        function bukaModalEdit(button) {
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');
            const nik = button.getAttribute('data-nik');

            // Set action form secara dinamis menuju URL update
            document.getElementById('form_edit_anggota').action =
                `{{ url('spp-group-rev-member/') }}/${id}`;

            // Masukkan data ke input field modal edit
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_nik').value = nik;

            // Panggil modal DaisyUI untuk tampil
            document.getElementById('modal_edit_anggota').showModal();
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Pemanggil otomatis jika modal TAMBAH ada error
            @if (session('error_modal') != 'edit' &&
                    ($errors->has('nama_anggota') || $errors->has('nik') || $errors->has('foto_ktp')))
                document.getElementById('modal_tambah_anggota').showModal();
            @endif

            // Pemanggil otomatis jika modal EDIT ada error
            @if (session('error_modal') == 'edit')
                // Ambil kembali URL action yang gagal dari session lama jika diperlukan, atau buka modal langsung
                document.getElementById('modal_edit_anggota').showModal();
            @endif
        });
    </script>

    <script>
        // Fungsi untuk memicu modal hapus dan mengeset action form secara dinamis
        function konfirmasiHapus(button) {
            const id = button.getAttribute('data-id');
            const nama = button.getAttribute('data-nama');

            // Set action URL form menuju route destruksi milik Anda
            document.getElementById('form_hapus_anggota').action = `{{ url('/spp-group-rev-member') }}/${id}`;

            // Ubah teks nama anggota di dalam modal agar informatif
            document.getElementById('hapus_nama_text').innerText = nama;

            // Tampilkan modal konfirmasi hapus DaisyUI
            document.getElementById('modal_hapus_anggota').showModal();
        }
    </script>
@endsection
