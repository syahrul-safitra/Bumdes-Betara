<div class="sticky top-0 z-50 border-b shadow-sm navbar bg-base-100/80 backdrop-blur-md px-4 md:px-10 border-base-200">
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </div>
            <ul tabindex="0"
                class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-xl bg-base-100 rounded-2xl w-64 border border-base-100 font-medium">
                <li><a href="/" class="py-3">Beranda</a></li>
                <li><a href="/profil" class="py-3">Profil</a></li>
                {{-- <li><a href="/dokumentasi-desa" class="py-3">Berita</a></li> --}}
                <li>
                    <button onclick="panduan_modal.showModal()"
                        class="hover:text-emerald-600 rounded-xl transition-all flex items-center gap-1.5 focus:bg-transparent active:bg-transparent">
                        <i class="fa-solid fa-circle-info text-sm text-emerald-500"></i>
                        <span>Cara Rental</span>
                    </button>
                </li>
                <li>
                    <button onclick="panduan_spp_modal.showModal()"
                        class="hover:text-emerald-600 rounded-xl transition-all flex items-center gap-1.5 focus:bg-transparent active:bg-transparent">
                        <i class="fa-solid fa-circle-nodes text-sm text-emerald-500"></i>
                        <span>Cara SPP</span>
                    </button>
                </li>

                <li><a href="/rental-kendaraan" class="py-3">Rental</a></li>
            </ul>
        </div>

        {{-- Logo --}}
        <a href="/" class="flex items-center gap-3 transition-all hover:scale-105 active:scale-95">
            <div
                class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center rounded-xl shadow-lg shadow-emerald-200 overflow-hidden">
                {{-- Huruf "B" dihapus, diganti dengan logo --}}
                <img src="{{ asset('Img/logo_betaraa.png') }}" alt="Logo B"
                    class="w-full h-full object-contain p-1.5">
            </div>
            <div class="flex flex-col leading-none hidden sm:flex">
                <span class="font-black text-xl tracking-tighter text-slate-800">BUMDes</span>
                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-[0.2em]">Bersama Betara</span>
            </div>
        </a>
    </div>

    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 font-bold text-slate-500 gap-2 items-center">
            <li><a href="/" class="hover:text-emerald-600 rounded-xl transition-all">Beranda</a></li>
            <li><a href="/profil" class="hover:text-emerald-600 rounded-xl transition-all">Profil</a></li>
            {{-- <li><a href="/dokumentasi-desa" class="hover:text-emerald-600 rounded-xl transition-all">Berita</a> --}}
            </li>
            <li><a href="/rental-kendaraan" class="hover:text-emerald-600 rounded-xl transition-all">Rental</a></li>

            {{-- Tombol Pemicu Modal Panduan Baru --}}
            <li>
                <button onclick="panduan_modal.showModal()"
                    class="hover:text-emerald-600 rounded-xl transition-all flex items-center gap-1.5 focus:bg-transparent active:bg-transparent">
                    <i class="fa-solid fa-circle-info text-sm text-emerald-500"></i>
                    <span>Cara Rental</span>
                </button>
            </li>

            <li>
                <button onclick="panduan_spp_modal.showModal()"
                    class="hover:text-emerald-600 rounded-xl transition-all flex items-center gap-1.5 focus:bg-transparent active:bg-transparent">
                    <i class="fa-solid fa-circle-nodes text-sm text-emerald-500"></i>
                    <span>Cara SPP</span>
                </button>
            </li>
        </ul>
    </div>

    <div class="navbar-end gap-4">

        @auth('customer')
            {{-- Tampilan Jika Sudah Login --}}
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button"
                    class="btn btn-ghost flex items-center gap-3 px-2 rounded-2xl hover:bg-slate-100">
                    <div class="flex flex-col items-end hidden md:flex">
                        <span class="text-xs font-bold text-slate-800">{{ auth('customer')->user()->nama }}</span>
                        <span class="text-[9px] uppercase tracking-widest text-emerald-600 font-black">Customer</span>
                    </div>
                    <div class="avatar">
                        <div class="w-10 rounded-xl ring ring-emerald-500 ring-offset-base-100 ring-offset-2">
                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode(auth('customer')->user()->nama) }}&background=10b981&color=fff" />
                        </div>
                    </div>
                </div>
                <ul tabindex="0"
                    class="mt-3 z-[1] p-2 shadow-2xl menu menu-sm dropdown-content bg-base-100 rounded-2xl w-56 border border-slate-50">
                    <div class="px-4 py-3 border-b border-slate-50 mb-2">
                        <p class="text-xs font-bold text-slate-400 uppercase">Menu Akun</p>
                    </div>
                    <li>
                        <a href="{{ url('/riwayat-sewa') }}" class="py-3 flex items-center gap-3 group">
                            <div
                                class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <span class="font-bold text-slate-700">Riwayat Sewa</span>
                        </a>
                    </li>
                    <li>
                        <form action="{{ url('/logout') }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" class="py-3 flex items-center gap-3 group w-full text-left">
                                <div
                                    class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-all">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                </div>
                                <span class="font-bold text-red-600">Logout</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            {{-- Tampilan Jika Belum Login --}}
            <a href="/login"
                class="btn bg-emerald-600 hover:bg-emerald-700 border-none text-white btn-sm px-8 rounded-xl shadow-lg shadow-emerald-100 normal-case font-bold transition-all hover:-translate-y-0.5">
                Login
            </a>
        @endauth
    </div>
