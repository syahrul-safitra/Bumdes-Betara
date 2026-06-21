@extends('Customer.Layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-12 md:px-10">
        <div class="mx-auto max-w-4xl">
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-black text-slate-800">Konfirmasi Penyewaan</h1>
                <p class="mt-2 text-slate-500">Lengkapi detail peminjaman harian untuk armada <span
                        class="font-bold text-emerald-600">{{ $car->merek }}</span></p>
            </div>

            <div class="overflow-hidden rounded-[3rem] border border-slate-100 bg-white shadow-xl">
                <div class="grid grid-cols-1 lg:grid-cols-12">

                    {{-- SIDEBAR DETAIL ARMADA & TANGGAL TERBOOKING --}}
                    <div class="bg-slate-900 p-8 text-white lg:col-span-4">
                        <div class="sticky top-8 space-y-6">
                            {{-- Detail Informasi Mobil --}}
                            <div>
                                <img src="{{ asset('File/' . $car->gambar) }}" alt="{{ $car->merek }}"
                                    class="mb-6 h-40 w-full rounded-3xl object-cover shadow-lg">
                                <h2 class="mb-1 text-xl font-bold">{{ $car->merek }}</h2>
                                <p class="mb-6 text-sm font-medium uppercase tracking-wider text-emerald-400">
                                    {{ $car->type }}</p>

                                <div class="space-y-4 border-t border-slate-800 pt-6">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-400">Harga /Hari</span>
                                        <span class="font-bold text-emerald-500">Rp
                                            {{ number_format($car->harga_perhari, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-400">Denda /Hari</span>
                                        <span class="font-bold text-red-400">Rp
                                            {{ number_format($car->denda_perhari, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-400">Sewa Driver /Hari</span>
                                        <span class="font-bold text-yellow-400">Rp
                                            {{ number_format($car->sewa_driver, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            {{-- REVISI POIN 1: DAFTAR TANGGAL YANG SUDAH DIBOOKING BULAN INI --}}
                            <div class="border-t border-slate-800 pt-6">
                                <div class="mb-3 flex items-center gap-2 text-amber-400">
                                    <i class="fa-solid fa-calendar-alt text-sm"></i>
                                    <h4 class="text-xs font-black uppercase tracking-wider">Jadwal Sewa Bulan Ini</h4>
                                </div>

                                <div class="space-y-2.5">
                                    @forelse($bookingBulanIni as $booked)
                                        <div
                                            class="flex flex-col gap-1 rounded-2xl bg-slate-800/50 p-3 border border-slate-800">
                                            <div class="flex items-center justify-between">
                                                <span
                                                    class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Unit
                                                    Terkunci</span>
                                                <span
                                                    class="badge badge-xs border-none bg-amber-500/20 text-amber-400 font-bold px-2 py-1 text-[9px] rounded">Reserved</span>
                                            </div>
                                            <span class="text-xs font-bold text-slate-200">
                                                {{ \Carbon\Carbon::parse($booked->tanggal_peminjaman)->translatedFormat('d M') }}
                                                s/d
                                                {{ \Carbon\Carbon::parse($booked->tanggal_pengembalian)->translatedFormat('d M Y') }}
                                            </span>
                                        </div>
                                    @empty
                                        <div
                                            class="rounded-2xl bg-emerald-950/30 border border-emerald-900/50 p-4 text-center">
                                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm mb-1 block"></i>
                                            <p class="text-[11px] font-medium text-emerald-400">Armada siap pakai. Belum ada
                                                jadwal booking bulan ini.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- FORM INPUT UTAMA (MODUL HARIAN) --}}
                    <div class="p-8 md:p-12 lg:col-span-8">
                        <form action="{{ url('rental') }}" method="POST" class="space-y-6" id="rentalForm">
                            @csrf

                            <input type="hidden" name="customer_id" value="{{ auth()->guard('customer')->user()->id }}">
                            <input type="hidden" name="vehicle_id" value="{{ $car->id }}">
                            <input type="hidden" name="tipe_sewa" value="harian"> {{-- Flag penanda jenis sewa ke backend --}}

                            <div class="mb-2">
                                <span
                                    class="badge bg-emerald-100 text-emerald-700 font-black uppercase italic tracking-wider px-3 py-2 rounded-xl text-[10px]">
                                    Mode Sewa: Harian berkala
                                </span>
                            </div>

                            @if ($errors->has('tanggal_peminjaman'))
                                <div
                                    class="alert alert-error mb-6 rounded-2xl border-red-200 bg-red-50 text-red-700 shadow-sm">
                                    <i class="fa-solid fa-calendar-xmark"></i>
                                    <span>{{ $errors->first('tanggal_peminjaman') }}</span>
                                </div>
                            @endif

                            {{-- BARIS TANGGAL RENTAL --}}
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="form-control">
                                    <label class="label ml-1 text-xs font-bold uppercase text-slate-600">Tanggal
                                        Peminjaman</label>
                                    <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman"
                                        value="{{ old('tanggal_peminjaman') }}"
                                        class="input input-bordered @error('tanggal_peminjaman') border-red-500 @else border-slate-200 @enderror w-full rounded-2xl bg-white transition-all focus:border-emerald-500">
                                </div>

                                <div class="form-control">
                                    <label class="label ml-1 text-xs font-bold uppercase text-slate-600">Tanggal
                                        Pengembalian</label>
                                    <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian"
                                        value="{{ old('tanggal_pengembalian') }}"
                                        class="input input-bordered @error('tanggal_pengembalian') border-red-500 @else border-slate-200 @enderror w-full rounded-2xl bg-white transition-all focus:border-emerald-500">
                                </div>
                            </div>

                            {{-- METODE PENGGUNAAN ARMADA --}}
                            <div class="form-control w-full">
                                <label class="mb-2 ml-1 text-xs font-bold uppercase text-slate-600">Metode Penggunaan
                                    Armada</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                                    {{-- Pilihan 1: Tanpa Driver --}}
                                    <div class="relative block h-20">
                                        <input type="radio" name="sewa_driver" value="0" id="driver_no"
                                            {{ old('sewa_driver', '0') == '0' ? 'checked' : '' }} class="peer hidden" />

                                        <label for="driver_no"
                                            class="absolute inset-0 flex items-center justify-between p-4 rounded-2xl border border-slate-200 bg-slate-50/50 cursor-pointer transition-all select-none peer-checked:border-emerald-500 peer-checked:bg-emerald-50/30 hover:bg-slate-50">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                                                    <i class="fa-solid fa-key text-sm"></i>
                                                </div>
                                                <div class="flex flex-col justify-center">
                                                    <span class="text-sm font-bold text-slate-700 leading-none">Lepas
                                                        Kunci</span>
                                                    <span
                                                        class="text-[11px] text-slate-400 block mt-1.5 leading-none">Menyetir
                                                        armada sendiri</span>
                                                </div>
                                            </div>
                                            <div
                                                class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-slate-300 peer-checked:border-emerald-600 bg-white">
                                                <div class="h-2.5 w-2.5 rounded-full bg-transparent transition-all"></div>
                                            </div>
                                        </label>
                                    </div>

                                    {{-- Pilihan 2: Menggunakan Jasa Driver --}}
                                    <div class="relative block h-20">
                                        <input type="radio" name="sewa_driver" value="1" id="driver_yes"
                                            {{ old('sewa_driver') == '1' ? 'checked' : '' }} class="peer hidden" />

                                        <label for="driver_yes"
                                            class="absolute inset-0 flex items-center justify-between p-4 rounded-2xl border border-slate-200 bg-slate-50/50 cursor-pointer transition-all select-none peer-checked:border-emerald-500 peer-checked:bg-emerald-50/30 hover:bg-slate-50">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                                                    <i class="fa-solid fa-user-tie text-sm"></i>
                                                </div>
                                                <div class="flex flex-col justify-center">
                                                    <span class="text-sm font-bold text-slate-700 leading-none">Gunakan
                                                        Jasa Driver</span>
                                                    <span
                                                        class="text-[11px] text-indigo-600 font-semibold block mt-1.5 leading-none">+
                                                        Rp {{ number_format($car->sewa_driver, 0, ',', '.') }} /
                                                        Hari</span>
                                                </div>
                                            </div>
                                            <div
                                                class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full border border-slate-300 peer-checked:border-emerald-600 bg-white">
                                                <div class="h-2.5 w-2.5 rounded-full bg-transparent transition-all"></div>
                                            </div>
                                        </label>
                                    </div>

                                </div>
                                @error('sewa_driver')
                                    <p class="mt-1 text-xs text-red-500 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- REVISI POIN 3: PILIHAN METODE PEMBAYARAN UANG MUKA (DP) --}}
                            <div class="form-control w-full">
                                <label class="label ml-1 text-xs font-bold uppercase text-slate-500">Metode Pembayaran Uang
                                    Muka (DP)</label>
                                <select name="is_dp" id="metode_pembayaran" onchange="toggleInfoTransferForm()"
                                    class="select select-bordered h-14 w-full rounded-2xl border-slate-200 bg-slate-50 font-bold text-slate-700 focus:border-emerald-500 focus:outline-none">
                                    <option value="0" {{ old('is_dp') == 0 ? 'selected' : '' }}>
                                        Bayar Tunai / Cash (Langsung di Kantor)</option>
                                    <option value="1" {{ old('is_dp') == 1 ? 'selected' : '' }}>
                                        Transfer Bank (Uang
                                        Muka / DP Online)</option>
                                </select>
                            </div>

                            {{-- BOX REKENING INFORMASI TF --}}
                            <div id="info_transfer_box"
                                class="hidden rounded-[2rem] border border-indigo-100 bg-indigo-50/40 p-6 transition-all duration-300">
                                <div class="flex items-start gap-3">
                                    <div
                                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-md">
                                        <i class="fa-solid fa-building-columns text-sm"></i>
                                    </div>
                                    <div>
                                        <span
                                            class="block text-[10px] font-black uppercase tracking-wider text-indigo-600">Rekening
                                            Resmi BUMDes Betara</span>
                                        <span class="block text-base font-black text-slate-800 mt-0.5">Bank Jambi:
                                            789-0123-456-7 (Bumdes Betara)</span>
                                        <span class="block text-xs text-slate-500 mt-1 leading-normal">
                                            * Silakan lakukan transfer DP awal minimal <strong
                                                class="text-indigo-600">20%</strong> dari total harga ke rekening di atas.
                                            Berkas bukti transfer dapat diunggah
                                            bersamaan dengan identitas KTP sesaat setelah form ini disimpan.
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <style>
                                .peer:checked~label div .h-2\.5 {
                                    background-color: #10b981 !important;
                                }

                                .peer:checked~label {
                                    border-color: #10b981 !important;
                                }
                            </style>

                            {{-- SYARAT KETENTUAN --}}
                            <div class="mt-4 rounded-[2rem] border border-emerald-100 bg-emerald-50 p-6">
                                <div class="flex gap-4">
                                    <div class="text-emerald-600">
                                        <i class="fa-solid fa-circle-info text-xl"></i>
                                    </div>
                                    <div class="text-xs leading-relaxed text-emerald-800">
                                        <p class="mb-1 font-bold underline">Syarat & Ketentuan Buberta Rent:</p>
                                        <ul class="ml-4 list-disc space-y-1">
                                            <li>Pengambilan armada lepas kunci wajib menunjukkan KTP asli.</li>
                                            <li>Keterlambatan pengembalian dikenakan denda per hari sesuai kebijakan.</li>
                                            <li>Bahan bakar dikembalikan sesuai kondisi awal serah terima.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            {{-- ACTION BUTTON --}}
                            <div class="pt-4">
                                <button type="button" onclick="booking_modal.showModal()"
                                    class="btn h-14 w-full rounded-2xl border-none bg-emerald-600 text-lg font-black text-white shadow-xl shadow-emerald-200 transition-all hover:bg-emerald-700 active:scale-95">
                                    <i class="fa-solid fa-check-circle mr-2"></i> Simpan Data Rental
                                </button>
                                <a href="{{ url('/rental-kendaraan') }}"
                                    class="btn btn-ghost mt-2 w-full font-bold text-slate-400 hover:bg-transparent">Batal</a>
                            </div>

                            {{-- MODAL BOX DIALOG --}}
                            <dialog id="booking_modal"
                                class="modal modal-middle backdrop-blur-sm transition-all duration-300">
                                <div
                                    class="modal-box relative overflow-hidden rounded-[2.5rem] border-none p-0 shadow-2xl">
                                    <div class="bg-slate-900 p-8 text-center text-white">
                                        <div
                                            class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-emerald-500 shadow-lg shadow-emerald-500/20">
                                            <i class="fa-solid fa-file-signature text-2xl"></i>
                                        </div>
                                        <h3 class="text-xl font-black">Konfirmasi Penyewaan</h3>
                                        <p class="mt-1 text-sm text-slate-400">Syarat & Ketentuan Buberta Rent</p>
                                    </div>

                                    <div class="bg-white p-8 text-sm leading-relaxed text-slate-600">
                                        <div class="space-y-4">
                                            <div class="flex gap-3">
                                                <i class="fa-solid fa-circle-check mt-1 text-base text-emerald-500"></i>
                                                <p>Penyewa wajib menjaga kebersihan dan kondisi armada selama masa sewa.</p>
                                            </div>
                                            <div class="flex gap-3">
                                                <i class="fa-solid fa-circle-check mt-1 text-base text-emerald-500"></i>
                                                <p>Segala bentuk keterlambatan akan dikenakan denda sesuai ketentuan yang
                                                    berlaku.</p>
                                            </div>
                                            <div class="flex gap-3">
                                                <i class="fa-solid fa-circle-check mt-1 text-base text-emerald-500"></i>
                                                <p>Dengan mengklik <span class="font-bold text-slate-800">"Konfirmasi &
                                                        Simpan"</span>, Anda menyatakan data yang diisi adalah benar.</p>
                                            </div>
                                        </div>

                                        <div class="modal-action mt-10 grid grid-cols-2 gap-4">
                                            <button type="button" onclick="booking_modal.close()"
                                                class="btn btn-ghost w-full rounded-2xl font-bold text-slate-400 hover:bg-slate-50">
                                                Kembali
                                            </button>
                                            <button type="button" onclick="submitMainForm()"
                                                class="btn rounded-2xl border-none bg-emerald-600 font-black text-white shadow-lg shadow-emerald-100 hover:bg-emerald-700">
                                                Konfirmasi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </dialog>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleInfoTransferForm() {
            const metode = document.getElementById('metode_pembayaran').value;
            const infoBox = document.getElementById('info_transfer_box');

            if (metode === 'transfer') {
                infoBox.classList.remove('hidden');
            } else {
                infoBox.classList.add('hidden');
            }
        }

        function submitMainForm() {
            document.getElementById('rentalForm').submit();
        }

        document.addEventListener("DOMContentLoaded", function() {
            toggleInfoTransferForm();
        });
    </script>

    {{-- <script>
        function submitMainForm() {
            // Ambil elemen form berdasarkan ID
            const form = document.getElementById('rentalForm');

            // Pastikan form ditemukan sebelum disubmit
            if (form) {
                form.submit();
            } else {
                console.error("Form dengan ID 'rentalForm' tidak ditemukan.");
            }
        }
    </script> --}}
@endsection
