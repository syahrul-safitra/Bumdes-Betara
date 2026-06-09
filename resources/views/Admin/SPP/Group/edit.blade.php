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
        <div class="flex items-center justify-between bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl"><i class="fa-solid fa-user-gear text-xl"></i></div>
                <div>
                    <h1 class="text-xl font-black text-slate-800 tracking-tight">Edit Kelompok: {{ $group->nama_kelompok }}
                    </h1>
                    <p class="text-xs text-slate-400 mt-0.5">Perbarui profil kelompok, kelola status, atau sesuaikan data
                        berkas anggota.</p>
                </div>
            </div>
        </div>

        {{-- Form Utama --}}
        <form action="{{ url('/spp-group/' . $group->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

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
                            <input type="text" name="nama_kelompok"
                                value="{{ old('nama_kelompok', $group->nama_kelompok) }}"
                                class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0"
                                required />
                        </div>

                        {{-- Nama Ketua --}}
                        <div class="flex w-full flex-col">
                            <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Nama Ketua Kelompok (PIC)</label>
                            <input type="text" name="nama_ketua" value="{{ old('nama_ketua', $group->nama_ketua) }}"
                                class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0"
                                required />
                        </div>

                        {{-- NIK Ketua (Tambahan Baru) --}}
                        <div class="flex w-full flex-col">
                            <label class="mb-2 ml-1 text-sm font-bold text-slate-600">NIK Ketua Kelompok</label>
                            <input type="text" name="nik_ketua" value="{{ old('nik_ketua', $group->nik_ketua) }}"
                                maxlength="16" placeholder="Contoh: 16 digit nomor induk kependudukan"
                                class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0 font-medium"
                                required />
                        </div>

                        {{-- No HP Ketua --}}
                        <div class="flex w-full flex-col">
                            <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Nomor HP / WhatsApp Ketua</label>
                            <input type="text" name="no_hp_ketua" value="{{ old('no_hp_ketua', $group->no_hp_ketua) }}"
                                class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0"
                                required />
                        </div>

                        {{-- Status Kelompok --}}
                        <div class="flex w-full flex-col">
                            <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Status Keaktifan Kelompok</label>
                            <select name="status"
                                class="select select-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0 font-medium">
                                <option value="aktif" {{ old('status', $group->status) == 'aktif' ? 'selected' : '' }}>
                                    Aktif</option>
                                <option value="non_aktif"
                                    {{ old('status', $group->status) == 'non_aktif' ? 'selected' : '' }}>Non-Aktif /
                                    Dibekukan</option>
                            </select>
                        </div>

                        {{-- File KTP Ketua (Tambahan Baru) --}}
                        <div class="flex w-full flex-col">
                            <div class="mb-2 flex items-center justify-between px-1">
                                <label class="text-sm font-bold text-slate-600">Ganti KTP Ketua Kelompok</label>
                                <span
                                    class="text-[10px] font-medium uppercase italic tracking-tighter text-slate-400">Kosongkan
                                    jika tetap</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="file" name="file_ktp" accept="image/*,application/pdf"
                                    class="file-input file-input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 font-medium text-slate-600 file:bg-slate-900 file:text-white file:border-none file:h-full file:px-4" />

                                @if ($group->file_ktp)
                                    <a href="{{ asset('File/SPP/KTP/' . $group->file_ktp) }}" target="_blank"
                                        class="btn h-14 w-14 btn-square bg-slate-900 text-white border-none rounded-2xl hover:bg-indigo-600 flex items-center justify-center shadow-lg"
                                        title="Lihat KTP Ketua Saat Ini">
                                        <i class="fa-solid fa-image text-base"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Alamat Kelompok --}}
                        <div class="flex w-full flex-col md:col-span-2">
                            <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Alamat Lingkungan / Domisili
                                Kelompok</label>
                            <textarea name="alamat_kelompok"
                                class="textarea textarea-bordered min-h-[100px] w-full rounded-2xl border-slate-200 bg-slate-50 p-5 focus:border-indigo-500 focus:outline-none focus:ring-0"
                                required>{{ old('alamat_kelompok', $group->alamat_kelompok) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- SEKSI 2: MANIPULASI DATA ANGGOTA --}}
                <div class="rounded-[2.5rem] border border-slate-100 bg-white p-8 shadow-xl shadow-slate-100/50 space-y-6">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-4">
                        <div>
                            <h2 class="text-xs font-black uppercase tracking-[0.2em] text-indigo-600">
                                <i class="fa-solid fa-users mr-1"></i> Anggota Terdaftar & Berkas KTP
                            </h2>
                            <p class="text-[11px] text-slate-400 mt-0.5">Kosongkan kolom input file KTP jika berkas tidak
                                ingin diganti.</p>
                        </div>
                        {{-- Tombol Tambah Anggota Baru --}}
                        <button type="button" onclick="addNewMemberEditRow()"
                            class="btn btn-sm rounded-xl border-none bg-indigo-50 text-indigo-600 hover:bg-indigo-100 font-black text-xs px-4">
                            <i class="fa-solid fa-user-plus mr-1"></i> Tambah Anggota Baru
                        </button>
                    </div>

                    {{-- Container List Anggota --}}
                    <div id="members-edit-container" class="space-y-4">

                        {{-- AMBIL DARI DATA LAMA (JIKA GAGAL VALIDASI) --}}
                        @if (old('anggota'))
                            @foreach (old('anggota') as $index => $oldAnggota)
                                <div
                                    class="member-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 items-end">
                                    {{-- Hidden ID Anggota jika dia anggota lama --}}
                                    <input type="hidden" name="anggota[{{ $index }}][id]"
                                        value="{{ $oldAnggota['id'] ?? '' }}">

                                    <div class="md:col-span-4 flex flex-col">
                                        <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">Nama Anggota</label>
                                        <input type="text" name="anggota[{{ $index }}][nama]"
                                            value="{{ $oldAnggota['nama'] }}"
                                            class="input input-sm input-bordered w-full rounded-xl border-slate-200 bg-white px-4"
                                            required />
                                    </div>

                                    <div class="md:col-span-4 flex flex-col">
                                        <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">NIK (Nomor KTP)</label>
                                        <input type="text" name="anggota[{{ $index }}][nik]"
                                            value="{{ $oldAnggota['nik'] }}" maxlength="16"
                                            class="input input-sm input-bordered w-full rounded-xl border-slate-200 bg-white px-4"
                                            required />
                                    </div>

                                    <div class="md:col-span-3 flex flex-col">
                                        <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">File KTP</label>
                                        <input type="file" name="anggota[{{ $index }}][file_ktp]"
                                            class="file-input file-input-sm file-input-bordered w-full rounded-xl" />
                                    </div>

                                    <div class="md:col-span-1 text-center">
                                        <button type="button" onclick="removeMemberEditRow(this)"
                                            class="btn btn-sm btn-square rounded-xl bg-red-50 text-red-600 hover:bg-red-100 border-none">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach

                            {{-- KONDISI NORMAL: LOAD DARI DATABASE KELOMPOK --}}
                        @else
                            @foreach ($group->members as $index => $member)
                                <div
                                    class="member-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100 items-end">
                                    {{-- Pasang ID unik record database --}}
                                    <input type="hidden" name="anggota[{{ $index }}][id]"
                                        value="{{ $member->id }}">

                                    <div class="md:col-span-4 flex flex-col">
                                        <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">Nama Anggota</label>
                                        <input type="text" name="anggota[{{ $index }}][nama]"
                                            value="{{ $member->nama_anggota }}"
                                            class="input input-sm input-bordered w-full rounded-xl border-slate-200 bg-white px-4 focus:border-indigo-500"
                                            required />
                                    </div>

                                    <div class="md:col-span-3 flex flex-col">
                                        <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">NIK (Nomor KTP)</label>
                                        <input type="text" name="anggota[{{ $index }}][nik]"
                                            value="{{ $member->nik }}" maxlength="16"
                                            class="input input-sm input-bordered w-full rounded-xl border-slate-200 bg-white px-4 focus:border-indigo-500"
                                            required />
                                    </div>

                                    <div class="md:col-span-4 flex flex-col">
                                        <label class="mb-1.5 ml-1 text-xs font-bold text-slate-500">Ganti File KTP</label>
                                        <div class="flex items-center gap-2">
                                            <input type="file" name="anggota[{{ $index }}][file_ktp]"
                                                class="file-input file-input-sm file-input-bordered w-full rounded-xl border-slate-200 bg-white text-xs" />
                                            @if ($member->file_ktp)
                                                <a href="{{ asset('File/SPP/KTP/' . $member->file_ktp) }}"
                                                    target="_blank"
                                                    class="btn btn-sm btn-square bg-slate-900 text-white border-none rounded-xl hover:bg-indigo-600"
                                                    title="Lihat KTP Saat Ini">
                                                    <i class="fa-solid fa-image text-xs"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="md:col-span-1 text-center">
                                        <button type="button" onclick="removeMemberEditRow(this)"
                                            class="btn btn-sm btn-square rounded-xl bg-red-50 text-red-600 hover:bg-red-100 border-none">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
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
                        Perbarui Kelompok
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- JAVASCRIPT ENGINE --}}
    <script>
        // Counter dihitung dari total jumlah anggota saat ini agar tidak tumpang tindih indeks array-nya
        let editMemberIndex = {{ old('anggota') ? count(old('anggota')) : $group->members->count() }};

        function addNewMemberEditRow() {
            const container = document.getElementById('members-edit-container');

            const rowHtml = `
            <div class="member-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-amber-50/40 rounded-2xl border border-amber-100 items-end">
                <input type="hidden" name="anggota[${editMemberIndex}][id]" value="">

                <div class="md:col-span-4 flex flex-col">
                    <label class="mb-1.5 ml-1 text-xs font-bold text-amber-700">Nama Anggota Baru</label>
                    <input type="text" name="anggota[${editMemberIndex}][nama]" class="input input-sm input-bordered w-full rounded-xl border-amber-200 bg-white px-4 focus:border-indigo-500" placeholder="Nama Lengkap" required />
                </div>
                
                <div class="md:col-span-3 flex flex-col">
                    <label class="mb-1.5 ml-1 text-xs font-bold text-amber-700">NIK Baru</label>
                    <input type="text" name="anggota[${editMemberIndex}][nik]" maxlength="16" class="input input-sm input-bordered w-full rounded-xl border-amber-200 bg-white px-4 focus:border-indigo-500" placeholder="16 Digit NIK" required />
                </div>
                
                <div class="md:col-span-4 flex flex-col">
                    <label class="mb-1.5 ml-1 text-xs font-bold text-amber-700">File KTP</label>
                    <input type="file" name="anggota[${editMemberIndex}][file_ktp]" class="file-input file-input-sm file-input-bordered w-full rounded-xl border-amber-200 bg-white text-xs" required />
                </div>

                <div class="md:col-span-1 text-center">
                    <button type="button" onclick="removeMemberEditRow(this)" class="btn btn-sm btn-square rounded-xl bg-red-50 text-red-600 hover:bg-red-100 border-none">
                        <i class="fa-solid fa-trash text-xs"></i>
                    </button>
                </div>
            </div>
        `;

            container.insertAdjacentHTML('beforeend', rowHtml);
            editMemberIndex++;
        }

        function removeMemberEditRow(button) {
            const row = button.closest('.member-row');
            if (row) {
                // Jika baris dihapus, kita bisa beri efek konfirmasi atau langsung hapus dari form view
                row.remove();
            }
        }
    </script>
@endsection
