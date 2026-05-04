<div class="drawer-side z-40">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
    <aside class="menu min-h-full w-72 bg-slate-900 p-6 text-slate-300">
        <div class="mb-10 mt-2 flex items-center gap-3 px-4">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500 shadow-lg shadow-emerald-500/30 overflow-hidden">
                {{-- Ikon lama dihapus --}}

                {{-- Gunakan w-full h-full dan object-contain agar logo menyesuaikan kotak secara proporsional --}}
                <img src="{{ asset('Img/logo_betaraa.png') }}" alt="Logo Betara"
                    class="h-full w-full object-contain p-1.5">
            </div>
            <div>
                <h1 class="text-xl font-black tracking-tight text-white">BUBERTA</h1>
                <p class="text-[10px] font-bold uppercase leading-none tracking-[0.2em] text-emerald-500">Admin Panel
                </p>
            </div>
        </div>

        <p class="mb-4 px-4 text-[10px] font-bold uppercase tracking-widest text-slate-500">Main Menu</p>
        <ul class="space-y-2">
            {{-- Dashboard --}}
            <li>
                <a href="{{ url('/dashboard') }}"
                    class="rounded-2xl p-4 font-bold transition-all {{ Request::is('dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/20' : 'hover:bg-slate-800 hover:text-white' }}">

                    <i
                        class="fa-solid fa-gauge w-6 {{ Request::is('dashboard') ? 'text-white' : 'text-slate-500' }}"></i>
                    Dashboard
                </a>
            </li>

            @if (auth()->guard('admin')->user()->is_admin)
                {{-- Dokumentasi --}}
                <li>
                    <a href="{{ url('/dokumentasi') }}"
                        class="rounded-2xl p-4 font-bold transition-all {{ Request::is('dokumentasi*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i
                            class="fa-solid fa-newspaper w-6 {{ Request::is('dokumentasi*') ? 'text-white' : 'text-slate-500' }}"></i>
                        Dokumentasi
                    </a>
                </li>

                {{-- Kendaraan --}}
                <li>
                    <a href="{{ url('/vehicle') }}"
                        class="rounded-2xl p-4 font-bold transition-all {{ Request::is('vehicle*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i
                            class="fa-solid fa-car-side w-6 {{ Request::is('vehicle*') ? 'text-white' : 'text-slate-500' }}"></i>
                        Kendaraan
                    </a>
                </li>

                {{-- Rental --}}
                <li>
                    <a href="{{ url('/rental') }}"
                        class="rounded-2xl p-4 font-bold transition-all {{ Request::is('rental*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i
                            class="fa-solid fa-calendar-check w-6 {{ Request::is('rental*') ? 'text-white' : 'text-slate-500' }}"></i>
                        Rental Kendaraan
                    </a>
                </li>

                {{-- Customer --}}
                <li>
                    <a href="{{ url('/customer') }}"
                        class="rounded-2xl p-4 font-bold transition-all {{ Request::is('customer*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i
                            class="fa-solid fa-user-group w-6 {{ Request::is('customer*') ? 'text-white' : 'text-slate-500' }}"></i>
                        Customer
                    </a>
                </li>
                {{-- Set Admin --}}
                <li>
                    <a href="{{ url('/admin') }}"
                        class="rounded-2xl p-4 font-bold transition-all {{ Request::is('admin*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i
                            class="fa-solid fa-user-group w-6 {{ Request::is('admin*') ? 'text-white' : 'text-slate-500' }}"></i>
                        Set Admin
                    </a>
                </li>
            @else
                {{-- Rental --}}
                <li>
                    <a href="{{ url('/rental') }}"
                        class="rounded-2xl p-4 font-bold transition-all {{ Request::is('rental*') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                        <i
                            class="fa-solid fa-calendar-check w-6 {{ Request::is('rental*') ? 'text-white' : 'text-slate-500' }}"></i>
                        Rental Kendaraan
                    </a>
                </li>
            @endif
        </ul>

        <div class="mt-auto pt-10">
            <div class="rounded-3xl border border-slate-700/50 bg-slate-800/50 p-4">
                <p class="mb-2 text-xs text-slate-400">Login sebagai:</p>
                <p class="text-sm font-bold uppercase tracking-wider text-white">
                    {{ auth()->guard('admin')->user()->name }}</p>
            </div>
        </div>
    </aside>
</div>
