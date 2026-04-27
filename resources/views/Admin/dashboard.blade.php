<main class="p-6 lg:p-10 space-y-10">

    <div class="text-sm breadcrumbs p-0 text-slate-400">
        <ul>
            <li>Admin</li>
            <li class="text-emerald-600 font-semibold">Dashboard</li>
        </ul>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                [
                    'label' => 'Total Berita',
                    'val' => '24',
                    'icon' => 'fa-newspaper',
                    'color' => 'bg-blue-500',
                ],
                [
                    'label' => 'Unit Kendaraan',
                    'val' => '12',
                    'icon' => 'fa-car',
                    'color' => 'bg-emerald-500',
                ],
                ['label' => 'Rental Aktif', 'val' => '05', 'icon' => 'fa-key', 'color' => 'bg-purple-500'],
                ['label' => 'Customer', 'val' => '1.2k', 'icon' => 'fa-users', 'color' => 'bg-orange-500'],
            ];
        @endphp

        @foreach ($stats as $s)
            <div
                class="relative group bg-white p-6 rounded-[2rem] shadow-sm hover:shadow-xl transition-all duration-300 border border-slate-100">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-slate-400 font-medium text-sm">{{ $s['label'] }}</p>
                        <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $s['val'] }}</h3>
                    </div>
                    <div
                        class="{{ $s['color'] }} w-12 h-12 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-inherit">
                        <i class="fa-solid {{ $s['icon'] }}"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-xs font-bold text-emerald-600">
                    <i class="fa-solid fa-arrow-up mr-1"></i> 12% <span class="text-slate-400 font-normal ml-1">dari
                        bulan lalu</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h3 class="font-bold text-xl text-slate-800">Transaksi Rental Terbaru</h3>
            <div class="join">
                <input class="input input-sm input-bordered join-item rounded-l-full px-4" placeholder="Cari nama..." />
                <button
                    class="btn btn-sm btn-emerald-600 border-none text-white join-item rounded-r-full px-6">Cari</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-lg">
                <thead class="bg-slate-50/50 text-slate-500">
                    <tr>
                        <th class="font-bold uppercase text-[11px] tracking-widest">Customer</th>
                        <th class="font-bold uppercase text-[11px] tracking-widest">Kendaraan</th>
                        <th class="font-bold uppercase text-[11px] tracking-widest text-center">Status</th>
                        <th class="font-bold uppercase text-[11px] tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-slate-600">
                    <tr class="hover:bg-slate-50/80 transition-all">
                        <td>
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold">
                                    AJ</div>
                                <div>
                                    <div class="font-bold text-slate-800">Ahmad Junaidi</div>
                                    <div class="text-[11px] opacity-50">#TRX-99210</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="font-semibold">Toyota Avanza</span>
                            <br /><span class="badge badge-sm badge-ghost">B 1234 ABC</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-emerald-100 text-emerald-700 border-none font-bold p-3">Active</span>
                        </td>
                        <td class="text-right">
                            <button class="btn btn-ghost btn-circle btn-sm"><i
                                    class="fa-solid fa-ellipsis-vertical"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</main>