</div>

<dialog id="panduan_modal" class="modal modal-bottom sm:modal-middle backdrop-blur-sm">
    <div class="modal-box rounded-[2.5rem] bg-white p-8 max-w-xl border border-slate-100 shadow-2xl">

        {{-- Header Modal --}}
        <div class="flex items-start justify-between mb-6">
            <div>
                <h3 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                    <span class="p-2 bg-emerald-50 text-emerald-600 rounded-xl"><i class="fa-solid fa-route"></i></span>
                    Panduan & Tata Cara Sewa
                </h3>
                <p class="text-xs text-slate-400 mt-1 uppercase font-black tracking-widest">BUBERTA RENT</p>
            </div>
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost text-slate-400 hover:bg-slate-100">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </form>
        </div>

        {{-- Alur & Prosedur Transaksi --}}
        <div class="space-y-6">

            {{-- Tahap 1: Registrasi --}}
            <div class="flex gap-4 relative">
                <div class="absolute left-4 top-10 bottom-0 w-[2px] bg-slate-100 z-0"></div>
                <div
                    class="w-9 h-9 bg-emerald-500 text-white rounded-xl font-black flex items-center justify-center flex-shrink-0 z-10 shadow-md shadow-emerald-100 italic">
                    1
                </div>
                <div class="space-y-1 pt-1">
                    <h4 class="font-black text-slate-800 text-sm">Registrasi Akun Sesuai Tipe</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Buka halaman pendaftaran, pilih tipe keanggotaan Anda:
                    </p>
                    <div class="flex gap-2 mt-2">
                        <span
                            class="badge badge-sm border-none bg-emerald-50 text-emerald-700 font-bold text-[10px] py-2 px-3">
                            <i class="fa-solid fa-user mr-1 text-[9px]"></i> INDIVIDU: Siapkan KTP
                        </span>
                        <span
                            class="badge badge-sm border-none bg-indigo-50 text-indigo-700 font-bold text-[10px] py-2 px-3">
                            <i class="fa-solid fa-building mr-1 text-[9px]"></i> PERUSAHAAN: Siapkan NPWP
                        </span>
                    </div>
                </div>
            </div>

            {{-- Tahap 2: Skema Pilihan Paket Sewa (Harian vs Bulanan) --}}
            <div class="flex gap-4 relative">
                <div class="absolute left-4 top-10 bottom-0 w-[2px] bg-slate-100 z-0"></div>
                <div
                    class="w-9 h-9 bg-emerald-500 text-white rounded-xl font-black flex items-center justify-center flex-shrink-0 z-10 shadow-md shadow-emerald-100 italic">
                    2
                </div>
                <div class="space-y-2 pt-1">
                    <h4 class="font-black text-slate-800 text-sm">Pilih Armada & Ketentuan Durasi</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Pilih unit mobil pada katalog, lalu tentukan tipe kontrak sewa yang Anda butuhkan:
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-1">
                        {{-- Aturan Sewa Harian --}}
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/60">
                            <span class="text-[10px] uppercase font-black text-emerald-600 block mb-0.5"><i
                                    class="fa-solid fa-calendar-day"></i> Kontrak Harian</span>
                            <p class="text-[11px] font-medium text-slate-600 leading-relaxed">
                                Keterlambatan pengembalian armada dihitung <strong class="text-slate-800">per
                                    hari</strong> berdasarkan nominal tarif denda tetap yang telah disepakati bersama.
                            </p>
                        </div>
                        {{-- Aturan Sewa Bulanan --}}
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/60">
                            <span class="text-[10px] uppercase font-black text-indigo-600 block mb-0.5"><i
                                    class="fa-solid fa-calendar-days"></i> Kontrak Bulanan</span>
                            <p class="text-[11px] font-medium text-slate-600 leading-relaxed">
                                Penyewa dapat melakukan <strong class="text-slate-800">DP minimal 20%</strong> di awal
                                kontrak. Klausul mutlak: segala bentuk kerusakan unit ditanggung sepenuhnya oleh
                                penyewa.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tahap 3: Syarat Dokumen & Validasi Berkas --}}
            <div class="flex gap-4 relative">
                <div class="absolute left-4 top-10 bottom-0 w-[2px] bg-slate-100 z-0"></div>
                <div
                    class="w-9 h-9 bg-emerald-500 text-white rounded-xl font-black flex items-center justify-center flex-shrink-0 z-10 shadow-md shadow-emerald-100 italic">
                    3
                </div>
                <div class="space-y-2 pt-1">
                    <h4 class="font-black text-slate-800 text-sm">Upload Identitas & Pembayaran</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Penyewa wajib mengunggah berkas identitas (<span class="font-bold text-slate-700">KTP /
                            NPWP</span>) beserta <span class="font-bold text-slate-700">alamat lengkap domisili</span>.
                        Pembayaran tunai divalidasi oleh petugas hingga status berubah menjadi <span
                            class="badge badge-xs border-none bg-emerald-500 text-white font-black uppercase text-[9px] px-1.5 py-1">Lunas</span>
                        / DP Terverifikasi.
                    </p>

                    <div class="flex flex-wrap gap-2 pt-1">
                        <span
                            class="badge badge-sm border-none bg-emerald-50 text-emerald-700 font-bold text-[10px] py-2 px-3">
                            <i class="fa-solid fa-money-bill-wave mr-1.5 text-emerald-600"></i> Pembayaran Tunai (Cash)
                        </span>
                        <span
                            class="badge badge-sm border-none bg-indigo-50 text-indigo-700 font-bold text-[10px] py-2 px-3">
                            <i class="fa-solid fa-file-invoice mr-1.5 text-indigo-600"></i> Wajib Berkas Valid
                        </span>
                    </div>
                </div>
            </div>

            {{-- Tahap 4: Serah Terima Kendaraan --}}
            <div class="flex gap-4">
                <div
                    class="w-9 h-9 bg-emerald-500 text-white rounded-xl font-black flex items-center justify-center flex-shrink-0 z-10 shadow-md shadow-emerald-100 italic">
                    4
                </div>
                <div class="space-y-2 pt-1">
                    <h4 class="font-black text-slate-800 text-sm">Pengambilan Unit Armada</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Silakan datang ke pool kantor BUMDES untuk serah terima unit dengan memperlihatkan
                        dokumen penunjang asli:
                    </p>
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-3 space-y-2">
                        <div class="flex items-center gap-2 text-[11px]">
                            <i class="fa-solid fa-id-card text-emerald-500 w-4"></i>
                            <span class="text-slate-600"><strong class="text-slate-800">Individu:</strong>
                                Memperlihatkan KTP asli & SIM A pengemudi.</span>
                        </div>
                        <div class="flex items-center gap-2 text-[11px]">
                            <i class="fa-solid fa-file-contract text-indigo-500 w-4"></i>
                            <span class="text-slate-600"><strong class="text-slate-800">Perusahaan:</strong> Membawa
                                NPWP atau surat resmi dari PT terkait.</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Footer Aksi --}}
        <div class="modal-action mt-8 flex justify-end">
            <form method="dialog">
                <button
                    class="btn bg-slate-900 hover:bg-slate-800 text-white border-none rounded-2xl px-8 font-black uppercase italic tracking-widest text-xs">
                    Saya Mengerti
                </button>
            </form>
        </div>
    </div>

    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>


