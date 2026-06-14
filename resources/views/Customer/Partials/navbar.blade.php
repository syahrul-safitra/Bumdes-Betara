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
                <li><a href="/dokumentasi-desa" class="py-3">Berita</a></li>
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
            <li><a href="/dokumentasi-desa" class="hover:text-emerald-600 rounded-xl transition-all">Berita</a>
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

<dialog id="panduan_modal" class="modal modal-bottom sm:modal-middle">
    <div class="modal-box rounded-[2.5rem] bg-white p-8 max-w-xl border border-slate-100 shadow-2xl">

        <div class="flex items-start justify-between mb-6">
            <div>
                <h3 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                    <span class="p-2 bg-emerald-50 text-emerald-600 rounded-xl"><i class="fa-solid fa-route"></i></span>
                    Panduan & Tata Cara Sewa
                </h3>
                <p class="text-xs text-slate-400 mt-1 uppercase font-black tracking-widest">Buberta Rent Armada</p>
            </div>
            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost text-slate-400 hover:bg-slate-100">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </form>
        </div>

        <div class="space-y-6">

            <div class="flex gap-4 relative">
                <div class="absolute left-4 top-10 bottom-0 w-[2px] bg-slate-100 z-0"></div>
                <div
                    class="w-9 h-9 bg-emerald-500 text-white rounded-xl font-black flex items-center justify-center flex-shrink-0 z-10 shadow-md shadow-emerald-100 italic">
                    1</div>
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

            <div class="flex gap-4 relative">
                <div class="absolute left-4 top-10 bottom-0 w-[2px] bg-slate-100 z-0"></div>
                <div
                    class="w-9 h-9 bg-emerald-500 text-white rounded-xl font-black flex items-center justify-center flex-shrink-0 z-10 shadow-md shadow-emerald-100 italic">
                    2</div>
                <div class="space-y-1 pt-1">
                    <h4 class="font-black text-slate-800 text-sm">Pilih Armada & Tentukan Tanggal</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Masuk ke katalog kendaraan, pilih unit mobil yang tersedia, lalu tentukan <span
                            class="font-bold text-slate-700">Tanggal Peminjaman</span> serta <span
                            class="font-bold text-slate-700">Tanggal Pengembalian</span>.
                    </p>
                </div>
            </div>

            <!-- Tahap 3: Konfirmasi & Pembayaran (Terupdate) -->
            <div class="flex gap-4 relative">
                <div class="absolute left-4 top-10 bottom-0 w-[2px] bg-slate-100 z-0"></div>
                <div
                    class="w-9 h-9 bg-emerald-500 text-white rounded-xl font-black flex items-center justify-center flex-shrink-0 z-10 shadow-md shadow-emerald-100 italic">
                    3
                </div>
                <div class="space-y-2 pt-1">
                    <h4 class="font-black text-slate-800 text-sm">Upload Identitas & Pembayaran Tunai</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Customer wajib mengunggah berkas identitas (<span class="font-bold text-slate-700">KTP /
                            NPWP</span>) beserta <span class="font-bold text-slate-700">alamat lengkap domisili</span>
                        saat melakukan rental. Pembayaran dilakukan secara tunai hingga status berubah menjadi
                        <span
                            class="badge badge-xs border-none bg-emerald-500 text-white font-black uppercase text-[9px] px-1.5 py-1">LUNAS</span>.
                    </p>

                    {{-- Keterangan Metode Pembayaran Resmi --}}
                    <div class="flex flex-wrap gap-2 pt-1">
                        <span
                            class="badge badge-sm border-none bg-emerald-50 text-emerald-700 font-bold text-[10px] py-2 px-3">
                            <i class="fa-solid fa-money-bill-wave mr-1.5 text-emerald-600"></i> Hanya Pembayaran Tunai
                            (Cash)
                        </span>
                        <span
                            class="badge badge-sm border-none bg-indigo-50 text-indigo-700 font-bold text-[10px] py-2 px-3">
                            <i class="fa-solid fa-file-invoice mr-1.5 text-indigo-600"></i> Wajib Berkas & Alamat
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex gap-4">
                <div
                    class="w-9 h-9 bg-emerald-500 text-white rounded-xl font-black flex items-center justify-center flex-shrink-0 z-10 shadow-md shadow-emerald-100 italic">
                    4</div>
                <div class="space-y-2 pt-1">
                    <h4 class="font-black text-slate-800 text-sm">Pengambilan Unit Armada</h4>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Datang ke lokasi kantor BUMDes/Buberta Rent untuk serah terima unit dengan membawa dokumen asli
                        saat status operasional Anda:
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
                                Surat Kuasa asli/Surat Tugas dari PT terkait.</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

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
<dialog id="panduan_spp_modal" class="modal modal-bottom sm:modal-middle">
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
                        Panduan Alur Pengajuan SPP
                    </h3>
                    <p class="text-[11px] font-medium text-slate-400 italic">Sistem Informasi Simpan Pinjam Kelompok
                        BUMDes Betara</p>
                </div>
            </div>

            <form method="dialog">
                <button class="btn btn-sm btn-circle btn-ghost text-slate-400 focus:outline-none">✕</button>
            </form>
        </div>

        <!-- Body / Konten Langkah -->
        <div class="rounded-3xl border border-slate-100 bg-slate-50/70 p-5 md:p-6 text-left">
            <ol class="space-y-6 list-none p-0 m-0">

                <!-- Langkah 1 -->
                <li class="relative pl-12">
                    <span
                        class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-600 text-sm font-black text-white shadow-md shadow-indigo-100">1</span>
                    <h5 class="text-sm font-black uppercase tracking-tight text-slate-800 mb-0.5">Verifikasi Domisili &
                        Kelompok</h5>
                    <p class="text-xs font-medium leading-relaxed text-slate-600 m-0">
                        Calon peminjam wajib terdaftar secara sah sebagai warga Desa Betara dan mengajukan pinjaman
                        melalui sistem kelompok (tanggung renteng).
                    </p>
                </li>

                <!-- Langkah 2 -->
                <li class="relative pl-12">
                    <span
                        class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-600 text-sm font-black text-white shadow-md shadow-indigo-100">2</span>
                    <h5 class="text-sm font-black uppercase tracking-tight text-slate-800 mb-0.5">Validasi Dokumen
                        Utama</h5>
                    <p class="text-xs font-medium leading-relaxed text-slate-600 m-0">
                        Peminjam mempersiapkan Dokumen Kartu Tanda Penduduk (KTP) asli dan salinannya sebagai syarat
                        administrasi tunggal.
                    </p>
                </li>

                <!-- Langkah 3 -->
                <li class="relative pl-12">
                    <span
                        class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-600 text-sm font-black text-white shadow-md shadow-indigo-100">3</span>
                    <h5 class="text-sm font-black uppercase tracking-tight text-slate-800 mb-0.5">Pengisian Form &
                        Dokumen Kredit</h5>
                    <p class="text-xs font-medium leading-relaxed text-slate-600 m-0">
                        Mengisi formulir pengajuan pinjaman, menentukan batas plafon dana, serta memilih tenor (durasi)
                        angsuran yang disediakan sistem.
                    </p>
                </li>

                <!-- Langkah 4 -->
                <li class="relative pl-12">
                    <span
                        class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-600 text-sm font-black text-white shadow-md shadow-indigo-100">4</span>
                    <h5 class="text-sm font-black uppercase tracking-tight text-slate-800 mb-0.5">Keputusan &
                        Persetujuan (Approval)</h5>
                    <p class="text-xs font-medium leading-relaxed text-slate-600 m-0">
                        Ketua BUMDes memberikan keputusan akhir berupa persetujuan penuh, penyesuaian nominal plafon,
                        atau penolakan pengajuan berdasarkan data dokumen.
                    </p>
                </li>

                <!-- Langkah 5 -->
                <li class="relative pl-12">
                    <span
                        class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-600 text-sm font-black text-white shadow-md shadow-indigo-100">5</span>
                    <h5 class="text-sm font-black uppercase tracking-tight text-slate-800 mb-0.5">Pencairan Dana Tahap
                        Awal</h5>
                    <p class="text-xs font-medium leading-relaxed text-slate-600 m-0">
                        Peminjam menandatangani akad kredit, kemudian menerima pencairan dana stimulus awal sebesar
                        <span class="font-bold text-slate-800">Rp 2.000.000</span> (secara tunai atau transfer).
                    </p>
                </li>

                <!-- Langkah 6 -->
                <li class="relative pl-12">
                    <span
                        class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-xl bg-indigo-600 text-sm font-black text-white shadow-md shadow-indigo-100">6</span>
                    <h5 class="text-sm font-black uppercase tracking-tight text-slate-800 mb-0.5">Pencairan Saldo Sisa
                        Kredit</h5>
                    <p class="text-xs font-medium leading-relaxed text-slate-600 m-0">
                        Setelah peminjam menyelesaikan pembayaran angsuran pertama secara tertib, sisa saldo plafon
                        pinjaman akan dicairkan seluruhnya.
                    </p>
                </li>

                <!-- Langkah 7 -->
                <li class="relative pl-12">
                    <span
                        class="absolute left-0 top-0 flex h-8 w-8 items-center justify-center rounded-xl bg-red-500 text-sm font-black text-white shadow-md shadow-red-100">7</span>
                    <h5 class="text-sm font-black uppercase tracking-tight text-red-600 mb-0.5">Sanksi Keterlambatan
                        Angsuran</h5>
                    <p class="text-xs font-medium leading-relaxed text-slate-600 m-0">
                        Anggota yang terlambat membayar angsuran bulanan melewati batas tanggal jatuh tempo akan
                        dikenakan denda akumulatif sebesar <span class="font-bold text-red-600">Rp 5.000 / hari</span>.
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
    <form method="dialog" class="modal-backdrop bg-slate-900/40 backdrop-blur-xs">
        <button>close</button>
    </form>
</dialog>
