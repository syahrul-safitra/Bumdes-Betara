@extends('Customer.Layouts.main')

@section('content')
    <section class="bg-emerald-600 py-16">
        <div class="container mx-auto px-4 md:px-10 text-center text-white">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Profil Lembaga</h1>
            <p class="text-emerald-100 max-w-2xl mx-auto">Mengenal lebih dekat BUMDES Bersama Betara IKD, perjalanan
                sejarah, visi, misi, dan komitmen kami untuk masyarakat.</p>
        </div>
    </section>

    <div class="sticky top-[64px] z-30 bg-white border-b border-base-200">
        <div class="container mx-auto px-4">
            <div
                class="flex justify-center overflow-x-auto whitespace-nowrap py-4 gap-6 text-sm font-bold uppercase tracking-wider">
                <a href="#sejarah" class="text-emerald-700 hover:text-emerald-500 transition-colors">Sejarah</a>
                <a href="#visi-misi" class="text-emerald-700 hover:text-emerald-500 transition-colors">Visi & Misi</a>
                <a href="#struktur" class="text-emerald-700 hover:text-emerald-500 transition-colors">Struktur</a>
                <a href="#layanan" class="text-emerald-700 hover:text-emerald-500 transition-colors">Layanan</a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 md:px-10 py-12 space-y-24">

        <section id="sejarah" class="scroll-mt-32">
            <div class="flex flex-col lg:flex-row gap-12 items-center">
                <div class="lg:w-1/2">
                    <div class="badge badge-success mb-4 uppercase font-bold p-3">Sejarah</div>
                    <h2 class="text-3xl font-bold mb-6 text-slate-800 italic">Transformasi Menuju Kemandirian</h2>
                    <div class="text-slate-600 leading-relaxed space-y-4 text-justify">
                        <p>
                            <strong>BUMDES Bersama Betara IKD</strong> berdiri pada tahun 2018 sebagai bentuk respon
                            terhadap peluang ekonomi yang semakin terbuka. Kelahiran lembaga ini merupakan hasil
                            transformasi dari <strong>UPK ex. PNPM Mandiri</strong>.
                        </p>
                        <p>
                            Seiring terbitnya UU Desa No. 6 Tahun 2014 dan PP No. 43 Tahun 2015, melalui Musyawarah Antar
                            Desa disepakati perubahan nama menjadi Badan Usaha Milik Bersama (BUMDES Bersama Betara).
                            Resmi didirikan pada <strong>30 Juli 2018</strong> di Kecamatan Betara berdasarkan Peraturan
                            Bersama Kepala Desa se-Kecamatan Betara.
                        </p>
                        <p>
                            Sejak tahun 2023, kami terus berinovasi dengan melakukan penambahan unit usaha strategis,
                            termasuk kerja sama dengan perusahaan di lingkungan Kelurahan Mekar Jaya untuk memperluas
                            jangkauan jasa kami.
                        </p>
                    </div>
                </div>
                <div class="lg:w-1/2">
                    <div
                        class="bg-emerald-100 rounded-[2rem] p-4 rotate-3 flex justify-center items-center overflow-hidden">
                        <img src="{{ asset('Img/kantor_bumdes.jpg') }}"
                            class="rounded-[1.5rem] shadow-xl -rotate-3 hover:rotate-0 transition-transform duration-500 w-full h-full object-cover"
                            alt="Kantor BUMDes">
                    </div>
                </div>
            </div>
        </section>

        <section id="visi-misi" class="scroll-mt-32 bg-slate-50 -mx-4 md:-mx-10 px-4 md:px-10 py-16 rounded-[3rem]">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800">Visi & Misi</h2>
                <div class="w-20 h-1 bg-emerald-500 mx-auto mt-4 rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="card bg-white p-8 shadow-sm border-l-8 border-emerald-500">
                    <h3 class="text-2xl font-bold mb-6 flex items-center gap-3">
                        <span class="text-4xl text-emerald-200">01</span> Visi
                    </h3>
                    <ul class="space-y-4 text-slate-600">
                        <li class="flex gap-2"><span>✔</span> Menjadi Lembaga usaha yang mandiri, profesional dan mampu
                            mengelola potensi Desa untuk kesejahteraan masyarakat.</li>
                        <li class="flex gap-2"><span>✔</span> Mewujudkan masyarakat yang sejahtera, mandiri, dan berdaya
                            saing melalui pengembangan ekonomi dan pelayanan sosial.</li>
                    </ul>
                </div>
                <div class="card bg-white p-8 shadow-sm border-l-8 border-emerald-500">
                    <h3 class="text-2xl font-bold mb-6 flex items-center gap-3">
                        <span class="text-4xl text-emerald-200">02</span> Misi
                    </h3>
                    <ul class="space-y-4 text-sm text-slate-600">
                        <li><strong>• Pengelolaan Potensi Desa:</strong> Menggali dan memanfaatkan Sumber Daya Alam serta
                            aset untuk kemakmuran masyarakat.</li>
                        <li><strong>• Pengembangan Usaha:</strong> Mendirikan unit usaha inovatif yang berkelanjutan untuk
                            meningkatkan PAD.</li>
                        <li><strong>• Peningkatan Kesejahteraan:</strong> Menciptakan lapangan kerja dan mengembangkan
                            kewirausahaan lokal.</li>
                        <li><strong>• Peningkatan Pendapatan:</strong> Pengelolaan efisien untuk memaksimalkan Pendapatan
                            Asli Desa.</li>
                    </ul>
                </div>
            </div>
        </section>

        <section id="struktur" class="scroll-mt-32 text-center">
            <h2 class="text-3xl font-bold text-slate-800 mb-8">Struktur Organisasi</h2>
            <div class="max-w-4xl mx-auto bg-white p-4 rounded-3xl shadow-xl border border-emerald-100">
                <img src="{{ asset('Img/struktur_susunan.jpeg') }}" class="w-full rounded-2xl"
                    alt="Struktur Organisasi BUMDes">
                <p class="mt-4 text-sm text-slate-400">Periode Kepengurusan 2026</p>
            </div>
        </section>

        <section id="layanan" class="scroll-mt-32">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-slate-800 uppercase tracking-widest">Layanan & Unit Usaha</h2>
                <p class="text-slate-500 mt-2">Solusi ekonomi terpadu untuk masyarakat Betara.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $layanan = [
                        ['title' => 'LED BUBERTA', 'desc' => 'Simpan Pinjam Kelompok Perempuan.'],
                        ['title' => 'BUBERTA RENT', 'desc' => 'Jasa Rental Sewa Kendaraan.'],
                        // ['title' => 'BUBERTA FINANCE', 'desc' => 'Pengkreditan barang dan elektronik.'],
                        // ['title' => 'TOKO GUBERTA', 'desc' => 'Tata Boga & Pengadaian Barang.'],
                        // ['title' => 'GADA MASETARA BERKAH', 'desc' => 'Pelayanan Jasa Godin.'],
                        // ['title' => 'SERVICE ELECTRONIC', 'desc' => 'Jasa perbaikan alat elektronik.'],
                        // ['title' => 'UNIT AYAM PETELUR', 'desc' => 'Produksi telur lokal desa.'],
                    ];
                @endphp

                @foreach ($layanan as $item)
                    <div
                        class="group p-6 bg-white border border-emerald-50 rounded-2xl hover:bg-emerald-600 transition-all duration-300 shadow-sm hover:shadow-emerald-200">
                        <div
                            class="w-12 h-12 bg-emerald-100 group-hover:bg-white/20 rounded-xl mb-4 flex items-center justify-center text-emerald-600 group-hover:text-white transition-colors font-bold text-lg">
                            {{ $loop->iteration }}
                        </div>
                        <h4 class="font-bold text-slate-800 group-hover:text-white mb-2">{{ $item['title'] }}</h4>
                        <p class="text-sm text-slate-500 group-hover:text-emerald-50">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

    </div>
@endsection
