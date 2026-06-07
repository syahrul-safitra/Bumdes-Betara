@extends('Admin.Layouts.main')

@section('content')
    <main class="space-y-8 p-6 lg:p-10">

        <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-black tracking-tighter text-slate-800">Data <span
                        class="text-emerald-600">Customer</span></h1>
                <p class="text-sm font-medium text-slate-500">Kelola informasi pelanggan dan verifikasi identitas.</p>
            </div>

            {{-- Form Pencarian --}}
            <form action="{{ url()->current() }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau No. HP..."
                    class="input input-bordered w-full max-w-xs rounded-2xl bg-white pl-10 focus:border-emerald-500 focus:outline-none shadow-sm border-slate-200 text-sm">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            </form>
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

        <div class="overflow-hidden rounded-[2.5rem] border border-slate-100 bg-white shadow-xl">
            <div class="overflow-x-auto p-4">
                <table class="table-zebra table w-full whitespace-nowrap">
                    <thead>
                        <tr class="border-b border-slate-100">
                            <th class="bg-white text-[10px] font-black uppercase italic tracking-widest text-slate-400">No
                            </th>
                            <th class="bg-white text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                Customer</th>
                            <th class="bg-white text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                Kontak & Email</th>
                            <th class="bg-white text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                Alamat</th>
                            <th class="bg-white text-[10px] font-black uppercase italic tracking-widest text-slate-400">
                                Identitas (KTP)</th>
                            <th class="bg-white text-[10px] font-black uppercase italic tracking-widest text-slate-400">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600">
                        @foreach ($customers as $item)
                            <tr class="border-b border-slate-50 transition-all hover:bg-slate-50/50">
                                {{-- Di dalam @foreach --}}
                                <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</td>
                                <td class="py-5 pl-8">
                                    <div class="font-black uppercase italic tracking-tight text-slate-800">
                                        {{ $item->nama }}
                                    </div>
                                    {{-- <div class="text-[10px] font-bold uppercase tracking-widest text-emerald-600">ID:
                                        #CST-{{ $item->id }}</div> --}}
                                </td>
                                <td>
                                    <div class="flex flex-col gap-1">
                                        <span class="text-sm font-bold text-slate-700"><i
                                                class="fa-solid fa-envelope mr-2 text-xs opacity-30"></i>{{ $item->email }}</span>
                                        <span class="text-xs font-medium text-slate-500"><i
                                                class="fa-solid fa-phone mr-2 text-xs opacity-30"></i>{{ $item->no_telepon }}</span>
                                    </div>
                                </td>
                                <td>
                                    <p class="line-clamp-2 max-w-[200px] text-xs font-medium italic leading-relaxed">
                                        {{ $item->alamat }}
                                    </p>
                                </td>
                                <td class="text-center">
                                    @if ($item->file_identitas)
                                        <div class="avatar">
                                            <div
                                                class="w-16 cursor-zoom-in rounded-xl ring ring-emerald-50 ring-offset-2 transition-transform hover:scale-110">
                                                <a href="{{ asset('File/' . $item->file_identitas) }}" target="_blank">
                                                    <img src="{{ asset('File/' . $item->file_identitas) }}"
                                                        alt="IDENTITAS {{ $item->nama }}" />
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <span class="badge badge-ghost text-[10px] font-bold uppercase opacity-50">No
                                            File</span>
                                    @endif
                                </td>
                                <td class="pr-8 text-center">
                                    <div class="flex justify-center gap-2">
                                        {{-- Tombol Edit --}}
                                        <a href="{{ url('customer/' . $item->id . '/edit') }}"
                                            class="btn btn-square btn-sm rounded-xl border-none bg-amber-400 text-amber-900 shadow-md shadow-amber-100 transition-all hover:-translate-y-1 hover:bg-amber-500">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <button type="button"
                                            onclick="openDeleteModal('{{ $item->id }}', '{{ $item->nama }}')"
                                            class="btn btn-square btn-sm rounded-xl border-none bg-red-100 text-red-600 shadow-md shadow-red-50 transition-all hover:-translate-y-1 hover:bg-red-200">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Letakkan tepat sebelum penutup tag div kartu putih --}}
                <div
                    class="flex flex-col items-center justify-between border-t border-slate-50 bg-slate-50/50 p-6 md:flex-row">
                    <p class="mb-4 text-[10px] font-black uppercase tracking-widest text-slate-400 md:mb-0">
                        Menampilkan {{ $customers->firstItem() ?? 0 }} - {{ $customers->lastItem() ?? 0 }} dari
                        {{ $customers->total() }} Customer
                    </p>
                    <div class="pagination-custom">
                        {{ $customers->links() }}
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
                    <i class="fa-solid fa-user-xmark text-3xl"></i>
                </div>
                <h3 class="text-2xl font-black text-slate-800">Hapus Customer?</h3>
                <p class="leading-relaxed text-slate-500">
                    Anda akan menghapus data pelanggan <br>
                    <span id="delete_item_name" class="font-bold italic text-slate-800"></span>. <br>
                    Semua histori rental terkait pelanggan ini mungkin akan terpengaruh.
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
                        Ya, Hapus Permanen
                    </button>
                </form>
            </div>
        </div>
        <form method="dialog" class="modal-backdrop bg-slate-900/40 backdrop-blur-sm">
            <button>close</button>
        </form>
    </dialog>

    <script>
        function openDeleteModal(id, name) {
            const modal = document.getElementById('delete_modal');
            const form = document.getElementById('delete_form');
            const namePlaceholder = document.getElementById('delete_item_name');

            form.action = `/customer/${id}`; // Sesuaikan dengan route admin Anda
            namePlaceholder.innerText = name;
            modal.showModal();
        }
    </script>
@endsection
