@extends('Customer.Layouts.main')

@section('content')
    <section class="bg-slate-900 py-20 relative overflow-hidden">
        <div class="container mx-auto px-4 md:px-10 relative z-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="text-white max-w-xl">
                    <div class="inline-block px-4 py-1 bg-emerald-600 rounded-full text-xs font-bold uppercase mb-4">Unit
                        Usaha BUBERTA RENT</div>
                    <h1 class="text-5xl font-black mb-4">Sewa Kendaraan <br><span class="text-emerald-500">Mudah &
                            Terjangkau</span></h1>
                    <p class="text-slate-400 text-lg">Melayani kebutuhan transportasi warga Desa Betara Ikd untuk urusan
                        keluarga, bisnis, maupun wisata dengan armada yang terawat.</p>
                </div>
                <div class="hidden lg:block w-80 h-80 bg-emerald-600/20 rounded-full blur-3xl absolute -right-20 top-0">
                </div>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 md:px-10 py-12">
        <div class="flex flex-col lg:flex-row gap-10">

            <aside class="lg:w-1/4 space-y-8">
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <h3 class="font-bold text-slate-800 mb-4">Cari Kendaraan</h3>
                    <div class="space-y-4">
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Tipe</span></label>
                            <select class="select select-bordered w-full rounded-xl">
                                <option>Semua Tipe</option>
                                <option>Mobil (Roda 4)</option>
                                <option>Motor (Roda 2)</option>
                            </select>
                        </div>
                        <div class="form-control">
                            <label class="label"><span class="label-text font-semibold">Urutkan</span></label>
                            <select class="select select-bordered w-full rounded-xl">
                                <option>Terbaru</option>
                                <option>Harga Terendah</option>
                                <option>Harga Tertinggi</option>
                            </select>
                        </div>
                        <button class="btn btn-emerald-600 border-none text-white w-full rounded-xl mt-4">Terapkan
                            Filter</button>
                    </div>
                </div>

                <div class="bg-emerald-50 p-6 rounded-3xl border border-emerald-100 text-center">
                    <div
                        class="w-12 h-12 bg-emerald-600 text-white rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <h4 class="font-bold text-slate-800">Butuh Bantuan?</h4>
                    <p class="text-xs text-slate-500 mb-4">Hubungi admin untuk ketersediaan mendadak atau lepas kunci.</p>
                    <a href="https://wa.me/6281234567890" class="text-emerald-600 font-bold hover:underline">+62
                        812-3456-7890</a>
                </div>
            </aside>

            <main class="lg:w-3/4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    @php
                        $units = [
                            [
                                'nama' => 'Toyota Avanza 2022',
                                'harga' => '350.000',
                                'type' => 'Mobil',
                                'trans' => 'Manual',
                                'seat' => '7 Kursi',
                                'img' => 'https://images.unsplash.com/photo-1590362891991-f776e747a588?q=80&w=600',
                                'status' => 'Ready',
                            ],
                            [
                                'nama' => 'Daihatsu Xenia',
                                'harga' => '300.000',
                                'type' => 'Mobil',
                                'trans' => 'Manual',
                                'seat' => '7 Kursi',
                                'img' => 'https://images.unsplash.com/photo-1541899481282-d53bffe3c35d?q=80&w=600',
                                'status' => 'Ready',
                            ],
                            [
                                'nama' => 'Honda Vario 160',
                                'harga' => '80.000',
                                'type' => 'Motor',
                                'trans' => 'Matic',
                                'seat' => '2 Kursi',
                                'img' => 'https://images.unsplash.com/photo-1599819811279-d5ad9cccf838?q=80&w=600',
                                'status' => 'Booked',
                            ],
                            [
                                'nama' => 'Yamaha NMAX',
                                'harga' => '120.000',
                                'type' => 'Motor',
                                'trans' => 'Matic',
                                'seat' => '2 Kursi',
                                'img' => 'https://images.unsplash.com/photo-1581232227577-50a80393049b?q=80&w=600',
                                'status' => 'Ready',
                            ],
                        ];
                    @endphp

                    @foreach ($units as $unit)
                        <div
                            class="bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group">
                            <div class="relative h-52 overflow-hidden">
                                <img src="{{ $unit['img'] }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    alt="{{ $unit['nama'] }}">
                                <div class="absolute top-4 left-4">
                                    <span
                                        class="badge {{ $unit['status'] == 'Ready' ? 'bg-emerald-500' : 'bg-slate-400' }} border-none text-white font-bold p-3">{{ $unit['status'] }}</span>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-xl font-bold text-slate-800">{{ $unit['nama'] }}</h3>
                                    <div class="text-emerald-600 font-black text-lg">Rp{{ $unit['harga'] }} <span
                                            class="text-[10px] text-slate-400 font-normal">/Hari</span></div>
                                </div>

                                <div class="flex gap-4 my-4">
                                    <div
                                        class="flex items-center gap-1 text-xs text-slate-500 bg-slate-50 px-2 py-1 rounded-md">
                                        <i class="fas fa-cog"></i> {{ $unit['trans'] }}
                                    </div>
                                    <div
                                        class="flex items-center gap-1 text-xs text-slate-500 bg-slate-50 px-2 py-1 rounded-md">
                                        <i class="fas fa-user-friends"></i> {{ $unit['seat'] }}
                                    </div>
                                </div>

                                <hr class="border-slate-100 my-4">

                                <div class="flex gap-2">
                                    <button
                                        class="btn btn-emerald-600 border-none text-white flex-1 rounded-xl shadow-lg shadow-emerald-100 {{ $unit['status'] == 'Booked' ? 'btn-disabled' : '' }}">
                                        Sewa Sekarang
                                    </button>
                                    <button class="btn btn-square btn-outline border-slate-200 rounded-xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </main>
        </div>
    </div>

    <section class="bg-slate-50 py-16 mt-12">
        <div class="container mx-auto px-4 md:px-10">
            <h2 class="text-2xl font-bold text-slate-800 mb-8 text-center">Ketentuan Penyewaan</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="flex gap-4">
                    <div class="text-emerald-600 font-bold text-3xl">01</div>
                    <p class="text-sm text-slate-600">Menyerahkan kartu identitas (KTP) asli yang masih berlaku sebagai
                        jaminan selama masa sewa.</p>
                </div>
                <div class="flex gap-4">
                    <div class="text-emerald-600 font-bold text-3xl">02</div>
                    <p class="text-sm text-slate-600">Memiliki SIM sesuai dengan jenis kendaraan yang disewa (SIM A untuk
                        Mobil, SIM C untuk Motor).</p>
                </div>
                <div class="flex gap-4">
                    <div class="text-emerald-600 font-bold text-3xl">03</div>
                    <p class="text-sm text-slate-600">Kerusakan yang disebabkan kelalaian penyewa sepenuhnya menjadi
                        tanggung jawab penyewa sesuai kesepakatan.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
