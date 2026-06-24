@extends('Admin.Layouts.main')

@section('content')
    <main class="p-6 lg:p-10 space-y-10">

        @if (session('success'))
            <div id="success-alert"
                class="fixed top-5 right-5 z-[100] flex w-full max-w-sm items-center gap-4 rounded-3xl border border-emerald-100 bg-white/90 p-4 text-emerald-800 shadow-2xl backdrop-blur-md animate-in fade-in slide-in-from-right-10 duration-500">

                {{-- Ikon Centang --}}
                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-emerald-500 text-white shadow-lg shadow-emerald-200">
                    <i class="fa-solid fa-circle-check text-xl"></i>
                </div>

                <div class="flex flex-col">
                    <span class="text-[10px] font-black uppercase tracking-[0.2em] text-emerald-600/70">Sistem BUBERTA</span>
                    <h3 class="text-sm font-black leading-tight">Berhasil!</h3>
                    <p class="text-xs font-medium opacity-80">{{ session('success') }}</p>
                </div>

                {{-- Progress Bar (Opsional: Indikator waktu habis) --}}
                <div class="absolute bottom-0 left-0 h-1 bg-emerald-500 rounded-full transition-all duration-[3000ms] ease-linear w-full"
                    id="progress-bar"></div>
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $stats = [
                    [
                        'label' => 'Berita Bulan Ini',
                        'val' => $total_berita_bln_ini,
                        'icon' => 'fa-newspaper',
                        'color' => 'bg-blue-500',
                    ],
                    [
                        'label' => 'Unit Kendaraan',
                        'val' => $total_unit_kendaraan,
                        'icon' => 'fa-car',
                        'color' => 'bg-emerald-500',
                    ],
                    [
                        'label' => 'Rental Aktif',
                        'val' => $total_rental_aktif,
                        'icon' => 'fa-key',
                        'color' => 'bg-purple-500',
                    ],
                    ['label' => 'Customer', 'val' => $total_customer, 'icon' => 'fa-users', 'color' => 'bg-orange-500'],
                ];
            @endphp

            @foreach ($stats as $s)
                <div
                    class="relative group bg-white p-6 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-400 font-medium text-sm">{{ $s['label'] }}</p>
                            <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $s['val'] }}</h3>
                        </div>
                        <div
                            class="{{ $s['color'] }} w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-inherit">
                            <i class="fa-solid {{ $s['icon'] }}"></i>
                        </div>
                    </div>
                    {{-- <div class="mt-4 flex items-center text-xs font-bold text-emerald-600">
                        <i class="fa-solid fa-arrow-up mr-1"></i> 12% <span class="text-slate-400 font-normal ml-1">dari
                            bulan lalu</span>
                    </div> --}}
                </div>
            @endforeach
        </div>

        {{-- Grid 4 Kartu Statistik Atas --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            {{-- Kartu 1: Modal Berputar --}}
            <div class="bg-white border border-slate-200 p-6 rounded-[2rem] shadow-sm flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shrink-0">
                    <i class="fa-solid fa-money-bill-trend-up"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider">Modal Berputar (Aktif)</p>
                    <p class="text-lg font-black text-slate-800 mt-0.5">Rp
                        {{ number_format($totalModalBerputar, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Kartu 2: Kas Denda Masuk --}}
            <div class="bg-white border border-slate-200 p-6 rounded-[2rem] shadow-sm flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg shrink-0">
                    <i class="fa-solid fa-vault"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider">Kas Denda Terkumpul</p>
                    <p class="text-lg font-black text-indigo-600 mt-0.5">Rp
                        {{ number_format($totalDendaMasuk, 0, ',', '.') }}</p>
                </div>
            </div>

            {{-- Kartu 3: Kelompok Menunggak --}}
            <div class="bg-white border border-slate-200 p-6 rounded-[2rem] shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-lg shrink-0">
                    <i class="fa-solid fa-users-slash"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider">Kelompok Menunggak</p>
                    <p class="text-lg font-black text-red-600 mt-0.5">{{ $jumlahKelompokMenunggak }} Kelompok</p>
                </div>
            </div>

            {{-- Kartu 4: Denda Berjalan Luar --}}
            <div class="bg-white border border-slate-200 p-6 rounded-[2rem] shadow-sm flex items-center gap-4">
                <div
                    class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg shrink-0">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </div>
                <div>
                    <p class="text-[10px] uppercase font-black text-slate-400 tracking-wider">Denda Belum Tertagih</p>
                    <p class="text-lg font-black text-slate-800 mt-0.5">Rp
                        {{ number_format($totalDendaBerjalan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        {{-- Dua Kolom Utama Bawah --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Sisi Kiri (Lebar 2/3): Aktivitas & Peninjauan Pinjaman Terbaru --}}
            <div class="lg:col-span-2 space-y-4">
                <h3 class="text-sm font-black text-slate-800 tracking-tight flex items-center gap-1.5">
                    <i class="fa-solid fa-clock-rotate-left text-slate-400"></i> Aktivitas Pinjaman Terbaru
                </h3>
                <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="table w-full border-none">
                            <thead>
                                <tr
                                    class="bg-slate-50/70 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                                    <th class="p-4">Nama Kelompok</th>
                                    <th class="p-4">Plafon</th>
                                    <th class="p-4">Status Verifikasi</th>
                                    <th class="p-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-slate-700 text-xs font-semibold">
                                @forelse($recentLoans as $loan)
                                    <tr class="hover:bg-slate-50/30 transition-colors">
                                        <td class="p-4">
                                            <div class="font-bold text-slate-800">{{ $loan->group->nama_kelompok }}</div>
                                            <div class="text-[10px] text-slate-400 font-medium">Ketua:
                                                {{ $loan->group->nama_ketua }}</div>
                                        </td>
                                        <td class="p-4">Rp
                                            {{ number_format($loan->plafon_disetujui ?? $loan->plafon_diajukan, 0, ',', '.') }}
                                        </td>
                                        <td class="p-4">
                                            @if ($loan->status_loan == 'review')
                                                <span
                                                    class="badge bg-amber-50 text-amber-700 border-amber-100 font-bold text-[10px] rounded-lg py-1.5">Ditinjau</span>
                                            @elseif($loan->status_loan == 'berjalan' || $loan->status_loan == 'disetujui')
                                                <span
                                                    class="badge bg-indigo-50 text-indigo-700 border-indigo-100 font-bold text-[10px] rounded-lg py-1.5">Aktif</span>
                                            @elseif($loan->status_loan == 'lunas')
                                                <span
                                                    class="badge bg-slate-900 text-white border-none font-bold text-[10px] rounded-lg py-1.5">Lunas</span>
                                            @else
                                                <span
                                                    class="badge bg-slate-100 text-slate-500 border-none font-bold text-[10px] rounded-lg py-1.5">{{ $loan->status_loan }}</span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-center">
                                            <a href="{{ url('/spp-loan/' . $loan->id) }}"
                                                class="btn btn-xs bg-slate-900 hover:bg-slate-800 text-white border-none rounded-lg px-2.5 py-1 font-bold normal-case">
                                                Buka Berkas
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-slate-400 font-medium">Belum ada
                                            riwayat pengajuan modal.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Sisi Kanan (Lebar 1/3): Panel Perhatian Utama (Kelompok yang Menunggak) --}}
            <div class="space-y-4">
                <h3 class="text-sm font-black text-slate-800 tracking-tight flex items-center gap-1.5">
                    <i class="fa-solid fa-bell-trigger text-red-500 animate-bounce"></i> Perhatian Utama (Menunggak)
                </h3>
                <div
                    class="bg-white rounded-[2rem] border border-slate-200 p-5 shadow-sm space-y-3 max-h-[350px] overflow-y-auto">
                    @forelse($lateInstallments as $ins)
                        @php
                            $hariTelat = \Carbon\Carbon::parse($ins->tanggal_jatuh_tempo)->diffInDays(
                                \Carbon\Carbon::now(),
                            );
                            $estimasiDenda = $hariTelat * 5000;
                        @endphp
                        <div
                            class="bg-red-50/50 border border-red-100/70 p-4 rounded-2xl flex items-start justify-between gap-2">
                            <div>
                                <h4 class="font-black text-slate-800 text-xs">Kelompok
                                    {{ $ins->loan->group->nama_kelompok }}</h4>
                                <p class="text-[10px] text-slate-400 mt-0.5">Angsuran Ke-{{ $ins->angsuran_ke }} • Jt
                                    Tempo: {{ \Carbon\Carbon::parse($ins->tanggal_jatuh_tempo)->format('d/m/Y') }}</p>
                                <div
                                    class="text-[9px] font-black text-red-600 mt-1 inline-block bg-red-100 px-1.5 py-0.5 rounded">
                                    Telat {{ $hariTelat }} Hari (+Rp {{ number_format($estimasiDenda, 0, ',', '.') }})
                                </div>
                            </div>
                            <a href="{{ url('/admin/loan-verification/' . $ins->loan_id . '/installments') }}"
                                class="btn btn-xs bg-white hover:bg-red-100 border border-red-200 text-red-700 rounded-lg p-1 text-[10px] font-bold shadow-sm">
                                <i class="fa-solid fa-chevron-right"></i>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-12 text-slate-400 text-xs font-medium">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-2xl block mb-2"></i>
                            Luar biasa! Seluruh kelompok telah membayar angsuran tepat waktu bulan ini.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('success-alert');
            const progressBar = document.getElementById('progress-bar');

            if (alert) {
                // Animasi progress bar mengecil (opsional)
                setTimeout(() => {
                    progressBar.style.width = '0%';
                }, 10);

                // Menghilangkan alert setelah 3 detik
                setTimeout(() => {
                    // Tambahkan animasi keluar
                    alert.style.transition = "all 0.5s ease";
                    alert.style.opacity = "0";
                    alert.style.transform = "translateX(100px)";

                    // Hapus dari DOM setelah animasi selesai
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 3000);
            }
        });
    </script>
@endsection
