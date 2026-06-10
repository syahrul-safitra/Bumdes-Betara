@extends('Admin.Layouts.main')

@section('content')
    <main class="mx-auto max-w-5xl space-y-8 p-6 lg:p-10">

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="/vehicle" class="btn btn-ghost btn-circle bg-white shadow-sm">
                    <i class="fa-solid fa-arrow-left text-slate-600"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-black text-slate-800 lg:text-3xl">Edit <span
                            class="text-emerald-600">Armada</span></h1>
                    <p class="text-sm text-slate-500">Perbarui informasi unit kendaraan {{ $vehicle->merek }}.</p>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-[2.5rem] border border-slate-100 bg-white shadow-xl shadow-slate-200/50">
            <form action="{{ url('/vehicle/' . $vehicle->id) }}" method="POST" class="space-y-8 p-8 lg:p-12"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                    <div class="form-control w-full">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-slate-700">Nomor Plat</span>
                        </label>
                        <input type="text" name="no_plat" value="{{ old('no_plat', $vehicle->no_plat) }}"
                            class="input input-bordered w-full rounded-2xl @error('no_plat') border-red-500 @else border-slate-200 @enderror bg-slate-50 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50" />
                        @error('no_plat')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-slate-700">Merek/Tipe</span>
                        </label>
                        <input type="text" name="merek" value="{{ old('merek', $vehicle->merek) }}"
                            class="input input-bordered w-full rounded-2xl @error('merek') border-red-500 @else border-slate-200 @enderror bg-slate-50 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50" />
                        @error('merek')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-slate-700">Warna</span>
                        </label>
                        <input type="text" name="warna" value="{{ old('warna', $vehicle->warna) }}"
                            class="input input-bordered w-full rounded-2xl @error('warna') border-red-500 @else border-slate-200 @enderror bg-slate-50 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50" />
                        @error('warna')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-slate-700">Tahun</span>
                        </label>
                        <input type="number" name="tahun" value="{{ old('tahun', $vehicle->tahun) }}"
                            class="input input-bordered w-full rounded-2xl @error('tahun') border-red-500 @else border-slate-200 @enderror bg-slate-50 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50" />
                        @error('tahun')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-slate-700">Harga Sewa / Hari</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-slate-400">Rp</span>
                            <input type="number" name="harga_perhari"
                                value="{{ old('harga_perhari', $vehicle->harga_perhari) }}"
                                class="input input-bordered w-full pl-12 rounded-2xl @error('harga_perhari') border-red-500 @else border-slate-200 @enderror bg-slate-50 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50" />
                        </div>
                        @error('harga_perhari')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-control w-full">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-slate-700">Denda / Perhari</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-slate-400">Rp</span>
                            <input type="number" name="denda_perhari"
                                value="{{ old('denda_perhari', $vehicle->denda_perhari) }}"
                                class="input input-bordered w-full pl-12 rounded-2xl @error('denda_perhari') border-red-500 @else border-slate-200 @enderror bg-slate-50 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50" />
                        </div>
                        @error('denda_perhari')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Jasa Driver / Hari (Tambahan Baru) --}}
                    <div class="form-control w-full">
                        <label class="label mb-2">
                            <span class="label-text font-bold text-slate-700">Harga Jasa Driver / Hari</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-slate-400">Rp</span>
                            <input type="number" name="sewa_driver"
                                value="{{ old('sewa_driver', $vehicle->sewa_driver) }}" placeholder="100000"
                                class="input input-bordered w-full pl-12 rounded-2xl @error('sewa_driver') border-red-500 @else border-slate-200 @enderror bg-slate-50 focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-50" />
                        </div>
                        @error('sewa_driver')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-control w-full">
                    <label class="label mb-2">
                        <span class="label-text font-bold text-slate-700">Foto Kendaraan</span>
                    </label>

                    <div class="mb-4 {{ $vehicle->gambar ? '' : 'hidden' }}" id="preview-container">
                        <div class="relative inline-block">
                            <img id="img-preview" src="{{ $vehicle->gambar ? asset('File/' . $vehicle->gambar) : '' }}"
                                class="h-52 w-full rounded-2xl object-cover shadow-md border border-slate-200">
                            <button type="button" onclick="resetImage()"
                                class="btn btn-circle btn-error btn-xs absolute -right-2 -top-2 shadow-lg text-white">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        @if ($vehicle->gambar)
                            <p class="mt-2 text-[10px] text-slate-400 italic font-medium">* Gambar saat ini:
                                {{ $vehicle->gambar }}</p>
                        @endif
                    </div>

                    <input type="file" name="gambar" id="gambar-input" onchange="previewImage()"
                        class="file-input file-input-bordered w-full rounded-2xl @error('gambar') border-red-500 @else border-slate-200 @enderror bg-slate-50" />
                    @error('gambar')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-4 border-t border-slate-50 pt-6">
                    <a href="{{ url('/vehicle') }}"
                        class="btn btn-ghost rounded-2xl px-8 font-bold text-slate-500">Batal</a>
                    <button type="submit"
                        class="btn rounded-2xl border-none bg-emerald-600 px-10 font-bold text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700">
                        <i class="fa-solid fa-save mr-2"></i> Perbarui Armada
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        const originalSrc = "{{ $vehicle->gambar ? asset('File/' . $vehicle->gambar) : '' }}";

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
            if (originalSrc) {
                imgPreview.src = originalSrc;
            } else {
                previewContainer.classList.add('hidden');
            }
        }
    </script>
@endsection
