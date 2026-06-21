@extends('Customer.Layouts.main') {{-- Sesuaikan dengan nama layout master Anda --}}

@section('content')
    <div class="mx-auto max-w-6xl px-4 py-12">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">

            {{-- SISI KIRI: FORM BOOKING BULANAN --}}
            <div class="lg:col-span-7">
                <div class="rounded-[2.5rem] border border-slate-100 bg-white p-8 shadow-xl md:p-12">
                    <div class="mb-8">
                        <span
                            class="badge badge-primary font-black uppercase italic tracking-widest text-[10px] px-3 py-2.5 rounded-md bg-indigo-100 border-none text-indigo-700">
                            <i class="fa-solid fa-calendar-check mr-1"></i> Paket Bulanan (Lepas Kunci)
                        </span>
                        <h2 class="mt-3 text-2xl font-black text-slate-800 tracking-tight">Formulir Sewa Jangka Panjang</h2>
                        <p class="text-sm text-slate-400 mt-1">Silakan tentukan tanggal mulai dan durasi bulan sewa armada
                            Anda.</p>
                    </div>

                    <form action="{{ url('/rental-bulanan') }}" method="POST" class="space-y-6">
                        @csrf
                        {{-- Hidden input untuk melempar id kendaraan --}}
                        <input type="hidden" name="vehicle_id" id="vehicle_id" value="{{ $vehicle->id }}">
                        <input type="hidden" name="customer_id" value="{{ Auth::guard('customer')->user()->id }}">

                        {{-- Pilihan Tanggal Mulai --}}
                        <div class="form-control w-full">
                            <label
                                class="mb-2 ml-1 text-xs font-black uppercase italic tracking-widest text-slate-500 block">
                                Tanggal Mulai Sewa
                            </label>
                            <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman" required
                                min="{{ date('Y-m-d') }}" value="{{ old('tanggal_peminjaman', date('Y-m-d')) }}"
                                class="input input-bordered h-14 w-full rounded-2xl border-slate-200 bg-slate-50 font-bold text-slate-700 focus:border-indigo-500 focus:bg-white focus:ring-4 focus:ring-indigo-50 focus:outline-none" />
                            @error('tanggal_peminjaman')
                                <p class="mt-1 text-xs text-red-500 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Pilihan Berapa Bulan --}}
                        <div class="form-control w-full">
                            <label
                                class="mb-2 ml-1 text-xs font-black uppercase italic tracking-widest text-slate-500 block">
                                Durasi Sewa (Bulan)
                            </label>
                            <select name="berapa_bulan" id="berapa_bulan" onchange="hitungEstimasi()"
                                class="select select-bordered h-14 w-full rounded-2xl border-slate-200 bg-slate-50 font-bold text-slate-700 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-50/50">
                                @for ($i = 1; $i <= 3; $i++)
                                    <option value="{{ $i }}" {{ old('berapa_bulan') == $i ? 'selected' : '' }}>
                                        {{ $i }} Bulan
                                    </option>
                                @endfor
                            </select>
                            @error('berapa_bulan')
                                <p class="mt-1 text-xs text-red-500 ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Pilihan Skema DP atau Cash Penuh --}}
                        <div class="form-control w-full">
                            <label
                                class="mb-2 ml-1 text-xs font-black uppercase italic tracking-widest text-slate-500 block">
                                Metode Pembayaran Awal
                            </label>
                            <select name="is_dp" id="is_dp" onchange="hitungEstimasi()"
                                class="select select-bordered h-14 w-full rounded-2xl border-slate-200 bg-slate-50 font-bold text-slate-700 focus:border-indigo-500 focus:bg-white focus:outline-none focus:ring-4 focus:ring-indigo-50/50">
                                <option value="0" {{ old('is_dp') == '0' ? 'selected' : '' }}>Bayar Tunai Langsung di
                                    Kantor (Full Cash)</option>
                                <option value="1" {{ old('is_dp') == '1' ? 'selected' : '' }}>Bayar Uang Muka
                                    (Transfer DP 20%)</option>
                            </select>
                        </div>

                        {{-- Info Tambahan Ketentuan --}}
                        <div class="rounded-2xl bg-amber-50 border border-amber-100 p-4 text-xs text-amber-800 space-y-1">
                            <p class="font-bold"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Ketentuan Sewa
                                Bulanan:</p>
                            <ul class="list-disc list-inside space-y-0.5 opacity-90 pl-1">
                                <li>Paket ini hanya mendukung sistem penyewaan <strong>Lepas Kunci</strong>.</li>
                                <li>Tanggal pengembalian dihitung otomatis pas sesuai kalender bulanan sejak armada diambil.
                                </li>
                                {{-- TAMBAHAN KETERANGAN KERUSAKAN --}}
                                <li class="text-red-700 font-semibold"><i
                                        class="fa-solid fa-circle-exclamation mr-0.5 text-red-500"></i> Segala bentuk
                                    kerusakan armada selama masa sewa sepenuhnya <strong>ditanggung oleh customer</strong>.
                                </li>
                            </ul>
                        </div>
                        {{-- Button Submit --}}
                        <button type="submit"
                            class="btn h-14 w-full rounded-2xl border-none bg-indigo-600 text-base font-black uppercase italic tracking-tighter text-white shadow-xl shadow-indigo-100 transition-all hover:bg-indigo-700 active:scale-95">
                            <i class="fa-solid fa-car-side mr-2 text-indigo-300"></i> Lanjutkan Booking
                        </button>
                    </form>
                </div>
            </div>

            {{-- SISI KANAN: RINGKASAN ARMADA & ESTIMASI HARGA (REAL-TIME) --}}
            <div class="lg:col-span-5">
                <div class="sticky top-8 space-y-6">

                    {{-- Detail Mobil --}}
                    <div
                        class="overflow-hidden rounded-[2.5rem] border border-slate-100 bg-white p-6 shadow-xl text-center">
                        <img src="{{ asset('File/' . $vehicle->gambar) }}" alt="{{ $vehicle->merek }}"
                            class="mx-auto h-40 w-full rounded-2xl object-cover mb-4">
                        <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">{{ $vehicle->merek }}</h3>
                        <p class="text-xs font-bold text-slate-400 mt-0.5">{{ $vehicle->no_plat }} • {{ $vehicle->warna }}
                        </p>

                        <div class="mt-4 grid grid-cols-2 gap-2 border-t border-slate-50 pt-4 text-left">
                            <div class="rounded-2xl bg-slate-50 p-3">
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Tarif
                                    Bulanan</span>
                                <span class="text-sm font-black text-indigo-600">Rp
                                    {{ number_format($vehicle->harga_perbulan, 0, ',', '.') }}<span
                                        class="text-[10px] font-normal text-slate-400">/bln</span></span>
                            </div>
                            <div class="rounded-2xl bg-slate-50 p-3">
                                <span class="block text-[9px] font-bold text-slate-400 uppercase tracking-wider">Denda
                                    Telat</span>
                                <span class="text-sm font-black text-orange-600">Rp
                                    {{ number_format($vehicle->denda_perhari, 0, ',', '.') }}<span
                                        class="text-[10px] font-normal text-slate-400">/hari</span></span>
                            </div>
                        </div>
                    </div>

                    {{-- Card Billing Live Kalkulator --}}
                    <div class="rounded-[2.5rem] bg-slate-900 p-8 text-white shadow-2xl">
                        <h3 class="text-xs font-black uppercase tracking-widest text-indigo-400 mb-6">Live Billing Summary
                        </h3>

                        <div class="space-y-4">
                            <div class="flex justify-between text-slate-400 text-xs">
                                <span>Sewa Pokok (<span id="live_bulan">1</span> Bulan)</span>
                                <span id="live_harga_pokok">Rp 0</span>
                            </div>

                            <div id="live_row_dp"
                                class="hidden flex justify-between text-indigo-400 text-xs border-t border-dashed border-slate-800 pt-3">
                                <span>Kewajiban Transfer DP (20%)</span>
                                <span id="live_nominal_dp">Rp 0</span>
                            </div>

                            <div class="mt-6 flex items-center justify-between border-t-2 border-indigo-500/30 pt-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-indigo-400" id="live_label_total">Total Bayar Di
                                        Kantor</span>
                                    <span
                                        class="text-[9px] text-slate-500 uppercase tracking-wider font-semibold mt-0.5">Estimasi
                                        Pokok</span>
                                </div>
                                <span class="text-2xl font-black text-white" id="live_grand_total">Rp 0</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    {{-- JAVASCRIPT LIVE CALCULATION --}}
    <script>
        const hargaPerBulan = {{ $vehicle->harga_perbulan }};

        function hitungEstimasi() {
            const berapaBulan = parseInt(document.getElementById('berapa_bulan').value);
            const isDp = document.getElementById('is_dp').value;

            // Hitung total sewa pokok bersih
            const totalSewaPokok = hargaPerBulan * berapaBulan;
            const nominalDp = totalSewaPokok * 0.2;

            // Ubah text durasi bulan di bill summary
            document.getElementById('live_bulan').innerText = berapaBulan;
            // Ubah text harga pokok sewa
            document.getElementById('live_harga_pokok').innerText = 'Rp ' + totalSewaPokok.toLocaleString('id-ID');

            if (isDp === '1') {
                // Tampilkan baris potongan DP
                document.getElementById('live_row_dp').classList.remove('hidden');
                document.getElementById('live_nominal_dp').innerText = 'Rp ' + nominalDp.toLocaleString('id-ID');

                // Grand total menjadi hanya sisa pelunasan cash di kantor
                document.getElementById('live_label_total').innerText = 'Sisa Pelunasan (Cash)';
                document.getElementById('live_grand_total').innerText = 'Rp ' + (totalSewaPokok - nominalDp).toLocaleString(
                    'id-ID');
            } else {
                // Sembunyikan baris DP
                document.getElementById('live_row_dp').classList.add('hidden');

                // Grand total kembali penuh harus lunas di kantor
                document.getElementById('live_label_total').innerText = 'Total Bayar Di Kantor';
                document.getElementById('live_grand_total').innerText = 'Rp ' + totalSewaPokok.toLocaleString('id-ID');
            }
        }

        // Jalankan kalkulasi pertama kali saat halaman di-load
        document.addEventListener("DOMContentLoaded", function() {
            hitungEstimasi();
        });
    </script>
@endsection
