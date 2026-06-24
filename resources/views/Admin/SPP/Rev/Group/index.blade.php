@extends('Admin.Layouts.main')

@section('content')
    <main class="p-6 md:p-10 space-y-8">

        {{-- Header Halaman --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Verifikasi Kelompok SPP</h1>
                <p class="text-sm text-slate-500 mt-1">Tinjau legalitas profil dan kuota anggota sebelum memberikan akses
                    pengajuan modal.</p>
            </div>

            {{-- Statistik Ringkas --}}
            <div class="flex gap-3">
                <div class="bg-amber-50 border border-amber-100 px-4 py-2 rounded-2xl text-center">
                    <p class="text-[10px] font-bold text-amber-600 uppercase">Perlu Ditinjau</p>
                    <p class="text-lg font-black text-amber-700">{{ $groups->where('status_validasi', 'pending')->count() }}
                    </p>
                </div>
                <div class="bg-emerald-50 border border-emerald-100 px-4 py-2 rounded-2xl text-center">
                    <p class="text-[10px] font-bold text-emerald-600 uppercase">Valid / Aktif</p>
                    <p class="text-lg font-black text-emerald-700">{{ $groups->where('status_validasi', 'valid')->count() }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="alert alert-success rounded-2xl shadow-sm text-sm font-bold text-white bg-emerald-500 border-none">
                <i class="fa-solid fa-circle-check text-base"></i> {{ session('success') }}
            </div>
        @endif

        {{-- TAB FILTER STATUS (DaisyUI) --}}
        <div class="tabs tabs-boxed bg-slate-100 p-1.5 rounded-2xl w-full md:w-max flex gap-1">
            <a href="{{ url('/spp-group-admin?status=pending') }}"
                class="tab rounded-xl font-bold text-xs transition-all {{ request('status', 'pending') == 'pending' ? 'tab-active bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                <i class="fa-solid fa-clock-rotate-left mr-1.5 text-amber-500"></i> Perlu Ditinjau
                <span
                    class="badge badge-sm bg-amber-100 text-amber-700 border-none ml-1.5 font-black">{{ $groups->where('status_validasi', 'pending')->count() }}</span>
            </a>
            <a href="{{ url('/spp-group-admin?status=valid') }}"
                class="tab rounded-xl font-bold text-xs transition-all {{ request('status') == 'valid' ? 'tab-active bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                <i class="fa-solid fa-circle-check mr-1.5 text-emerald-500"></i> Telah Disetujui
            </a>
            <a href="{{ url('/spp-group-admin?status=ditolak') }}"
                class="tab rounded-xl font-bold text-xs transition-all {{ request('status') == 'ditolak' ? 'tab-active bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                <i class="fa-solid fa-circle-xmark mr-1.5 text-red-500"></i> Ditolak
            </a>
        </div>

        {{-- TABEL UTAMA KELOMPOK --}}
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm">
            <div class="overflow-x-auto">
                <table class="table w-full border-separate border-spacing-y-2">
                    <thead>
                        <tr class="text-slate-400 border-none text-xs uppercase tracking-wider">
                            <th class="bg-transparent pl-4">No</th>
                            <th class="bg-transparent">Nama Kelompok</th>
                            <th class="bg-transparent">Ketua Kelompok</th>
                            <th class="bg-transparent text-center">Jumlah Anggota</th>
                            <th class="bg-transparent">Status Kelayakan</th>
                            <th class="bg-transparent text-center pr-4">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm font-semibold text-slate-700">
                        @forelse($filteredGroups as $group)
                            <tr class="bg-slate-50/60 border border-slate-100 transition-all hover:bg-slate-50">
                                {{-- Nomor --}}
                                <td class="rounded-l-2xl pl-4 py-4">{{ $loop->iteration }}</td>

                                {{-- Nama Kelompok & Alamat Singkat --}}
                                <td>
                                    <div class="font-black text-slate-800">{{ $group->nama_kelompok }}</div>
                                    <div class="text-xs text-slate-400 font-normal mt-0.5 max-w-xs truncate">
                                        {{ $group->alamat_kelompok }}</div>
                                </td>

                                {{-- Data Ketua --}}
                                <td>
                                    <div class="text-slate-700 font-bold">{{ $group->nama_ketua }}</div>
                                    <div class="text-xs text-slate-400 font-normal mt-0.5">{{ $group->no_hp_ketua }}</div>
                                </td>

                                {{-- Jumlah Anggota Perempuan --}}
                                <td class="text-center">
                                    <div
                                        class="badge bg-indigo-50 border-none text-indigo-600 font-black rounded-lg px-2.5 py-3 text-xs">
                                        <i class="fa-solid fa-users mr-1 text-[10px]"></i> {{ $group->members_count }}
                                        Orang
                                    </div>
                                </td>

                                {{-- Status Badge --}}
                                <td>
                                    @if ($group->status_validasi == 'pending')
                                        <span
                                            class="badge bg-amber-50 text-amber-700 border-amber-200 font-bold px-3 py-3 rounded-xl text-xs gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Belum
                                            Valid
                                        </span>
                                    @elseif($group->status_validasi == 'valid')
                                        <span
                                            class="badge bg-emerald-50 text-emerald-700 border-emerald-200 font-bold px-3 py-3 rounded-xl text-xs gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Terverifikasi
                                        </span>
                                    @else
                                        <span
                                            class="badge bg-red-50 text-red-700 border-red-200 font-bold px-3 py-3 rounded-xl text-xs gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Akun Ditolak
                                        </span>
                                    @endif
                                </td>

                                {{-- Tombol Aksi Menuju Lembar Kerja --}}
                                <td class="rounded-r-2xl text-center pr-4">
                                    <a href="{{ url('/spp-group-admin/' . $group->id . '/show') }}"
                                        class="btn btn-sm bg-slate-900 hover:bg-slate-800 border-none text-white font-bold rounded-xl px-4 text-xs normal-case">
                                        <i class="fa-solid fa-file-shield mr-1"></i> Periksa Berkas
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="text-center py-12 text-slate-400 italic bg-slate-50/50 rounded-2xl">
                                    Tidak ada data kelompok dengan status "{{ request('status', 'pending') }}".
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>
@endsection
