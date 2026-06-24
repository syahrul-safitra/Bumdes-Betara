@extends('SPPMember.Layouts.main') {{-- Sesuaikan dengan layout portal kelompok Anda --}}

@section('content')
    <main class="p-6 md:p-10 space-y-6">
        {{-- Navigasi Atas & Judul --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ url('/spp-group-all') }}"
                    class="text-xs font-bold text-indigo-600 hover:underline inline-flex items-center gap-1 mb-1">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pinjaman
                </a>
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Kartu Angsuran Digital </h1>
                <p class="text-xs text-slate-400 mt-0.5">Pantau histori pembayaran, batas jatuh tempo, dan akumulasi denda
                    kelompok.</p>
            </div>

            {{-- Badge Status Utama Pinjaman --}}
            <div>
                @if ($loan->status_loan == 'disetujui')
                    <span
                        class="badge bg-emerald-50 text-emerald-700 border-emerald-200 font-black text-xs px-4 py-3 rounded-xl uppercase tracking-wider">Cair
                        Awal (Rp 2 Juta)</span>
                @elseif($loan->status_loan == 'berjalan')
                    @if ($loan->status_pencairan == 'cair_penuh')
                        <span
                            class="badge bg-indigo-50 text-indigo-700 border-indigo-200 font-black text-xs px-4 py-3 rounded-xl uppercase tracking-wider">Sedang
                            Berjalan (Sisa Dana Cair)</span>
                    @else
                        <span
                            class="badge bg-amber-50 text-amber-700 border-amber-200 font-black text-xs px-4 py-3 rounded-xl uppercase tracking-wider animate-pulse">Menunggu
                            Sisa Dana Cair</span>
                    @endif
                @elseif($loan->status_loan == 'lunas')
                    <span
                        class="badge bg-slate-900 text-white border-none font-black text-xs px-4 py-3 rounded-xl uppercase tracking-wider">Lunas
                        Total</span>
                @else
                    <span
                        class="badge bg-red-50 text-red-700 border-red-200 font-black text-xs px-4 py-3 rounded-xl uppercase tracking-wider">{{ $loan->status_loan }}</span>
                @endif


            </div>
        </div>

        {{-- Grid Ringkasan Informasi Finansial --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div class="bg-white border border-slate-200 p-6 rounded-[2rem] shadow-sm">
                <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider">Plafon Disetujui</p>
                <p class="text-xl font-black text-slate-800 mt-1">Rp
                    {{ number_format($loan->plafon_disetujui, 0, ',', '.') }}</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Tenor Pinjaman: {{ $loan->tenor_bulan }} Bulan</p>
            </div>
            <div class="bg-white border border-slate-200 p-6 rounded-[2rem] shadow-sm">
                <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider">Dana Telah Dicairkan</p>
                <p class="text-xl font-black text-indigo-600 mt-1">Rp
                    {{ number_format($loan->total_dicairkan, 0, ',', '.') }}</p>
                <p class="text-[11px] text-indigo-500 mt-0.5 font-semibold">
                    Status: {{ $loan->status_pencairan == 'cair_penuh' ? 'Lunas Dicairkan (100%)' : 'Dicairkan Tahap 1' }}
                </p>
            </div>
            <div class="bg-white border border-slate-200 p-6 rounded-[2rem] shadow-sm">
                <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider">Total Sisa Angsuran</p>
                @php
                    $sisaBulan = $installments->where('status_bayar', 'belum_bayar')->count();
                @endphp
                <p class="text-xl font-black text-slate-800 mt-1">{{ $sisaBulan }} / {{ $loan->tenor_bulan }} Bulan</p>
                <p class="text-[11px] text-slate-400 mt-0.5">Status Pinjaman: <span
                        class="font-bold text-slate-600 uppercase">{{ $loan->status_loan }}</span></p>
            </div>
        </div>

        {{-- Banner Informasi Pemberitahuan Sisa Dana (Kondisional Versi Kelompok) --}}
        @if ($loan->status_loan == 'disetujui')
            <div class="bg-amber-50 border border-amber-200 p-6 rounded-3xl flex items-start gap-3">
                <div
                    class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm shrink-0 mt-0.5">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div>
                    <h4 class="font-black text-amber-900 text-sm">Sisa Pencairan Dana Terkunci</h4>
                    <p class="text-xs text-amber-700 leading-relaxed mt-0.5">Sesuai kebijakan BUMDes, sisa dana modal usaha
                        sebesar <strong>Rp {{ number_format($loan->plafon_disetujui - 2000000, 0, ',', '.') }}</strong> baru
                        dapat diserahkan sepenuhnya setelah kelompok Anda menyelesaikan pembayaran <strong>Angsuran Bulan
                            Ke-1</strong> di bawah ini.</p>
                </div>
            </div>
        @elseif($loan->status_loan == 'berjalan' && $loan->status_pencairan != 'cair_penuh')
            <div class="bg-indigo-50 border border-indigo-100 p-6 rounded-3xl flex items-start gap-3">
                <div
                    class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm shrink-0 mt-0.5">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <h4 class="font-black text-indigo-900 text-sm">Gembok Sisa Dana Terbuka!</h4>
                    <p class="text-xs text-indigo-700 leading-relaxed mt-0.5">Selamat, kelompok Anda telah melunasi angsuran
                        pertama. Sisa dana modal sebesar <strong>Rp
                            {{ number_format($loan->plafon_disetujui - 2000000, 0, ',', '.') }}</strong> sudah siap
                        diambil. Silakan hubungi bendahara BUMDes untuk proses penyerahan dana fisik.</p>
                </div>
            </div>
        @endif

        {{-- Komponen Tabel Utama Kartu Angsuran --}}
        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table w-full border-none">
                    <thead>
                        <tr
                            class="bg-slate-50/70 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                            <th class="p-5">Bulan Ke</th>
                            <th class="p-5">Angsuran Pokok</th>
                            <th class="p-5">Jasa BUMDes (0.5%)</th>
                            <th class="p-5 text-red-600">Denda Keterlambatan</th>
                            <th class="p-5">Total Tagihan</th>
                            <th class="p-5">Batas Jatuh Tempo</th>
                            <th class="p-5">Tanggal Bayar</th>
                            <th class="p-5 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 text-xs font-semibold">
                        @foreach ($installments as $ins)
                            @php
                                $dendaHariIni = 0;
                                $selisihHari = 0;

                                // Hitung denda real-time jika belum bayar dan melewati jatuh tempo
                                if (
                                    $ins->status_bayar == 'belum_bayar' &&
                                    \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($ins->tanggal_jatuh_tempo))
                                ) {
                                    $selisihHari = \Carbon\Carbon::parse($ins->tanggal_jatuh_tempo)->diffInDays(
                                        \Carbon\Carbon::now(),
                                    );
                                    $dendaHariIni = $selisihHari * 5000; // Sesuai tarif Rp 5.000/hari
                                }
                            @endphp

                            <tr
                                class="hover:bg-slate-50/30 transition-colors {{ $ins->status_bayar == 'lunas' ? 'bg-slate-50/10 text-slate-400' : '' }}">
                                <td class="p-5 font-black text-slate-800">Bulan {{ $ins->angsuran_ke }}</td>
                                <td class="p-5">Rp {{ number_format($ins->jumlah_pokok, 0, ',', '.') }}</td>
                                <td class="p-5">Rp {{ number_format($ins->jumlah_bunga, 0, ',', '.') }}</td>

                                {{-- Kolom Denda --}}
                                <td class="p-5 text-red-600 font-bold">
                                    @if ($ins->status_bayar == 'lunas')
                                        Rp {{ number_format($ins->denda_kumulatif, 0, ',', '.') }}
                                    @elseif($dendaHariIni > 0)
                                        Rp {{ number_format($dendaHariIni, 0, ',', '.') }}
                                    @else
                                        <span class="text-slate-300 font-normal">-</span>
                                    @endif
                                </td>

                                {{-- Total Tagihan --}}
                                <td class="p-5 font-black text-slate-800">
                                    @if ($ins->status_bayar == 'lunas')
                                        Rp {{ number_format($ins->total_dibayar, 0, ',', '.') }}
                                    @else
                                        Rp
                                        {{ number_format($ins->jumlah_pokok + $ins->jumlah_bunga + $dendaHariIni, 0, ',', '.') }}
                                    @endif
                                </td>

                                <td class="p-5">{{ \Carbon\Carbon::parse($ins->tanggal_jatuh_tempo)->format('d M Y') }}
                                </td>
                                <td class="p-5">
                                    {{ $ins->tanggal_bayar ? \Carbon\Carbon::parse($ins->tanggal_bayar)->format('d M Y') : '-' }}
                                </td>

                                {{-- Badge Status --}}
                                <td class="p-5 text-center">
                                    @if ($ins->status_bayar == 'lunas')
                                        <span
                                            class="badge bg-emerald-50 text-emerald-700 border-emerald-100 font-bold text-[10px] rounded-lg py-2">Lunas</span>
                                    @elseif($dendaHariIni > 0)
                                        <div class="space-y-1">
                                            <span
                                                class="badge bg-red-50 text-red-700 border-red-100 font-bold text-[10px] rounded-lg py-2">Menunggak</span>
                                            <div class="text-[9px] text-red-500 font-black">Telat {{ $selisihHari }} Hari
                                            </div>
                                        </div>
                                    @else
                                        <span
                                            class="badge bg-amber-50 text-amber-700 border-amber-100 font-bold text-[10px] rounded-lg py-2">Belum
                                            Bayar</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
