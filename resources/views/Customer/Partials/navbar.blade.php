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
                <li><a href="/dokumentasi-desa" class="py-3">Dokumentasi</a></li>
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
        <ul class="menu menu-horizontal px-1 font-bold text-slate-500 gap-2">
            <li><a href="/" class="hover:text-emerald-600 rounded-xl transition-all">Beranda</a></li>
            <li><a href="/profil" class="hover:text-emerald-600 rounded-xl transition-all">Profil</a></li>
            <li><a href="/dokumentasi-desa" class="hover:text-emerald-600 rounded-xl transition-all">Dokumentasi</a>
            </li>
            <li><a href="/rental-kendaraan" class="hover:text-emerald-600 rounded-xl transition-all">Rental</a></li>
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
