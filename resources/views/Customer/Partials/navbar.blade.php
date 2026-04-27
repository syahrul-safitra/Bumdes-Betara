<div class="sticky top-0 z-50 shadow-md navbar bg-base-100 px-4 md:px-10 border-b border-base-200">
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </div>
            <ul tabindex="0"
                class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-200">
                <li><a>Beranda</a></li>
                <li><a href="{{ url('/profile') }}">Profil</a></li>
                <li><a href="{{ url('/dokumentasi-desa') }}">Dokumentasi</a></li>
                <li><a>Rental Kendaraan</a></li>
            </ul>
        </div>

        <a href="/" class="flex items-center gap-3 transition-all hover:opacity-80">
            <div
                class="w-10 h-10 bg-emerald-600 text-white flex items-center justify-center rounded-xl shadow-inner font-bold text-xl">
                ZC
            </div>
            <div class="flex flex-col leading-tight hidden sm:flex">
                <span class="font-bold text-lg text-emerald-800">BUMDes</span>
                <span class="text-xs font-medium text-slate-500 uppercase tracking-widest">Bersama Betara</span>
            </div>
        </a>
    </div>

    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 font-semibold text-slate-600 gap-1">
            <li><a href="/" class="hover:text-emerald-600 focus:text-emerald-600">Beranda</a></li>
            <li><a href="/profil" class="hover:text-emerald-600 focus:text-emerald-600">Profil</a></li>
            <li><a href="/dokumentasi-desa" class="hover:text-emerald-600 focus:text-emerald-600">Dokumentasi</a></li>
        </ul>
    </div>

    <div class="navbar-end gap-3">
        <a href="/login"
            class="btn btn-primary btn-sm px-8 rounded-lg shadow-md hover:shadow-lg transition-all normal-case">
            Login
        </a>
    </div>
</div>
