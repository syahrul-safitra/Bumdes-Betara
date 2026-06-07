@extends('Admin.Layouts.main')

@section('content')
    <main class="min-h-screen bg-slate-50/50 p-4 antialiased md:p-8 lg:p-12">
        <div class="mx-auto max-w-7xl">
            {{-- Header --}}
            <div class="mb-8 text-left">
                {{-- <div class="flex items-center gap-3 text-sm font-semibold uppercase tracking-widest text-slate-400">
                    <a href="{{ url("customer") }}" class="transition-all hover:text-emerald-600">Customer</a>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    <span class="text-slate-800">Edit Profil</span>
                </div> --}}
                <h1 class="mt-2 text-3xl font-black uppercase italic tracking-tighter text-slate-800">
                    Update Data <span class="text-emerald-600">Customer</span>
                </h1>
            </div>

            {{-- Card Form --}}
            <div class="rounded-[2.5rem] border border-slate-100 bg-white p-8 shadow-xl shadow-slate-200/50">
                <form action="{{ url('customer/' . $customer->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-10 lg:grid-cols-2">

                        {{-- Kolom Kiri --}}
                        <div class="flex flex-col gap-6">
                            <h2 id="header-kiri" class="text-xs font-black uppercase tracking-[0.2em] text-emerald-600">
                                Informasi Pribadi / Instansi</h2>

                            {{-- Tipe Customer --}}
                            <div class="flex w-full flex-col">
                                <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Tipe Keanggotaan</label>
                                <select name="tipe" id="edit-tipe" onchange="handleEditTypeChange(this.value)"
                                    class="select select-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-emerald-500 focus:outline-none focus:ring-0 font-medium">
                                    <option value="individu"
                                        {{ old('tipe', $customer->tipe) == 'individu' ? 'selected' : '' }}>Individu /
                                        Pribadi</option>
                                    <option value="perusahaan"
                                        {{ old('tipe', $customer->tipe) == 'perusahaan' ? 'selected' : '' }}>Perusahaan / PT
                                    </option>
                                </select>
                            </div>

                            {{-- Nama --}}
                            <div class="flex w-full flex-col">
                                <label id="label-edit-nama" class="mb-2 ml-1 text-sm font-bold text-slate-600">Nama
                                    Lengkap</label>
                                <input type="text" name="nama" id="input-edit-nama"
                                    value="{{ old('nama', $customer->nama) }}"
                                    class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-emerald-500 focus:outline-none focus:ring-0 custom-edit-focus"
                                    required />
                            </div>

                            {{-- Email --}}
                            <div class="flex w-full flex-col">
                                <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                                    class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-emerald-500 focus:outline-none focus:ring-0 custom-edit-focus"
                                    required />
                            </div>

                            {{-- Telepon --}}
                            <div class="flex w-full flex-col">
                                <label id="label-edit-telepon" class="mb-2 ml-1 text-sm font-bold text-slate-600">Nomor
                                    Telepon / WhatsApp</label>
                                <input type="text" name="no_telepon"
                                    value="{{ old('no_telepon', $customer->no_telepon) }}"
                                    class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-emerald-500 focus:outline-none focus:ring-0 custom-edit-focus"
                                    required />
                            </div>

                            {{-- Alamat --}}
                            <div class="flex w-full flex-col">
                                <label id="label-edit-alamat" class="mb-2 ml-1 text-sm font-bold text-slate-600">Alamat
                                    Rumah</label>
                                <textarea name="alamat" id="textarea-edit-alamat"
                                    class="textarea textarea-bordered min-h-[120px] w-full rounded-2xl border-slate-200 bg-slate-50 p-5 focus:border-emerald-500 focus:outline-none focus:ring-0 custom-edit-focus"
                                    required>{{ old('alamat', $customer->alamat) }}</textarea>
                            </div>
                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="flex flex-col gap-6">
                            <h2 id="header-kanan" class="text-xs font-black uppercase tracking-[0.2em] text-emerald-600">
                                Keamanan & Identitas</h2>

                            {{-- Password --}}
                            <div class="flex w-full flex-col">
                                <div class="mb-2 flex items-center justify-between px-1">
                                    <label class="text-sm font-bold text-slate-600">Ganti Password</label>
                                    <span
                                        class="text-[10px] font-medium uppercase italic tracking-tighter text-slate-400">Kosongkan
                                        jika tetap</span>
                                </div>
                                <input type="text" name="password" placeholder="••••••••"
                                    class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-emerald-500 focus:outline-none focus:ring-0 custom-edit-focus" />
                            </div>

                            {{-- Berkas Identitas Dinamis --}}
                            <div class="flex w-full flex-col">
                                <label id="label-edit-identitas" class="mb-2 ml-1 text-sm font-bold text-slate-600">Dokumen
                                    KTP</label>

                                {{-- Container Preview --}}
                                <div
                                    class="group relative mb-4 mt-2 overflow-hidden rounded-3xl border border-slate-100 bg-slate-50 p-2">
                                    <div
                                        class="absolute inset-0 z-10 flex items-center justify-center bg-slate-900/40 opacity-0 transition-opacity group-hover:opacity-100">
                                        <span id="text-edit-overlay"
                                            class="text-[10px] font-black uppercase tracking-widest text-white">Preview
                                            Dokumen</span>
                                    </div>

                                    {{-- Diganti dari gambar_ktp menjadi file_identitas --}}
                                    <img id="preview-identitas"
                                        src="{{ $customer->file_identitas ? asset('File/' . $customer->file_identitas) : 'https://placehold.co/600x400/f8fafc/cbd5e1?text=No+Image' }}"
                                        class="h-44 w-full rounded-2xl object-cover transition-all" alt="Preview Identitas">
                                </div>

                                {{-- Input File diubah name-nya menjadi file_identitas --}}
                                <input type="file" name="file_identitas" id="input-identitas"
                                    onchange="previewEditImage(this)"
                                    class="file-input file-input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 file:mr-4 file:border-none file:bg-slate-900 file:px-6 file:text-[10px] file:font-black file:uppercase file:text-white hover:file:bg-emerald-600" />

                                <span
                                    class="ml-1 mt-2 text-[10px] font-bold uppercase italic tracking-widest text-slate-400">
                                    Max 2MB (JPG/PNG)
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="mt-12 flex items-center justify-end gap-4 border-t border-slate-50 pt-10">
                        <a href="{{ url('customer') }}"
                            class="btn btn-ghost rounded-2xl px-10 font-black uppercase tracking-widest text-slate-400">
                            Batal
                        </a>
                        <button type="submit" id="btn-edit-submit"
                            class="btn rounded-2xl border-none bg-emerald-600 px-12 font-black uppercase tracking-widest text-white shadow-xl shadow-emerald-100 transition-all hover:-translate-y-1 hover:bg-emerald-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function previewImage() {
            const input = document.getElementById('input-ktp');
            const preview = document.getElementById('preview-ktp');

            // Pastikan ada file yang dipilih
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                // Saat file selesai dibaca
                reader.onload = function(e) {
                    // Ubah source gambar preview menjadi data URL file baru
                    preview.src = e.target.result;

                    // Tambahkan sedikit efek animasi saat berubah
                    preview.classList.add('scale-95');
                    setTimeout(() => {
                        preview.classList.remove('scale-95');
                    }, 100);
                }

                // Baca file sebagai Data URL
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script>
        function handleEditTypeChange(type) {
            const headerKiri = document.getElementById('header-kiri');
            const headerKanan = document.getElementById('header-kanan');
            const selectTipe = document.getElementById('edit-tipe');
            const labelNama = document.getElementById('label-edit-nama');
            const inputNama = document.getElementById('input-edit-nama');
            const labelTelepon = document.getElementById('label-edit-telepon');
            const labelAlamat = document.getElementById('label-edit-alamat');
            const labelIdentitas = document.getElementById('label-edit-identitas');
            const textOverlay = document.getElementById('text-edit-overlay');
            const btnSubmit = document.getElementById('btn-edit-submit');
            const fileInput = document.getElementById('input-identitas');
            const focusElements = document.querySelectorAll('.custom-edit-focus');

            if (type === 'perusahaan') {
                // 1. Ubah Teks Label ke Mode Perusahaan (PT)
                labelNama.innerText = "Nama Perusahaan / PT";
                labelTelepon.innerText = "Nomor Telepon Kantor (PIC)";
                labelAlamat.innerText = "Alamat Kantor Utama / Pusat";
                labelIdentitas.innerText = "Dokumen NPWP Perusahaan";
                textOverlay.innerText = "Preview NPWP";

                // 2. Ubah Warna Tema Komponen Utama ke Indigo (Ungu)
                headerKiri.className = "text-xs font-black uppercase tracking-[0.2em] text-indigo-600";
                headerKanan.className = "text-xs font-black uppercase tracking-[0.2em] text-indigo-600";
                selectTipe.classList.remove('focus:border-emerald-500');
                selectTipe.classList.add('focus:border-indigo-500');

                fileInput.className =
                    "file-input file-input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 file:mr-4 file:border-none file:bg-slate-900 file:px-6 file:text-[10px] file:font-black file:uppercase file:text-white hover:file:bg-indigo-600";

                btnSubmit.className =
                    "btn rounded-2xl border-none bg-indigo-600 px-12 font-black uppercase tracking-widest text-white shadow-xl shadow-indigo-100 transition-all hover:-translate-y-1 hover:bg-indigo-700";

                focusElements.forEach(el => {
                    el.classList.remove('focus:border-emerald-500');
                    el.classList.add('focus:border-indigo-500');
                });
            } else {
                // 1. Kembalikan Teks Label ke Mode Individu
                labelNama.innerText = "Nama Lengkap";
                labelTelepon.innerText = "Nomor Telepon / WhatsApp";
                labelAlamat.innerText = "Alamat Rumah";
                labelIdentitas.innerText = "Dokumen KTP";
                textOverlay.innerText = "Preview KTP";

                // 2. Kembalikan Warna Tema Komponen Utama ke Emerald (Hijau)
                headerKiri.className = "text-xs font-black uppercase tracking-[0.2em] text-emerald-600";
                headerKanan.className = "text-xs font-black uppercase tracking-[0.2em] text-emerald-600";
                selectTipe.classList.remove('focus:border-indigo-500');
                selectTipe.classList.add('focus:border-emerald-500');

                fileInput.className =
                    "file-input file-input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 file:mr-4 file:border-none file:bg-slate-900 file:px-6 file:text-[10px] file:font-black file:uppercase file:text-white hover:file:bg-emerald-600";

                btnSubmit.className =
                    "btn rounded-2xl border-none bg-emerald-600 px-12 font-black uppercase tracking-widest text-white shadow-xl shadow-emerald-100 transition-all hover:-translate-y-1 hover:bg-emerald-700";

                focusElements.forEach(el => {
                    el.classList.remove('focus:border-indigo-500');
                    el.classList.add('focus:border-emerald-500');
                });
            }
        }

        // Fungsi Pengganti previewImage() Lama agar Mendukung Sistem ID Baru
        function previewEditImage(input) {
            const preview = document.getElementById('preview-identitas');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Pemicu Otomatis saat Halaman Dimuat Berdasarkan Data dari Database
        document.addEventListener("DOMContentLoaded", function() {
            const currentType = document.getElementById('edit-tipe').value;
            handleEditTypeChange(currentType);
        });
    </script>
@endsection
