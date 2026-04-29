<div class="drawer-side z-40">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
    <aside class="menu min-h-full w-72 bg-slate-900 p-6 text-slate-300">
        <div class="mb-10 mt-2 flex items-center gap-3 px-4">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500 text-white shadow-lg shadow-emerald-500/30">
                <i class="fa-solid fa-leaf text-lg"></i>
            </div>
            <div>
                <h1 class="text-xl font-black tracking-tight text-white">BUBERTA</h1>
                <p class="text-[10px] font-bold uppercase leading-none tracking-[0.2em] text-emerald-500">Admin
                    Panel</p>
            </div>
        </div>

        <p class="mb-4 px-4 text-[10px] font-bold uppercase tracking-widest text-slate-500">Main Menu</p>
        <ul class="space-y-2">
            <li><a class="rounded-2xl bg-emerald-600 p-4 font-bold text-white shadow-lg shadow-emerald-900/20"><i
                        class="fa-solid fa-grid-2 w-6"></i> Dashboard</a></li>
            <li><a href="{{ url('/dokumentasi') }}"
                    class="rounded-2xl p-4 transition-all hover:bg-slate-800 hover:text-white"><i
                        class="fa-solid fa-newspaper w-6 text-slate-500"></i> Dokumentasi</a></li>
            <li><a href="{{ url('/vehicle') }}"
                    class="rounded-2xl p-4 transition-all hover:bg-slate-800 hover:text-white"><i
                        class="fa-solid fa-car-side w-6 text-slate-500"></i> Kendaraan</a></li>
            <li><a class="rounded-2xl p-4 transition-all hover:bg-slate-800 hover:text-white"><i
                        class="fa-solid fa-calendar-check w-6 text-slate-500"></i> Rental Kendaraan</a></li>
            <li><a class="rounded-2xl p-4 transition-all hover:bg-slate-800 hover:text-white"><i
                        class="fa-solid fa-user-group w-6 text-slate-500"></i> Customer</a></li>
        </ul>

        <div class="mt-auto pt-10">
            <div class="rounded-3xl border border-slate-700/50 bg-slate-800/50 p-4">
                <p class="mb-2 text-xs text-slate-400">Login sebagai:</p>
                <p class="text-sm font-bold uppercase tracking-wider text-white">Syahrul - Developer</p>
            </div>
        </div>
    </aside>
</div>
