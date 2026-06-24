@extends('Admin.Layouts.main') {{-- Sesuaikan dengan layout admin Anda --}}

@section('content')
    <main class="p-6 md:p-10 space-y-8">

        {{-- Navigasi Kembali & Judul --}}
        <div class="space-y-2">
            <a href="{{ url('/spp-loan?status=' . $loan->status_loan) }}"
                class="text-xs font-bold text-indigo-600 hover:underline inline-flex items-center gap-1">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pinjaman
            </a>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight">Kartu Angsuran Digital</h1>
                    <p class="text-sm text-slate-500 mt-1">Kelompok: <span
                            class="font-bold text-slate-700">{{ $loan->group->nama_kelompok }}</span> &bull; No. Kontrak:
                        <span class="font-bold text-slate-700">{{ $loan->no_kontrak ?? 'Belum Ada' }}</span>
                    </p>
                </div>

                {{-- Badge Status Pinjaman --}}
                <div class="flex items-center gap-3">

                    {{-- Penanda Status Pinjaman --}}
                    @if ($loan->status_loan == 'disetujui')
                        <span
                            class="badge bg-emerald-50 text-emerald-700 border-emerald-200 font-black text-xs px-4 py-3 rounded-xl uppercase tracking-wider">
                            Cair Awal (Rp 2 Juta)
                        </span>
                    @elseif($loan->status_loan == 'berjalan')
                        {{-- Cek apakah sisa dananya sudah benar-benar diserahkan atau baru terbuka gemboknya --}}
                        @if ($loan->status_pencairan == 'cair_penuh')
                            <span
                                class="badge bg-indigo-50 text-indigo-700 border-indigo-200 font-black text-xs px-4 py-3 rounded-xl uppercase tracking-wider">
                                Sedang Berjalan (Sisa Dana Cair)
                            </span>
                        @else
                            <span
                                class="badge bg-amber-50 text-amber-700 border-amber-200 font-black text-xs px-4 py-3 rounded-xl uppercase tracking-wider animate-pulse">
                                Siap Cair Tahap 2
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

                    {{-- TOMBOL BARU: Lihat Bukti Transfer (Muncul jika berkas fisik tersedia di folder /public/File/SPP/BuktiTransfer) --}}
                    @if (in_array($loan->status_loan, ['disetujui', 'berjalan', 'lunas']) &&
                            $loan->bukti_transfer &&
                            $loan->bukti_transfer != '-')
                        <a href="{{ asset('File/SPP/Berkas/' . $loan->bukti_transfer) }}" target="_blank"
                            class="btn btn-sm bg-indigo-50 hover:bg-indigo-100 border border-indigo-200/60 text-indigo-700 font-black text-xs rounded-xl px-4 py-2.5 h-auto min-h-0 normal-case flex items-center gap-1.5 shadow-sm transition-all duration-200">
                            <i class="fa-solid fa-receipt text-[11px]"></i> Bukti Transfer
                        </a>
                    @endif

                    {{-- TOMBOL BARU: Cetak Rekap Transaksi (Hanya muncul jika pinjaman sudah disetujui, berjalan, atau lunas) --}}
                    @if (in_array($loan->status_loan, ['disetujui', 'berjalan', 'lunas']))
                        <a href="{{ url('/spp-loan/' . $loan->id . '/report') }}" target="_blank"
                            class="btn btn-sm bg-slate-900 hover:bg-slate-800 border-none text-white font-black text-xs rounded-xl px-4 py-2.5 h-auto min-h-0 normal-case flex items-center gap-1.5 shadow-sm transition-all duration-200">
                            <i class="fa-solid fa-file-pdf text-[11px]"></i> Cetak Rekap Transaksi
                        </a>
                    @endif

                </div>
            </div>
        </div>

        {{-- Flash Message Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success rounded-2xl shadow-sm text-sm font-bold text-white bg-emerald-500 border-none">
                <i class="fa-solid fa-circle-check text-base"></i> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-error rounded-2xl shadow-sm text-sm font-bold text-white bg-red-500 border-none">
                <i class="fa-solid fa-circle-xmark text-base"></i> {{ session('error') }}
            </div>
        @endif

        {{-- Grid Informasi Ringkasan Keuangan Pinjaman --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg"><i
                        class="fa-solid fa-wallet"></i></div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Plafon Pinjaman</p>
                    <p class="text-lg font-black text-slate-800">Rp
                        {{ number_format($loan->plafon_disetujui, 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Dana Telah Dicairkan</p>
                    <p class="text-lg font-black text-slate-800">Rp {{ number_format($loan->total_dicairkan, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg"><i
                        class="fa-solid fa-business-time"></i></div>
                <div>
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Tenor Pengembalian</p>
                    <p class="text-lg font-black text-slate-800">{{ $loan->tenor_bulan }} Bulan <span
                            class="text-xs text-slate-400 font-medium">(Jasa 0.5%)</span></p>
                </div>
            </div>
        </div>

        {{-- Banner Notifikasi Interaktif Alur Pencairan Tahap 2 --}}
        @if ($loan->status_loan == 'disetujui')
            {{-- TAMPILKAN BANNER KUNING JIKA STATUS MASIH BARU DISETUJUI (BARU CAIR AWAL 2 JUTA) --}}
            <div
                class="bg-amber-50 border border-amber-200 p-6 rounded-3xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center text-sm shrink-0 mt-0.5">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-amber-900 text-sm">Sisa Pencairan Dana Terkunci</h4>
                        <p class="text-xs text-amber-700 leading-relaxed mt-0.5">Sesuai kebijakan, sisa dana sebesar
                            <strong>Rp {{ number_format($loan->plafon_disetujui - 2000000, 0, ',', '.') }}</strong> baru
                            dapat diserahkan sepenuhnya setelah kelompok menyelesaikan pembayaran <strong>Angsuran Bulan
                                Ke-1</strong> di bawah ini.
                        </p>
                    </div>
                </div>
            </div>

            {{-- PERBAIKAN: Banner biru hanya muncul jika status 'berjalan' DAN status_pencairan BELUM 'cair_penuh' --}}
        @elseif($loan->status_loan == 'berjalan' && $loan->status_pencairan != 'cair_penuh')
            <div
                class="bg-indigo-50 border border-indigo-100 p-6 rounded-3xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-start gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-sm shrink-0 mt-0.5">
                        <i class="fa-solid fa-lock-open"></i>
                    </div>
                    <div>
                        <h4 class="font-black text-indigo-900 text-sm">Gembok Sisa Dana Terbuka (Siap Cair Tahap 2)</h4>
                        <p class="text-xs text-indigo-700 leading-relaxed mt-0.5">
                            Kelompok telah melunasi angsuran pertama. Segera serahkan sisa dana modal sebesar
                            <strong class="text-slate-900">Rp
                                {{ number_format($loan->plafon_disetujui - 2000000, 0, ',', '.') }}</strong> ke ketua
                            kelompok.
                        </p>
                    </div>
                </div>

                {{-- Tombol Trigger Modal --}}
                <label for="modal_cair_tahap2"
                    class="btn btn-sm bg-indigo-600 hover:bg-indigo-700 border-none text-white font-black text-xs rounded-xl px-4 py-2.5 normal-case shrink-0 cursor-pointer flex items-center gap-1.5 shadow-md shadow-indigo-100 active:scale-95 transition-all">
                    <i class="fa-solid fa-money-check-dollar"></i> Proses Cair Tahap 2
                </label>
            </div>

            {{-- ================= STURKTUR MODAL DIALOG: PENCAIRAN TAHAP 2 ================= --}}
            <input type="checkbox" id="modal_cair_tahap2" class="modal-toggle" />
            <div class="modal modal-bottom sm:modal-middle" role="dialog">
                <div
                    class="modal-box rounded-[2rem] border border-slate-200 p-8 shadow-2xl text-left bg-white whitespace-normal">

                    {{-- Ikon & Judul Utama --}}
                    <div class="flex items-start gap-4">
                        <div
                            class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg shrink-0">
                            <i class="fa-solid fa-hand-holding-hand"></i>
                        </div>
                        <div>
                            <h3 class="font-black text-slate-800 text-lg tracking-tight">Konfirmasi Pencairan Sisa Dana</h3>
                            <p class="text-xs text-slate-400 mt-0.5">Kelompok: <span
                                    class="font-bold text-slate-600">{{ $loan->group->nama_kelompok }}</span></p>
                        </div>
                    </div>

                    {{-- Detail Nominal Penyerahan Dana di Dalam Kotak Berwarna --}}
                    <div class="mt-6 bg-indigo-50/40 border border-indigo-100 p-6 rounded-2xl text-center">
                        <p class="text-indigo-500 uppercase tracking-wider text-[10px] font-black">Nominal Penyerahan Dana
                            (Tahap 2)</p>
                        <p class="text-indigo-700 text-3xl font-black mt-1.5 tracking-tight">
                            Rp {{ number_format($loan->plafon_disetujui - 2000000, 0, ',', '.') }}
                        </p>
                        <div class="text-[10px] text-indigo-500 font-semibold mt-1 italic">
                            (Total Plafon Rp {{ number_format($loan->plafon_disetujui, 0, ',', '.') }} dikurangi Cair Awal
                            Rp 2.000.000)
                        </div>
                    </div>

                    {{-- Informasi Peringatan Prosedural --}}
                    <p class="text-[11px] text-slate-400 leading-relaxed mt-5 font-medium">
                        <i class="fa-solid fa-circle-info text-indigo-500 mr-0.5"></i> Tindakan ini akan mencatatkan
                        penyerahan modal tahap akhir secara permanen di sistem kas BUMDes. Pastikan uang tunai atau transfer
                        bank senilai sisa dana di atas sudah diserahkan sepenuhnya kepada pengurus kelompok yang sah.
                    </p>

                    {{-- Tombol Aksi Form di Bagian Bawah Modal --}}
                    <div class="modal-action gap-2 pt-2">
                        <label for="modal_cair_tahap2"
                            class="btn btn-sm bg-slate-100 hover:bg-slate-200 border-none text-slate-600 font-bold rounded-xl px-4 normal-case cursor-pointer">
                            Batal
                        </label>

                        {{-- PERBAIKAN: Form action disesuaikan menuju rute Admin yang benar --}}
                        <form action="{{ url('/spp-loan-cair2/' . $loan->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="btn btn-sm bg-indigo-600 hover:bg-indigo-700 border-none text-white font-black rounded-xl px-5 normal-case shadow-md shadow-indigo-100">
                                <i class="fa-solid fa-paper-plane mr-1"></i> Sahkan Pencairan
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @endif

        {{-- Tabel Jadwal Angsuran --}}
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                <h3 class="text-sm font-black text-slate-800">Skema Angsuran Bulanan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full border-none">
                    <thead>
                        <tr
                            class="bg-slate-50/70 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                            <th class="p-5">Bulan Ke</th>
                            <th class="p-5">Angsuran Pokok</th>
                            <th class="p-5">Jasa BUMDes (0.5%)</th>
                            <th class="p-5 text-red-600">Denda (Telat)</th> {{-- <th> BARU UNTUK DENDA --}}
                            <th class="p-5">Total Tagihan</th>
                            <th class="p-5">Jatuh Tempo</th>
                            <th class="p-5">Tanggal Bayar</th>
                            <th class="p-5 text-center">Status</th>
                            <th class="p-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 text-xs font-semibold">
                        @foreach ($installments as $ins)
                            @php
                                // 1. Inisialisasi variabel denda awal
                                $dendaHariIni = 0;
                                $selisihHari = 0;

                                // 2. Jika BELUM BAYAR dan TANGGAL JATUH TEMPO SUDAH LEWAT dari hari ini
                                if (
                                    $ins->status_bayar == 'belum_bayar' &&
                                    \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($ins->tanggal_jatuh_tempo))
                                ) {
                                    // Hitung selisih hari keterlambatan
                                    $selisihHari = \Carbon\Carbon::parse($ins->tanggal_jatuh_tempo)->diffInDays(
                                        \Carbon\Carbon::now(),
                                    );

                                    // Misalkan aturan BUMDes: Denda Rp 5.000 per hari keterlambatan
                                    // Silakan sesuaikan nominal Rp 5.000 ini dengan aturan BUMDes Jambi Anda
                                    $dendaHariIni = $selisihHari * 5000;
                                }
                            @endphp
                            <tr
                                class="hover:bg-slate-50/30 transition-colors {{ $ins->status_bayar == 'lunas' ? 'bg-slate-50/20 text-slate-400' : '' }}">
                                <td class="p-5 font-black text-slate-800">Bulan {{ $ins->angsuran_ke }}</td>
                                <td class="p-5">Rp {{ number_format($ins->jumlah_pokok, 0, ',', '.') }}</td>
                                <td class="p-5">Rp {{ number_format($ins->jumlah_bunga, 0, ',', '.') }}</td>
                                {{-- KONTEN TD BARU: Menampilkan denda berjalan secara transparan --}}
                                <td class="p-5 text-red-600 font-bold">
                                    @if ($ins->status_bayar == 'lunas')
                                        Rp {{ number_format($ins->denda_kumulatif, 0, ',', '.') }}
                                    @elseif($dendaHariIni > 0)
                                        Rp {{ number_format($dendaHariIni, 0, ',', '.') }}
                                    @else
                                        <span class="text-slate-300 font-normal">-</span>
                                    @endif
                                </td>
                                <td class="p-5 font-bold text-slate-800">Rp
                                    {{ number_format($ins->jumlah_pokok + $ins->jumlah_bunga, 0, ',', '.') }}</td>


                                <td class="p-5">{{ \Carbon\Carbon::parse($ins->tanggal_jatuh_tempo)->format('d M Y') }}
                                </td>
                                <td class="p-5">
                                    {{ $ins->tanggal_bayar ? \Carbon\Carbon::parse($ins->tanggal_bayar)->format('d M Y') : '-' }}
                                </td>
                                <td class="p-5 text-center vertical-align-middle">
                                    @if ($ins->status_bayar == 'lunas')
                                        <div class="flex flex-col items-center justify-center gap-1 w-full mx-auto">
                                            {{-- Badge Status Lunas --}}
                                            <span
                                                class="badge bg-emerald-50 text-emerald-700 border-emerald-100 font-bold text-[10px] rounded-lg py-2 min-w-[90px] text-center">
                                                Lunas
                                            </span>

                                            {{-- Deteksi Sumber Pembayaran --}}
                                            @if ($ins->bukti_pembayaran && $ins->bukti_pembayaran != '-')
                                                {{-- JIKA VIA TRANSFER: Tampilkan Tombol Intip Bukti --}}
                                                <a href="{{ asset('File/SPP/Berkas/' . $ins->bukti_pembayaran) }}"
                                                    target="_blank"
                                                    class="btn btn-xs h-5 min-h-0 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200/60 text-indigo-700 font-extrabold text-[9px] rounded-md px-2 normal-case flex items-center gap-0.5 mt-1 transition-all">
                                                    <i class="fa-solid fa-receipt text-[8px]"></i> Bukti TF
                                                </a>
                                            @else
                                                {{-- JIKA TUNAI: Tampilkan Penanda Cash --}}
                                                <span
                                                    class="text-[9px] text-slate-400 font-bold mt-0.5 flex items-center gap-0.5 justify-center">
                                                    <i class="fa-solid fa-money-bill-wave text-[8px]"></i> Tunai / Kasir
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        {{-- Kondisi Belum Bayar / Menunggak di Sisi Admin --}}
                                        <div class="flex flex-col items-center justify-center min-h-[36px] w-full mx-auto">
                                            @if ($dendaHariIni > 0)
                                                {{-- Perhitungan denda real-time admin --}}
                                                <span
                                                    class="badge bg-red-50 text-red-700 border-red-100 font-bold text-[10px] rounded-lg py-2 min-w-[90px] text-center">
                                                    Menunggak
                                                </span>
                                                <div class="text-[9px] text-red-500 font-black mt-0.5">Telat
                                                    {{ $selisihHari }} Hari</div>
                                            @else
                                                <span
                                                    class="badge bg-amber-50 text-amber-700 border-amber-100 font-bold text-[10px] rounded-lg py-2 min-w-[90px] text-center">
                                                    Belum Bayar
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                                <td class="p-5 text-center">
                                    @if ($ins->status_bayar != 'lunas')
                                        {{-- Pembungkus Form & Modal Per Baris Angsuran --}}
                                        <div>
                                            {{-- Tombol Pemicu Modal (Trigger) --}}
                                            <label for="modal_pay_{{ $ins->id }}"
                                                class="btn btn-xs bg-emerald-600 hover:bg-emerald-700 border-none text-white font-bold rounded-lg px-3 py-1 normal-case cursor-pointer inline-flex items-center gap-1">
                                                <i class="fa-solid fa-receipt text-[10px]"></i> Bayar
                                            </label>

                                            {{-- Elemen Kontrol Modal (DaisyUI Toggle) --}}
                                            <input type="checkbox" id="modal_pay_{{ $ins->id }}"
                                                class="modal-toggle" />

                                            {{-- Komponen Kontainer Modal --}}
                                            <div class="modal modal-bottom sm:modal-middle" role="dialog">
                                                <div
                                                    class="modal-box rounded-[2rem] border border-slate-200 p-8 shadow-2xl text-left bg-white whitespace-normal">

                                                    {{-- Ikon & Judul Utama --}}
                                                    <div class="flex items-start gap-4">
                                                        <div
                                                            class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shrink-0">
                                                            <i class="fa-solid fa-file-invoice-dollar"></i>
                                                        </div>
                                                        <div>
                                                            <h3 class="font-black text-slate-800 text-lg tracking-tight">
                                                                Konfirmasi Pembayaran</h3>
                                                            <p class="text-xs text-slate-400 mt-0.5">Kelompok: <span
                                                                    class="font-bold text-slate-600">{{ $loan->group->nama_kelompok }}</span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    {{-- Detail Rincian Tagihan di Dalam Kotak --}}
                                                    <div
                                                        class="mt-6 bg-slate-50 border border-slate-100 p-5 rounded-2xl space-y-2.5 text-xs font-semibold text-slate-600">
                                                        <div class="flex justify-between items-center">
                                                            <span class="text-slate-400">Periode Angsuran</span>
                                                            <span
                                                                class="text-slate-800 font-bold bg-slate-200/60 px-2 py-0.5 rounded-md">Bulan
                                                                Ke-{{ $ins->angsuran_ke }}</span>
                                                        </div>
                                                        <div class="flex justify-between items-center">
                                                            <span class="text-slate-400">Angsuran Pokok</span>
                                                            <span class="text-slate-700">Rp
                                                                {{ number_format($ins->jumlah_pokok, 0, ',', '.') }}</span>
                                                        </div>
                                                        <div class="flex justify-between items-center">
                                                            <span class="text-slate-400">Jasa BUMDes (0.5%)</span>
                                                            <span class="text-slate-700">Rp
                                                                {{ number_format($ins->jumlah_bunga, 0, ',', '.') }}</span>
                                                        </div>

                                                        {{-- PERBAIKAN: Baris Info Denda Otomatis Muncul Jika Ada Keterlambatan --}}
                                                        @if ($dendaHariIni > 0)
                                                            <div
                                                                class="flex justify-between items-center text-red-600 font-bold bg-red-50/70 px-2.5 py-1.5 rounded-xl border border-red-100">
                                                                <span>Denda Keterlambatan ({{ $selisihHari }} Hari)</span>
                                                                <span>+ Rp
                                                                    {{ number_format($dendaHariIni, 0, ',', '.') }}</span>
                                                            </div>
                                                        @endif

                                                        {{-- PERBAIKAN: Total Setoran Sudah Ditambah Denda --}}
                                                        <div
                                                            class="border-t border-dashed border-slate-200 my-2 pt-2.5 flex justify-between items-center text-sm font-black">
                                                            <span class="text-slate-800">Total Setoran</span>
                                                            <span class="text-emerald-600 text-base">
                                                                Rp
                                                                {{ number_format($ins->jumlah_pokok + $ins->jumlah_bunga + $dendaHariIni, 0, ',', '.') }}
                                                            </span>
                                                        </div>
                                                    </div>

                                                    {{-- Informasi Peringatan Tambahan jika Menunggak --}}
                                                    @if ($dendaHariIni > 0)
                                                        <p class="text-[11px] text-red-500 leading-relaxed mt-4 font-bold">
                                                            <i class="fa-solid fa-triangle-exclamation mr-0.5"></i>
                                                            Pembayaran ini melampaui batas jatuh tempo. Pastikan denda
                                                            keterlambatan sebesar Rp
                                                            {{ number_format($dendaHariIni, 0, ',', '.') }} juga ditagih ke
                                                            ketua kelompok.
                                                        </p>
                                                    @else
                                                        <p
                                                            class="text-[11px] text-slate-400 leading-relaxed mt-4 font-medium">
                                                            <i class="fa-solid fa-circle-info text-indigo-500 mr-0.5"></i>
                                                            Pastikan uang setoran fisik dari kelompok sudah Anda terima dan
                                                            dihitung dengan benar sebelum melakukan konfirmasi pembukuan
                                                            ini.
                                                        </p>
                                                    @endif

                                                    {{-- Aksi Form Tombol di Bagian Bawah --}}
                                                    <div class="modal-action gap-2 pt-2">
                                                        <label for="modal_pay_{{ $ins->id }}"
                                                            class="btn btn-sm bg-slate-100 hover:bg-slate-200 border-none text-slate-600 font-bold rounded-xl px-4 normal-case cursor-pointer">
                                                            Batal
                                                        </label>

                                                        {{-- Form Kirim Data ke Backend --}}
                                                        <form action="{{ url('/spp-loan-pay/' . $ins->id) }}"
                                                            method="POST" class="inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="btn btn-sm bg-emerald-600 hover:bg-emerald-700 border-none text-white font-black rounded-xl px-5 normal-case shadow-md shadow-emerald-100">
                                                                <i class="fa-solid fa-check-double mr-1"></i> Sahkan
                                                                Pembayaran
                                                            </button>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center gap-1">
                                            <span class="text-[11px] italic font-medium text-slate-400">Terbayar</span>

                                            {{-- TAMBAHKAN: Tombol Cetak Nota Pintas --}}
                                            <a href="{{ url('/spp-installment/' . $ins->id . '/receipt') }}"
                                                target="_blank"
                                                class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 px-2 py-0.5 rounded transition-colors inline-flex items-center gap-0.5">
                                                <i class="fa-solid fa-print text-[9px]"></i> Cetak Nota
                                            </a>
                                        </div>
                                    @endif
                                </td>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
