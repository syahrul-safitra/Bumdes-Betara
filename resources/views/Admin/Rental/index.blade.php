@extends('Admin.Layouts.main')

@section('content')
    <main class="space-y-8 p-6 lg:p-10">


        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-black text-slate-800 lg:text-3xl">Daftar <span class="text-emerald-600">Rental</span>
                </h1>
                <p class="text-sm text-slate-500">Kelola transaksi dan operasional armada Buberta Rent.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                {{-- Form Pencarian Baru --}}
                <form action="{{ url()->current() }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau armada..."
                        class="input input-bordered w-full max-w-xs rounded-2xl bg-white pl-10 focus:border-emerald-500 focus:outline-none shadow-sm border-slate-200 text-sm">
                    <i
                        class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                </form>

                @if (!auth()->guard('admin')->user()->is_admin)
                    <button onclick="report_modal.showModal()"
                        class="btn rounded-2xl border-none bg-slate-900 px-6 text-xs font-black uppercase italic tracking-widest text-white shadow-lg shadow-slate-200 transition-all hover:bg-slate-800 active:scale-95">
                        <i class="fa-solid fa-print mr-2 text-emerald-400"></i> Cetak Laporan
                    </button>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div role="alert"
                class="alert flex items-center rounded-2xl border-emerald-200 bg-emerald-100 text-emerald-800 shadow-sm">
                <i class="fa-solid fa-circle-check text-xl text-emerald-600"></i>
                <div class="flex flex-col">
                    <span class="text-sm font-bold">Berhasil!</span>
                    <span class="text-xs opacity-90">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="btn btn-ghost btn-xs btn-circle ml-auto">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-error rounded-2xl border-none bg-red-100 font-bold italic text-red-800 shadow-lg">
                <i class="fa-solid fa-circle-xmark text-xl"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Table Card Container -->
        <div class="overflow-hidden rounded-[2.5rem] border border-slate-100 bg-white shadow-xl">
            <div class="overflow-x-auto p-4">
                <table id="rentalTable" class="table-zebra table w-full whitespace-nowrap">

                    @if (auth()->guard('admin')->user()->is_admin)
                        <!-- head -->
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="bg-white text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                    No
                                </th>
                                <th class="bg-white text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                    Customer</th>
                                <th class="bg-white text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                    Armada</th>
                                <th class="bg-white text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                    Durasi Sewa</th>
                                <th
                                    class="bg-white text-center text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                    Status Operasional</th>
                                <th
                                    class="bg-white text-center text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                    Status Bayar</th>
                                <th
                                    class="bg-white text-center text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="font-medium italic text-slate-600">
                            @foreach ($rentals as $item)
                                <tr class="transition-colors hover:bg-slate-50/50">
                                    <td class="text-xs font-bold text-slate-400">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar placeholder">
                                                {{-- <div class="w-10 rounded-xl bg-slate-100 text-slate-400 shadow-inner">
                                                    <span
                                                        class="text-xs font-black uppercase">{{ substr($item->customer->nama, 0, 2) }}</span>
                                                </div> --}}
                                            </div>
                                            <div>
                                                <div class="text-sm font-black tracking-tight text-slate-800">
                                                    {{ $item->customer->nama }}</div>
                                                <div
                                                    class="text-[10px] font-bold uppercase italic tracking-tighter opacity-50">
                                                    Client ID: #{{ $item->customer->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-ghost border-slate-200 py-3 text-xs font-black italic">{{ $item->vehicle->merek }}</span>
                                    </td>
                                    <td>
                                        <div class="space-y-1 text-xs">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-calendar-plus text-[10px] text-emerald-500"></i>
                                                <span>{{ date('d/m/y', strtotime($item->tanggal_peminjaman)) }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-calendar-check text-[10px] text-red-400"></i>
                                                <span>{{ date('d/m/y', strtotime($item->tanggal_pengembalian)) }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->status_rental == 'belum_diambil')
                                            <span
                                                class="badge border-none bg-amber-100 px-4 py-3 text-[10px] font-black uppercase italic tracking-tighter text-amber-700">Belum
                                                Diambil</span>
                                        @elseif($item->status_rental == 'sedang_dipinjam')
                                            <span
                                                class="badge border-none bg-sky-100 px-4 py-3 text-[10px] font-black uppercase italic tracking-tighter text-sky-700">Sudah
                                                Diambil</span>
                                        @else
                                            <span
                                                class="badge border-none bg-emerald-100 px-4 py-3 text-[10px] font-black uppercase italic tracking-tighter text-emerald-700">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($item->status_pembayaran == 'pending')
                                            <span
                                                class="badge border-none bg-red-100 px-4 py-3 text-[10px] font-black uppercase italic tracking-tighter text-red-700">Pending</span>
                                        @else
                                            <span
                                                class="badge border-none bg-emerald-500 px-4 py-3 text-[10px] font-black uppercase italic tracking-tighter text-white">Lunas</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ url('rental/' . $item->id . '/edit') }}"
                                                class="btn btn-square btn-sm rounded-xl border-none bg-amber-400 text-amber-900 shadow-md shadow-amber-100 transition-all hover:bg-amber-500">
                                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                                            </a>
                                            <button type="button"
                                                onclick="openDeleteModal('{{ $item->id }}', '{{ $item->customer->nama }}')"
                                                class="btn btn-square btn-sm rounded-xl border-none bg-red-100 text-red-600 shadow-md shadow-red-50 transition-all hover:bg-red-200">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @else
                        <!-- head -->
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="bg-white text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                    No
                                </th>
                                <th class="bg-white text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                    Customer</th>
                                <th class="bg-white text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                    Armada</th>
                                <th class="bg-white text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                    Durasi Sewa</th>
                                <th
                                    class="bg-white text-center text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                    Status Operasional</th>
                                <th
                                    class="bg-white text-center text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                    Status Bayar</th>
                            </tr>
                        </thead>
                        <tbody class="font-medium italic text-slate-600">
                            @foreach ($rentals as $item)
                                <tr class="transition-colors hover:bg-slate-50/50">
                                    <td class="text-xs font-bold text-slate-400">{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="flex items-center space-x-3">
                                            <div class="avatar placeholder">
                                                {{-- <div class="w-10 rounded-xl bg-slate-100 text-slate-400 shadow-inner">
                                                    <span
                                                        class="text-xs font-black uppercase">{{ substr($item->customer->nama, 0, 2) }}</span>
                                                </div> --}}
                                            </div>
                                            <div>
                                                <div class="text-sm font-black tracking-tight text-slate-800">
                                                    {{ $item->customer->nama }}</div>
                                                <div
                                                    class="text-[10px] font-bold uppercase italic tracking-tighter opacity-50">
                                                    Client ID: #{{ $item->customer->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-ghost border-slate-200 py-3 text-xs font-black italic">{{ $item->vehicle->merek }}</span>
                                    </td>
                                    <td>
                                        <div class="space-y-1 text-xs">
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-calendar-plus text-[10px] text-emerald-500"></i>
                                                <span>{{ date('d/m/y', strtotime($item->tanggal_peminjaman)) }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-calendar-check text-[10px] text-red-400"></i>
                                                <span>{{ date('d/m/y', strtotime($item->tanggal_pengembalian)) }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->status_rental == 'belum_diambil')
                                            <span
                                                class="badge border-none bg-amber-100 px-4 py-3 text-[10px] font-black uppercase italic tracking-tighter text-amber-700">Belum
                                                Diambil</span>
                                        @elseif($item->status_rental == 'sedang_dipinjam')
                                            <span
                                                class="badge border-none bg-sky-100 px-4 py-3 text-[10px] font-black uppercase italic tracking-tighter text-sky-700">Sudah
                                                Diambil</span>
                                        @else
                                            <span
                                                class="badge border-none bg-emerald-100 px-4 py-3 text-[10px] font-black uppercase italic tracking-tighter text-emerald-700">Selesai</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($item->status_pembayaran == 'pending')
                                            <span
                                                class="badge border-none bg-red-100 px-4 py-3 text-[10px] font-black uppercase italic tracking-tighter text-red-700">Pending</span>
                                        @else
                                            <span
                                                class="badge border-none bg-emerald-500 px-4 py-3 text-[10px] font-black uppercase italic tracking-tighter text-white">Lunas</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>


                <div class="border-t border-slate-50 bg-slate-50/50 p-6">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                            Menampilkan {{ $rentals->firstItem() ?? 0 }} - {{ $rentals->lastItem() ?? 0 }} dari
                            {{ $rentals->total() }} Data
                        </p>
                        <div class="pagination-container">
                            {{ $rentals->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <dialog id="delete_modal" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box rounded-[2.5rem] border border-slate-100 bg-white p-10 shadow-2xl">
            <div class="flex flex-col items-center space-y-4 text-center">
                <div
                    class="mb-2 flex h-20 w-20 items-center justify-center rounded-3xl bg-red-50 text-red-500 shadow-inner">
                    <i class="fa-solid fa-triangle-exclamation text-3xl"></i>
                </div>

                <h3 class="text-2xl font-black text-slate-800">Hapus Data Rental?</h3>
                <p class="text-slate-500">
                    Anda akan menghapus data transaksi milik <br>
                    <span id="delete_item_name" class="font-bold italic text-slate-800"></span>. <br>
                    <span class="mt-2 block text-xs font-medium uppercase italic tracking-widest text-red-400">Tindakan ini
                        permanen!</span>
                </p>
            </div>

            <div class="modal-action mt-10 flex justify-center gap-3">
                <form method="dialog">
                    <button class="btn btn-ghost rounded-2xl px-8 font-bold text-slate-400">Batal</button>
                </form>

                <form id="delete_form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="btn rounded-2xl border-none bg-red-600 px-10 font-bold text-white shadow-lg shadow-red-100 hover:bg-red-700">
                        Ya, Hapus Data
                    </button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop bg-slate-900/40 backdrop-blur-sm">
            <button>close</button>
        </form>
    </dialog>

    <!-- Modal Cetak Laporan (DaisyUI Modal) -->
    <dialog id="report_modal" class="modal">
        <div class="modal-box max-w-sm rounded-[2.5rem] bg-white p-8">
            <div class="mb-6 flex items-center justify-between">
                <h3 class="text-xl font-black uppercase italic tracking-tighter text-slate-800">Cetak Laporan</h3>
                <form method="dialog">
                    <button class="btn btn-sm btn-circle btn-ghost">✕</button>
                </form>
            </div>

            <p class="mb-6 text-sm italic text-slate-500">Tentukan periode laporan yang ingin Anda unduh.</p>

            <form action="{{ url('laporan') }}" method="POST" class="space-y-4">
                @csrf
                <div class="form-control">
                    <label class="label text-[10px] font-black uppercase italic text-slate-400">Tanggal Awal</label>
                    <input type="date" name="tanggal_awal" required
                        class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 font-bold italic text-slate-600 focus:outline-emerald-500" />
                </div>
                <div class="form-control">
                    <label class="label text-[10px] font-black uppercase italic text-slate-400">Tanggal Akhir</label>
                    <input type="date" name="tanggal_akhir" required
                        class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 font-bold italic text-slate-600 focus:outline-emerald-500" />
                </div>

                <div class="space-y-2 pt-4">
                    <button type="submit"
                        class="btn w-full rounded-2xl border-none bg-slate-900 font-black uppercase italic tracking-tighter text-white hover:bg-slate-800">
                        Proses Laporan
                    </button>
                </div>
            </form>
        </div>
        <form method="dialog" class="modal-backdrop">
            <button>close</button>
        </form>
    </dialog>


    <script>
        function openDeleteModal(id, customerName) {
            // 1. Set nama customer ke elemen span id="delete_item_name"
            const nameSpan = document.getElementById('delete_item_name');
            if (nameSpan) {
                nameSpan.innerText = customerName;
            }

            // 2. Set action URL pada form agar mengarah ke route destroy yang tepat
            const deleteForm = document.getElementById('delete_form');
            if (deleteForm) {
                // Sesuaikan URL rute hapus sesuai dengan konfigurasi web.php Anda (misal: /rental atau /rental-mobil)
                deleteForm.action = '/rental/' + id;
            }

            // 3. Tampilkan modal menggunakan fungsi bawaan DaisyUI/HTML5 Dialog
            const modal = document.getElementById('delete_modal');
            if (modal) {
                modal.showModal();
            }
        }
    </script>
@endsection
