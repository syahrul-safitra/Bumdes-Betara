@extends('Admin.Layouts.main')

@section('content')
    <main class="p-6 lg:p-10 space-y-8">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800">Manajemen <span class="text-emerald-600">Berita</span></h1>
                <p class="text-slate-500 text-sm mt-1">Kelola publikasi kegiatan dan dokumentasi Desa Betara Ikd.</p>
            </div>
            <button
                class="btn bg-emerald-600 hover:bg-emerald-700 border-none text-white rounded-2xl px-6 shadow-lg shadow-emerald-200">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Berita Baru
            </button>
        </div>

        <div class="bg-white p-4 rounded-[2rem] shadow-sm border border-slate-100 flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Cari judul berita..."
                    class="input input-bordered w-full pl-12 rounded-xl bg-slate-50 border-none focus:ring-2 focus:ring-emerald-500" />
            </div>

            <button
                class="btn bg-emerald-600 border-none text-white rounded-xl px-8 shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-all duration-300">
                <i class="fa-solid fa-magnifying-glass mr-2 text-sm"></i>
                Cari
            </button>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table table-lg">
                    <thead class="bg-slate-50/50 text-slate-400 uppercase text-[11px] tracking-widest">
                        <tr>
                            <th class="py-6">Gambar & Judul</th>
                            <th>Tanggal Publish</th>
                            <th>Isi Singkat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-slate-600">
                        <tr class="hover:bg-slate-50/80 transition-all border-b border-slate-50">
                            <td class="max-w-md">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-2xl overflow-hidden shadow-md flex-shrink-0">
                                        <img src="https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=200"
                                            class="object-cover h-full w-full" alt="Thumbnail">
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800 leading-tight">Peresmian Unit Usaha BUBERTA RENT
                                        </h3>
                                        <span
                                            class="badge badge-sm bg-emerald-100 text-emerald-700 border-none font-bold mt-1">Unit
                                            Usaha</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-calendar text-emerald-500"></i>
                                    <span class="font-medium text-sm">15 Nov 2023</span>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs text-slate-400 line-clamp-2 italic">
                                    BUM Desa Bersama Betara secara resmi meluncurkan unit usaha terbarunya...
                                </p>
                            </td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <button
                                        class="btn btn-square btn-sm btn-ghost text-blue-500 bg-blue-50 hover:bg-blue-500 hover:text-white">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button
                                        class="btn btn-square btn-sm btn-ghost text-red-500 bg-red-50 hover:bg-red-500 hover:text-white">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-slate-50/80 transition-all border-b border-slate-50">
                            <td class="max-w-md">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-2xl overflow-hidden shadow-md flex-shrink-0">
                                        <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=200"
                                            class="object-cover h-full w-full" alt="Thumbnail">
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-800 leading-tight">Rapat Kerja Tahunan BUMDes 2024
                                        </h3>
                                        <span
                                            class="badge badge-sm bg-blue-100 text-blue-700 border-none font-bold mt-1">Kegiatan</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-calendar text-emerald-500"></i>
                                    <span class="font-medium text-sm">10 Jan 2024</span>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs text-slate-400 line-clamp-2 italic">
                                    Pembahasan mengenai penguatan regulasi sesuai UU Desa No 6 Tahun 2014...
                                </p>
                            </td>
                            <td>
                                <div class="flex justify-center gap-2">
                                    <button
                                        class="btn btn-square btn-sm btn-ghost text-blue-500 bg-blue-50 hover:bg-blue-500 hover:text-white">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button
                                        class="btn btn-square btn-sm btn-ghost text-red-500 bg-red-50 hover:bg-red-500 hover:text-white">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="p-6 bg-slate-50 flex justify-between items-center text-xs text-slate-500">
                <p>Menampilkan 1 sampai 10 dari 24 Berita</p>
                <div class="join">
                    <button class="join-item btn btn-xs">Prev</button>
                    <button class="join-item btn btn-xs btn-active bg-emerald-600 text-white border-none">1</button>
                    <button class="join-item btn btn-xs">2</button>
                    <button class="join-item btn btn-xs">Next</button>
                </div>
            </div>
        </div>
    </main>
@endsection
