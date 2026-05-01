    @extends('Admin.Layouts.main')

    @section('content')
        <main class="space-y-8 p-6 lg:p-10">

            @if (session('success'))
                <div role="alert"
                    class="alert mb-6 flex items-center rounded-2xl border-emerald-200 bg-emerald-100 text-emerald-800 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current text-emerald-600"
                        fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="flex flex-col">
                        <span class="font-bold">Berhasil!</span>
                        <span class="text-sm opacity-90">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="btn btn-ghost btn-xs btn-circle ml-auto">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            <div class="flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
                <div>
                    <h1 class="text-3xl font-black text-slate-800">Manajemen <span class="text-emerald-600">Berita</span>
                    </h1>
                    <p class="mt-1 text-sm text-slate-500">Kelola publikasi kegiatan dan dokumentasi Desa Betara Ikd.</p>
                </div>
                <a href="{{ url('/dokumentasi/create') }}"
                    class="btn rounded-2xl border-none bg-emerald-600 px-6 text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700">
                    <i class="fa-solid fa-plus mr-2"></i> Tambah Berita Baru
                </a>
            </div>

            {{-- <div class="flex flex-col gap-4 rounded-[2rem] border border-slate-100 bg-white p-4 shadow-sm md:flex-row">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" placeholder="Cari judul berita..."
                            class="input input-bordered w-full rounded-xl border-none bg-slate-50 pl-12 focus:ring-2 focus:ring-emerald-500" />
                    </div>

                    <button
                        class="btn rounded-xl border-none bg-emerald-600 px-8 text-white shadow-lg shadow-emerald-100 transition-all duration-300 hover:bg-emerald-700">
                        <i class="fa-solid fa-magnifying-glass mr-2 text-sm"></i>
                        Cari
                    </button>
                </div> --}}

            <div class="overflow-hidden rounded-[2.5rem] border border-slate-100 bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="table-lg table">
                        <thead class="bg-slate-50/50 text-[11px] uppercase tracking-widest text-slate-400">
                            <tr>
                                <th>No</th>
                                <th class="py-6">Gambar & Judul</th>
                                <th>Tanggal Publish</th>
                                <th>Isi Singkat</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-slate-600">
                            @foreach ($dokumentasis as $item)
                                <tr class="border-b border-slate-50 transition-all hover:bg-slate-50/80">
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="max-w-md">
                                        <div class="flex items-center gap-4">
                                            <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-2xl shadow-md">
                                                <img src="{{ asset('/File/' . $item->gambar) }}"
                                                    class="h-full w-full object-cover" alt="Thumbnail">
                                            </div>
                                            <div>
                                                <h3 class="font-bold leading-tight text-slate-800">{{ $item->judul }}
                                                </h3>
                                                {{-- <span
                                                    class="badge badge-sm mt-1 border-none bg-emerald-100 font-bold text-emerald-700">Unit
                                                    Usaha</span> --}}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex items-center gap-2">
                                            <i class="fa-regular fa-calendar text-emerald-500"></i>
                                            <span
                                                class="text-sm font-medium">{{ date('d-m-Y', strtotime($item->tanggal)) }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="line-clamp-2 text-xs italic text-slate-400">
                                            {!! \Illuminate\Support\Str::limit(strip_tags($item->kontent), 50, '...') !!}
                                        </p>
                                    </td>
                                    <td>
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ url('/dokumentasi/' . $item->id . '/edit') }}"
                                                class="btn btn-square btn-sm btn-ghost bg-blue-50 text-blue-500 hover:bg-blue-500 hover:text-white">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <button type="button"
                                                onclick="openDeleteModal('{{ $item->id }}', '{{ $item->judul }}')"
                                                class="btn btn-square btn-sm btn-ghost bg-red-50 text-red-500 hover:bg-red-500 hover:text-white">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <dialog id="delete_modal" class="modal modal-bottom sm:modal-middle">
                    <div class="modal-box rounded-[2rem] border border-slate-100 bg-white p-8">
                        <div class="flex flex-col items-center space-y-4 text-center">
                            <div
                                class="mb-2 flex h-16 w-16 items-center justify-center rounded-full bg-red-50 p-4 text-red-500">
                                <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                            </div>

                            <h3 class="text-xl font-black text-slate-800">Hapus Dokumentasi?</h3>
                            <p class="text-sm text-slate-500">
                                Anda akan menghapus berita <br>
                                <span id="delete_item_title" class="font-bold italic text-slate-800"></span>. <br>
                                Tindakan ini tidak dapat dibatalkan.
                            </p>
                        </div>

                        <div class="modal-action mt-8 flex justify-center gap-3">
                            <form method="dialog">
                                <button class="btn btn-ghost rounded-2xl px-8 font-bold text-slate-500">Batal</button>
                            </form>

                            <form id="delete_form" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn rounded-2xl border-none bg-red-500 px-8 font-bold text-white shadow-lg shadow-red-100 hover:bg-red-600">
                                    Ya, Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    <form method="dialog" class="modal-backdrop">
                        <button>close</button>
                    </form>
                </dialog>

                {{-- <div class="flex items-center justify-between bg-slate-50 p-6 text-xs text-slate-500">
                    <p>Menampilkan 1 sampai 10 dari 24 Berita</p>
                    <div class="join">
                        <button class="join-item btn btn-xs">Prev</button>
                        <button class="join-item btn btn-xs btn-active border-none bg-emerald-600 text-white">1</button>
                        <button class="join-item btn btn-xs">2</button>
                        <button class="join-item btn btn-xs">Next</button>
                    </div>
                </div> --}}
            </div>
        </main>

        <script>
            function openDeleteModal(id, title) {
                const modal = document.getElementById('delete_modal');
                const form = document.getElementById('delete_form');
                const titlePlaceholder = document.getElementById('delete_item_title');

                // 1. Set Action URL secara dinamis
                form.action = `/dokumentasi/${id}`;

                // 2. Set judul berita agar admin tidak salah hapus
                titlePlaceholder.innerText = `"${title}"`;

                // 3. Munculkan modal (fungsi bawaan DaisyUI/HTML5 Dialog)
                modal.showModal();
            }
        </script>
    @endsection
