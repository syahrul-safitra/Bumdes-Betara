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


    <section class="bg-slate-50 py-12 border-b border-base-200">
        <div class="container mx-auto px-4 md:px-10">
            <div class="flex flex-col md:flex-row justify-between items-end gap-6">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 text-emerald-600 font-bold mb-2">
                        <span class="w-8 h-[2px] bg-emerald-600"></span>
                        Kabar Betara Ikd
                    </div>
                    <h1 class="text-4xl font-black text-slate-800"><span class="text-emerald-600">Berita
                            Kegiatan</span></h1>
                    <p class="text-slate-500 mt-3 text-lg">Ikuti perkembangan terbaru, peresmian unit usaha, dan laporan
                        kegiatan BUMDES Bersama Betara secara transparan.</p>
                </div>

            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 md:px-10 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">


            @foreach ($dokumentasis as $post)
                <article
                    class="group bg-white rounded-3xl overflow-hidden border border-base-200 shadow-sm hover:shadow-xl transition-all duration-300">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ asset('File/' . $post->gambar) }}"
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            alt="{{ $post->judul }}">
                        {{-- <div class="absolute top-4 left-4">
                            <span
                                class="badge bg-emerald-600 border-none text-white font-bold p-3">{{ $post['kategori'] }}</span>
                        </div> --}}
                    </div>

                    <div class="p-6">
                        <div class="flex items-center gap-2 text-slate-400 text-xs font-semibold mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ date('d-m-Y', strtotime($post->tanggal)) }}
                        </div>
                        <h3
                            class="text-xl font-bold text-slate-800 group-hover:text-emerald-600 transition-colors line-clamp-2 mb-3">
                            {{ $post->judul }}
                        </h3>
                        <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 mb-6">
                            {!! Str::limit(strip_tags($post->kontent), 200, '...') !!}
                        </p>

                        <a href="{{ url('/dokumentasi-desa/' . $post->id) }}"
                            class="inline-flex items-center gap-2 text-emerald-600 font-bold text-sm hover:gap-3 transition-all">
                            Baca Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-16 flex flex-col items-center gap-5">
            {{-- Info Data --}}
            <p class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">
                Halaman {{ $dokumentasis->currentPage() }} dari {{ $dokumentasis->lastPage() }}
            </p>

            {{-- Tombol Navigasi --}}
            <div class="join bg-white shadow-sm border border-slate-200 p-1 rounded-2xl">
                {{-- Tombol Previous --}}
                @if ($dokumentasis->onFirstPage())
                    <button class="join-item btn btn-ghost btn-disabled btn-md text-slate-300">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                @else
                    <a href="{{ $dokumentasis->previousPageUrl() }}"
                        class="join-item btn btn-ghost btn-md hover:bg-emerald-50 hover:text-emerald-600 transition-all">
                        <i class="fa-solid fa-chevron-left"></i>
                    </a>
                @endif

                {{-- Nomor Halaman (Hanya tampil di desktop untuk menjaga kerapian) --}}
                <div class="hidden md:flex">
                    @foreach ($dokumentasis->getUrlRange(max(1, $dokumentasis->currentPage() - 1), min($dokumentasis->lastPage(), $dokumentasis->currentPage() + 1)) as $page => $url)
                        <a href="{{ $url }}"
                            class="join-item btn btn-md {{ $page == $dokumentasis->currentPage() ? 'bg-emerald-600 text-white hover:bg-emerald-700 border-none' : 'btn-ghost hover:bg-emerald-50' }}">
                            {{ $page }}
                        </a>
                    @endforeach
                </div>

                {{-- Indikator Mobile --}}
                <button class="join-item btn btn-md btn-ghost md:hidden no-animation cursor-default">
                    {{ $dokumentasis->currentPage() }}
                </button>

                {{-- Tombol Next --}}
                @if ($dokumentasis->hasMorePages())
                    <a href="{{ $dokumentasis->nextPageUrl() }}"
                        class="join-item btn btn-ghost btn-md hover:bg-emerald-50 hover:text-emerald-600 transition-all">
                        <i class="fa-solid fa-chevron-right"></i>
                    </a>
                @else
                    <button class="join-item btn btn-ghost btn-disabled btn-md text-slate-300">
                        <i class="fa-solid fa-chevron-right"></i>
                    </button>
                @endif
            </div>
        </div>

        {{-- <div class="flex justify-center mt-16">
            <div class="join shadow-sm">
                <button class="join-item btn bg-white border-base-200">«</button>
                <button class="join-item btn bg-emerald-600 text-white border-emerald-600 hover:bg-emerald-700">1</button>
                <button class="join-item btn bg-white border-base-200">2</button>
                <button class="join-item btn bg-white border-base-200">3</button>
                <button class="join-item btn bg-white border-base-200">»</button>
            </div>
        </div> --}}
    </div>

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