<!-- Modal Panduan Tata Cara Simpan Pinjam (SPP) -->
<dialog id="panduan_spp_modal" class="modal modal-bottom sm:modal-middle backdrop-blur-sm">
    <div class="modal-box max-w-2xl rounded-[2rem] border border-slate-100 bg-white p-6 md:p-8 shadow-2xl">

        <!-- Header Modal -->
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-emerald-600 shadow-inner">
                    <i class="fa-solid fa-book-open text-xl"></i>
                </div>
                <div class="text-left">
                    <h3 class="text-lg font-black uppercase italic tracking-tight text-slate-800">
                        Panduan Prosedur & Aturan SPP
                    </h3>
                    <p class="text-[11px] font-medium text-slate-400 italic">Sistem Informasi Simpan Pinjam Perempuan
                        BUMDes Betara</p>
                </div>
            </div>

            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost text-slate-400 focus:outline-none">✕</button>
            </form>
        </div>

        <!-- Persyaratan Utama Kelompok -->
        <div class="mb-5 p-4 bg-amber-50/60 border border-amber-200/70 rounded-2xl text-left">
            <h4 class="text-xs font-black uppercase tracking-wider text-amber-800 flex items-center gap-1.5 mb-1.5">
                <i class="fa-solid fa-circle-exclamation text-amber-600"></i> Syarat Kelayakan Kelompok
            </h4>
            <ul class="text-[11px] font-medium text-slate-600 list-disc list-inside space-y-1">
                <li>Anggota kelompok wajib khusus <strong class="text-slate-800">perempuan</strong> domisili Desa
                    Betara (tanggung renteng).</li>
                <li>Ketua wajib mengunggah <strong class="text-slate-800">Foto KTP</strong> pengurus serta seluruh
                    daftar anggota.</li>
                <li>Akun kelompok harus melalui <strong class="text-slate-800">Validasi & Persetujuan Lapangan</strong>
                    oleh Admin BUMDes.</li>
            </ul>
        </div>

        <!-- Body / Konten Langkah Alur -->
        <div class="rounded-3xl border border-slate-100 bg-slate-50/70 p-5 md:p-6 text-left">
            <ol class="space-y-6 list-none p-0 m-0">

                <!-- Langkah 1 -->
                <li class="relative pl-12">
                    <span
                        class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-600 text-sm font-black text-white shadow-md shadow-indigo-100">1</span>
                    <h5 class="text-sm font-black uppercase tracking-tight text-slate-800 mb-0.5">Pengajuan Modal Usaha
                    </h5>
                    <p class="text-xs font-medium leading-relaxed text-slate-600 m-0">
                        Ketua kelompok mengisi formulir pengajuan pinjaman pada sistem, menentukan batas nominal <span
                            class="font-bold text-slate-800">Plafon Kontrak</span>, menentukan tenor bulanan, serta
                        menyertakan rincian rencana usaha.
                    </p>
                </li>

                <!-- Langkah 2 -->
                <li class="relative pl-12">
                    <span
                        class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-600 text-sm font-black text-white shadow-md shadow-indigo-100">2</span>
                    <h5 class="text-sm font-black uppercase tracking-tight text-slate-800 mb-0.5">Verifikasi Kelayakan
                        & Jasa Program</h5>
                    <p class="text-xs font-medium leading-relaxed text-slate-600 m-0">
                        Admin memeriksa rekam jejak pengajuan. Jika disetujui, sistem otomatis menerbitkan
                        kartu angsuran resmi berkala dengan kalkulasi suku bunga program sebesar <span
                            class="font-bold text-indigo-600">0.5% per bulan</span>.
                    </p>
                </li>

                <!-- Langkah 3 -->
                <li class="relative pl-12">
                    <span
                        class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-600 text-sm font-black text-white shadow-md shadow-indigo-100">3</span>
                    <h5 class="text-sm font-black uppercase tracking-tight text-slate-800 mb-0.5">Mekanisme Pencairan
                        Bertahap</h5>
                    <p class="text-xs font-medium leading-relaxed text-slate-600 m-0">
                        Dana dicairkan melalui dua fase utama: <span class="font-bold text-slate-800">Cair Awal sebesar
                            Rp 2.000.000</span> sebagai modal awal stimulus, kemudian sisa saldo plafon kontrak penuh
                        (<span class="font-bold text-indigo-600">Cair Penuh</span>) akan dibuka gemboknya setelah
                        pemantauan berkas dinyatakan produktif.
                    </p>
                </li>

                <!-- Langkah 4 -->
                <li class="relative pl-12">
                    <span
                        class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-xl bg-red-500 text-sm font-black text-white shadow-md shadow-red-100">4</span>
                    <h5 class="text-sm font-black uppercase tracking-tight text-red-600 mb-0.5">Ketentuan Setoran &
                        Sanksi Denda</h5>
                    <p class="text-xs font-medium leading-relaxed text-slate-600 m-0">
                        Pembayaran cicilan dilakukan tunai kepada petugas. Kelompok yang terlambat menyetor melewati
                        batas tanggal jatuh tempo akan dikenakan denda kumulatif otomatis dari sistem sebesar <span
                            class="font-bold text-red-600">Rp 5.000 / hari</span> hingga angsuran bulan bersangkutan
                        dilunasi.
                    </p>
                </li>

            </ol>
        </div>

        <!-- Footer Modal Button Close -->
        <div class="modal-action mt-6 justify-end">
            <form method="dialog">
                <button
                    class="btn min-h-[46px] h-[46px] rounded-2xl border-none bg-slate-900 px-6 font-black text-xs uppercase italic tracking-wider text-white shadow-lg shadow-slate-100 transition-all active:scale-95">
                    Saya Mengerti
                </button>
            </form>
        </div>

    </div>

    <!-- Lapisan backdrop klik di luar modal untuk menutup -->
    <form method="dialog" class="modal-backdrop bg-slate-900/40 backdrop-blur-sm">
        <button>close</button>
    </form>
</dialog>
