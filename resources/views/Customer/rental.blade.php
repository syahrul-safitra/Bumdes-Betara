@extends("Customer.Layouts.main")

@section("content")
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

                @php
                    $units = [
                        [
                            "nama" => "Toyota Avanza 2022",
                            "harga" => "350.000",
                            "type" => "Mobil",
                            "trans" => "Manual",
                            "seat" => "7 Kursi",
                            "img" => "https://images.unsplash.com/photo-1590362891991-f776e747a588?q=80&w=600",
                            "status" => "Ready"
                        ],
                        [
                            "nama" => "Daihatsu Xenia",
                            "harga" => "300.000",
                            "type" => "Mobil",
                            "trans" => "Manual",
                            "seat" => "7 Kursi",
                            "img" => "https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?q=80&w=600",
                            "status" => "Ready"
                        ],
                        [
                            "nama" => "Honda Vario 160",
                            "harga" => "80.000",
                            "type" => "Motor",
                            "trans" => "Matic",
                            "seat" => "2 Kursi",
                            "img" => "https://images.unsplash.com/photo-1599819811279-d5ad9cccf838?q=80&w=600",
                            "status" => "Booked"
                        ],
                        [
                            "nama" => "Yamaha NMAX",
                            "harga" => "120.000",
                            "type" => "Motor",
                            "trans" => "Matic",
                            "seat" => "2 Kursi",
                            "img" => "https://images.unsplash.com/photo-1581232227577-50a80393049b?q=80&w=600",
                            "status" => "Ready"
                        ]
                    ];
                @endphp

                @foreach ($vehicles as $unit)
                    <div
                        class="group overflow-hidden rounded-[2.5rem] border border-slate-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
                        <div class="relative h-56 overflow-hidden">
                            <img src="{{ asset("File/" . $unit->gambar) }}"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                alt="{{ $unit["nama"] }}">
                            {{-- <div class="absolute left-4 top-4">
                                <span
                                    class="badge {{ $unit["status"] == "Ready" ? "bg-emerald-500" : "bg-slate-400" }} border-none p-3 font-bold text-white shadow-lg">
                                    {{ $unit["status"] }}
                                </span>
                            </div> --}}
                        </div>
                        <div class="p-6">
                            <div class="mb-2 flex items-start justify-between gap-2">
                                <h3 class="text-lg font-extrabold leading-tight text-slate-800">{{ $unit->merek }}</h3>
                                <div class="text-right">
                                    <div class="text-lg font-black text-emerald-600">
                                        Rp {{ number_format($unit->harga_perhari, 0, ",", ".") }}</div>
                                    <div class="text-[10px] font-bold uppercase tracking-widest text-slate-400">/ Hari</div>
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

                            <div class="flex gap-2">
                                <button
                                    class="btn {{ $unit["status"] == "Booked" ? "btn-disabled opacity-50" : "" }} flex-1 rounded-2xl border-none bg-emerald-600 font-bold text-white shadow-lg shadow-emerald-100 hover:bg-emerald-700">
                                    Sewa Sekarang
                                </button>
                                {{-- <button
                                    class="btn btn-square rounded-2xl border-none bg-slate-50 text-slate-400 hover:bg-slate-100">
                                    <i class="fa-solid fa-circle-info text-lg"></i>
                                </button> --}}
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
