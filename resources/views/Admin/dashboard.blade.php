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
