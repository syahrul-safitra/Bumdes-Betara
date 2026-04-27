@extends('Customer.Layouts.main')

@section('content')
    <article class="bg-white min-h-screen pb-20">
        <header class="pt-12 pb-8 container mx-auto px-4 md:px-10 max-w-4xl">
            <nav class="flex gap-2 text-sm text-slate-500 mb-6 items-center">
                <a href="/dokumentasi" class="hover:text-emerald-600">Dokumentasi</a>
                <span>/</span>
                <span class="text-emerald-600 font-medium">Detail Berita</span>
            </nav>

            <div
                class="inline-block px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold uppercase tracking-wider mb-4">
                Unit Usaha
            </div>

            <h1 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight mb-6">
                Peresmian Unit Usaha BUBERTA RENT: Solusi Mobilitas Warga Betara Ikd
            </h1>

            <div class="flex items-center gap-4 border-y border-slate-100 py-4">
                <div class="avatar">
                    <div class="w-12 rounded-full ring ring-emerald-500 ring-offset-base-100 ring-offset-2">
                        <img src="https://ui-avatars.com/api/?name=Admin+BUMDes&background=10b981&color=fff" />
                    </div>
                </div>
                <div>
                    <p class="text-slate-900 font-bold text-sm">Admin BUMDes</p>
                    <p class="text-slate-500 text-xs">Dipublikasikan pada 15 November 2023 • 5 Menit Baca</p>
                </div>
                <div class="ml-auto flex gap-2">
                    <button class="btn btn-circle btn-sm btn-ghost"><i class="fab fa-facebook"></i></button>
                    <button class="btn btn-circle btn-sm btn-ghost"><i class="fab fa-whatsapp"></i></button>
                </div>
            </div>
        </header>

        <div class="container mx-auto px-4 md:px-10 max-w-5xl mb-12">
            <figure>
                <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=1200"
                    class="w-full rounded-[2rem] shadow-2xl object-cover h-[400px] md:h-[550px]"
                    alt="Peresmian BUBERTA RENT">
                <figcaption class="text-center text-slate-400 text-sm mt-4 italic">
                    Foto: Suasana pemotongan pita peresmian armada baru BUBERTA RENT di kantor BUMDes.
                </figcaption>
            </figure>
        </div>

        <div class="container mx-auto px-4 md:px-10 max-w-3xl">
            <div class="prose prose-lg prose-slate max-w-none leading-relaxed text-slate-700">
                <p class="text-xl font-medium text-slate-800 leading-normal mb-6">
                    <strong>BETARA IKD</strong> – BUM Desa Bersama Betara secara resmi meluncurkan unit usaha terbarunya,
                    <strong>BUBERTA RENT</strong>, sebuah layanan penyewaan kendaraan bermotor yang ditujukan untuk
                    mendukung produktivitas dan mobilitas masyarakat desa.
                </p>

                <p>
                    Peresmian yang dilakukan pada Rabu (15/11) ini dihadiri oleh jajaran perangkat desa, tokoh masyarakat,
                    serta pengelola BUMDes. Langkah ini diambil sebagai transformasi nyata dari penguatan modal yang
                    sebelumnya dikelola oleh UPK ex. PNPM Mandiri menjadi unit usaha yang lebih produktif dan menyentuh
                    kebutuhan harian warga.
                </p>

                <blockquote class="border-l-4 border-emerald-500 pl-6 my-8 italic text-xl text-emerald-900 font-serif">
                    "Kami melihat banyak warga yang membutuhkan kendaraan untuk urusan darurat maupun usaha, namun
                    terkendala biaya pengadaan. BUBERTA RENT hadir untuk mengisi celah tersebut dengan harga yang sangat
                    terjangkau."
                    <footer class="text-sm font-bold mt-2 text-slate-600">— Ketua BUMDes Bersama Betara</footer>
                </blockquote>

                <h3 class="text-2xl font-bold text-slate-800 mt-10 mb-4 text-emerald-700">Dampak Ekonomi Bagi Desa</h3>
                <p>
                    Unit usaha ini tidak hanya menyediakan armada, tetapi juga membuka lapangan kerja bagi pemuda desa di
                    bagian teknis dan administrasi. Keuntungan dari hasil penyewaan ini nantinya akan dialokasikan kembali
                    untuk Pendapatan Asli Desa (PAD) dan dana sosial kemasyarakatan.
                </p>

                <div class="grid grid-cols-2 gap-4 my-10">
                    <img src="https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?q=80&w=400" class="rounded-2xl"
                        alt="Armada 1">
                    <img src="https://images.unsplash.com/photo-1487754169491-0f4ff6451ef5?q=80&w=400" class="rounded-2xl"
                        alt="Armada 2">
                </div>

                <p>
                    Saat ini, BUBERTA RENT telah menyediakan 5 unit kendaraan roda empat dan 10 unit roda dua yang siap
                    disewakan. Warga desa Betara Ikd akan mendapatkan tarif khusus dengan menunjukkan identitas domisili
                    yang sah.
                </p>
            </div>

            <div class="mt-12 pt-8 border-t border-slate-100">
                <div class="flex flex-wrap gap-2">
                    <span class="text-sm font-bold text-slate-400 mr-2 uppercase">Tags:</span>
                    <div class="badge badge-outline">BUMDes</div>
                    <div class="badge badge-outline">Ekonomi Desa</div>
                    <div class="badge badge-outline">Betara Ikd</div>
                    <div class="badge badge-outline">Rental</div>
                </div>
            </div>

            <div class="mt-16 flex justify-between gap-4">
                <a href="#" class="flex-1 p-4 rounded-2xl border border-slate-100 hover:bg-slate-50 transition-all">
                    <p class="text-xs text-slate-400 mb-1 uppercase">Berita Sebelumnya</p>
                    <p class="font-bold text-slate-800 line-clamp-1">Rapat Kerja Tahunan BUMDes 2024</p>
                </a>
                <a href="#"
                    class="flex-1 p-4 rounded-2xl border border-slate-100 hover:bg-slate-50 transition-all text-right">
                    <p class="text-xs text-slate-400 mb-1 uppercase">Berita Selanjutnya</p>
                    <p class="font-bold text-slate-800 line-clamp-1">Pelatihan Tata Boga UMKM</p>
                </a>
            </div>
        </div>
    </article>
@endsection
