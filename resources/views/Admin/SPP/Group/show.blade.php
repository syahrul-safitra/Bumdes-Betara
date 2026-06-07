@extends('Admin.Layouts.main')

@section('content')
    <div class="p-6 max-w-6xl mx-auto space-y-6">

        {{-- Tombol Kembali & Navigasi Atas --}}
        <div class="flex justify-between items-center">
            <a href="{{ url('/spp-group') }}"
                class="btn btn-sm rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 border-none normal-case">
                <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Daftar
            </a>
            <a href="{{ url('/spp-group/' . $group->id . '/edit') }}"
                class="btn btn-sm rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 border-none normal-case">
                <i class="fa-solid fa-pen-to-square mr-1"></i> Edit Profil Kelompok
            </a>
        </div>

        {{-- KARTU UTAMA: PROFIL KELOMPOK --}}
        <div
            class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="p-4 bg-indigo-50 text-indigo-600 rounded-3xl text-2xl hidden sm:block">
                    <i class="fa-solid fa-people-roof"></i>
                </div>
                <div class="space-y-1">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="text-2xl font-black text-slate-800 tracking-tight">Kelompok {{ $group->nama_kelompok }}
                        </h1>
                        @if ($group->status == 'aktif')
                            <span
                                class="badge border-none bg-emerald-100 text-emerald-700 font-bold uppercase text-[9px] px-2.5 py-2 rounded-lg">Aktif</span>
                        @else
                            <span
                                class="badge border-none bg-slate-100 text-slate-400 font-bold uppercase text-[9px] px-2.5 py-2 rounded-lg">Non-Aktif</span>
                        @endif
                    </div>
                    <p class="text-sm font-medium text-slate-600">Ketua Kelompok (PIC): <span
                            class="font-bold text-slate-800">{{ $group->nama_ketua }}</span></p>
                    <p class="text-xs text-indigo-600 font-bold flex items-center gap-1"><i
                            class="fa-solid fa-phone text-xs"></i> {{ $group->no_hp_ketua }}</p>
                    <div class="text-xs text-slate-400 pt-2 flex items-start gap-1 max-w-xl">
                        <i class="fa-solid fa-location-dot text-slate-300 mt-0.5"></i>
                        <span>{{ $group->alamat_kelompok }}</span>
                    </div>
                </div>
            </div>

            {{-- Ringkasan Statistik Internal Kelompok --}}
            <div
                class="grid grid-cols-2 gap-4 border-t md:border-t-0 md:border-l border-slate-100 pt-4 md:pt-0 md:pl-8 min-w-[240px]">
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-wider">Total Anggota</p>
                    <p class="text-xl font-black text-slate-800 mt-0.5">{{ $group->members->count() }} <span
                            class="text-xs text-slate-400 font-normal">Orang</span></p>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-wider">Total Pinjaman</p>
                    <p class="text-xl font-black text-slate-800 mt-0.5">{{ $group->loans->count() }} <span
                            class="text-xs text-slate-400 font-normal">Kontrak</span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

            {{-- SISI KIRI (2 COLUMNS): MANIFEST DATA ANGGOTA & BERKAS KTP --}}
            <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm lg:col-span-2 space-y-4">
                <h2 class="text-sm font-black uppercase tracking-wider text-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-id-card text-indigo-500"></i> Berkas Manifes Anggota Kelompok
                </h2>

                <div class="overflow-x-auto w-full">
                    <table class="table w-full">
                        <thead>
                            <tr
                                class="border-b border-slate-100 text-slate-400 text-xs uppercase font-black tracking-wider">
                                <th class="bg-transparent w-12 text-center">No</th>
                                <th class="bg-transparent">Nama Anggota</th>
                                <th class="bg-transparent">NIK (Nomor KTP)</th>
                                <th class="bg-transparent text-center w-28">Berkas KTP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach ($group->members as $index => $member)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="text-center bg-transparent font-bold text-slate-400 text-xs">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="bg-transparent font-black text-slate-800 text-sm">
                                        {{ $member->nama_anggota }}
                                    </td>
                                    <td class="bg-transparent font-semibold text-slate-600 text-xs tracking-wide">
                                        {{ $member->nik }}
                                    </td>
                                    <td class="text-center bg-transparent">
                                        @if ($member->file_ktp)
                                            <a href="{{ asset('File/SPP/KTP/' . $member->file_ktp) }}" target="_blank"
                                                class="btn btn-xs rounded-xl border-none bg-indigo-50 text-indigo-600 hover:bg-indigo-100 font-bold px-3">
                                                <i class="fa-solid fa-image mr-1 text-[10px]"></i> KTP
                                            </a>
                                        @else
                                            <span class="text-xs text-red-400 italic">Berkas Hilang</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- SISI KANAN (1 COLUMN): REKAM JEJAK PINJAMAN KELOMPOK --}}
            <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm lg:col-span-1 space-y-4">
                <h2 class="text-sm font-black uppercase tracking-wider text-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-indigo-500"></i> Riwayat Kredit SPP
                </h2>

                <div class="space-y-3">
                    @forelse($group->loans as $loan)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex justify-between items-center">
                            <div>
                                <a href="{{ url('/spp-loan/' . $loan->id) }}"
                                    class="text-xs font-black text-indigo-600 hover:underline">
                                    {{ $loan->no_kontrak }}
                                </a>
                                <p class="text-[10px] text-slate-400 mt-0.5">Tenor: {{ $loan->tenor_bulan }} Bulan</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-black text-slate-800">
                                    Rp{{ number_format($loan->plafon_disetujui, 0, ',', '.') }}</p>
                                @if ($loan->status_loan == 'lunas')
                                    <span
                                        class="badge badge-xs border-none bg-emerald-100 text-emerald-700 font-bold text-[8px] px-1.5 py-1 rounded">LUNAS</span>
                                @elseif($loan->status_loan == 'berjalan')
                                    <span
                                        class="badge badge-xs border-none bg-sky-100 text-sky-700 font-bold text-[8px] px-1.5 py-1 rounded">AKTIF</span>
                                @elseif($loan->status_loan == 'macet')
                                    <span
                                        class="badge badge-xs border-none bg-red-100 text-red-700 font-bold text-[8px] px-1.5 py-1 rounded">MACET</span>
                                @else
                                    <span
                                        class="badge badge-xs border-none bg-amber-100 text-amber-700 font-bold text-[8px] px-1.5 py-1 rounded">REVIEW</span>
                                @endif
                            </div>
                        </div>

                    @empty

                        <div class="text-center py-6 text-slate-400 text-xs font-medium italic">
                            Kelompok ini belum pernah mengajukan pinjaman dana.
                        </div>
                    @endforelse

                </div>
            </div>

        </div>
    </div>
@endsection
