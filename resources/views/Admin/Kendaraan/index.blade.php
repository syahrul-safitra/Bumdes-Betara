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
                            <th>Unit</th>
                            <th>Informasi</th>
                            <th>Harga & Denda</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($vehicles as $item)
                            <tr class="border-b border-slate-50 transition-colors hover:bg-slate-50/50">
                                <td class="px-6 py-4">
                                    {{-- Konten Unit (Merek & Plat) --}}
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
                                    {{-- Konten Informasi (Warna & Tahun) --}}
                                    <div class="space-y-1 text-xs text-slate-600">
                                        <p>Warna: <span class="font-semibold">{{ $item->warna }}</span></p>
                                        <p>Tahun: <span class="font-semibold">{{ $item->tahun }}</span></p>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-sm">
                                    {{-- Konten Harga --}}
                                    <div class="font-black text-slate-800 italic">
                                        Rp {{ number_format($item->harga_perhari, 0, ',', '.') }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    {{-- Konten Aksi --}}
                                    {{-- Konten Aksi --}}
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ url('/vehicle/' . $item->id . '/edit') }}"
                                            class="btn btn-square btn-sm btn-ghost bg-slate-100 text-slate-600 hover:bg-amber-100 hover:text-amber-600 transition-colors">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        {{-- Tombol Delete --}}
                                        <button type="button"
                                            onclick="openDeleteModal('{{ $item->id }}', '{{ $item->merek }} ({{ $item->no_plat }})')"
                                            class="btn btn-square btn-sm btn-ghost bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-all">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
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

    {{-- <script>
        
    </script> --}}

    <script>
        // Fungsi Modal Delete (Gunakan merek & plat yang sudah dikirim)
        function openDeleteModal(id, info) {
            const modal = document.getElementById('delete_modal');
            const form = document.getElementById('delete_form');
            const titleSpan = document.getElementById('delete_item_title');

            titleSpan.innerText = info;
            form.action = '/vehicle/' + id;
            modal.showModal();
        }
    </script>
@endsection
