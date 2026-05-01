@extends('Customer.Layouts.main')

@section('content')
    <article class="bg-white min-h-screen pb-20">
        <header class="pt-12 pb-8 container mx-auto px-4 md:px-10 max-w-4xl">
            {{-- <nav class="flex gap-2 text-sm text-slate-500 mb-6 items-center">
                <a href="/dokumentasi" class="hover:text-emerald-600">Dokumentasi</a>
                <span>/</span>
                <span class="text-emerald-600 font-medium">Detail Berita</span>
            </nav>

            <div
                class="inline-block px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold uppercase tracking-wider mb-4">
                Unit Usaha
            </div> --}}

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
                    <p class="text-slate-500 text-xs">Dipublikasikan pada tanggal
                        {{ date('d M Y', strtotime($dokumentasi->tanggal)) }}</p>
                </div>
                <div class="ml-auto flex gap-2">
                    <button class="btn btn-circle btn-sm btn-ghost"><i class="fab fa-facebook"></i></button>
                    <button class="btn btn-circle btn-sm btn-ghost"><i class="fab fa-whatsapp"></i></button>
                </div>
            </div>
        </header>

        <div class="container mx-auto px-4 md:px-10 max-w-5xl mb-12">
            <figure>
                <img src="{{ asset('File/' . $dokumentasi->gambar) }}"
                    class="w-full rounded-[2rem] shadow-2xl object-cover h-[400px] md:h-[550px]"
                    alt="Peresmian BUBERTA RENT">
                {{-- <figcaption class="text-center text-slate-400 text-sm mt-4 italic">
                    Foto: Suasana pemotongan pita peresmian armada baru BUBERTA RENT di kantor BUMDes.
                </figcaption> --}}
            </figure>
        </div>

        <div class="container mx-auto px-4 md:px-10 max-w-3xl">
            <div class="prose prose-lg prose-slate max-w-none leading-relaxed text-slate-700">
                {!! $dokumentasi->kontent !!}
            </div>

            {{-- Tombol Kembali --}}
            <div class="mt-12 pt-8 border-t border-slate-100">
                <a href="{{ url('/dokumentasi-desa') }}"
                    class="inline-flex items-center gap-2 text-slate-500 hover:text-emerald-600 font-semibold transition-colors group">
                    <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                    Kembali ke Halaman Sebelumnya
                </a>
            </div>
        </div>
    </article>
@endsection
