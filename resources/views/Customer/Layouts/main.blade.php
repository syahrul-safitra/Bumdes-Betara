<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Layanan BUMDes</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>

    <style>
        /* Mengubah warna default pagination Laravel agar jadi Hijau Emerald */
        .pagination-custom nav svg {
            width: 20px;
        }

        .pagination-custom nav span[aria-current="page"] span {
            @apply bg-emerald-600 border-emerald-600 text-white rounded-xl;
        }

        .pagination-custom nav a {
            @apply rounded-xl hover:bg-emerald-50 transition-all;
        }
    </style>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

</head>

<body class="bg-base-200 min-h-screen">

    @include('Customer.Partials.navbar')

    <div class="fixed left-0 top-[64px] z-50 h-1 w-full bg-emerald-100">
        <div class="h-full w-1/2 bg-emerald-600"></div>
    </div>

    @yield('content')

    <footer class="bg-slate-900 pb-8 pt-16 text-slate-300">
        <div class="container mx-auto px-4 md:px-10">
            <div class="mb-12 grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-4">

                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        {{-- <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-xl font-bold text-white">
                            BB
                        </div> --}}
                        <span class="text-2xl font-bold tracking-tight text-white">BUMDES <span
                                class="text-emerald-500">Bersama Betara</span></span>
                    </div>
                    <p class="text-sm leading-relaxed">
                        Motor penggerak ekonomi Desa Bersama Betara melalui inovasi layanan digital dan pengelolaan
                        potensi
                        lokal yang berkelanjutan.
                    </p>
                    <div class="flex gap-4">
                        {{-- TOMBOL INSTAGRAM --}}
                        <a href="https://www.instagram.com/bumdes_betara/" target="_blank"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 text-slate-300 transition-all hover:bg-emerald-600 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.058-1.69-.072-4.949-.072zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                            </svg>
                        </a>

                        {{-- TAMBAHAN BARU: TOMBOL FACEBOOK --}}
                        <a href="https://www.facebook.com/p/Bumdes-Bersama-Betara-B3-100057311385318/" target="_blank"
                            class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-800 text-slate-300 transition-all hover:bg-emerald-600 hover:text-white"
                            title="Bagikan ke Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path d="M9 8H7v3h2v9h3v-9h3l.5-3H12V6c0-.88.39-1 1-1h2V2h-3c-2.9 0-4 1.55-4 3.5V8z" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="mb-6 text-lg font-bold text-white">Navigasi</h4>
                    <ul class="space-y-4 text-sm">
                        <li><a href="{{ url('/') }}" class="transition-colors hover:text-emerald-500">Beranda</a>
                        </li>
                        <li><a href="{{ url('/profil') }}" class="transition-colors hover:text-emerald-500">Profil
                                Desa</a></li>
                        <li><a href="{{ url('/dokumentasi-desa') }}"
                                class="transition-colors hover:text-emerald-500">Dokumentasi</a>
                        </li>
                        <li><a href="{{ url('/rental-kendaraan') }}"
                                class="font-bold transition-colors hover:text-emerald-500">Rental
                                Kendaraan</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="mb-6 text-lg font-bold text-white">Unit Usaha</h4>
                    <ul class="space-y-4 text-sm">
                        {{-- <li><a href="#" class="transition-colors hover:text-emerald-500">BUBERTA FINANCE</a>
                        </li> --}}
                        <li><a href="{{ url('/rental-kendaraan') }}"
                                class="font-bold text-emerald-400 transition-colors ">BUBERTA
                                RENT</a></li>

                        <li><a href="#" class="transition-colors hover:text-emerald-500">LED BUBERTA</a>
                        </li>
                        {{-- <li><a href="#" class="transition-colors hover:text-emerald-500">TOKO GUBERTA</a>
                        </li>
                        <li><a href="#" class="transition-colors hover:text-emerald-500">GADA MASETARA
                                BERKAH</a>
                        </li>
                        <li><a href="#" class="transition-colors hover:text-emerald-500">SERVICE
                                ELEKTRONIK</a>
                        </li>
                        <li><a href="#" class="transition-colors hover:text-emerald-500">UNIT AYAM PETELUR</a>
                        </li> --}}

                    </ul>
                </div>

                <div>
                    <h4 class="mb-6 text-lg font-bold text-white">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm text-slate-300 mb-6">
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 shrink-0 mt-0.5"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                            <span>29FH+Q2P, Jl. Lintas Kuala Tungkal-Jambi, Mekar Jaya, Kec. Betara, Kabupaten Tanjung
                                Jabung Barat, Jambi 36514.</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 shrink-0"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>0823 0651 1239</span>
                        </li>
                    </ul>

                    {{-- TOMBOL NAVIGASI HALAMAN DI DALAM DIV (EMERALD) --}}
                    <button onclick="navigasiHalamanSelanjutnya()"
                        class="group flex w-full h-12 items-center justify-between rounded-2xl bg-emerald-600 px-5 font-black uppercase italic tracking-tighter text-white shadow-lg shadow-emerald-900/20 transition-all hover:bg-emerald-700 active:scale-[0.98]">
                        <span class="text-xs">Halaman Selanjutnya</span>
                        <i
                            class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1 text-emerald-300"></i>
                    </button>
                </div>

                {{-- Skrip logika navigasi membaca URL aktif --}}
                <script>
                    function navigasiHalamanSelanjutnya() {
                        const currentPath = window.location.pathname;

                        const alurHalaman = [
                            '/',
                            '/profil',
                            // '/dokumentasi-desa'
                        ];

                        let currentIndex = alurHalaman.indexOf(currentPath);

                        if (currentIndex === -1 && currentPath.endsWith('/')) {
                            currentIndex = alurHalaman.indexOf(currentPath.slice(0, -1));
                        }

                        let nextIndex = currentIndex + 1;

                        if (nextIndex >= alurHalaman.length) {
                            nextIndex = 0; // Berputar kembali ke Beranda jika sudah di ujung halaman berita
                        }

                        window.location.href = alurHalaman[nextIndex];
                    }
                </script>
            </div>

            <hr class="mb-8 border-slate-800" />

            <div class="flex flex-col items-center justify-between gap-4 text-xs md:flex-row">
                <p>&copy; 2026 <span class="font-bold">BUMDES Bersama Betara</span>. Seluruh Hak Cipta
                    Dilindungi.</p>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-emerald-500">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-emerald-500">Kebijakan Privasi</a>
                    {{-- <a href="#" class="text-slate-500 italic">Desain oleh Zen Code (ZC)</a> --}}
                </div>
            </div>
        </div>
    </footer>
</body>

</html>
