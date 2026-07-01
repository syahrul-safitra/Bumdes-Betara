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

                            {{-- Status Rental --}}
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


                                @if ($rental->status_rental == 'sedang_dipinjam')
                                    Sudah Diambil
                                @else
                                    {{ str_replace('_', ' ', $rental->status_rental) }}
                                @endif

                            </span>
                        </div>
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

                            {{-- INFORMASI OPSI METODE DRIVER --}}
                            <div class="flex items-center justify-between border-b border-dashed border-slate-100 py-3">
                                <span class="font-medium uppercase italic tracking-tight text-slate-500">Metode
                                    Penggunaan</span>
                                @if ($rental->sewa_driver == 1)
                                    <span
                                        class="badge badge-sm border-none bg-indigo-50 text-indigo-600 font-bold px-3 py-2.5 rounded-lg">
                                        <i class="fa-solid fa-user-tie mr-1"></i> Dengan Driver BUMDes
                                    </span>
                                @else
                                    <span
                                        class="badge badge-sm border-none bg-slate-100 text-slate-600 font-bold px-3 py-2.5 rounded-lg">
                                        <i class="fa-solid fa-key mr-1"></i> Lepas Kunci (Sewa Mobil Saja)
                                    </span>
                                @endif
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
                                <div>
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Sewa
                                        Mobil/Hari</label>
                                    <p class="font-bold italic text-slate-700">
                                        Rp {{ number_format($rental->vehicle->harga_perhari, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Lama
                                        Sewa</label>
                                    <p class="font-bold italic text-slate-700">{{ $selisihHari }} Hari</p>
                                </div>

                                {{-- DINAMIS: TARIF DRIVER DI TAMPILKAN JIKA DIGUNAKAN --}}
                                @if ($rental->sewa_driver == 1)
                                    <div>
                                        <label class="text-[10px] font-bold uppercase tracking-widest text-indigo-400">Sewa
                                            Driver/Hari</label>
                                        <p class="font-bold italic text-indigo-600">
                                            Rp {{ number_format($rental->vehicle->sewa_driver, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div>
                                        <label
                                            class="text-[10px] font-bold uppercase tracking-widest text-indigo-400">Subtotal
                                            Driver</label>
                                        <p class="font-bold italic text-indigo-600">
                                            Rp
                                            {{ number_format($rental->vehicle->sewa_driver * $selisihHari, 0, ',', '.') }}
                                        </p>
                                    </div>
                                @endif

                                <div>
                                    <label
                                        class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Denda/Hari</label>
                                    <p class="font-bold italic text-red-500">
                                        Rp {{ number_format($rental->vehicle->denda_perhari, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div>
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Tanggal
                                        Dikembalikan</label>
                                    <p
                                        class="{{ $rental->tanggal_dikembalikan ? 'text-emerald-600' : 'text-slate-400' }} font-bold italic">
                                        {{ $rental->tanggal_dikembalikan ? date('d/m/Y', strtotime($rental->tanggal_dikembalikan)) : '--/--/----' }}
                                    </p>
                                </div>

                                <div>
                                    <label
                                        class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Keterlambatan</label>
                                    <p class="{{ $totalTelat > 0 ? 'text-red-500' : 'text-slate-700' }} font-bold italic">
                                        {{ $totalTelat }} Hari
                                    </p>
                                </div>

                                <div></div>

                                <div class="col-span-2 mt-2 border-t border-dashed border-slate-100 pt-4">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-red-400">Total Biaya
                                        Denda</label>
                                    <p class="text-lg font-black italic text-red-600">
                                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            <div class="space-y-3 mt-6">
                                {{-- BARIS PREVIEW IDENTITAS --}}
                                <div
                                    class="flex items-center justify-between rounded-3xl bg-slate-900 px-6 py-4 shadow-xl shadow-slate-200">
                                    <span class="text-xs font-black uppercase italic tracking-widest text-white">Identitas
                                        Penyewa</span>
                                    @if (!empty($rental->file_identitas))
                                        <a href="{{ asset('File/' . $rental->file_identitas) }}" target="_blank"
                                            class="btn btn-sm rounded-xl border-none bg-emerald-500 text-[10px] font-black uppercase italic text-white transition-all hover:bg-emerald-600">
                                            <i class="fa-solid fa-image mr-1"></i> Lihat
                                        </a>
                                    @else
                                        <span
                                            class="text-[10px] font-black uppercase italic tracking-widest text-red-400">Belum
                                            Unggah</span>
                                    @endif
                                </div>

                                {{-- TAMBAHAN BARU: BARIS PREVIEW BUKTI DP (Hanya muncul jika is_dp true) --}}
                                @if ($rental->is_dp == 1)
                                    <div
                                        class="flex items-center justify-between rounded-3xl bg-slate-900 px-6 py-4 shadow-xl shadow-slate-200 animate-fadeIn">
                                        <span class="text-xs font-black uppercase italic tracking-widest text-white">Bukti
                                            Transfer DP</span>
                                        @if (!empty($rental->bukti_dp))
                                            <a href="{{ asset('File/' . $rental->bukti_dp) }}" target="_blank"
                                                class="btn btn-sm rounded-xl border-none bg-indigo-500 text-[10px] font-black uppercase italic text-white transition-all hover:bg-indigo-600">
                                                <i class="fa-solid fa-receipt mr-1"></i> Lihat
                                            </a>
                                        @else
                                            <span
                                                class="text-[10px] font-black uppercase italic tracking-widest text-amber-400">Belum
                                                Unggah</span>
                                        @endif
                                    </div>
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
                                        Tagihan Rental</p>
                                    <h3 class="mt-1 text-3xl font-black italic leading-none tracking-tighter">Rp
                                        {{ number_format($rental->total_sewa, 0, ',', '.') }}</h3>
                                </div>
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

                    {{-- KONDISI 1: JIKA RENTAL MENGGUNAKAN DP TRANSFER (is_dp == 1) --}}
                    @if ($rental->is_dp == 1)
                        <p class="mb-6 text-sm italic text-slate-500">
                            Pesanan ini memerlukan pembayaran uang muka (DP) sebesar 20% melalui transfer bank.
                        </p>

                        {{-- CARD NOMINAL DP DAN REKENING --}}
                        <div class="mb-4 text-left rounded-3xl border border-indigo-100 bg-indigo-50/50 p-5 space-y-3">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-money-bill-transfer text-xs text-indigo-600"></i>
                                <p class="text-[10px] font-black uppercase italic tracking-widest text-indigo-600">
                                    Metode: Transfer Bank (DP 20%)
                                </p>
                            </div>

                            <div class="border-t border-indigo-100/70 pt-2 flex justify-between items-center">
                                <span class="text-xs font-medium text-slate-500">Nominal Transfer (DP):</span>
                                <span class="text-base font-black text-indigo-600">
                                    Rp {{ number_format($rental->total_sewa * 0.2, 0, ',', '.') }}
                                </span>
                            </div>

                            <div
                                class="rounded-2xl bg-white border border-indigo-100 p-3.5 text-xs text-slate-700 space-y-1">
                                <span class="block text-[10px] font-black uppercase tracking-wider text-slate-400">Rekening
                                    Resmi BUMDes Betara</span>
                                <span class="block font-black text-slate-800 text-sm">Bank Jambi: 789-0123-456-7</span>
                                <span class="block text-[11px] text-slate-400 leading-tight">A.N. BUMDesa Bersama
                                    Betara</span>
                            </div>
                        </div>

                        {{-- KONDISI 2: JIKA RENTAL TUNAI TANPA DP (is_dp == 0) --}}
                    @else
                        <p class="mb-6 text-sm italic text-slate-500">
                            Sistem rental saat ini hanya mendukung pembayaran tunai langsung di kantor.
                        </p>

                        {{-- INFO METODE UTAMA TUNAI --}}
                        <div class="mb-4 group rounded-3xl border-2 border-dashed border-emerald-200 bg-emerald-50/50 p-5">
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
                    @endif

                    {{-- CARD WHATSAPP KONFIRMASI ADMIN --}}
                    @php
                        $cleanPhone = $noTeleponAdmin->no_telepon;

                        if (substr($cleanPhone, 0, 2) === '08') {
                            $cleanPhone = '628' . substr($cleanPhone, 2);
                        }

                        $textWA = rawurlencode(
                            'Halo Admin Buberta Rent, saya ingin mengonfirmasi pesanan atas nama ' .
                                $rental->customer->nama .
                                ($rental->is_dp == 1
                                    ? '. Saya akan segera mengunggah bukti transfer DP.'
                                    : '. Saya akan segera melakukan konfirmasi berkas identitas.'),
                        );
                    @endphp

                    <div
                        class="mb-6 rounded-3xl border border-green-100 bg-green-50/50 p-5 text-left flex items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-green-500 text-white shadow-md shadow-green-200">
                                <i class="fa-brands fa-whatsapp text-xl"></i>
                            </div>
                            <div>
                                <span class="block text-[10px] font-black uppercase tracking-wider text-green-600">Butuh
                                    Bantuan?</span>
                                <span class="block text-xs font-bold text-slate-700 mt-0.5 leading-tight">Hubungi Admin
                                    BUMDes via WhatsApp</span>
                            </div>
                        </div>
                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ $textWA }}" target="_blank"
                            class="btn btn-sm min-h-[38px] h-[38px] rounded-xl border-none bg-green-600 font-bold text-[11px] text-white transition-all hover:bg-green-700 shadow-md shadow-green-100 active:scale-95 px-4 shrink-0">
                            Chat <i class="fa-solid fa-arrow-up-right-from-square ml-1 text-[9px] text-green-300"></i>
                        </a>
                    </div>

                    <hr class="border-slate-100 mb-6">

                    {{-- FORM ACTION UNTUK UPLOAD BERKAS --}}
                    <form action="{{ url('upload-identitas/' . $rental->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6 text-left">
                        @csrf

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

                        {{-- REVISI TAMBAHAN: INPUT BUKTI TRANSFER JIKA IS_DP ADALAH TRUE --}}
                        @if ($rental->is_dp == 1)
                            <div class="form-control w-full">
                                <label
                                    class="mb-2 ml-1 text-xs font-black uppercase italic tracking-widest text-indigo-600 block">
                                    Upload Bukti Transfer DP (20%)
                                </label>
                                <input type="file" name="bukti_dp" accept="image/*" required
                                    class="file-input file-input-bordered file-input-primary h-14 w-full rounded-2xl border-indigo-200 bg-indigo-50/30 font-bold text-slate-600 file:bg-indigo-600 file:text-white file:border-none file:h-full file:px-4 focus:border-indigo-500 focus:outline-none" />
                                <span class="text-[10px] text-slate-400 mt-2 ml-1 block leading-normal">
                                    * Wajib mengunggah foto struk/screenshot mutasi transfer bank yang valid berukuran
                                    maksimal 2MB.
                                </span>
                            </div>
                        @endif

                        {{-- Input Alamat --}}
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
