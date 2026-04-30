@extends("Admin.Layouts.main")

@section("content")
    {{-- Container dibuat max-w-5xl agar konsisten lebarnya dengan halaman Create Anda --}}
    <main class="space-y-8 p-6 lg:p-10">

        @if (session()->has("success"))
            <div
                class="animate-in fade-in slide-in-from-top-4 mb-8 flex items-center justify-between rounded-3xl border border-emerald-100 bg-emerald-50/50 p-4 shadow-sm duration-500">
                <div class="flex items-center gap-4">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-200">
                        <i class="fa-solid fa-check text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-widest text-emerald-600">Berhasil</p>
                        <p class="font-bold text-slate-700">{{ session("success") }}</p>
                    </div>
                </div>
                <button onclick="this.parentElement.remove()"
                    class="btn btn-ghost btn-circle btn-sm text-emerald-600 hover:bg-emerald-100">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        {{-- Header Section --}}
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ url("/rental") }}" class="btn btn-ghost btn-circle border border-slate-100 bg-white shadow-sm">
                    <i class="fa-solid fa-arrow-left text-slate-600"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-800 lg:text-3xl">Detail <span
                            class="text-emerald-600">Transaksi</span></h1>
                    <p class="text-sm text-slate-500">Rincian penyewaan armada BUBERTA RENT.</p>
                </div>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="overflow-hidden rounded-[2.5rem] border border-slate-100 bg-white shadow-xl shadow-slate-200/50">
            <div class="p-8 lg:p-12">

                {{-- Grid Utama: Lebar Kiri dan Kanan Seimbang --}}
                <div class="grid grid-cols-1 gap-12 lg:grid-cols-2">

                    {{-- Kolom Kiri: Detail Informasi --}}
                    <div class="space-y-8">
                        <section>
                            <h3
                                class="mb-4 flex items-center gap-2 text-xs font-black uppercase tracking-widest text-emerald-600">
                                <i class="fa-solid fa-user-tag text-emerald-500"></i> Identitas Penyewa
                            </h3>
                            <div class="space-y-4 rounded-3xl border border-slate-100 bg-slate-50 p-6">
                                <div class="flex justify-between border-b border-slate-200/50 pb-2">
                                    <span class="text-slate-500">Nama Lengkap</span>
                                    <span class="font-bold text-slate-800">{{ $rental->customer->nama }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-slate-500">Unit Kendaraan</span>
                                    <span class="font-bold text-emerald-700">{{ $rental->vehicle->merek }}</span>
                                </div>
                            </div>
                        </section>

                        <section>
                            <h3
                                class="mb-4 flex items-center gap-2 text-xs font-black uppercase tracking-widest text-emerald-600">
                                <i class="fa-solid fa-calendar-days text-emerald-500"></i> Periode Sewa
                            </h3>
                            {{-- Grid diubah menjadi 3 kolom untuk menampung tanggal dikembalikan --}}
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div class="rounded-2xl border border-slate-100 p-4">
                                    <p class="text-[10px] font-bold uppercase text-slate-400">Tanggal Pinjam</p>
                                    <p class="text-lg font-black text-slate-700">
                                        {{ date("d M Y", strtotime($rental->tanggal_peminjaman)) }}
                                    </p>
                                </div>
                                <div class="rounded-2xl border border-slate-100 p-4">
                                    <p class="text-[10px] font-bold uppercase text-slate-400">Estimasi Kembali</p>
                                    <p class="text-lg font-black text-slate-700">
                                        {{ date("d M Y", strtotime($rental->tanggal_pengembalian)) }}
                                    </p>
                                </div>
                                {{-- Field Tanggal Dikembalikan (Realisasi) --}}
                                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/30 p-4">
                                    <p class="text-[10px] font-bold uppercase text-emerald-600/60">Tgl. Dikembalikan</p>
                                    <p class="text-lg font-black text-emerald-700">
                                        @if ($rental->tanggal_dikembalikan)
                                            {{ date("d M Y", strtotime($rental->tanggal_dikembalikan)) }}
                                        @else
                                            <span class="font-medium italic text-slate-300">Belum Ada</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </section>
                    </div>

                    {{-- Kolom Kanan: Rincian Biaya & Status --}}
                    <div class="flex flex-col justify-between space-y-6">
                        <div class="rounded-[2rem] bg-slate-900 p-8 text-white shadow-2xl shadow-slate-300">
                            <div class="mb-6 flex items-center justify-between">
                                <h3 class="text-xs font-black uppercase tracking-widest text-emerald-400">Billing Summary
                                </h3>
                                <span
                                    class="badge badge-sm border-none bg-emerald-500 font-bold text-white">{{ $selisihHari }}
                                    Hari</span>
                            </div>

                            <div class="space-y-4">
                                <div class="flex justify-between text-slate-400">
                                    <span>Harga Sewa ({{ $selisihHari }}x)</span>
                                    <span>Rp {{ number_format($rental->vehicle->harga_perhari, 0, ",", ".") }}</span>
                                </div>

                                <div class="flex justify-between text-orange-400">
                                    <div class="flex flex-col">
                                        <span>Denda Keterlambatan</span>
                                        {{-- Keterangan Telat Hari --}}
                                        @if ($totalTelat * -1 > 0)
                                            <span
                                                class="text-[10px] font-bold uppercase italic tracking-tighter text-orange-300">
                                                (Terlambat {{ $totalTelat }} Hari)
                                            </span>
                                        @endif
                                    </div>
                                    <span>+ Rp {{ number_format($totalDenda, 0, ",", ".") }}</span>
                                </div>
                                {{-- <div class="flex justify-between text-orange-400">
                                    <span>Denda Keterlambatan</span>
                                    <span>+ Rp {{ number_format($totalDenda, 0, ",", ".") }}</span>
                                </div> --}}
                                <div class="mt-6 flex items-center justify-between border-t border-slate-800 pt-6">
                                    <span class="text-lg font-bold text-emerald-400">Grand Total</span>
                                    <span class="text-3xl font-black">Rp
                                        {{ number_format($totalHarga + $totalDenda, 0, ",", ".") }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            @empty($rental->tanggal_dikembalikan)
                                <label for="modal_status_rental"
                                    class="btn btn-outline rounded-2xl border-slate-200 font-bold text-slate-600 hover:border-emerald-600 hover:bg-emerald-600 hover:text-white">
                                    <i class="fa-solid fa-arrows-rotate mr-2"></i> Status Unit
                                </label>
                            @endempty
                            <label for="modal_status_pembayaran"
                                class="btn btn-outline rounded-2xl border-slate-200 font-bold text-slate-600 hover:border-emerald-600 hover:bg-emerald-600 hover:text-white">
                                <i class="fa-solid fa-wallet mr-2"></i> Status Bayar
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Row Bawah: Bukti & Tombol Simpan --}}
                <div
                    class="mt-12 flex flex-col items-center justify-between gap-6 border-t border-slate-50 pt-10 lg:flex-row">
                    <div class="flex items-center gap-4">
                        <div class="text-center lg:text-left">
                            <p class="text-[10px] font-black uppercase text-slate-400">Status Pembayaran</p>
                            <span
                                class="{{ $rental->status_pembayaran == "pending" ? "text-orange-500" : "text-emerald-600" }} text-xl font-black">
                                {{ strtoupper($rental->status_pembayaran) }}
                            </span>
                        </div>
                        <div class="hidden h-10 w-[1px] bg-slate-100 lg:block"></div>
                        <div class="text-center lg:text-left">
                            <p class="text-[10px] font-black uppercase text-slate-400">Status Rental</p>
                            <span class="text-xl font-black text-slate-700">
                                {{ strtoupper(str_replace("_", " ", $rental->status_rental)) }}
                            </span>
                        </div>
                    </div>

                    <div class="flex w-full flex-col gap-3 lg:w-auto lg:flex-row">
                        @if (!empty($rental->bukti_pembayaran))
                            <a href="{{ asset("file/" . $rental->bukti_pembayaran) }}" target="_blank"
                                class="btn rounded-2xl border-slate-200 bg-white px-6 font-bold text-slate-600 shadow-sm hover:bg-slate-50">
                                Lihat Bukti Bayar
                            </a>
                        @endif
                        {{-- <a href="{{ url("struk/" . $rental->id) }}"
                            class="btn rounded-2xl border-none bg-emerald-600 px-10 font-bold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700">
                            <i class="fa-solid fa-print mr-2"></i> Cetak Struk
                        </a> --}}
                    </div>
                </div>

            </div>
        </div>
    </main>

    {{-- Modal-modal diletakkan di luar main --}}

    <input type="checkbox" id="modal_status_rental" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box rounded-[2.5rem] border-none p-10 shadow-2xl">
            <h3 class="mb-6 text-2xl font-black text-slate-800">Update <span class="text-emerald-600">Progres</span></h3>

            {{-- Tambahkan id="formUpdateStatus" untuk dideteksi oleh JavaScript --}}
            <form id="formUpdateStatus" action="{{ url("set-status/" . $rental->id) }}" method="POST" class="space-y-3">
                @csrf
                @foreach (["belum_diambil", "sedang_dipinjam", "telah_dikembalikan"] as $status)
                    <label
                        class="group flex cursor-pointer items-center justify-between rounded-2xl border border-slate-100 bg-slate-50 p-5 transition-all hover:border-emerald-200 hover:bg-emerald-50">
                        <span class="font-bold capitalize text-slate-600 group-hover:text-emerald-700">
                            {{ str_replace("_", " ", $status) }}
                        </span>
                        <input type="radio" name="status_rental" value="{{ $status }}" class="radio radio-emerald"
                            @checked($rental->status_rental == $status) />
                    </label>
                @endforeach

                <div class="modal-action gap-3 pt-4">
                    <label for="modal_status_rental"
                        class="btn btn-ghost rounded-2xl border border-slate-100 px-8 font-bold text-slate-400">Batal</label>
                    <button type="submit"
                        class="btn rounded-2xl border-none bg-emerald-600 px-10 font-bold text-white shadow-lg shadow-emerald-100">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Permanen -->
    <input type="checkbox" id="modal_confirm_final" class="modal-toggle" />
    <div class="modal modal-bottom sm:modal-middle">
        <div class="modal-box rounded-[2.5rem] border-none p-10 shadow-2xl">
            <div
                class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-3xl bg-orange-100 text-orange-500 shadow-inner">
                <i class="fa-solid fa-triangle-exclamation text-4xl"></i>
            </div>

            <h3 class="text-center text-2xl font-black text-slate-800">Konfirmasi <span
                    class="text-orange-500">Final</span></h3>
            <p class="mt-4 text-center font-medium leading-relaxed text-slate-500">
                Status <span class="font-bold text-slate-800">"Telah Dikembalikan"</span> akan mengunci transaksi ini. Data
                tidak dapat diubah lagi demi konsistensi laporan. Lanjutkan?
            </p>

            <div class="modal-action flex justify-center gap-3 pt-6">
                <label for="modal_confirm_final"
                    class="btn btn-ghost rounded-2xl px-8 font-bold text-slate-400">Batal</label>
                <button type="button" id="btnExecuteSubmit"
                    class="btn rounded-2xl border-none bg-orange-500 px-10 font-bold text-white shadow-lg shadow-orange-100 hover:bg-orange-600">
                    Ya, Saya Yakin
                </button>
            </div>
        </div>
    </div>

    <script>
        const formStatus = document.getElementById('formUpdateStatus');
        const btnSubmitAwal = formStatus.querySelector('button[type="submit"]');
        const btnExecute = document.getElementById('btnExecuteSubmit');
        const checkboxModalUtama = document.getElementById('modal_status_rental');
        const checkboxModalConfirm = document.getElementById('modal_confirm_final');

        btnSubmitAwal.addEventListener('click', function(e) {
            e.preventDefault(); // Tahan form agar tidak langsung kirim

            const selectedStatus = document.querySelector('input[name="status_rental"]:checked').value;

            if (selectedStatus === 'telah_dikembalikan') {
                // Tutup modal pilih status, buka modal peringatan
                checkboxModalUtama.checked = false;
                setTimeout(() => {
                    checkboxModalConfirm.checked = true;
                }, 200); // Delay sedikit agar transisinya halus
            } else {
                // Jika status lain, langsung kirim
                formStatus.submit();
            }
        });

        // Eksekusi kirim form dari modal peringatan
        btnExecute.addEventListener('click', function() {
            formStatus.submit();
        });
    </script>

    <input type="checkbox" id="modal_status_pembayaran" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box rounded-[2.5rem] border-none p-10 shadow-2xl">
            <h3 class="mb-6 text-2xl font-black text-slate-800">Update <span class="text-emerald-600">Status Bayar</span>
            </h3>

            <form action="{{ url("set-pembayaran/" . $rental->id) }}" method="POST" class="space-y-3">
                @csrf

                {{-- Opsi Pending --}}
                <label
                    class="group flex cursor-pointer items-center justify-between rounded-2xl border border-slate-100 bg-slate-50 p-5 transition-all hover:border-orange-200 hover:bg-orange-50">
                    <span class="font-bold capitalize text-slate-600 group-hover:text-orange-700">Pending</span>
                    <input type="radio" name="status_pembayaran" value="pending" class="radio radio-warning"
                        @checked($rental->status_pembayaran == "pending") />
                </label>

                {{-- Opsi Telah Dibayar --}}
                <label
                    class="group flex cursor-pointer items-center justify-between rounded-2xl border border-slate-100 bg-slate-50 p-5 transition-all hover:border-emerald-200 hover:bg-emerald-50">
                    <span class="font-bold capitalize text-slate-600 group-hover:text-emerald-700">Telah Dibayar</span>
                    <input type="radio" name="status_pembayaran" value="telah_dibayar" class="radio radio-emerald"
                        @checked($rental->status_pembayaran == "telah_dibayar") />
                </label>

                <div class="modal-action gap-3 pt-4">
                    <label for="modal_status_pembayaran"
                        class="btn btn-ghost rounded-2xl px-8 font-bold text-slate-400">Batal</label>
                    <button type="submit"
                        class="btn rounded-2xl border-none bg-emerald-600 px-10 font-bold text-white shadow-lg shadow-emerald-100">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
