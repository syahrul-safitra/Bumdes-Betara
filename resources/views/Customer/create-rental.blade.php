@extends('Customer.Layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-12 md:px-10">
        <div class="mx-auto max-w-4xl">
            <div class="mb-10 text-center">
                <h1 class="text-3xl font-black text-slate-800">Konfirmasi Penyewaan</h1>
                <p class="mt-2 text-slate-500">Lengkapi detail peminjaman untuk armada <span
                        class="font-bold text-emerald-600">{{ $car->merek }}</span></p>
            </div>

            <div class="overflow-hidden rounded-[3rem] border border-slate-100 bg-white shadow-xl">
                <div class="grid grid-cols-1 lg:grid-cols-12">

                    <div class="bg-slate-900 p-8 text-white lg:col-span-4">
                        <div class="sticky top-8">
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
                            </div>
                        </div>
                    </div>

                    <div class="p-8 md:p-12 lg:col-span-8">
                        <form action="{{ url('rental') }}" method="POST" class="space-y-6" id="rentalForm">
                            @csrf

                            <input type="hidden" name="customer_id" value="{{ auth()->guard('customer')->user()->id }}">

                            {{-- <input type="hidden" name="customer_id" value="{{ Auth::guard("customer")->user()->id }}"> --}}
                            <input type="hidden" name="vehicle_id" value="{{ $car->id }}">

                            @if ($errors->has('tanggal_peminjaman'))
                                <div
                                    class="alert alert-error mb-6 rounded-2xl border-red-200 bg-red-50 text-red-700 shadow-sm">
                                    <i class="fa-solid fa-calendar-xmark"></i>
                                    <span>{{ $errors->first('tanggal_peminjaman') }}</span>
                                </div>
                            @endif
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                                <div class="form-control">
                                    <label class="label ml-1 text-xs font-bold uppercase text-slate-500">Harga Sewa
                                        Perhari</label>
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                            <span class="text-sm font-bold">Rp</span>
                                        </div>
                                        <input type="text" value="{{ number_format($car->harga_perhari, 0, ',', '.') }}"
                                            readonly
                                            class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 pl-11 font-bold text-slate-700">
                                    </div>
                                </div>

                                <div class="form-control">
                                    <label class="label ml-1 text-xs font-bold uppercase text-slate-500">Denda
                                        Perhari</label>
                                    <div class="relative">
                                        <div
                                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                            <span class="text-sm font-bold">Rp</span>
                                        </div>
                                        <input type="text" value="{{ number_format($car->denda_perhari, 0, ',', '.') }}"
                                            readonly
                                            class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 pl-11 font-bold text-red-600">
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="form-control">
                                    <label for="tanggal_peminjaman"
                                        class="label ml-1 text-xs font-bold uppercase text-slate-600">Tanggal
                                        Peminjaman</label>
                                    <input type="date" name="tanggal_peminjaman" id="tanggal_peminjaman"
                                        value="{{ old('tanggal_peminjaman') }}"
                                        class="input input-bordered @error('tanggal_peminjaman') border-red-500 @else border-slate-200 @enderror w-full rounded-2xl bg-white transition-all focus:border-emerald-500">
                                    {{-- @error('tanggal_peminjaman')
                                        <p class="ml-1 mt-1 text-[11px] font-bold tracking-wide text-red-500">
                                            <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
                                        </p>
                                    @enderror --}}
                                </div>

                                <div class="form-control">
                                    <label for="tanggal_pengembalian"
                                        class="label ml-1 text-xs font-bold uppercase text-slate-600">Tanggal
                                        Pengembalian</label>
                                    <input type="date" name="tanggal_pengembalian" id="tanggal_pengembalian"
                                        value="{{ old('tanggal_pengembalian') }}"
                                        class="input input-bordered @error('tanggal_pengembalian') border-red-500 @else border-slate-200 @enderror w-full rounded-2xl bg-white transition-all focus:border-emerald-500">
                                    {{-- @error('tanggal_pengembalian')
                                        <p class="ml-1 mt-1 text-[11px] font-bold tracking-wide text-red-500">
                                            <i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}
                                        </p>
                                    @enderror --}}
                                </div>
                            </div>

                            <div class="mt-4 rounded-[2rem] border border-emerald-100 bg-emerald-50 p-6">
                                <div class="flex gap-4">
                                    <div class="text-emerald-600">
                                        <i class="fa-solid fa-circle-info text-xl"></i>
                                    </div>
                                    <div class="text-xs leading-relaxed text-emerald-800">
                                        <p class="mb-1 font-bold underline">Syarat & Ketentuan Buberta Rent:</p>
                                        <ul class="ml-4 list-disc space-y-1">
                                            <li>Pengambilan armada wajib menunjukkan KTP asli.</li>
                                            <li>Keterlambatan pengembalian dikenakan denda per hari sesuai
                                                kebijakan.</li>
                                            <li>Bahan bakar dikembalikan dalam kondisi awal saat serah terima.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4">
                                <div class="pt-4">
                                    <button type="button" onclick="booking_modal.showModal()"
                                        class="btn h-14 w-full rounded-2xl border-none bg-emerald-600 text-lg font-black text-white shadow-xl shadow-emerald-200 transition-all hover:bg-emerald-700 active:scale-95">
                                        <i class="fa-solid fa-check-circle mr-2"></i> Simpan Data Rental
                                    </button>
                                    <a href="{{ url('/rental-kendaraan') }}"
                                        class="btn btn-ghost mt-2 w-full font-bold text-slate-400 hover:bg-transparent">Batal</a>
                                </div>

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
                                                    <p>Penyewa wajib menjaga kebersihan dan kondisi armada selama masa sewa.
                                                    </p>
                                                </div>
                                                <div class="flex gap-3">
                                                    <i class="fa-solid fa-circle-check mt-1 text-base text-emerald-500"></i>
                                                    <p>Segala bentuk keterlambatan akan dikenakan denda sesuai ketentuan
                                                        yang berlaku.</p>
                                                </div>
                                                <div class="flex gap-3">
                                                    <i class="fa-solid fa-circle-check mt-1 text-base text-emerald-500"></i>
                                                    <p>Dengan mengklik <span class="font-bold text-slate-800">"Konfirmasi &
                                                            Simpan"</span>, Anda menyatakan data yang diisi adalah benar.
                                                    </p>
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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
    </script>
@endsection
