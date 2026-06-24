@extends('Admin.Layouts.main')

@section('content')
    <main class="p-6 md:p-10 space-y-8">

        {{-- Tombol Kembali & Navigasi --}}
        <div>
            <a href="{{ url('spp-group-admin?status=' . $group->status_validasi) }}"
                class="btn btn-sm btn-ghost gap-2 rounded-xl text-slate-500 hover:text-slate-800 pl-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Kelompok
            </a>
        </div>

        {{-- Grid Utama 2 Kolom --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- KOLOM KIRI (LEBAR: 2/3): DETAIL DATA & DAFTAR ANGGOTA --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Kartu Profil Kelompok --}}
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl">
                            <i class="fa-solid fa-users-rectangle"></i>
                        </div>
                        <div>
                            <span
                                class="text-[10px] font-black uppercase px-2 py-0.5 rounded-md bg-slate-100 text-slate-500">Profil
                                Legalitas</span>
                            <h2 class="text-xl font-black text-slate-800 mt-0.5">{{ $group->nama_kelompok }}</h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2 border-t border-slate-100 text-sm">
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Nama Ketua</p>
                            <p class="font-bold text-slate-700 mt-0.5">{{ $group->nama_ketua }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">NIK Ketua</p>
                            <p class="font-bold text-slate-700 mt-0.5">{{ $group->nik_ketua }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Kontak / WhatsApp</p>
                            <p class="font-bold text-slate-700 mt-0.5">{{ $group->no_hp_ketua }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Email Akun</p>
                            <p class="font-bold text-slate-700 mt-0.5">{{ $group->email }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wider">Alamat Domisili Kelompok
                            </p>
                            <p class="font-bold text-slate-700 mt-0.5 leading-relaxed">{{ $group->alamat_kelompok }}</p>
                        </div>
                    </div>
                </div>

                {{-- Kartu Daftar Anggota Terdaftar --}}
                <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                    <div class="mb-4 flex items-center gap-3">
                        <div
                            class="w-10 h-10 bg-slate-50 text-slate-700 rounded-xl flex items-center justify-center text-base">
                            <i class="fa-solid fa-address-book"></i>
                        </div>
                        <div>
                            <h3 class="text-md font-black text-slate-800">Anggota Perempuan Terdaftar</h3>
                            <p class="text-xs text-slate-400">Total kuota kelompok saat ini:
                                {{ $group->members->count() + 1 }}
                                orang.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table w-full border-separate border-spacing-y-1.5">
                            <thead>
                                <tr class="text-slate-400 border-none text-xs uppercase tracking-wider">
                                    <th class="bg-transparent pl-2">No</th>
                                    <th class="bg-transparent">Nama Anggota</th>
                                    <th class="bg-transparent">NIK Anggota</th>
                                    <th class="bg-transparent text-center">Foto KTP</th>
                                </tr>
                            </thead>
                            <tbody class="text-xs font-semibold text-slate-700">
                                @forelse($group->members as $idx => $member)
                                    <tr class="bg-slate-50/60 border border-slate-100">
                                        <td class="rounded-l-xl pl-2 py-3">{{ $idx + 1 }}</td>
                                        <td class="font-bold text-slate-800">{{ $member->nama_anggota }}</td>
                                        <td>{{ $member->nik }}</td>
                                        <td class="text-center rounded-r-xl">
                                            @if ($member->file_ktp)
                                                <a href="{{ asset('File/SPP/KTP/' . $member->file_ktp) }}" target="_blank"
                                                    class="text-indigo-600 hover:underline font-bold">
                                                    <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Lihat KTP
                                                </a>
                                            @else
                                                <span class="text-slate-400 italic">Tidak ada file</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4"
                                            class="text-center py-6 text-slate-400 italic bg-slate-50 rounded-xl">
                                            Ketua kelompok belum menginputkan satu pun data anggota perempuan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN (LEBAR: 1/3): PANEL VERIFIKASI BERKAS & AKSI --}}
            <div class="space-y-6">

                {{-- Kartu File Berkas Utama --}}
                <div class="bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-wider"><i
                            class="fa-solid fa-paperclip mr-1"></i> Dokumen Lampiran</h4>

                    <div
                        class="p-4 bg-slate-50 border border-slate-100 rounded-2xl flex flex-col items-center text-center space-y-3">
                        <div
                            class="w-12 h-12 rounded-full bg-indigo-50 flex items-center justify-center text-xl text-indigo-600 shadow-sm">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black text-slate-700 max-w-[180px] truncate">
                                {{ $group->file_ktp ?? 'berkas_kolektif.pdf' }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">Berkas Kolektif / KTP Ketua</p>
                        </div>
                        @if ($group->file_ktp && $group->file_ktp != '-')
                            <a href="{{ asset('File/SPP/KTP/' . $group->file_ktp) }}" target="_blank"
                                class="btn btn-sm w-full bg-indigo-600 hover:bg-indigo-700 text-white border-none font-bold rounded-xl text-xs">
                                <i class="fa-solid fa-eye mr-1"></i> Buka & Tinjau File
                            </a>
                        @else
                            <button disabled
                                class="btn btn-sm w-full bg-slate-200 text-slate-400 border-none font-bold rounded-xl text-xs">
                                Berkas Belum Diupload
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Kartu Panel Keputusan Status --}}
                <div class="bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-4">
                    <h4 class="text-xs font-black text-slate-400 uppercase tracking-wider"><i
                            class="fa-solid fa-gavel mr-1"></i> Keputusan Kelayakan</h4>

                    {{-- Jika Status Saat ini Ditolak, Tampilkan Alasannya --}}
                    @if ($group->status_validasi == 'ditolak')
                        <div class="p-4 bg-red-50 border border-red-100 text-red-700 rounded-2xl text-xs space-y-1">
                            <p class="font-black"><i class="fa-solid fa-circle-info"></i> Alasan Penolakan Sebelumnya:</p>
                            <p class="font-semibold leading-relaxed italic">
                                "{{ $group->alasan_ditolak ?? 'Tidak ada alasan spesifik.' }}"</p>
                        </div>
                    @endif

                    <div class="space-y-2">
                        {{-- Form Setujui Kelompok (Tombol Hijau) --}}
                        @if ($group->status_validasi !== 'valid')
                            {{-- 1. Tombol Pemicu Modal (Trigger) --}}
                            <button type="button" onclick="approval_modal_{{ $group->id }}.showModal()"
                                class="btn w-full h-12 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-xl border-none text-xs shadow-lg shadow-emerald-100 transition-all duration-200">
                                <i class="fa-solid fa-circle-check text-sm mr-1.5"></i> Validasi / Setujui Akun
                            </button>

                            {{-- 2. Struktur Modal Dialog DaisyUI --}}
                            <dialog id="approval_modal_{{ $group->id }}"
                                class="modal modal-bottom sm:modal-middle backdrop-blur-sm transition-all">
                                <div
                                    class="modal-box bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-2xl max-w-sm text-center">

                                    {{-- Ikon Visual Peringatan di Dalam Modal --}}
                                    <div
                                        class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-4 shadow-sm">
                                        <i class="fa-solid fa-user-check"></i>
                                    </div>

                                    {{-- Konten Teks --}}
                                    <h3 class="text-base font-black text-slate-800 tracking-tight">Konfirmasi Validasi</h3>
                                    <p class="text-xs text-slate-400 mt-2 leading-relaxed">
                                        Apakah Anda yakin ingin menyetujui kelompok <strong class="text-slate-700">Kelompok
                                            {{ $group->nama_kelompok }}</strong>? Setelah disetujui, ketua kelompok akan
                                        langsung dapat mengajukan pinjaman modal usaha.
                                    </p>

                                    {{-- Form Aksi (Tombol Pilihan) --}}
                                    <div class="mt-6 flex flex-col gap-2">
                                        <form action="{{ url('/spp-group-admin/' . $group->id . '/approve') }}"
                                            method="POST" class="w-full">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit"
                                                class="btn btn-sm w-full h-10 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-xl border-none text-xs normal-case shadow-md shadow-emerald-100">
                                                Ya, Setujui Sekarang
                                            </button>
                                        </form>

                                        {{-- Tombol Batal/Keluar Modal --}}
                                        <form method="dialog" class="w-full">
                                            <button
                                                class="btn btn-sm w-full h-10 bg-slate-50 hover:bg-slate-100 text-slate-500 hover:text-slate-700 font-bold rounded-xl border border-slate-200/70 text-xs normal-case">
                                                Batalkan
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                {{-- Klik di luar modal untuk menutup otomatis --}}
                                <form method="dialog" class="modal-backdrop">
                                    <button>close</button>
                                </form>
                            </dialog>
                        @endif

                        {{-- Tombol Trigger Modal Tolak Kelompok (Tombol Merah) --}}
                        <button type="button" onclick="modal_tolak_kelompok.showModal()"
                            class="btn w-full h-12 bg-white hover:bg-red-50 text-red-500 border border-slate-200 hover:border-red-200 font-black rounded-xl text-xs shadow-sm">
                            <i class="fa-solid fa-circle-xmark text-sm mr-1.5"></i> Tolak / Batalkan Akun
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </main>

    {{-- ================= MODAL INPUT ALASAN PENOLAKAN KELOMPOK ================= --}}
    <dialog id="modal_tolak_kelompok" class="modal">
        <div class="modal-box max-w-sm rounded-[2.5rem] p-8 border border-slate-100 shadow-2xl bg-white text-center">
            <div
                class="w-14 h-14 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-xl mx-auto mb-4">
                <i class="fa-solid fa-comment-slash"></i>
            </div>

            <h3 class="font-black text-xl text-slate-800 mb-1">Berikan Alasan Penolakan</h3>
            <p class="text-xs text-slate-400 mb-4 px-2">Ketua kelompok akan melihat pesan ini pada dashboard mereka untuk
                melakukan perbaikan data.</p>

            <form action="{{ url('/spp-group-admin/' . $group->id . '/reject') }}" method="POST"
                class="space-y-4 text-left">
                @csrf
                @method('PUT')

                <div class="form-control">
                    <textarea name="alasan_ditolak" required rows="4"
                        placeholder="Contoh: Jumlah anggota perempuan kurang dari batas minimum 5 orang, atau berkas KTP Ketua buram..."
                        class="textarea textarea-bordered w-full rounded-2xl bg-slate-50 border-slate-200 focus:border-red-500 text-xs font-semibold leading-relaxed"></textarea>
                </div>

                <div class="flex gap-3 pt-2 justify-center">
                    <button type="button" onclick="modal_tolak_kelompok.close()"
                        class="btn btn-ghost flex-1 rounded-2xl font-bold text-xs">Batal</button>
                    <button type="submit"
                        class="btn bg-red-500 hover:bg-red-600 border-none text-white font-black flex-1 rounded-2xl text-xs shadow-lg shadow-red-100">
                        Kirim Penolakan
                    </button>
                </div>
            </form>
        </div>
    </dialog>
@endsection
