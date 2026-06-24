<div class="drawer-side z-40">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
    <aside class="menu min-h-full w-72 bg-slate-900 p-6 text-slate-300 flex flex-col">

        {{-- Header Brand --}}
        <div class="mb-10 mt-2 flex items-center gap-3 px-4">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-2xl bg-indigo-600 shadow-lg shadow-indigo-600/30 overflow-hidden">
                <img src="{{ asset('Img/logo_betaraa.png') }}" alt="Logo Betara"
                    class="h-full w-full object-contain p-1.5">
            </div>
            <div>
                <h1 class="text-xl font-black tracking-tight text-white">BUBERTA</h1>
                <p class="text-[10px] font-bold uppercase leading-none tracking-[0.2em] text-indigo-400">Ketua Kelompok
                </p>
            </div>
        </div>

        {{-- Main Menu --}}
        <p class="mb-4 px-4 text-[10px] font-bold uppercase tracking-widest text-slate-500">Main Menu</p>
        <ul class="space-y-2 flex-1">

            {{-- 1. Dashboard Utama --}}
            <li>
                <a href="{{ url('/spp-dashboard') }}"
                    class="rounded-2xl p-4 font-bold transition-all flex items-center {{ Request::is('spp-dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i
                        class="fa-solid fa-gauge w-6 {{ Request::is('spp-dashboard') ? 'text-white' : 'text-slate-500' }}"></i>
                    Dashboard
                </a>
            </li>

            <li class="pt-4 px-4 text-[10px] font-black uppercase tracking-widest text-indigo-400 italic">Manajemen SPP
            </li>

            {{-- 2. Menu Lengkapi Profil Kelompok (Tahap 2) --}}
            <li>
                <a href="{{ url('/spp-group-rev') }}"
                    class="rounded-2xl p-4 font-bold transition-all flex items-center {{ Request::is('spp-group-rev*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i
                        class="fa-solid fa-building-user w-6 {{ Request::is('spp-group-rev*') ? 'text-white' : 'text-slate-500' }}"></i>
                    Profil Kelompok
                </a>
            </li>

            {{-- 3. Menu Data Anggota Kelompok (Tahap 3) --}}
            {{-- <li>
                <a href="{{ url('/group/members') }}"
                    class="rounded-2xl p-4 font-bold transition-all flex items-center {{ Request::is('group/members*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'hover:bg-slate-800 hover:text-white' }}">
                    <i
                        class="fa-solid fa-user-group w-6 {{ Request::is('group/members*') ? 'text-white' : 'text-slate-500' }}"></i>
                    Data Anggota
                </a>
            </li> --}}

            {{-- 4. Menu Pengajuan & Riwayat Pinjaman (Tahap 5 & 6) --}}

            @if (auth()->guard('spp')->user()->status_validasi === 'valid')
                <li>
                    <a href="{{ url('/spp-group-loan') }}"
                        class="rounded-2xl p-4 font-bold transition-all flex items-center {{ Request::is('spp-group-loan*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'hover:bg-slate-800 hover:text-white' }}">

                        {{-- Ikon diganti ke fa-file-invoice-dollar untuk membedakan dengan menu pinjaman berjalan --}}
                        <i
                            class="fa-solid fa-file-invoice-dollar w-6 {{ Request::is('spp-group-loan*') ? 'text-white' : 'text-slate-500' }}"></i>

                        Pengajuan Pinjaman
                    </a>
                </li>

                <li>
                    {{-- href diarahkan ke rute daftar pinjaman kelompok yang sinkron dengan controller --}}
                    <a href="{{ url('/spp-group-all') }}"
                        class="rounded-2xl p-4 font-bold transition-all flex items-center gap-1 {{ Request::is('group/my-loans*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-900/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                        <i
                            class="fa-solid fa-hand-holding-dollar w-6 text-base transition-colors {{ Request::is('group/my-loans*') ? 'text-white' : 'text-slate-500 group-hover:text-white' }}"></i>

                        <span>Pinjaman Saya</span>
                    </a>
                </li>
            @endif


        </ul>

        {{-- Footer Identitas Login Ketua --}}
        <div class="mt-auto pt-10">
            <div class="rounded-3xl border border-slate-700/50 bg-slate-800/50 p-4 relative overflow-hidden">
                <p class="mb-1 text-[10px] uppercase font-black tracking-wider text-slate-500">Ketua Kelompok:</p>
                <p class="text-sm font-bold text-white truncate">
                    {{ auth()->guard('spp')->user()->nama_ketua }}
                </p>
                <p class="text-[11px] text-indigo-400 font-semibold truncate mt-0.5">
                    {{ auth()->guard('spp')->user()->nama_kelompok }}
                </p>

                {{-- Indikator Status Validasi Akun --}}
                <div class="mt-3 pt-2 border-t border-slate-700/50 flex items-center justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">Status Berkas:</span>
                    @if (auth()->guard('spp')->user()->status_validasi == 'valid')
                        <span class="badge badge-success badge-sm text-[10px] font-bold text-white px-2">Valid</span>
                    @elseif(auth()->guard('spp')->user()->status_validasi == 'ditolak')
                        <span class="badge badge-error badge-sm text-[10px] font-bold text-white px-2">Ditolak</span>
                    @else
                        <span
                            class="badge badge-warning badge-sm text-[10px] font-bold text-slate-900 px-2">Pending</span>
                    @endif
                </div>
            </div>

            {{-- Tombol Logout --}}
            {{-- <form action="{{ url('/group/logout') }}" method="POST" class="mt-3">
                @csrf
                <button type="submit"
                    class="btn btn-sm w-full rounded-xl bg-red-600/10 hover:bg-red-600 text-red-500 hover:text-white border-none transition-all text-xs font-bold">
                    <i class="fa-solid fa-right-from-bracket mr-1.5"></i> Keluar Aplikasi
                </button>
            </form> --}}
        </div>

    </aside>
</div>
