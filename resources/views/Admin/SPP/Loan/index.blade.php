@extends('Admin.Layouts.main')

@section('content')
    <div class="p-6 max-w-7xl mx-auto space-y-6">

        {{-- Alert Notifikasi Sukses/Gagal --}}
        @if (session('success'))
            <div class="alert alert-success rounded-2xl border-none text-white font-bold shadow-md shadow-emerald-100 mb-4">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-error rounded-2xl border-none text-white font-bold shadow-md mb-4">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Top Header Dashboard Pinjaman --}}
        <div
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div>
                <h1 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                    <span class="p-2 bg-indigo-50 text-indigo-600 rounded-xl"><i
                            class="fa-solid fa-hand-holding-dollar"></i></span>
                    Daftar Pinjaman Dana SPP
                </h1>
                <p class="text-xs text-slate-400 mt-1">Pantau status pengajuan plafon, realisasi pencairan awal, dan rekam
                    jejak angsuran kelompok.</p>
            </div>

            {{-- 2. Tombol Tambah yang Sudah Ada Sebelumnya --}}
            <a href="{{ url('/spp-loan/create') }}"
                class="btn btn-md bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-black text-xs border-none shadow-md shadow-indigo-100">
                <i class="fa-solid fa-plus"></i> Tambah Pengajuan
            </a>
        </div>

        {{-- Tabel Utama Pinjaman --}}
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <div class="overflow-x-auto w-full">
                <table class="table w-full">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase font-black tracking-wider">
                            <th class="bg-transparent text-center w-12">No</th>
                            <th class="bg-transparent">No. Kontrak & Kelompok</th>
                            <th class="bg-transparent text-right">Plafon Kontrak</th>
                            <th class="bg-transparent text-right">Total Dicairkan</th>
                            <th class="bg-transparent text-center">Tenor & Bunga</th>
                            <th class="bg-transparent text-center">Status</th>
                            <th class="bg-transparent text-center w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($loans as $index => $loan)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                {{-- Nomor Urut --}}
                                <td class="text-center bg-transparent font-bold text-slate-400 text-sm">
                                    {{ $index + 1 }}
                                </td>

                                {{-- Nomor Kontrak & Nama Kelompok --}}
                                <td class="bg-transparent">
                                    <div class="font-black text-slate-800 text-sm tracking-tight">
                                        {{ $loan->no_kontrak }}
                                    </div>
                                    <div
                                        class="text-[11px] text-slate-500 font-bold mt-0.5 uppercase flex items-center gap-1">
                                        <i class="fa-solid fa-people-roof text-indigo-500 text-[10px]"></i>
                                        {{ $loan->group->nama_kelompok }}
                                    </div>
                                </td>

                                {{-- Plafon Disetujui --}}
                                <td class="bg-transparent text-right font-black text-slate-800 text-sm">
                                    Rp{{ number_format($loan->plafon_disetujui, 0, ',', '.') }}
                                </td>

                                {{-- Total Dana yang Sudah Dicairkan --}}
                                <td class="bg-transparent text-right font-bold text-emerald-600 text-sm">
                                    Rp{{ number_format($loan->total_dicairkan, 0, ',', '.') }}
                                </td>

                                {{-- Tenor & Bunga Bulanan --}}
                                <td class="text-center bg-transparent">
                                    <div class="text-xs font-black text-slate-700">{{ $loan->tenor_bulan }} Bulan</div>
                                    <div class="text-[10px] text-slate-400 font-semibold mt-0.5">Bunga:
                                        {{ $loan->bunga_persen }}% / bln</div>
                                </td>

                                {{-- Status Pinjaman (Badge Kontras) --}}
                                <td class="text-center bg-transparent">
                                    @if ($loan->status_loan == 'review')
                                        <span
                                            class="badge border-none bg-amber-100 text-amber-700 font-black uppercase text-[9px] px-2.5 py-1.5 rounded-lg italic shadow-sm shadow-amber-100">Review</span>
                                    @elseif($loan->status_loan == 'berjalan')
                                        <span
                                            class="badge border-none bg-sky-500 text-white font-black uppercase text-[9px] px-2.5 py-1.5 rounded-lg shadow-sm shadow-sky-100">Berjalan</span>
                                    @elseif($loan->status_loan == 'macet')
                                        <span
                                            class="badge border-none bg-red-500 text-white font-black uppercase text-[9px] px-2.5 py-1.5 rounded-lg shadow-sm shadow-red-100">Macet</span>
                                    @else
                                        <span
                                            class="badge border-none bg-emerald-500 text-white font-black uppercase text-[9px] px-2.5 py-1.5 rounded-lg shadow-sm shadow-emerald-100">Lunas</span>
                                    @endif
                                </td>

                                {{-- Tombol Aksi Kerja --}}
                                <td class="text-center bg-transparent">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Jika masih review, arahkan ke halaman detail untuk proses 'Cairkan Tahap Awal' --}}
                                        {{-- Jika sudah berjalan, arahkan ke detail untuk melihat tabel angsuran bulanan --}}
                                        <a href="{{ url('/spp-loan/' . $loan->id) }}"
                                            class="btn btn-sm rounded-xl border-none bg-indigo-50 text-indigo-600 hover:bg-indigo-100 font-bold px-4 shadow-sm"
                                            title="Buka Detail & Transaksi">
                                            <i class="fa-solid fa-folder-open text-xs mr-1"></i> Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- State jika data pinjaman kosong --}}
                            <tr>
                                <td colspan="7" class="text-center bg-transparent py-12">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="p-4 bg-slate-50 text-slate-300 rounded-full text-2xl"><i
                                                class="fa-solid fa-file-invoice-dollar"></i></div>
                                        <div class="text-sm font-black text-slate-400">Belum Ada Pengajuan Pinjaman</div>
                                        <p class="text-xs text-slate-400 max-w-xs -mt-1">Silakan tekan tombol "Buat
                                            Pengajuan" di atas untuk mendaftarkan kontrak pinjaman baru bagi kelompok aktif.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
