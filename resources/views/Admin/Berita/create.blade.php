@extends('Admin.Layouts.main')

@section('content')
    <main class="p-6 lg:p-10 space-y-8 max-w-5xl mx-auto">

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="/admin/berita" class="btn btn-ghost btn-circle bg-white shadow-sm">
                    <i class="fa-solid fa-arrow-left text-slate-600"></i>
                </a>
                <div>
                    <h1 class="text-2xl lg:text-3xl font-black text-slate-800">Tambah <span class="text-emerald-600">Berita
                            Baru</span></h1>
                    <p class="text-slate-500 text-sm">Publikasikan informasi terbaru untuk warga desa.</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <form action="#" method="POST" class="p-8 lg:p-12 space-y-8">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="form-control w-full md:col-span-2">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-slate-700">Judul Berita</span>
                        </label>
                        <input type="text" name="judul" placeholder="Contoh: Peresmian Unit Usaha Baru"
                            class="input input-bordered w-full rounded-2xl bg-slate-50 border-slate-200 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50 text-lg font-semibold"
                            required />
                    </div>

                    <div class="form-control w-full">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-slate-700">Tanggal Publikasi</span>
                        </label>
                        <div class="relative">
                            <i class="fa-regular fa-calendar absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="date" name="tanggal"
                                class="input input-bordered w-full pl-12 rounded-2xl bg-slate-50 border-slate-200 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50"
                                required />
                        </div>
                    </div>

                    <div class="form-control w-full">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-slate-700">Gambar Utama</span>
                        </label>
                        <input type="file" name="gambar"
                            class="file-input file-input-bordered w-full rounded-2xl bg-slate-50 border-slate-200" />
                    </div>
                </div>

                <div class="form-control w-full">
                    <label class="label mb-2">
                        <span class="label-text font-bold text-slate-700">Isi Berita</span>
                    </label>
                    <input id="isi" type="hidden" name="isi">
                    <trix-editor input="isi" placeholder="Tuliskan detail berita di sini..."></trix-editor>
                    <p class="text-[11px] text-slate-400 mt-2 px-2">*Gunakan toolbar di atas untuk memformat teks (Tebal,
                        Miring, List, dll).</p>
                </div>

                <div class="flex items-center justify-end gap-4 pt-6 border-t border-slate-50">
                    <button type="button" class="btn btn-ghost rounded-2xl px-8 font-bold text-slate-500">Batal</button>
                    <button type="submit"
                        class="btn bg-emerald-600 hover:bg-emerald-700 border-none text-white rounded-2xl px-10 shadow-lg shadow-emerald-200 font-bold">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Simpan & Publikasi
                    </button>
                </div>

            </form>
        </div>

    </main>
@endsection
