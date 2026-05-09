@extends('Admin.Layouts.main')

@section('content')
    <main class="mx-auto max-w-5xl space-y-8 p-6 lg:p-10">

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ url('/dokumentasi') }}" class="btn btn-ghost btn-circle bg-white shadow-sm">
                    <i class="fa-solid fa-arrow-left text-slate-600"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-800 lg:text-3xl">Edit <span
                            class="text-emerald-600">Berita</span></h1>
                    <p class="text-sm text-slate-500">Perbarui informasi berita yang sudah dipublikasikan.</p>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-[2.5rem] border border-slate-100 bg-white shadow-xl shadow-slate-200/50">
            <form action="{{ url('/dokumentasi/' . $berita->id) }}" method="POST" class="space-y-8 p-8 lg:p-12"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <div class="form-control w-full md:col-span-2">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-slate-700">Judul Berita</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul', $berita->judul) }}"
                            placeholder="Contoh: Peresmian Unit Usaha Baru"
                            class="input input-bordered @error('judul') border-red-500 @else border-slate-200 @enderror w-full rounded-2xl bg-slate-50 text-lg font-semibold focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50" />
                        @error('judul')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-slate-700">Tanggal Publikasi</span>
                        </label>
                        <div class="relative">
                            <i class="fa-regular fa-calendar absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="date" name="tanggal" value="{{ old('tanggal', $berita->tanggal) }}"
                                class="input input-bordered @error('tanggal') border-red-500 @else border-slate-200 @enderror w-full rounded-2xl bg-slate-50 pl-12 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50" />
                        </div>
                        @error('tanggal')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-slate-700">Gambar Utama</span>
                        </label>

                        <div class="{{ $berita->gambar ? '' : 'hidden' }} mb-4" id="preview-container">
                            <div class="relative inline-block">
                                <img id="img-preview" src="{{ $berita->gambar ? asset('File/' . $berita->gambar) : '' }}"
                                    class="h-40 w-full rounded-2xl border border-slate-200 object-cover shadow-md">
                                <button type="button" onclick="resetImage()"
                                    class="btn btn-circle btn-error btn-xs absolute -right-2 -top-2 text-white shadow-lg">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            @if ($berita->gambar)
                                <p class="mt-2 text-[10px] italic text-slate-400">*Gambar saat ini: {{ $berita->gambar }}
                                </p>
                            @endif
                        </div>

                        <input type="file" name="gambar" id="gambar-input" onchange="previewImage()"
                            class="file-input file-input-bordered @error('gambar') border-red-500 @else border-slate-200 @enderror w-full rounded-2xl bg-slate-50" />
                        @error('gambar')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-control w-full">
                    <label class="label mb-2">
                        <span class="label-text font-bold text-slate-700">Isi Berita</span>
                    </label>
                    <input id="kontent" type="hidden" name="kontent" value="{{ old('kontent', $berita->kontent) }}">
                    <div class="@error('kontent') border border-red-500 rounded-xl p-1 @enderror">
                        <trix-editor input="kontent" placeholder="Tuliskan detail berita di sini..."
                            class="bg-slate-50"></trix-editor>
                    </div>
                    @error('kontent')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-4 border-t border-slate-50 pt-6">
                    <a href="{{ url('/dokumentasi') }}"
                        class="btn btn-ghost rounded-2xl px-8 font-bold text-slate-500">Batal</a>
                    <button type="submit"
                        class="btn rounded-2xl border-none bg-emerald-600 px-10 font-bold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700">
                        <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function previewImage() {
            const input = document.querySelector('#gambar-input');
            const imgPreview = document.querySelector('#img-preview');
            const previewContainer = document.querySelector('#preview-container');

            if (input.files && input.files[0]) {
                const blob = URL.createObjectURL(input.files[0]);
                imgPreview.src = blob;
                previewContainer.classList.remove('hidden');
                imgPreview.onload = () => URL.revokeObjectURL(blob);
            }
        }

        function resetImage() {
            const input = document.querySelector('#gambar-input');
            const imgPreview = document.querySelector('#img-preview');
            const previewContainer = document.querySelector('#preview-container');

            input.value = "";
            // Jika ada gambar asli dari database, kembalikan ke gambar tersebut
            const originalImage = "{{ $berita->gambar ? asset('File/' . $berita->gambar) : '' }}";

            if (originalImage) {
                imgPreview.src = originalImage;
            } else {
                previewContainer.classList.add('hidden');
            }
        }
    </script>
@endsection
