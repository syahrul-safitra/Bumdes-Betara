@extends('Customer.Layouts.main')

@section('content')
    <div class="container mx-auto px-4 py-12">
        @if (session()->has('success'))
            <div
                class="alert alert-success mx-auto mb-8 max-w-5xl rounded-2xl border-none bg-emerald-100 text-emerald-800 shadow-lg">
                <i class="fa-solid fa-circle-check text-xl"></i>
                <span class="font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="mx-auto grid max-w-6xl grid-cols-1 items-start gap-8 lg:grid-cols-12">

            <div class="lg:col-span-7">
                <div class="overflow-hidden rounded-[2.5rem] border border-slate-100 bg-white shadow-xl">
                    <div class="flex items-center justify-between bg-slate-900 p-8">
                        <div>
                            <h2 class="text-2xl font-black uppercase italic tracking-tighter text-white">Invoice</h2>
                            <p class="mt-1 text-xs font-bold uppercase tracking-widest text-slate-400">Ref:
                                #-{{ $rental->id }}</p>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            {{-- Status Pembayaran --}}
                            <span
                                class="badge badge-lg {{ $rental->status_pembayaran == 'pending' ? 'bg-amber-400 text-amber-900' : 'bg-emerald-500 text-white' }} rounded-xl border-none px-6 py-4 font-bold">
                                <i class="fa-solid fa-money-bill-wave mr-2 opacity-50"></i>
                                {{ strtoupper(str_replace('_', ' ', $rental->status_pembayaran)) }}
                            </span>

                            {{-- Status Rental (Tambahan Baru) --}}
                            @php
                                $statusColor = [
                                    'belum_diambil' => 'bg-slate-700 text-slate-300',
                                    'sedang_dipinjam' => 'bg-blue-500 text-white',
                                    'telah_dikembalikan' => 'bg-indigo-500 text-white',
                                ];
                                $statusIcon = [
                                    'belum_diambil' => 'fa-clock',
                                    'sedang_dipinjam' => 'fa-car-side',
                                    'telah_dikembalikan' => 'fa-box-check',
                                ];
                            @endphp
                            <span
                                class="badge badge-md {{ $statusColor[$rental->status_rental] ?? 'bg-slate-700' }} rounded-lg border-none px-4 py-3 text-[10px] font-black uppercase tracking-widest">
                                <i
                                    class="fa-solid {{ $statusIcon[$rental->status_rental] ?? 'fa-circle' }} mr-1.5 opacity-70"></i>
                                {{ str_replace('_', ' ', $rental->status_rental) }}
                            </span>
                        </div>
                        {{-- <div class="text-right">
                            <span
                                class="badge badge-lg {{ $rental->status_pembayaran == "pending" ? "bg-amber-400 text-amber-900" : "bg-emerald-500 text-white" }} rounded-xl border-none px-6 py-4 font-bold">
                                {{ strtoupper(str_replace("_", " ", $rental->status_pembayaran)) }}
                            </span>
                        </div> --}}
                    </div>

                    <div class="space-y-4 p-8 md:p-10">
                        <div class="grid grid-cols-1 gap-y-4 text-sm">
                            <div class="flex items-center justify-between border-b border-dashed border-slate-100 py-3">
                                <span class="font-medium uppercase italic tracking-tight text-slate-500">Nama
                                    Customer</span>
                                <span class="font-black text-slate-800">{{ $rental->customer->nama }}</span>
                            </div>

                            <div class="flex items-center justify-between border-b border-dashed border-slate-100 py-3">
                                <span class="font-medium uppercase italic tracking-tight text-slate-500">Alamat
                                    Lengkap</span>
                                <span
                                    class="font-black text-slate-800">{{ $rental->alamat ? $rental->alamat : 'Belum di isi' }}</span>
                            </div>

                            <div class="flex items-center justify-between border-b border-dashed border-slate-100 py-3">
                                <span class="font-medium uppercase italic tracking-tight text-slate-500">Armada</span>
                                <span
                                    class="font-black italic text-emerald-600 underline decoration-2 underline-offset-4">{{ $rental->vehicle->merek }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 py-2">
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <span class="block text-[10px] font-bold uppercase text-slate-400">Tanggal Pinjam</span>
                                    <span
                                        class="text-sm font-black italic text-slate-700">{{ date('d M Y', strtotime($rental->tanggal_peminjaman)) }}</span>
                                </div>
                                <div class="rounded-2xl border-l-4 border-emerald-500 bg-slate-50 p-4">
                                    <span class="block text-[10px] font-bold uppercase text-slate-400">Tanggal
                                        Kembali</span>
                                    <span
                                        class="text-sm font-black italic text-slate-700">{{ date('d M Y', strtotime($rental->tanggal_pengembalian)) }}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-x-8 gap-y-4 pt-4">
                                <!-- Sewa per Hari -->
                                <div>
                                    <label
                                        class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Sewa/Hari</label>
                                    <p class="font-bold italic text-slate-700">
                                        Rp {{ number_format($rental->vehicle->harga_perhari, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Lama Sewa -->
                                <div>
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Lama
                                        Sewa</label>
                                    <p class="font-bold italic text-slate-700">{{ $selisihHari }} Hari</p>
                                </div>

                                <!-- Denda per Hari -->
                                <div>
                                    <label
                                        class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Denda/Hari</label>
                                    <p class="font-bold italic text-red-500">
                                        Rp {{ number_format($rental->vehicle->denda_perhari, 0, ',', '.') }}
                                    </p>
                                </div>

                                <!-- Tanggal Dikembalikan (Penempatan Baru agar sejajar dengan Keterlambatan) -->
                                <div>
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Tanggal
                                        Dikembalikan</label>
                                    <p
                                        class="{{ $rental->tanggal_dikembalikan ? 'text-emerald-600' : 'text-slate-400' }} font-bold italic">
                                        {{ $rental->tanggal_dikembalikan ? date('d/m/Y', strtotime($rental->tanggal_dikembalikan)) : '--/--/----' }}
                                    </p>
                                </div>

                                <!-- Keterlambatan -->
                                <div>
                                    <label
                                        class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Keterlambatan</label>
                                    <p class="{{ $totalTelat > 0 ? 'text-red-500' : 'text-slate-700' }} font-bold italic">
                                        {{ $totalTelat }} Hari
                                    </p>
                                </div>

                                <!-- Kosongkan satu grid atau bisa diisi info lain jika perlu agar Total Denda tetap di bawah -->
                                <div></div>

                                <!-- Total Denda -->
                                <div class="col-span-2 mt-2 border-t border-dashed border-slate-100 pt-4">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-red-400">Total Biaya
                                        Denda</label>
                                    <p class="text-lg font-black italic text-red-600">
                                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="mt-6 flex items-center justify-between rounded-3xl bg-slate-900 px-6 py-4 shadow-xl shadow-slate-200">
                                <span class="text-xs font-black uppercase italic tracking-widest text-white">Identitas
                                    Penyewa</span>
                                @if (!empty($rental->file_identitas))
                                    <a href="{{ asset('File/' . $rental->file_identitas) }}" target="_blank"
                                        class="btn btn-sm rounded-xl border-none bg-emerald-500 text-[10px] font-black uppercase italic text-white transition-all hover:bg-emerald-600">
                                        <i class="fa-solid fa-image mr-1"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-[10px] font-black uppercase italic tracking-widest text-red-400">Belum
                                        Unggah</span>
                                @endif
                            </div>
                        </div>

                        <div class="relative mt-10 overflow-hidden rounded-[2rem] bg-emerald-600 p-8 text-white">
                            <div class="absolute -bottom-4 -right-4 opacity-10">
                                <i class="fa-solid fa-receipt text-9xl"></i>
                            </div>
                            <div class="relative z-10 flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-black uppercase italic tracking-[0.2em] opacity-80">Total
                                        Rental</p>
                                    <h3 class="mt-1 text-3xl font-black italic leading-none tracking-tighter">Rp
                                        {{ number_format($totalHarga, 0, ',', '.') }}</h3>
                                </div>
                                {{-- <a href="{{ url('struk/' . $rental->id) }}"
                                        class="btn rounded-2xl border-none bg-white/20 text-xs font-black uppercase italic text-white shadow-lg backdrop-blur-md transition-all hover:bg-white hover:text-emerald-700">
                                        <i class="fa-solid fa-print mr-2"></i> Print
                                    </a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div
                    class="sticky top-8 rounded-[2.5rem] border border-slate-100 bg-white p-8 text-center shadow-xl md:p-10">

                    <div
                        class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-100 text-emerald-600 shadow-inner">
                        <i class="fa-solid fa-address-card text-3xl"></i>
                    </div>

                    <h3 class="mb-2 text-xl font-black uppercase italic tracking-tight text-slate-800">
                        Identitas & Pembayaran
                    </h3>
                    <p class="mb-6 text-sm italic text-slate-500">
                        Sistem rental saat ini hanya mendukung pembayaran tunai langsung di kantor.
                    </p>

                    <div class="mb-8 group rounded-3xl border-2 border-dashed border-emerald-200 bg-emerald-50/50 p-5">
                        <div class="mb-1 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-money-bill-wave text-xs text-emerald-600"></i>
                            <p class="text-[10px] font-black uppercase italic tracking-widest text-emerald-600">
                                Metode: Pembayaran Tunai (Cash)
                            </p>
                        </div>
                        <p class="text-xs font-bold italic tracking-tight text-slate-700 leading-relaxed">
                            Silakan lakukan pelunasan di kantor Buberta Rent saat pengambilan armada fisik.
                        </p>
                    </div>

                    <hr class="border-slate-100 mb-6">

                    {{-- Arahkan action form ini ke route update/store identitas rental Anda --}}
                    <form action="{{ url('upload-identitas/' . $rental->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6 text-left">
                        @csrf
                        {{-- @method('PUT') Gunakan PUT/PATCH jika sifatnya mengupdate data rental yang sudah ada --}}

                        {{-- Input File Identitas --}}
                        <div class="form-control w-full">
                            <label
                                class="mb-2 ml-1 text-xs font-black uppercase italic tracking-widest text-slate-500 block">
                                Upload File Identitas (KTP / NPWP)
                            </label>
                            <input type="file" name="file_identitas" accept="image/*,application/pdf"
                                class="file-input file-input-bordered h-14 w-full rounded-2xl border-slate-200 bg-slate-50 font-bold text-slate-600 file:bg-slate-900 file:text-white file:border-none file:h-full file:px-4" />
                            <span class="text-[10px] text-slate-400 mt-2 ml-1 block leading-normal">
                                * Format berkas berupa Gambar (JPG/PNG) atau PDF. Pastikan data identitas terlihat jelas
                                demi validasi admin.
                            </span>
                        </div>

                        {{-- Tambahan Input Alamat sesuai Instruksi Dosen Pembimbing --}}
                        <div class="form-control w-full">
                            <label
                                class="mb-2 ml-1 text-xs font-black uppercase italic tracking-widest text-slate-500 block">
                                Alamat Lengkap Saat Ini
                            </label>
                            <textarea name="alamat" placeholder="Tuliskan alamat lengkap domisili saat ini " required
                                class="textarea textarea-bordered min-h-[100px] w-full rounded-2xl border-slate-200 bg-slate-50 p-4 focus:border-indigo-500 focus:outline-none focus:ring-0 font-medium text-slate-700 placeholder:text-slate-400 placeholder:italic text-sm">{{ @old('alamat', $rental->alamat) }}</textarea>
                            <span class="text-[10px] text-slate-400 mt-2 ml-1 block leading-normal">
                                * Wajib diisi secara detail (Nama Jalan, No. Rumah, RT/RW, Kecamatan) untuk mempermudah
                                proses verifikasi lapangan.
                            </span>
                        </div>

                        {{-- Tombol Submit --}}
                        <button type="submit"
                            class="btn h-14 w-full rounded-2xl border-none bg-indigo-600 text-base font-black uppercase italic tracking-tighter text-white shadow-xl shadow-indigo-100 transition-all hover:bg-indigo-700 active:scale-95">
                            <i class="fa-solid fa-cloud-arrow-up mr-2 text-indigo-300"></i> Simpan Data & Berkas
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
