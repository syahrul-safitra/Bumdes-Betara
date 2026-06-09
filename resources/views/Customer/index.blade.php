@extends('Customer.Layouts.main')

@section('content')
    <div class="hero min-h-[85vh] relative overflow-hidden"
        style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url('{{ asset('Img/bg.png') }}'); 
        background-size: cover; 
        background-position: center; 
        background-attachment: fixed;">

        {{-- <div class="hero-content text-center text-white z-10 p-6">
            <div class="max-w-3xl">
                <h1 class="mb-6 text-6xl md:text-7xl font-extrabold tracking-tight">
                    BUMDES <br /> <span class="text-emerald-400">Bersama Betara</span>
                </h1>
                <p class="mb-10 text-xl md:text-2xl text-slate-100">
                    Mengelola potensi desa untuk kemandirian ekonomi Desa Betara.
                </p>
            </div>
        </div> --}}
    </div>
    <div class="absolute bottom-0 left-0 w-full overflow-hidden z-20 leading-[0]">
        <svg class="relative block w-full h-[60px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path
                d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V120H0V0C49.63,6.81,97.66,22.6,146.31,31.52,210.21,43.21,268.39,60.67,321.39,56.44Z"
                class="fill-base-200"></path>
        </svg>
    </div>

    <section class="py-20 bg-white relative overflow-hidden">
        <div
            class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-emerald-50 rounded-full blur-3xl opacity-50">
        </div>
        <div
            class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-96 h-96 bg-emerald-50 rounded-full blur-3xl opacity-50">
        </div>

        <div class="container mx-auto px-4 md:px-10 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12">

                <div class="lg:w-1/2 grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        {{-- <img src="{{ asset('Img/kantor_desa.jpg') }}"
                            class="rounded-2xl shadow-lg hover:scale-105 transition-transform duration-500" alt="Sawah"> --}}
                        <img src="{{ asset('Img/kantor_bumdes.jpg') }}"
                            class="rounded-2xl shadow-lg hover:scale-105 transition-transform duration-500"
                            alt="Perkebunan">
                    </div>
                    <div class="pt-8">
                        <img src="{{ asset('Img/foto_bupati.jpg') }}"
                            class="rounded-2xl shadow-lg h-full object-cover hover:scale-105 transition-transform duration-500"
                            alt="Aktivitas Desa">
                    </div>
                </div>

                <div class="lg:w-1/2 space-y-6">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-sm font-bold">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        Tentang Betara Ikd
                    </div>

                    <h2 class="text-4xl font-extrabold text-slate-800 leading-tight">
                        Harmoni Alam dan <span class="text-emerald-600">Kemandirian Ekonomi</span> Desa
                    </h2>

                    <div class="space-y-4 text-lg text-slate-600 leading-relaxed text-justify">
                        {{-- <p>
                            Terletak di jantung kesuburan tanah Jambi, **Desa Betara Ikd** merupakan wilayah yang diberkati
                            dengan kekayaan alam melimpah. Dari hamparan hijau perkebunan hingga semangat gotong royong
                            warganya, kami percaya bahwa kemajuan desa dimulai dari pengelolaan potensi lokal yang cerdas
                            dan berkelanjutan.
                        </p> --}}
                        <p>
                            Melalui **BUMDES Bersama Betara**, kami berkomitmen untuk menjadi motor penggerak ekonomi desa.
                            Kami hadir bukan sekadar sebagai badan usaha, melainkan sebagai mitra warga dalam menyediakan
                            layanan transportasi yang andal, pendampingan produk UMKM, hingga keterbukaan informasi publik
                            demi mewujudkan Desa Betara yang modern tanpa meninggalkan akar budaya.
                        </p>
                    </div>

                    {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-500 text-white rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="font-bold text-slate-700">Potensi Perkebunan</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-emerald-500 text-white rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="font-bold text-slate-700">Layanan Digital</span>
                        </div>
                    </div> --}}
                </div>

            </div>
        </div>
    </section>

    <section class="py-16 bg-slate-50">
        <div class="container mx-auto px-4 md:px-10">
            <div class="text-center mb-10">
                <h2 class="text-3xl font-extrabold text-slate-800">Lokasi <span class="text-emerald-600">Desa Betara</span>
                </h2>
                <p class="text-slate-500 mt-2">Kunjungi kantor BUMDES kami atau lihat jangkauan layanan kami di peta bawah
                    ini.</p>
            </div>

            <div class="bg-white p-4 rounded-3xl shadow-xl border border-emerald-100">
                <div class="overflow-hidden rounded-2xl h-[450px]">

                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.240013737293!2d103.37498977485414!3d-0.9755406990150441!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e28a5bb9eaa4035%3A0x89b7a031bb6b9097!2sBUMDES%20BERSAMA%20BETARA%20(B3)!5e0!3m2!1sid!2sid!4v1777810295255!5m2!1sid!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <div class="flex items-start gap-4 p-6 bg-emerald-600 rounded-2xl text-white shadow-lg shadow-emerald-100">
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg">Kantor BUMDES</h4>
                        <p class="text-emerald-50 text-sm">Jalan Lintas Jambi-Kuala Tungkal, Desa Betara, Kec. Betara,
                            Jambi.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-6 bg-white rounded-2xl border border-slate-200 shadow-sm">
                    <div class="bg-emerald-100 text-emerald-600 p-3 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg text-slate-800">Jam Operasional</h4>
                        <p class="text-slate-500 text-sm">Senin - Jumat: 08.00 - 15.00 WIB
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
