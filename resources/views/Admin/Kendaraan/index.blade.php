@extends('Admin.Layouts.main')

@section('content')
    <main class="space-y-8 p-6 lg:p-10">

        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-2xl font-black text-slate-800 lg:text-3xl">Daftar <span class="text-emerald-600">Armada</span>
                </h1>
                <p class="text-sm text-slate-500">Total {{ $vehicles->count() }} unit kendaraan tersedia di BUBERTA RENT.
                </p>
            </div>
            <a href="{{ url('/vehicle/create') }}"
                class="btn rounded-2xl border-none bg-emerald-600 px-6 font-bold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Unit Baru
            </a>
        </div>

        @if (session('success'))
            <div role="alert"
                class="alert bg-emerald-100 border-emerald-200 text-emerald-800 rounded-2xl flex items-center shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-xl"></i>
                <div class="flex flex-col">
                    <span class="font-bold text-sm">Berhasil!</span>
                    <span class="text-xs opacity-90">{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" class="btn btn-ghost btn-xs btn-circle ml-auto">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        <div class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-xl shadow-slate-200/50">
            <div class="overflow-x-auto">
                <table class="table table-zebra w-full">
                    <thead class="bg-slate-50/50">
                        <tr class="border-b border-slate-100 text-slate-600">
                            <th class="px-6 py-5 font-black uppercase tracking-wider text-[11px]">Unit</th>
                            <th class="px-6 py-5 font-black uppercase tracking-wider text-[11px]">Informasi</th>
                            <th class="px-6 py-5 font-black uppercase tracking-wider text-[11px]">Harga & Denda</th>
                            <th class="px-6 py-5 font-black uppercase tracking-wider text-[11px] text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($vehicles as $item)
                            <tr class="border-b border-slate-50 transition-colors hover:bg-slate-50/50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="avatar">
                                            <div class="mask mask-squircle h-16 w-16 shadow-sm">
                                                <img src="{{ asset('File/' . $item->gambar) }}" alt="{{ $item->merek }}" />
                                            </div>
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-800">{{ $item->merek }}</div>
                                            <div class="text-xs font-bold text-emerald-600 uppercase tracking-widest">
                                                {{ $item->no_plat }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2 text-xs text-slate-600">
                                            <i class="fa-solid fa-palette w-4 text-slate-300"></i>
                                            <span>Warna: <span class="font-semibold">{{ $item->warna }}</span></span>
                                        </div>
                                        <div class="flex items-center gap-2 text-xs text-slate-600">
                                            <i class="fa-solid fa-calendar-days w-4 text-slate-300"></i>
                                            <span>Tahun: <span class="font-semibold">{{ $item->tahun }}</span></span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="space-y-1">
                                        <div class="text-sm font-black text-slate-800 italic">
                                            Rp {{ number_format($item->harga_perhari, 0, ',', '.') }} <span
                                                class="text-[10px] font-normal text-slate-400 not-italic">/Hari</span>
                                        </div>
                                        <div class="text-[11px] font-bold text-red-500 flex items-center gap-1">
                                            <i class="fa-solid fa-clock-rotate-left"></i>
                                            Denda: Rp {{ number_format($item->denda_perhari, 0, ',', '.') }}/jam
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ url('/vehicle/' . $item->id . '/edit') }}"
                                            class="btn btn-square btn-sm btn-ghost bg-slate-100 text-slate-600 hover:bg-yellow-100 hover:text-yellow-600">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <button type="button"
                                            onclick="openDeleteModal('{{ $item->id }}', '{{ $item->merek }} ({{ $item->no_plat }})')"
                                            class="btn btn-square btn-sm btn-ghost bg-red-50 text-red-500 hover:bg-red-500 hover:text-white">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-0">
                                    <div class="flex flex-col items-center justify-center py-20 text-center">
                                        <div class="bg-slate-50 p-6 rounded-full mb-4">
                                            <i class="fa-solid fa-car-side text-4xl text-slate-200"></i>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-800">Belum Ada Armada</h3>
                                        <p class="text-sm text-slate-400 max-w-xs mx-auto">Mulai tambahkan kendaraan untuk
                                            disewakan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <dialog id="delete_modal" class="modal">
        <div class="modal-box rounded-[2rem] p-8 bg-white">
            <div class="text-center space-y-4">
                <div class="bg-red-50 text-red-500 p-4 rounded-full w-16 h-16 flex items-center justify-center mx-auto">
                    <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                </div>
                <h3 class="font-black text-xl text-slate-800">Hapus Armada?</h3>
                <p class="text-slate-500 text-sm">Data unit <span id="delete_item_title"
                        class="font-bold text-red-500"></span> akan dihapus permanen dan data rental akan ikut terhapus.</p>
            </div>
            <div class="modal-action flex justify-center gap-3 mt-6">
                <form method="dialog">
                    <button class="btn btn-ghost rounded-2xl px-8 font-bold">Batal</button>
                </form>
                <form id="delete_form" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="btn bg-red-500 hover:bg-red-600 border-none text-white rounded-2xl px-8 font-bold">Hapus
                        Sekarang</button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop"><button>close</button></form>
    </dialog>

    <script>
        function openDeleteModal(id, title) {
            const modal = document.getElementById('delete_modal');
            const form = document.getElementById('delete_form');
            const titlePlaceholder = document.getElementById('delete_item_title');

            form.action = `/vehicle/${id}`;
            titlePlaceholder.innerText = title;
            modal.showModal();
        }
    </script>
@endsection
