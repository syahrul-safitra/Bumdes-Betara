@extends("Customer.Layouts.main")

@section("content")
    <div class="container mx-auto px-4 py-12">
        @if (session()->has("success"))
            <div
                class="alert alert-success mx-auto mb-8 max-w-5xl rounded-2xl border-none bg-emerald-100 text-emerald-800 shadow-lg">
                <i class="fa-solid fa-circle-check text-xl"></i>
                <span class="font-bold">{{ session("success") }}</span>
            </div>
        @endif

        <div class="mx-auto grid max-w-6xl grid-cols-1 items-start gap-8 lg:grid-cols-12">

            <div class="lg:col-span-7">
                <div class="overflow-hidden rounded-[2.5rem] border border-slate-100 bg-white shadow-xl">
                    <div class="flex items-center justify-between bg-slate-900 p-8">
                        <div>
                            <h2 class="text-2xl font-black uppercase italic tracking-tighter text-white">Invoice</h2>
                            <p class="mt-1 text-xs font-bold uppercase tracking-widest text-slate-400">Ref:
                                #INV-{{ $rental->id }}{{ date("mY") }}</p>
                        </div>
                        <div class="text-right">
                            <span
                                class="badge badge-lg {{ $rental->status_pembayaran == "pending" ? "bg-amber-400 text-amber-900" : "bg-emerald-500 text-white" }} rounded-xl border-none px-6 py-4 font-bold">
                                {{ strtoupper(str_replace("_", " ", $rental->status_pembayaran)) }}
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
                                <span class="font-medium uppercase italic tracking-tight text-slate-500">Armada</span>
                                <span
                                    class="font-black italic text-emerald-600 underline decoration-2 underline-offset-4">{{ $rental->vehicle->merek }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 py-2">
                                <div class="rounded-2xl bg-slate-50 p-4">
                                    <span class="block text-[10px] font-bold uppercase text-slate-400">Tanggal Pinjam</span>
                                    <span
                                        class="text-sm font-black italic text-slate-700">{{ date("d M Y", strtotime($rental->tanggal_peminjaman)) }}</span>
                                </div>
                                <div class="rounded-2xl border-l-4 border-emerald-500 bg-slate-50 p-4">
                                    <span class="block text-[10px] font-bold uppercase text-slate-400">Tanggal
                                        Kembali</span>
                                    <span
                                        class="text-sm font-black italic text-slate-700">{{ date("d M Y", strtotime($rental->tanggal_pengembalian)) }}</span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-x-8 gap-y-4 pt-4">
                                <div>
                                    <label
                                        class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Sewa/Hari</label>
                                    <p class="font-bold italic text-slate-700">Rp
                                        {{ number_format($rental->vehicle->harga_perhari, 0, ",", ".") }}</p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Lama
                                        Sewa</label>
                                    <p class="font-bold italic text-slate-700">{{ $selisihHari }} Hari</p>
                                </div>
                                <div>
                                    <label
                                        class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Denda/Hari</label>
                                    <p class="font-bold italic text-red-500">Rp
                                        {{ number_format($rental->vehicle->denda_perhari, 0, ",", ".") }}</p>
                                </div>
                                <div>
                                    <label
                                        class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Keterlambatan</label>
                                    <p class="{{ $totalTelat > 0 ? "text-red-500" : "text-slate-700" }} font-bold italic">
                                        {{ $totalTelat }} Hari</p>
                                </div>
                            </div>

                            <div
                                class="mt-6 flex items-center justify-between rounded-3xl bg-slate-900 px-6 py-4 shadow-xl shadow-slate-200">
                                <span class="text-xs font-black uppercase italic tracking-widest text-white">Bukti
                                    Bayar</span>
                                @if (!empty($rental->bukti_pembayaran))
                                    <a href="{{ asset("file/" . $rental->bukti_pembayaran) }}" target="_blank"
                                        class="btn btn-sm rounded-xl border-none bg-emerald-500 text-[10px] font-black uppercase italic text-white transition-all hover:bg-emerald-600">
                                        <i class="fa-solid fa-image mr-1"></i> Lihat Bukti
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
                                        Pembayaran</p>
                                    <h3 class="mt-1 text-3xl font-black italic leading-none tracking-tighter">Rp
                                        {{ number_format($totalHarga, 0, ",", ".") }}</h3>
                                </div>
                                <a href="{{ url("struk/" . $rental->id) }}"
                                    class="btn rounded-2xl border-none bg-white/20 text-xs font-black uppercase italic text-white shadow-lg backdrop-blur-md transition-all hover:bg-white hover:text-emerald-700">
                                    <i class="fa-solid fa-print mr-2"></i> Print
                                </a>
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
                        <i class="fa-solid fa-credit-card text-3xl"></i>
                    </div>

                    <h3 class="mb-2 text-xl font-black uppercase italic tracking-tight text-slate-800">Informasi Pembayaran
                    </h3>
                    <p class="mb-8 text-sm italic text-slate-500">Silakan lakukan pembayaran via transfer bank untuk
                        konfirmasi pesanan Anda.</p>

                    <div class="mb-10 space-y-4">
                        <div
                            class="group cursor-default rounded-3xl border border-slate-100 bg-slate-50 p-5 transition-all hover:border-emerald-200">
                            <p class="mb-1 text-[10px] font-black uppercase italic tracking-widest text-slate-400">Bank Dana
                            </p>
                            <p
                                class="text-lg font-black italic tracking-tight text-slate-800 transition-colors group-hover:text-emerald-600">
                                0856 4959 8578</p>
                        </div>
                        <div
                            class="group cursor-default rounded-3xl border border-slate-100 bg-slate-50 p-5 transition-all hover:border-emerald-200">
                            <p class="mb-1 text-[10px] font-black uppercase italic tracking-widest text-slate-400">Bank BNI
                            </p>
                            <p
                                class="text-lg font-black italic tracking-tight text-slate-800 transition-colors group-hover:text-emerald-600">
                                0794 8037 85</p>
                        </div>
                    </div>

                    <form action="{{ url("upload-pembayaran/" . $rental->id) }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <div class="form-control">
                            <label class="label text-xs font-black uppercase italic tracking-widest text-slate-500">Pilih
                                Berkas Bukti (JPG/PNG)</label>
                            <input type="file" name="bukti_pembayaran" required accept="image/*"
                                class="file-input file-input-bordered h-14 w-full rounded-2xl border-slate-200 bg-white font-bold italic text-slate-600" />
                        </div>

                        <button type="submit"
                            class="btn h-14 w-full rounded-2xl border-none bg-slate-900 text-base font-black uppercase italic tracking-tighter text-white shadow-xl shadow-slate-200 transition-all hover:bg-slate-800 active:scale-95">
                            <i class="fa-solid fa-cloud-arrow-up mr-2 text-emerald-400"></i> Upload Bukti Pembayaran
                        </button>
                    </form>

                    <p class="mt-8 text-[10px] font-bold uppercase italic leading-relaxed tracking-wider text-slate-400">
                        Pastikan nominal transfer sesuai dengan total pembayaran untuk mempercepat proses verifikasi admin.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
