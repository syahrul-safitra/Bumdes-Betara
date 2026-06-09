@extends('Customer.Layouts.main')

@section('content')
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

                {{-- <div class="flex gap-2 overflow-x-auto pb-2">
                    <button class="btn btn-sm btn-primary rounded-full">Semua</button>
                    <button class="btn btn-sm btn-ghost rounded-full border border-base-300">Kegiatan</button>
                    <button class="btn btn-sm btn-ghost rounded-full border border-base-300">Peresmian</button>
                    <button class="btn btn-sm btn-ghost rounded-full border border-base-300">Rapat Desa</button>
                </div> --}}
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 md:px-10 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            {{-- @php
                $berita = [
                    [
                        'judul' => 'Peresmian Unit Usaha Buberta Rent Tahun 2023',
                        'tgl' => '15 Nov 2023',
                        'kategori' => 'Unit Usaha',
                        'img' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=800',
                        'excerpt' =>
                            'BUMDes Bersama Betara resmi meluncurkan layanan rental kendaraan untuk memudahkan mobilitas warga desa...',
                    ],
                    [
                        'judul' => 'Rapat Kerja Tahunan: Transformasi UPK ke BUMDes',
                        'tgl' => '10 Jan 2024',
                        'kategori' => 'Musyawarah',
                        'img' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=800',
                        'excerpt' =>
                            'Pembahasan mengenai penguatan regulasi sesuai UU Desa No 6 Tahun 2014 dan peningkatan PAD desa.',
                    ],
                    [
                        'judul' => 'Pelatihan Tata Boga untuk Unit Usaha Toko Guberta',
                        'tgl' => '05 Feb 2024',
                        'kategori' => 'Pelatihan',
                        'img' => 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?q=80&w=800',
                        'excerpt' =>
                            'Meningkatkan skill SDM lokal dalam mengelola unit usaha Tata Boga dan penyediaan konsumsi rapat.',
                    ],
                    [
                        'judul' => 'Penyaluran Modal Simpan Pinjam Kelompok Perempuan',
                        'tgl' => '20 Mar 2024',
                        'kategori' => 'Sosial',
                        'img' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb773b09?q=80&w=800',
                        'excerpt' =>
                            'Unit LED BUBERTA kembali menyalurkan bantuan modal usaha untuk kelompok perempuan di wilayah Betara.',
                    ],
                    [
                        'judul' => 'Kunjungan Studi Banding dari BUMDes Luar Daerah',
                        'tgl' => '12 Apr 2024',
                        'kategori' => 'Kunjungan',
                        'img' => 'https://images.unsplash.com/photo-1521737604893-d14cc237f11d?q=80&w=800',
                        'excerpt' =>
                            'Sharing session mengenai keberhasilan pengelolaan aset eks-PNPM menjadi unit usaha mandiri.',
                    ],
                    [
                        'judul' => 'Pemeliharaan Rutin Unit Armada Rental Kendaraan',
                        'tgl' => '01 Mei 2024',
                        'kategori' => 'Layanan',
                        'img' => 'https://images.unsplash.com/photo-1487754169491-0f4ff6451ef5?q=80&w=800',
                        'excerpt' =>
                            'Memastikan semua kendaraan dalam kondisi prima demi kenyamanan pelanggan BUBERTA RENT.',
                    ],
                ];
            @endphp --}}

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

    {{-- <section class="container mx-auto px-4 md:px-10 mb-20">
        <div class="bg-emerald-900 rounded-[3rem] p-8 md:p-16 text-center text-white relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-3xl font-bold mb-4">Jangan Lewatkan Info Desa Betara!</h2>
                <p class="text-emerald-200 mb-8 max-w-md mx-auto text-sm">Dapatkan update langsung kegiatan BUMDes dan promo
                    rental kendaraan melalui WhatsApp Anda.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center max-w-lg mx-auto">
                    <input type="text" placeholder="Masukkan nomor WhatsApp"
                        class="input input-bordered w-full text-slate-800 rounded-full" />
                    <button class="btn btn-emerald-500 border-none text-white px-10 rounded-full">Gabung Grup</button>
                </div>
            </div>
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-emerald-800 rounded-full blur-3xl opacity-50"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-emerald-700 rounded-full blur-3xl opacity-50"></div>
        </div>
    </section> --}}
@endsection
