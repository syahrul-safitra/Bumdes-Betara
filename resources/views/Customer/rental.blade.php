@extends('Customer.Layouts.main')

@section('content')
    <section class="relative overflow-hidden bg-slate-900 py-20">
        <div class="container relative z-10 mx-auto px-4 md:px-10">
            <div class="flex flex-col items-center justify-between gap-8 md:flex-row">
                <div class="max-w-xl text-white">
                    <div class="mb-4 inline-block rounded-full bg-emerald-600 px-4 py-1 text-xs font-bold uppercase">Unit
                        Usaha BUBERTA RENT</div>
                    <h1 class="mb-4 text-5xl font-black">Sewa Kendaraan <br><span class="text-emerald-500">Mudah &
                            Terjangkau</span></h1>
                    <p class="text-lg text-slate-400">Melayani kebutuhan transportasi warga Desa Betara Ikd untuk urusan
                        keluarga, bisnis, maupun wisata dengan armada yang terawat.</p>
                </div>
                <div class="absolute -right-20 top-0 hidden h-80 w-80 rounded-full bg-emerald-600/20 blur-3xl lg:block">
                </div>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 py-12 md:px-10">

        <main class="w-full">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($vehicles as $unit)
                    <div
                        class="group overflow-hidden rounded-[2.5rem] border border-slate-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ asset('File/' . $unit->gambar) }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                alt="{{ $unit['nama'] }}">
                            {{-- <div class="absolute left-4 top-4">
                                <span
                                    class="badge {{ $unit["status"] == "Ready" ? "bg-emerald-500" : "bg-slate-400" }} border-none p-3 font-bold text-white shadow-lg">
                                    {{ $unit["status"] }}
                                </span>
                            </div> --}}
                        </div>
                        <div class="p-6">
                            <div class="mb-2 flex items-start justify-between gap-4">
                                {{-- Merek / Tipe Mobil --}}
                                <h3 class="text-lg font-extrabold leading-tight text-slate-800">{{ $unit->merek }}</h3>

                                {{-- Rincian Tarif (Hari & Bulan) --}}
                                <div class="text-right shrink-0">
                                    {{-- Info Harga Harian --}}
                                    <div class="text-lg font-black text-emerald-600 leading-none">
                                        Rp {{ number_format($unit->harga_perhari, 0, ',', '.') }}
                                    </div>
                                    <div
                                        class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mt-0.5 mb-2 block">
                                        / Hari
                                    </div>

                                    {{-- Info Harga Bulanan --}}
                                    <div
                                        class="text-sm font-extrabold text-indigo-600 leading-none border-t border-slate-100 pt-1.5">
                                        Rp {{ number_format($unit->harga_perbulan, 0, ',', '.') }}
                                    </div>
                                    <div class="text-[9px] font-bold uppercase tracking-widest text-slate-400 mt-0.5 block">
                                        / Bulan
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="my-4 flex gap-3">
                                <div
                                    class="flex items-center gap-1.5 rounded-xl bg-slate-50 px-3 py-1.5 text-xs font-bold text-slate-500">
                                    <i class="fas fa-cog text-emerald-500"></i> {{ $unit["trans"] }}
                                </div>
                                <div
                                    class="flex items-center gap-1.5 rounded-xl bg-slate-50 px-3 py-1.5 text-xs font-bold text-slate-500">
                                    <i class="fas fa-user-friends text-emerald-500"></i> {{ $unit["seat"] }}
                                </div>
                            </div> --}}

                            <hr class="my-4 border-slate-100">

                            <div class="flex gap-3 mt-4">
                                {{-- Tombol Sewa Harian --}}
                                <a href="{{ url('/create-rental/' . $unit->id) }}"
                                    class="btn flex-1 rounded-2xl border-none bg-emerald-600 font-bold text-white shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-all text-xs">
                                    <i class="fa-solid fa-calendar-day mr-1"></i> Harian
                                </a>

                                {{-- Tombol Sewa Bulanan --}}
                                <a href="{{ url('/create-rental-bulanan/' . $unit->id) }}"
                                    class="btn flex-1 rounded-2xl border-none bg-indigo-600 font-bold text-white shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all text-xs">
                                    <i class="fa-solid fa-calendar-days mr-1"></i> Bulanan
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </main>
    </div>

    <section class="mt-12 bg-slate-50 py-16">
        <div class="container mx-auto px-4 md:px-10">
            <h2 class="mb-8 text-center text-2xl font-bold text-slate-800">Ketentuan Penyewaan</h2>
            <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                <div class="flex gap-4">
                    <div class="text-3xl font-bold text-emerald-600">01</div>
                    <p class="text-sm text-slate-600">Menyerahkan kartu identitas (KTP) asli yang masih berlaku sebagai
                        jaminan selama masa sewa.</p>
                </div>
                <div class="flex gap-4">
                    <div class="text-3xl font-bold text-emerald-600">02</div>
                    <p class="text-sm text-slate-600">Memiliki SIM sesuai dengan jenis kendaraan yang disewa (SIM A untuk
                        Mobil, SIM C untuk Motor).</p>
                </div>
                <div class="flex gap-4">
                    <div class="text-3xl font-bold text-emerald-600">03</div>
                    <p class="text-sm text-slate-600">Kerusakan yang disebabkan kelalaian penyewa sepenuhnya menjadi
                        tanggung jawab penyewa sesuai kesepakatan.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
