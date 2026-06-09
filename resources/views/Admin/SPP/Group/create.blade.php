@extends('Admin.Layouts.main')

@section('content')
    <div class="p-6 max-w-5xl mx-auto space-y-6">

        {{-- Error Validation Alert --}}
        @if ($errors->any())
            <div class="alert alert-error rounded-2xl border-none text-white font-bold shadow-md p-4">
                <div class="flex flex-col gap-1">
                    <span class="text-sm font-black flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation"></i>
                        Terjadi Kesalahan Input:</span>
                    <ul class="list-disc list-inside text-xs font-medium pl-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Header --}}
        <div class="flex items-center gap-4 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl"><i class="fa-regular fa-user text-xl"></i></div>
            <div>
                <h1 class="text-xl font-black text-slate-800 tracking-tight">Pendaftaran Kelompok & Anggota</h1>
                <p class="text-xs text-slate-400 mt-0.5">Input data induk kelompok beserta manifest berkas KTP seluruh
                    anggotanya.</p>
            </div>
        </div>

        {{-- Form Utama --}}
        <form action="{{ url('/spp-group') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-8">
                {{-- SEKSI 1: DATA INDUK KELOMPOK --}}
                <div class="rounded-[2.5rem] border border-slate-100 bg-white p-8 shadow-xl shadow-slate-100/50 space-y-6">
                    <h2 class="text-xs font-black uppercase tracking-[0.2em] text-indigo-600 mb-2">
                        <i class="fa-solid fa-home mr-1"></i> Informasi Profil Kelompok
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Nama Kelompok --}}
                        <div class="flex w-full flex-col">
                            <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Nama Kelompok Perempuan</label>
                            <input type="text" name="nama_kelompok" value="{{ old('nama_kelompok') }}"
                                placeholder="Contoh: Melati, Mawar"
                                class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0"
                                required />
                        </div>

                        {{-- Nama Ketua --}}
                        <div class="flex w-full flex-col">
                            <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Nama Ketua Kelompok (PIC)</label>
                            <input type="text" name="nama_ketua" value="{{ old('nama_ketua') }}"
                                placeholder="Nama penanggung jawab kelompok"
                                class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0"
                                required />
                        </div>

                        {{-- NIK Ketua (Tambahan Baru) --}}
                        <div class="flex w-full flex-col">
                            <label class="mb-2 ml-1 text-sm font-bold text-slate-600">NIK Ketua Kelompok</label>
                            <input type="text" name="nik_ketua" value="{{ old('nik_ketua') }}"
                                placeholder="Contoh: 16 digit nomor induk kependudukan" maxlength="16" minlength="16"
                                class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0 font-medium"
                                required />
                        </div>

                        {{-- No HP Ketua --}}
                        <div class="flex w-full flex-col">
                            <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Nomor HP / WhatsApp Ketua</label>
                            <input type="text" name="no_hp_ketua" value="{{ old('no_hp_ketua') }}"
                                placeholder="Contoh: 0812xxxxxxxx"
                                class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0"
                                required />
                        </div>

                        {{-- File KTP Ketua (Tambahan Baru) --}}
                        <div class="flex w-full flex-col md:col-span-2">
                            <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Upload KTP Ketua Kelompok</label>
                            <input type="file" name="file_ktp" accept="image/*,application/pdf"
                                class="file-input file-input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 font-medium text-slate-600 file:bg-slate-900 file:text-white file:border-none file:h-full file:px-5"
                                required />
                            <span class="text-[10px] text-slate-400 mt-1 ml-1">* Format berkas: JPG, PNG, atau PDF (Maksimal
                                2MB)</span>
                        </div>

                        {{-- Alamat Kelompok --}}
                        <div class="flex w-full flex-col md:col-span-2">
                            <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Alamat Lingkungan / Domisili
                                Kelompok</label>
                            <textarea name="alamat_kelompok" placeholder="Tulis alamat lengkap atau RT/RW domisili kelompok berkumpul..."
                                class="textarea textarea-bordered min-h-[100px] w-full rounded-2xl border-slate-200 bg-slate-50 p-5 focus:border-indigo-500 focus:outline-none focus:ring-0"
                                required>{{ old('alamat_kelompok') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- SEKSI 2: DATA ANGGOTA & KTP (DINAMIS) --}}
                {{-- SEKSI 2: DATA ANGGOTA & KTP (ANTI-HILANG SAAT GAGAL VALIDASI) --}}
                <div class="rounded-[2.5rem] border border-slate-100 bg-white p-8 shadow-xl shadow-slate-100/50 space-y-6">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-4">
                        <div>
                            <h2 class="text-xs font-black uppercase tracking-[0.2em] text-indigo-600">
                                <i class="fa-solid fa-users mr-1"></i> Daftar Anggota Kelompok
                            </h2>
                            <p class="text-[11px] text-slate-400 mt-0.5">Wajib menyertakan NIK valid dan unggahan fotokopi
                                KTP asli.</p>
                        </div>
                        <button type="button" onclick="addMemberRow()"
                            class="btn btn-sm rounded-xl border-none bg-indigo-50 text-indigo-600 hover:bg-indigo-100 font-black text-xs px-4">
                            <i class="fa-solid fa-user-plus mr-1"></i> Tambah Baris
                        </button>
                    </div>

                    {{-- Wadah Container Baris Anggota --}}
                    <div id="members-container" class="space-y-4">

                        {{-- JIKA ADA DATA LAMA (KARENA GAGAL VALIDASI) --}}
                        @if (old('anggota'))
                            @foreach (old('anggota') as $index => $oldAnggota)
                                <div
                                    class="member-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 items-end">
                                    <div class="md:col-span-4 flex flex-col">
                                        <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">Nama Anggota</label>
                                        <input type="text" name="anggota[{{ $index }}][nama]"
                                            value="{{ $oldAnggota['nama'] }}"
                                            class="input input-sm input-bordered w-full rounded-xl border-slate-200 bg-white px-4 focus:border-indigo-500"
                                            required />
                                    </div>

                                    <div class="md:col-span-4 flex flex-col">
                                        <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">NIK (Nomor KTP)</label>
                                        <input type="text" name="anggota[{{ $index }}][nik]"
                                            value="{{ $oldAnggota['nik'] }}" maxlength="16" minlength="16"
                                            class="input input-sm input-bordered w-full rounded-xl border-slate-200 bg-white px-4 focus:border-indigo-500"
                                            required />
                                    </div>

                                    <div class="md:col-span-3 flex flex-col">
                                        <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">File Fotokopi
                                            KTP</label>
                                        <input type="file" name="anggota[{{ $index }}][file_ktp]"
                                            class="file-input file-input-sm file-input-bordered w-full rounded-xl border-slate-200 bg-white"
                                            {{ $index == 0 ? 'required' : '' }} />
                                        <span class="text-[10px] text-amber-600 font-medium mt-1">* Pilih ulang file
                                            KTP</span>
                                    </div>

                                    <div class="md:col-span-1 text-center">
                                        @if ($index == 0)
                                            <button type="button"
                                                class="btn btn-sm btn-square rounded-xl bg-slate-200 text-slate-400 border-none cursor-not-allowed"
                                                disabled><i class="fa-solid fa-trash text-xs"></i></button>
                                        @else
                                            <button type="button" onclick="removeMemberRow(this)"
                                                class="btn btn-sm btn-square rounded-xl bg-red-50 text-red-600 hover:bg-red-100 border-none"><i
                                                    class="fa-solid fa-trash text-xs"></i></button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            {{-- JIKA KONDISI NORMAL (BARU PERTAMA KALI BUKA HALAMAN) --}}
                        @else
                            <div
                                class="member-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 items-end">
                                <div class="md:col-span-4 flex flex-col">
                                    <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">Nama Anggota</label>
                                    <input type="text" name="anggota[0][nama]"
                                        class="input input-sm input-bordered w-full rounded-xl border-slate-200 bg-white px-4 focus:border-indigo-500"
                                        placeholder="Nama Lengkap" />
                                </div>

                                <div class="md:col-span-4 flex flex-col">
                                    <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">NIK (Nomor KTP)</label>
                                    <input type="text" name="anggota[0][nik]" maxlength="16"
                                        class="input input-sm input-bordered w-full rounded-xl border-slate-200 bg-white px-4 focus:border-indigo-500"
                                        placeholder="16 Digit NIK" required />
                                </div>

                                <div class="md:col-span-3 flex flex-col">
                                    <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">File Fotokopi KTP</label>
                                    <input type="file" name="anggota[0][file_ktp]"
                                        class="file-input file-input-sm file-input-bordered w-full rounded-xl border-slate-200 bg-white file:bg-slate-900 file:border-none text-xs"
                                        required />
                                </div>

                                <div class="md:col-span-1 text-center">
                                    <button type="button"
                                        class="btn btn-sm btn-square rounded-xl bg-slate-200 text-slate-400 border-none cursor-not-allowed"
                                        disabled><i class="fa-solid fa-trash text-xs"></i></button>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                {{-- FOOTER / SUBMIT ACTION --}}
                <div class="flex items-center justify-end gap-4 border-t border-slate-100 pt-6">
                    <a href="{{ url('/spp-group') }}"
                        class="btn btn-ghost rounded-2xl px-10 font-black uppercase tracking-widest text-slate-400">
                        Batal
                    </a>
                    <button type="submit"
                        class="btn rounded-2xl border-none bg-indigo-600 px-12 font-black uppercase tracking-widest text-white shadow-xl shadow-indigo-100 transition-all hover:-translate-y-1 hover:bg-indigo-700">
                        Simpan Kelompok
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- JAVASCRIPT INJECTOR: Kontrol Penambahan Baris Anggota --}}
    <script>
        let memberIndex = 1; // Mulai indeks dari 1 karena indeks 0 sudah dipakai baris default

        function addMemberRow() {
            const container = document.getElementById('members-container');

            // Template HTML Baris Anggota Baru dengan Indeks Dinamis
            const rowHtml = `
            <div class="member-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 items-end animation-fade-in">
                <div class="md:col-span-4 flex flex-col">
                    <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">Nama Anggota</label>
                    <input type="text" name="anggota[${memberIndex}][nama]" class="input input-sm input-bordered w-full rounded-xl border-slate-200 bg-white px-4 maxlength="100" focus:border-indigo-500 focus:outline-none" placeholder="Nama Lengkap" required />
                </div>
                
                <div class="md:col-span-4 flex flex-col">
                    <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">NIK (Nomor KTP)</label>
                    <input type="text" name="anggota[${memberIndex}][nik]" maxlength="16" minlength="16" class="input input-sm input-bordered w-full rounded-xl border-slate-200 bg-white px-4 focus:border-indigo-500 focus:outline-none" placeholder="16 Digit NIK" required />
                </div>
                
                <div class="md:col-span-3 flex flex-col">
                    <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">File Fotokopi KTP</label>
                    <input type="file" name="anggota[${memberIndex}][file_ktp]" class="file-input file-input-sm file-input-bordered w-full rounded-xl border-slate-200 bg-white file:bg-slate-900 file:border-none file:text-white file:text-[10px] file:font-bold hover:file:bg-indigo-600" required />
                </div>

                <div class="md:col-span-1 text-center">
                    <button type="button" onclick="removeMemberRow(this)" class="btn btn-sm btn-square rounded-xl bg-red-50 text-red-600 hover:bg-red-100 border-none transition-all shadow-sm">
                        <i class="fa-solid fa-trash text-xs"></i>
                    </button>
                </div>
            </div>
        `;

            // Sisipkan baris baru ke dalam kontainer
            container.insertAdjacentHTML('beforeend', rowHtml);
            memberIndex++; // Naikkan indeks untuk baris berikutnya
        }

        function removeMemberRow(button) {
            // Hapus elemen div induk (.member-row) dari baris yang tombol tong sampahnya diklik
            const row = button.closest('.member-row');
            if (row) {
                row.remove();
            }
        }
    </script>
@endsection
