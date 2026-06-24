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
            <div class="flex flex-wrap items-center gap-2.5">

                {{-- 1. BAGIAN BADGE STATUS PINJAMAN --}}
                @if ($loan->status_loan == 'disetujui')
                    <span
                        class="badge bg-emerald-50 text-emerald-700 border-emerald-200 font-black text-xs px-4 py-3 rounded-xl uppercase tracking-wider">
                        Cair Awal (Rp 2 Juta)
                    </span>
                @elseif($loan->status_loan == 'berjalan')
                    @if ($loan->status_pencairan == 'cair_penuh')
                        <span
                            class="badge bg-indigo-50 text-indigo-700 border-indigo-200 font-black text-xs px-4 py-3 rounded-xl uppercase tracking-wider">
                            Sedang Berjalan (Sisa Dana Cair)
                        </span>
                    @else
                        <span
                            class="badge bg-amber-50 text-amber-700 border-amber-200 font-black text-xs px-4 py-3 rounded-xl uppercase tracking-wider animate-pulse">
                            Menunggu Sisa Dana Cair
                        </span>
                    @endif
                @elseif($loan->status_loan == 'lunas')
                    <span
                        class="badge bg-slate-900 text-white border-none font-black text-xs px-4 py-3 rounded-xl uppercase tracking-wider">
                        Lunas Total
                    </span>
                @else
                    <span
                        class="badge bg-red-50 text-red-700 border-red-200 font-black text-xs px-4 py-3 rounded-xl uppercase tracking-wider">
                        {{ $loan->status_loan }}
                    </span>
                @endif

                {{-- 2. REVISI BARU: BADGE/TOMBOL BUKTI TRANSFER DARI ADMIN --}}
                @if (in_array($loan->status_loan, ['disetujui', 'berjalan', 'lunas']))
                    <div class="flex items-center gap-2">

                        {{-- Bukti Transfer Awal (Rp 2 Juta) --}}
                        @if ($loan->bukti_transfer && $loan->bukti_transfer != '-')
                            <a href="{{ asset('File/SPP/Berkas/' . $loan->bukti_transfer) }}" target="_blank"
                                class="btn btn-sm bg-slate-100 hover:bg-slate-200 border border-slate-200/80 text-slate-700 font-bold text-[11px] rounded-xl px-3 h-8 min-h-0 normal-case inline-flex items-center gap-1 transition-all">
                                <i class="fa-solid fa-receipt text-emerald-600 text-[10px]"></i> Bukti TF Awal
                            </a>
                        @endif

                        {{-- Bukti Transfer Sisa Dana / Cair Penuh (Hanya muncul jika sudah cair penuh dan ada filenya) --}}
                        @if ($loan->status_pencairan == 'cair_penuh' && isset($loan->bukti_transfer_penuh) && $loan->bukti_transfer_penuh != '-')
                            <a href="{{ asset('File/SPP/BuktiTransfer/' . $loan->bukti_transfer_penuh) }}" target="_blank"
                                class="btn btn-sm bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 text-indigo-700 font-bold text-[11px] rounded-xl px-3 h-8 min-h-0 normal-case inline-flex items-center gap-1 transition-all">
                                <i class="fa-solid fa-circle-check text-indigo-600 text-[10px]"></i> Bukti TF Pelunasan
                            </a>
                        @endif

                    </div>
                @endif

            </div>
        </div>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div
                class="mb-5 flex items-start gap-3 rounded-2xl border border-emerald-100 bg-emerald-50/60 p-4 text-emerald-800 shadow-sm animate-fade-in">
                <i class="fa-solid fa-circle-check text-base mt-0.5 shrink-0 text-emerald-600"></i>
                <div class="space-y-0.5">
                    <h5 class="text-xs font-black uppercase tracking-wide">Transaksi Berhasil</h5>
                    <p class="text-xs font-medium leading-relaxed text-emerald-700/90">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Notifikasi Gagal / Error --}}
        @if (session('error'))
            <div
                class="mb-5 flex items-start gap-3 rounded-2xl border border-red-100 bg-red-50/60 p-4 text-red-800 shadow-sm animate-fade-in">
                <i class="fa-solid fa-circle-exclamation text-base mt-0.5 shrink-0 text-red-600"></i>
                <div class="space-y-0.5">
                    <h5 class="text-xs font-black uppercase tracking-wide">Transaksi Gagal</h5>
                    <p class="text-xs font-medium leading-relaxed text-red-700/90">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Notifikasi Error Validasi Input Berkas --}}
        @if ($errors->any())
            <div
                class="mb-5 flex items-start gap-3 rounded-2xl border border-amber-100 bg-amber-50/60 p-4 text-amber-800 shadow-sm animate-fade-in">
                <i class="fa-solid fa-triangle-exclamation text-base mt-0.5 shrink-0 text-amber-600"></i>
                <div class="space-y-0.5">
                    <h5 class="text-xs font-black uppercase tracking-wide">Periksa Kembali Berkas</h5>
                    <ul class="list-disc list-inside text-xs font-medium space-y-0.5 text-amber-700/90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

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
                        sebesar <strong>Rp {{ number_format($loan->plafon_disetujui - 2000000, 0, ',', '.') }}</strong>
                        baru
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
                                <td class="p-5 text-center vertical-align-middle">
                                    @if ($ins->status_bayar == 'lunas')
                                        <div class="flex flex-col items-center justify-center gap-1.5 w-full mx-auto">
                                            <span
                                                class="badge bg-emerald-50 text-emerald-700 border-emerald-100 font-bold text-[10px] rounded-lg py-2 min-w-[85px] text-center">
                                                Lunas
                                            </span>
                                            @if ($ins->bukti_pembayaran && $ins->bukti_pembayaran != '-')
                                                <a href="{{ asset('File/SPP/Berkas/' . $ins->bukti_pembayaran) }}"
                                                    target="_blank"
                                                    class="text-[9px] text-indigo-600 font-bold hover:underline flex items-center gap-0.5 justify-center">
                                                    <i class="fa-solid fa-image text-[8px]"></i> Lihat Bukti TF
                                                </a>
                                            @endif
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center justify-center gap-2 w-full mx-auto">
                                            {{-- Bagian Status Badge --}}
                                            <div class="flex flex-col items-center justify-center min-h-[32px]">
                                                @if ($dendaHariIni > 0)
                                                    <span
                                                        class="badge bg-red-50 text-red-700 border-red-100 font-bold text-[10px] rounded-lg py-2 min-w-[85px] text-center">
                                                        Menunggak
                                                    </span>
                                                    <div class="text-[9px] text-red-500 font-black mt-0.5">Telat
                                                        {{ $selisihHari }} Hari</div>
                                                @else
                                                    <span
                                                        class="badge bg-amber-50 text-amber-700 border-amber-100 font-bold text-[10px] rounded-lg py-2 min-w-[85px] text-center">
                                                        Belum Bayar
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Bagian Tombol Aksi --}}
                                            <button
                                                onclick="document.getElementById('modal_bayar_{{ $ins->id }}').showModal()"
                                                class="w-[85px] h-6 inline-flex items-center justify-center gap-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-[10px] rounded-md transition-all active:scale-95 shadow-xs border-none cursor-pointer">
                                                <i class="fa-solid fa-upload text-[9px]"></i> Bayar TF
                                            </button>
                                        </div>

                                        {{-- 📦 KODE MODAL DI DALAM TD (ID UNIK) --}}
                                        <dialog id="modal_bayar_{{ $ins->id }}"
                                            class="modal modal-bottom sm:modal-middle backdrop-blur-xs">
                                            <div
                                                class="modal-box max-w-md rounded-[2rem] border border-slate-100 bg-white p-6 shadow-2xl">

                                                <div class="mb-5 flex items-center justify-between">
                                                    <div class="text-left">
                                                        <h3
                                                            class="text-sm font-black uppercase tracking-tight text-slate-800">
                                                            Upload Bukti Transfer</h3>
                                                        <p class="text-[10px] text-slate-400 font-bold">Angsuran Bulan
                                                            Ke-{{ $ins->angsuran_ke }}</p>
                                                    </div>
                                                    <form method="dialog">
                                                        <button
                                                            class="btn btn-sm btn-circle btn-ghost text-slate-400 focus:outline-none">✕</button>
                                                    </form>
                                                </div>

                                                {{-- Form Kirim ke Controller --}}
                                                <form action="{{ url('/spp-group-payloan/' . $ins->id) }}" method="POST"
                                                    enctype="multipart/form-data" class="space-y-4 text-left">
                                                    @csrf

                                                    {{-- 🔥 REVISI BARU: Informasi Rekening Tujuan BUMDes --}}
                                                    <div
                                                        class="p-4 bg-indigo-50/60 border border-indigo-100 rounded-2xl flex items-start gap-3">
                                                        <div
                                                            class="w-8 h-8 bg-indigo-600 text-white rounded-xl flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                                                            <i class="fa-solid fa-building-columns text-xs"></i>
                                                        </div>
                                                        <div class="space-y-0.5">
                                                            <span
                                                                class="text-[10px] font-black text-indigo-500 uppercase tracking-wider block">Rekening
                                                                Tujuan BUMDes</span>
                                                            {{-- Silakan sesuaikan teks rekening bank di bawah ini dengan rekening asli BUMDes Anda --}}
                                                            <p class="text-xs font-black text-slate-800 tracking-wide">
                                                                {{ $noRek[0]->no_rek }}</p>
                                                            {{-- <p
                                                                class="text-[10px] text-slate-500 font-bold uppercase tracking-tight">
                                                                a.n Kas BUMDes Resmi</p> --}}
                                                        </div>
                                                    </div>

                                                    {{-- Detail Rincian Biaya --}}
                                                    <div
                                                        class="p-4 bg-slate-50 border border-slate-200/60 rounded-2xl space-y-1">
                                                        <span
                                                            class="text-[10px] font-black text-slate-400 uppercase tracking-wider block">Rincian
                                                            Nominal Tagihan</span>
                                                        <div
                                                            class="flex justify-between text-xs text-slate-600 font-medium pt-1">
                                                            <span>Pokok Angsuran:</span>
                                                            <span class="font-bold text-slate-800">Rp
                                                                {{ number_format($ins->jumlah_pokok, 0, ',', '.') }}</span>
                                                        </div>
                                                        <div
                                                            class="flex justify-between text-xs text-slate-600 font-medium">
                                                            <span>Jasa Program:</span>
                                                            <span class="font-bold text-slate-800">Rp
                                                                {{ number_format($ins->jumlah_bungan ?? $ins->jumlah_bunga, 0, ',', '.') }}</span>
                                                        </div>
                                                        @if ($dendaHariIni > 0)
                                                            <div
                                                                class="flex justify-between text-xs text-red-600 font-medium">
                                                                <span>Denda Keterlambatan:</span>
                                                                <span class="font-black">Rp
                                                                    {{ number_format($dendaHariIni, 0, ',', '.') }}</span>
                                                            </div>
                                                        @endif
                                                        <div
                                                            class="border-t border-slate-200 mt-2 pt-2 flex justify-between text-sm font-black text-slate-800">
                                                            <span>Total Transfer:</span>
                                                            <span class="text-indigo-600">
                                                                Rp
                                                                {{ number_format($ins->jumlah_pokok + ($ins->jumlah_bungan ?? $ins->jumlah_bunga) + $dendaHariIni, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    {{-- Form File Input --}}
                                                    <div class="form-control">
                                                        <label
                                                            class="label text-xs font-bold uppercase text-slate-500 tracking-wider">Pilih
                                                            Gambar Bukti Transfer (JPG/PNG)</label>
                                                        <input type="file" name="bukti_pembayaran" required
                                                            accept="image/*"
                                                            class="file-input file-input-bordered file-input-sm w-full rounded-xl border-slate-200 bg-slate-50/50 text-xs font-bold text-slate-700">
                                                        <label class="label text-[10px] text-amber-600 font-semibold mt-1">
                                                            <i class="fa-solid fa-circle-info mr-0.5"></i> Berkas yang
                                                            diunggah akan langsung melunasi angsuran ini secara instan.
                                                        </label>
                                                    </div>

                                                    {{-- Tombol Aksi --}}
                                                    <div class="modal-action gap-2 pt-2">
                                                        <button type="button"
                                                            onclick="document.getElementById('modal_bayar_{{ $ins->id }}').close()"
                                                            class="btn btn-sm bg-slate-100 hover:bg-slate-200 border-none text-slate-600 font-bold rounded-xl px-4">Batal</button>
                                                        <button type="submit"
                                                            class="btn btn-sm bg-indigo-600 hover:bg-indigo-700 border-none text-white font-black rounded-xl px-5">Kirim
                                                            & Lunasi</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </dialog>
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
