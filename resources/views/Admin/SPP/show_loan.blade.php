@extends('Admin.Layouts.main') {{-- Sesuaikan dengan layout admin Anda --}}

@section('content')
    <div class="p-6 max-w-7xl mx-auto space-y-8">

        {{-- Header Dashboard Pinjaman --}}
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div>
                <span
                    class="badge badge-sm border-none bg-purple-100 text-purple-700 font-bold uppercase tracking-wider px-3 py-2 mb-2">
                    Simpan Pinjam Perempuan (SPP)
                </span>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Kontrak: {{ $loan->no_kontrak }}</h1>
                <p class="text-xs text-slate-400 mt-1 uppercase font-semibold">Kelompok: <span
                        class="text-slate-700 font-bold">{{ $loan->group->nama_kelompok }}</span> (Ketua:
                    {{ $loan->group->nama_ketua }})</p>
            </div>
            <div>
                @if ($loan->status_loan == 'review')
                    <span
                        class="badge badge-lg border-none bg-amber-100 text-amber-700 font-black px-6 py-4 rounded-xl uppercase italic">Dalam
                        Review</span>
                @elseif($loan->status_loan == 'berjalan')
                    <span
                        class="badge badge-lg border-none bg-sky-500 text-white font-black px-6 py-4 rounded-xl uppercase italic shadow-md shadow-sky-100">Pinjaman
                        Berjalan</span>
                @elseif($loan->status_loan == 'macet')
                    <span
                        class="badge badge-lg border-none bg-red-500 text-white font-black px-6 py-4 rounded-xl uppercase italic shadow-md shadow-red-100">Kredit
                        Macet</span>
                @else
                    <span
                        class="badge badge-lg border-none bg-emerald-500 text-white font-black px-6 py-4 rounded-xl uppercase italic shadow-md shadow-emerald-100">Lunas</span>
                @endif
            </div>
        </div>

        {{-- Grid Ringkasan Keuangan --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="p-4 bg-purple-50 text-purple-600 rounded-2xl"><i
                        class="fa-solid fa-file-invoice-dollar text-xl"></i></div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Plafon Disetujui</p>
                    <h3 class="text-xl font-black text-slate-800 mt-0.5">
                        Rp{{ number_format($loan->plafon_disetujui, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl"><i
                        class="fa-solid fa-hand-holding-dollar text-xl"></i></div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Dicairkan</p>
                    <h3 class="text-xl font-black text-slate-800 mt-0.5">
                        Rp{{ number_format($loan->total_dicairkan, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-4">
                <div class="p-4 bg-amber-50 text-amber-600 rounded-2xl"><i class="fa-solid fa-vault text-xl"></i></div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sisa Plafon Tersimpan</p>
                    <h3 class="text-xl font-black text-slate-800 mt-0.5">
                        Rp{{ number_format($loan->plafon_disetujui - $loan->total_dicairkan, 0, ',', '.') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

            {{-- SISI KIRI: Riwayat Pencairan Dana Bertahap --}}
            <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm space-y-4 lg:col-span-1">
                <div class="flex justify-between items-center mb-2">
                    <h2 class="text-sm font-black uppercase tracking-wider text-slate-700">Riwayat Pencairan</h2>
                    {{-- Tombol cairkan tahap berikutnya hanya muncul jika status berjalan dan sisa plafon > 0 --}}
                    @if ($loan->status_loan == 'berjalan' && $loan->plafon_disetujui - $loan->total_dicairkan > 0)
                        <button
                            class="btn btn-xs rounded-lg bg-purple-600 hover:bg-purple-700 text-white border-none font-bold">
                            + Cairkan Sisa
                        </button>
                    @endif
                </div>

                <div class="space-y-4">
                    @foreach ($loan->disbursements as $cair)
                        <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 flex justify-between items-center">
                            <div>
                                <p class="text-xs font-black text-slate-800">Pencairan Tahap {{ $cair->tahap_ke }}</p>
                                <p class="text-[11px] text-slate-400 mt-0.5"><i class="fa-solid fa-calendar-days mr-1"></i>
                                    {{ \Carbon\Carbon::parse($cair->tanggal_cair)->translatedFormat('d M Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-emerald-600">
                                    Rp{{ number_format($cair->jumlah_cair, 0, ',', '.') }}</p>
                                @if ($cair->bukti_pencairan)
                                    <a href="{{ asset('File/SPP/Pencairan/' . $cair->bukti_pencairan) }}" target="_blank"
                                        class="text-[10px] text-purple-600 font-bold hover:underline">Lihat Bukti</a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- SISI KANAN: Tabel Utama Jadwal Angsuran Bulanan --}}
            <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm lg:col-span-2 space-y-4">
                <h2 class="text-sm font-black uppercase tracking-wider text-slate-700 mb-2">Tabel Angsuran Bulanan (Tenor:
                    {{ $loan->tenor_bulan }} Bulan)</h2>

                <div class="overflow-x-auto w-full">
                    <table class="table w-full">
                        <thead>
                            <tr
                                class="border-b border-slate-100 text-slate-400 text-xs uppercase font-black tracking-wider">
                                <th class="bg-transparent text-center w-12">Bulan</th>
                                <th class="bg-transparent">Rincian Pokok + Bunga (0.5%)</th>
                                <th class="bg-transparent text-center">Jatuh Tempo</th>
                                <th class="bg-transparent text-center">Denda</th>
                                <th class="bg-transparent text-center">Status</th>
                                <th class="bg-transparent text-center w-20">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach ($loan->installments as $inst)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="text-center font-black text-slate-700 bg-transparent italic text-sm">
                                        {{ $inst->angsuran_ke }}
                                    </td>
                                    <td class="bg-transparent">
                                        <div class="font-black text-slate-800 text-sm">
                                            Rp{{ number_format($inst->jumlah_pokok + $inst->jumlah_bunga, 0, ',', '.') }}
                                        </div>
                                        <div class="text-[10px] text-slate-400 mt-0.5">
                                            P: Rp{{ number_format($inst->jumlah_pokok, 0, ',', '.') }} | B:
                                            Rp{{ number_format($inst->jumlah_bunga, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td class="text-center bg-transparent text-xs font-bold text-slate-600">
                                        {{ \Carbon\Carbon::parse($inst->tanggal_jatuh_tempo)->translatedFormat('d M Y') }}
                                    </td>
                                    <td
                                        class="text-center bg-transparent text-xs font-black {{ $inst->denda_kumulatif > 0 ? 'text-red-500' : 'text-slate-400' }}">
                                        {{ $inst->denda_kumulatif > 0 ? 'Rp' . number_format($inst->denda_kumulatif, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="text-center bg-transparent">
                                        @if ($inst->status_bayar == 'lunas')
                                            <span
                                                class="badge badge-xs border-none bg-emerald-500 text-white font-black uppercase text-[9px] px-2 py-2">Lunas</span>
                                        @elseif($inst->status_bayar == 'terlambat')
                                            <span
                                                class="badge badge-xs border-none bg-red-500 text-white font-black uppercase text-[9px] px-2 py-2">Terlambat</span>
                                        @else
                                            <span
                                                class="badge badge-xs border-none bg-slate-100 text-slate-500 font-black uppercase text-[9px] px-2 py-2">Belum
                                                Bayar</span>
                                        @endif
                                    </td>
                                    <td class="text-center bg-transparent">
                                        @if ($inst->status_bayar != 'lunas')
                                            {{-- Tombol Bayar / Setor Angsuran Kelompok --}}
                                            <button
                                                class="btn btn-xs rounded-xl border-none bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3">
                                                Bayar
                                            </button>
                                        @else
                                            <span class="text-[11px] text-slate-400 font-medium"><i
                                                    class="fa-solid fa-circle-check text-emerald-500 mr-1"></i>
                                                Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
