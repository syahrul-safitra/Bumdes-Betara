@extends('Admin.Layouts.main')

@section('content')
    <div class="p-6 max-w-6xl mx-auto space-y-6">

        {{-- Flash Alert Notifikasi --}}
        @if (session('success'))
            <div class="alert alert-success rounded-2xl border-none text-white font-bold shadow-md mb-4">
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

        {{-- Navigation Top Bar --}}
        <div class="flex justify-between items-center">
            {{-- Letakkan di area tombol atas show.blade.php --}}
            <div class="flex items-center gap-2">
                <a href="{{ url('/spp-loan/' . $loan->id . '/report') }}" target="_blank"
                    class="btn btn-sm bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl font-black text-xs border-none shadow-sm flex items-center gap-1.5">
                    <i class="fa-solid fa-file-pdf"></i>
                    Cetak Dokumen Laporan
                </a>

                {{-- Tombol Kembali yang sudah ada sebelumnya --}}
                <a href="{{ url('/spp-loan') }}"
                    class="btn btn-sm btn-ghost rounded-xl border border-slate-200 text-slate-500 font-bold text-xs">
                    Kembali
                </a>
            </div>
        </div>

        {{-- KARTU PROFIL KONTRAK PINJAMAN --}}
        <div
            class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between gap-6 items-start md:items-center">
            <div class="space-y-1.5">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-xs font-black uppercase bg-indigo-50 text-indigo-600 px-3 py-1 rounded-xl">Kontrak
                        SPP</span>
                    <h1 class="text-xl font-black text-slate-800 tracking-tight">{{ $loan->no_kontrak }}</h1>
                </div>
                <p class="text-sm font-medium text-slate-600 flex items-center gap-1.5">
                    <i class="fa-solid fa-people-roof text-indigo-500"></i> Kelompok Benefisari:
                    <span class="font-black text-slate-800">Kelompok {{ $loan->group->nama_kelompok }}</span>
                </p>
                <p class="text-xs text-slate-400">Parameter Kredit: Tenor <span
                        class="text-slate-700 font-bold">{{ $loan->tenor_bulan }} Bulan</span> dengan Bunga <span
                        class="text-indigo-600 font-bold">{{ $loan->bunga_persen }}%</span> per bulan.</p>
            </div>

            {{-- STATUS CONTROLLER & ACTION BUTTON --}}
            <div>
                @if ($loan->status_loan == 'review')
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        <span
                            class="badge badge-lg border-none bg-amber-100 text-amber-700 font-black uppercase text-xs p-4 rounded-xl italic">Status:
                            Review Berkas</span>

                        {{-- Tombol pemicu Modal DaisyUI --}}
                        <label for="modal-cairkan"
                            class="btn btn-md rounded-2xl border-none bg-emerald-600 hover:bg-emerald-700 text-white font-black uppercase tracking-wider text-xs px-6 shadow-lg shadow-emerald-100 cursor-pointer transition-all hover:-translate-y-0.5">
                            <i class="fa-solid fa-money-bill-transfer mr-2 text-sm"></i> Cairkan Dana Sekarang
                        </label>
                    </div>
                @else
                    <div>
                        @if ($loan->status_loan == 'review')
                            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                                <span
                                    class="badge badge-lg border-none bg-amber-100 text-amber-700 font-black uppercase text-xs p-4 rounded-xl italic">Status:
                                    Review Berkas</span>

                                <label for="modal-cairkan"
                                    class="btn btn-md rounded-2xl border-none bg-emerald-600 hover:bg-emerald-700 text-white font-black uppercase tracking-wider text-xs px-6 shadow-lg shadow-emerald-100 cursor-pointer">
                                    <i class="fa-solid fa-money-bill-transfer mr-2 text-sm"></i> Cairkan Dana Awal
                                </label>
                            </div>
                        @else
                            <div class="flex items-center gap-4">
                                {{-- TOMBOL PENCAIRAN TAHAP BERIKUTNYA (Muncul jika total dicairkan masih kurang dari plafon) --}}
                                @if ($loan->status_loan == 'berjalan' && $loan->total_dicairkan < $loan->plafon_disetujui)
                                    <label for="modal-cairkan-lanjut"
                                        class="btn btn-sm rounded-xl border border-emerald-600 bg-transparent hover:bg-emerald-50 text-emerald-600 font-black uppercase text-[10px] px-4 shadow-sm cursor-pointer">
                                        <i class="fa-solid fa-hand-holding-dollar mr-1"></i> Cairkan Sisa Dana
                                    </label>
                                @endif

                                <div class="text-right">
                                    <p class="text-[10px] font-black uppercase text-slate-400 tracking-wider">Status
                                        Pinjaman</p>
                                    @if ($loan->status_loan == 'berjalan')
                                        <span
                                            class="badge border-none bg-sky-500 text-white font-black uppercase text-xs px-4 py-3 rounded-xl mt-1">Kredit
                                            Aktif</span>
                                    @elseif($loan->status_loan == 'macet')
                                        <span
                                            class="badge border-none bg-red-500 text-white font-black uppercase text-xs px-4 py-3 rounded-xl mt-1">Kredit
                                            Macet</span>
                                    @else
                                        <span
                                            class="badge border-none bg-emerald-500 text-white font-black uppercase text-xs px-4 py-3 rounded-xl mt-1">Lunas</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        {{-- KOMPONEN DIALOG MODAL CAIRKAN DANA BERTAHAP --}}
        <input type="checkbox" id="modal-cairkan" class="modal-toggle" />
        <div class="modal modal-bottom sm:modal-middle" role="dialog">
            <div class="modal-box bg-white rounded-[2.5rem] p-8 max-w-md border border-slate-100 shadow-2xl">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="p-4 bg-emerald-50 text-emerald-600 rounded-full text-3xl">
                        <i class="fa-solid fa-vault"></i>
                    </div>

                    <div class="space-y-1">
                        <h3 class="text-lg font-black text-slate-800 tracking-tight">Pencairan Dana Tahap Awal</h3>
                        <p class="text-xs text-slate-400">Masukkan nominal dana yang akan diserahkan ke kelompok untuk tahap
                            ini.</p>
                    </div>

                    {{-- Form Input Nominal Cair --}}
                    <form action="{{ url('/spp-loan/' . $loan->id . '/disburse') }}" method="POST"
                        class="w-full text-left space-y-4 mt-2">
                        @csrf

                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-2">
                            <div class="flex justify-between text-xs font-semibold text-slate-500">
                                <span>Total Plafon Kontrak:</span>
                                <span
                                    class="font-black text-slate-800">Rp{{ number_format($loan->plafon_disetujui, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex flex-col w-full">
                            <label class="mb-1 ml-1 text-xs font-bold text-slate-500">Nominal Pencairan Saat Ini
                                (Rp)</label>
                            <input type="number" name="nominal_cair" max="{{ $loan->plafon_disetujui }}" value="2000000"
                                placeholder="Contoh: 2000000"
                                class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0 font-bold text-emerald-600"
                                required />
                            <span class="text-[10px] text-slate-400 mt-1 ml-1">* Maksimal sebesar total plafon
                                kontrak</span>
                        </div>

                        <div class="flex items-center justify-end gap-3 mt-6 border-t border-slate-50 pt-4">
                            <label for="modal-cairkan"
                                class="btn btn-ghost rounded-xl px-6 font-bold uppercase text-xs text-slate-400 tracking-wider">
                                Batal
                            </label>
                            <button type="submit"
                                class="btn rounded-xl border-none bg-emerald-600 text-white font-black uppercase text-xs px-6 tracking-wider shadow-md hover:bg-emerald-700">
                                Konfirmasi Cairkan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- KEL Kelompok Nilai Nominal Finansial --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-wider">Total Plafon Disetujui</p>
                <p class="text-2xl font-black text-slate-800 mt-1">
                    Rp{{ number_format($loan->plafon_disetujui, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-wider">Dana yang Dicairkan</p>
                <p class="text-2xl font-black text-emerald-600 mt-1">
                    Rp{{ number_format($loan->total_dicairkan, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <p class="text-[10px] font-black uppercase text-slate-400 tracking-wider">Angsuran per Bulan</p>
                <p class="text-2xl font-black text-indigo-600 mt-1">
                    @if ($loan->installments && $loan->installments->isNotEmpty())
                        @php
                            // Ambil baris angsuran pertama sebagai sampel nominal bulanan
                            $firstInstallment = $loan->installments->first();
                            // Jumlahkan nilai Pokok + Jasa Bunga bulanan
                            $totalAngsuranBulanan = $firstInstallment->jumlah_pokok + $firstInstallment->jumlah_bunga;
                        @endphp
                        Rp{{ number_format($totalAngsuranBulanan, 0, ',', '.') }}
                    @else
                        <span class="text-sm font-medium text-slate-400">Belum di-generate</span>
                    @endif
                </p>
            </div>
        </div>

        {{-- TABEL JADWAL ANGSURAN BULANAN --}}
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <h2 class="text-sm font-black uppercase tracking-wider text-slate-700 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-calendar-days text-indigo-500"></i> Amortisasi & Jadwal Angsuran Bulanan
            </h2>

            <div class="w-full overflow-x-auto bg-white rounded-3xl border border-slate-100">

                <table class="table w-full table-fixed min-w-[750px]">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase font-black tracking-wider">
                            {{-- Menggunakan lebar persentase agar proporsional dan presisi --}}
                            <th class="bg-transparent text-center w-[10%]">Bulan Ke</th>
                            <th class="bg-transparent w-[18%]">Tanggal Jatuh Tempo</th>
                            <th class="bg-transparent text-right w-[15%]">Angsuran Pokok</th>
                            <th class="bg-transparent text-right w-[12%]">Bunga ({{ $loan->bunga_persen }}%)</th>
                            <th class="bg-transparent text-right w-[15%]">Total Angsuran</th>
                            <th class="bg-transparent text-center w-[12%]">Denda Terlambat</th>
                            <th class="bg-transparent text-center w-[10%]">Status</th>
                            <th class="bg-transparent text-center w-[12%]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($loan->installments as $installment)
                            @php
                                // Ambil tanggal jatuh tempo dari database dan ubah ke objek Carbon
                                $jt = \Carbon\Carbon::parse($installment->tanggal_jatuh_tempo)->startOfDay();
                                $hariIni = \Carbon\Carbon::now()->startOfDay();

                                $dendaBerjalan = 0;
                                $hariTerlambat = 0;

                                // Gunakan fungsi bawaan Carbon untuk menghitung selisih hari secara mutlak
                                if ($installment->status_bayar == 'belum_bayar' && $hariIni->greaterThan($jt)) {
                                    $hariTerlambat = $hariIni->diffInDays($jt);
                                    $dendaBerjalan = $hariTerlambat * 2000;
                                }
                            @endphp

                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="text-center bg-transparent font-black text-slate-700 text-sm">
                                    {{ $installment->angsuran_ke }}
                                </td>
                                <td class="bg-transparent text-sm font-semibold text-slate-600">
                                    {{ \Carbon\Carbon::parse($installment->tanggal_jatuh_tempo)->translatedFormat('d F Y') }}
                                </td>
                                <td class="bg-transparent text-right text-slate-600 text-sm font-medium">
                                    Rp{{ number_format($installment->jumlah_pokok, 0, ',', '.') }}
                                </td>
                                <td class="bg-transparent text-right text-slate-600 text-sm font-medium">
                                    Rp{{ number_format($installment->jumlah_bunga, 0, ',', '.') }}
                                </td>
                                <td class="bg-transparent text-right font-black text-slate-800 text-sm">
                                    {{-- Total Angsuran = Pokok + Bunga --}}
                                    Rp{{ number_format($installment->jumlah_pokok + $installment->jumlah_bunga, 0, ',', '.') }}
                                </td>

                                {{-- Kolom Denda Keterlambatan --}}
                                <td class="text-center bg-transparent">
                                    @if ($installment->status_bayar == 'lunas')
                                        <span
                                            class="text-slate-500 font-bold text-xs">Rp{{ number_format($installment->denda_kumulatif, 0, ',', '.') }}</span>
                                    @else
                                        @if ($dendaBerjalan > 0)
                                            <div class="flex flex-col items-center">
                                                <span
                                                    class="text-red-600 font-black text-xs">Rp{{ number_format($dendaBerjalan, 0, ',', '.') }}</span>
                                                <span
                                                    class="text-[9px] bg-red-100 text-red-700 font-black px-1.5 py-0.5 rounded mt-0.5">Telat
                                                    {{ $hariTerlambat }} Hari</span>
                                            </div>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    @endif
                                </td>

                                {{-- Kolom Status Bayar --}}
                                <td class="text-center bg-transparent">
                                    @if ($installment->status_bayar == 'lunas')
                                        <span
                                            class="badge border-none bg-emerald-100 text-emerald-700 font-bold text-[9px] px-2 py-1.5 rounded-lg uppercase">Lunas</span>
                                    @else
                                        <span
                                            class="badge border-none bg-slate-100 text-slate-400 font-bold text-[9px] px-2 py-1.5 rounded-lg uppercase">Belum
                                            Bayar</span>
                                    @endif
                                </td>

                                {{-- Tombol Aksi Kerja Bayar --}}
                                <td class="text-center bg-transparent">
                                    @if ($installment->status_bayar == 'belum_bayar' && $loan->status_loan == 'berjalan')
                                        {{-- Tombol pemicu Modal dengan ID unik per baris angsuran --}}
                                        <label for="modal-bayar-{{ $installment->id }}"
                                            class="btn btn-xs rounded-lg border-none bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-3 shadow cursor-pointer">
                                            Bayar
                                        </label>

                                        {{-- KOMPONEN MODAL DI DALAM LOOP (Unik per Baris) --}}
                                        <input type="checkbox" id="modal-bayar-{{ $installment->id }}"
                                            class="modal-toggle" />
                                        <div class="modal modal-bottom sm:modal-middle" role="dialog">
                                            <div
                                                class="modal-box bg-white rounded-[2.5rem] p-8 max-w-sm border border-slate-100 shadow-2xl text-left">
                                                <div class="flex flex-col items-center text-center space-y-3">
                                                    <div class="p-3 bg-indigo-50 text-indigo-600 rounded-full text-2xl">
                                                        <i class="fa-solid fa-file-invoice-dollar"></i>
                                                    </div>
                                                    <h3 class="text-base font-black text-slate-800">Konfirmasi
                                                        Pembayaran
                                                    </h3>
                                                    <p class="text-xs text-slate-400">Anda akan mencatat setoran tunai
                                                        untuk Angsuran Bulan Ke-{{ $installment->angsuran_ke }}.</p>
                                                </div>

                                                {{-- Detail Billing --}}
                                                <div
                                                    class="w-full bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-2 mt-4 text-xs font-semibold text-slate-600">
                                                    <div class="flex justify-between">
                                                        <span>Angsuran Pokok:</span>
                                                        <span
                                                            class="text-slate-800">Rp{{ number_format($installment->jumlah_pokok, 0, ',', '.') }}</span>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <span>Jasa Bunga:</span>
                                                        <span
                                                            class="text-slate-800">Rp{{ number_format($installment->jumlah_bunga, 0, ',', '.') }}</span>
                                                    </div>

                                                    {{-- Tampilkan info denda di modal jika real-time terdeteksi telat --}}
                                                    @if ($dendaBerjalan > 0)
                                                        <div
                                                            class="flex justify-between text-red-600 bg-red-50 p-2 rounded-lg border border-red-100 mt-1">
                                                            <span>Denda Telat ({{ $hariTerlambat }} Hari):</span>
                                                            <span
                                                                class="font-black">Rp{{ number_format($dendaBerjalan, 0, ',', '.') }}</span>
                                                        </div>
                                                    @endif

                                                    <div
                                                        class="flex justify-between border-t border-slate-200 pt-2 text-slate-800 font-black text-sm">
                                                        <span>Total Setoran:</span>
                                                        <span
                                                            class="text-indigo-600">Rp{{ number_format($installment->jumlah_pokok + $installment->jumlah_bunga + $dendaBerjalan, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>

                                                {{-- Form Aksi Submit --}}
                                                <form action="{{ url('/spp-installment/' . $installment->id . '/pay') }}"
                                                    method="POST"
                                                    class="modal-action flex items-center justify-end gap-2 mt-6">
                                                    @csrf
                                                    <label for="modal-bayar-{{ $installment->id }}"
                                                        class="btn btn-ghost btn-sm rounded-xl px-4 font-bold text-xs text-slate-400">Batal</label>
                                                    <button type="submit"
                                                        class="btn btn-sm rounded-xl border-none bg-indigo-600 text-white font-black text-xs px-5 shadow">Konfirmasi
                                                        Lunas</button>
                                                </form>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ url('/spp-installment/' . $installment->id . '/receipt') }}"
                                            target="_blank"
                                            class="btn btn-xs rounded-lg border border-slate-200 bg-white hover:bg-slate-50 text-slate-600 font-bold px-2 shadow-sm">
                                            <i class="fa-solid fa-print text-indigo-500 mr-1"></i> Kuitansi
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8"
                                    class="text-center bg-transparent py-12 text-slate-400 text-xs italic font-medium">
                                    Jadwal pembayaran belum dibuat. Tekan tombol <span
                                        class="font-bold text-emerald-600">"Cairkan Dana Sekarang"</span> di atas untuk
                                    mengaktifkan kredit dan membuat tabel angsuran bulanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- KOMPONEN DIALOG MODAL CAIRKAN SISA PLAFON (BERTAHAP) --}}
    @if ($loan->status_loan == 'berjalan' && $loan->total_dicairkan < $loan->plafon_disetujui)
        <input type="checkbox" id="modal-cairkan-lanjut" class="modal-toggle" />
        <div class="modal modal-bottom sm:modal-middle" role="dialog">
            <div class="modal-box bg-white rounded-[2.5rem] p-8 max-w-md border border-slate-100 shadow-2xl">
                <div class="flex flex-col items-center text-center space-y-4">
                    <div class="p-4 bg-sky-50 text-sky-600 rounded-full text-3xl">
                        <i class="fa-solid fa-hand-holding-dollar"></i>
                    </div>

                    <div class="space-y-1">
                        <h3 class="text-lg font-black text-slate-800 tracking-tight">Pencairan Tahap Lanjutan</h3>
                        <p class="text-xs text-slate-400">Menyerahkan sisa komitmen plafon kredit pinjaman kelompok.
                        </p>
                    </div>

                    <form action="{{ url('/spp-loan/' . $loan->id . '/disburse-next') }}" method="POST"
                        class="w-full text-left space-y-4 mt-2">
                        @csrf

                        @php
                            $sisaPlafonKontrak = $loan->plafon_disetujui - $loan->total_dicairkan;
                        @endphp

                        <div
                            class="bg-slate-50 p-4 rounded-2xl border border-slate-100 space-y-2 text-xs font-semibold text-slate-500">
                            <div class="flex justify-between">
                                <span>Plafon Kontrak:</span>
                                <span
                                    class="text-slate-800 font-bold">Rp{{ number_format($loan->plafon_disetujui, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Sudah Dicairkan:</span>
                                <span
                                    class="text-emerald-600 font-bold">Rp{{ number_format($loan->total_dicairkan, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between border-t border-slate-200/60 pt-2 text-slate-700">
                                <span>Sisa Maksimal Cair:</span>
                                <span
                                    class="text-indigo-600 font-black">Rp{{ number_format($sisaPlafonKontrak, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex flex-col w-full">
                            <label class="mb-1 ml-1 text-xs font-bold text-slate-500">Nominal Dicairkan Sekarang
                                (Rp)</label>
                            <input type="number" name="nominal_cair_lanjut" max="{{ $sisaPlafonKontrak }}"
                                value="{{ $sisaPlafonKontrak }}" placeholder="Masukkan nominal"
                                class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0 font-bold text-sky-600"
                                required />
                        </div>

                        <div class="flex items-center justify-end gap-3 mt-6 border-t border-slate-50 pt-4">
                            <label for="modal-cairkan-lanjut"
                                class="btn btn-ghost rounded-xl px-6 font-bold uppercase text-xs text-slate-400 tracking-wider">
                                Batal
                            </label>
                            <button type="submit"
                                class="btn rounded-xl border-none bg-indigo-600 text-white font-black uppercase text-xs px-6 tracking-wider shadow-md hover:bg-indigo-700">
                                Konfirmasi Serah Dana
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
