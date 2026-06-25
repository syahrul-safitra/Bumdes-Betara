@extends('Admin.Layouts.main')

@section('content')
    <main class="min-h-screen bg-slate-50/50 p-4 antialiased md:p-8 lg:p-12">
        <div class="mx-auto max-w-7xl">
            {{-- Header --}}
            <div class="mb-8 text-left">
                {{-- <div class="flex items-center gap-3 text-sm font-semibold uppercase tracking-widest text-slate-400">
                    <a href="{{ url("customer") }}" class="transition-all hover:text-emerald-600">Customer</a>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    <span class="text-slate-800">Edit Profil</span>
                </div> --}}
                <h1 class="mt-2 text-3xl font-black uppercase italic tracking-tighter text-slate-800">
                    Update Data <span class="text-emerald-600">Admin/Direktur</span>
                </h1>
            </div>

            {{-- Card Form --}}
            <div class="rounded-[2.5rem] border border-slate-100 bg-white p-8 shadow-xl shadow-slate-200/50">
                <form action="{{ url('admin/' . $admin->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-10 lg:grid-cols-2">

                        {{-- Kolom Kiri --}}
                        <div class="flex flex-col gap-6">
                            <h2 class="text-xs font-black uppercase tracking-[0.2em] text-emerald-600">Informasi Pribadi
                            </h2>

                            {{-- Nama --}}
                            <div class="flex w-full flex-col">
                                <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Nama</label>
                                <input type="text" name="name" value="{{ old('name', $admin->name) }}"
                                    class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-emerald-500 focus:outline-none focus:ring-0"
                                    required />
                            </div>

                            {{-- Email --}}
                            <div class="flex w-full flex-col">
                                <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Alamat Email</label>
                                <input type="email" name="email" value="{{ old('email', $admin->email) }}"
                                    class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-emerald-500 focus:outline-none focus:ring-0"
                                    required />
                            </div>

                        </div>

                        {{-- Kolom Kanan --}}
                        <div class="flex flex-col gap-6">
                            <h2 class="text-xs font-black uppercase tracking-[0.2em] text-emerald-600">Keamanan & Identitas
                            </h2>

                            {{-- No Telepon (Fixed old value attribute) --}}
                            <div class="flex w-full flex-col">
                                <label class="mb-2 ml-1 text-sm font-bold text-slate-600">No Telepon</label>
                                <input type="text" name="no_telepon" value="{{ old('no_telepon', $admin->no_telepon) }}"
                                    class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-emerald-500 focus:outline-none focus:ring-0" />
                            </div>

                            {{-- 🔥 INPUT BARU: Nomor Rekening Kas BUMDes --}}
                            <div class="flex w-full flex-col">
                                <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Nomor Rekening Bank BUMDes</label>
                                <input type="text" name="no_rek" value="{{ old('no_rek', $admin->no_rek) }}"
                                    placeholder="Contoh: Bank Jambi - 700123456"
                                    class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-emerald-500 focus:outline-none focus:ring-0" />
                            </div>

                            {{-- Password --}}
                            <div class="flex w-full flex-col">
                                <div class="mb-2 flex items-center justify-between px-1">
                                    <label class="text-sm font-bold text-slate-600">Ganti Password</label>
                                    <span
                                        class="text-[10px] font-medium uppercase italic tracking-tighter text-slate-400">Kosongkan
                                        jika tetap</span>
                                </div>
                                <input type="text" name="password" placeholder="••••••••"
                                    class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-emerald-500 focus:outline-none focus:ring-0" />
                            </div>

                            {{-- KTP --}}
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="mt-12 flex items-center justify-end gap-4 border-t border-slate-50 pt-10">
                        <a href="{{ url('admin') }}"
                            class="btn btn-ghost rounded-2xl px-10 font-black uppercase tracking-widest text-slate-400">
                            Batal
                        </a>
                        <button type="submit"
                            class="btn rounded-2xl border-none bg-emerald-600 px-12 font-black uppercase tracking-widest text-white shadow-xl shadow-emerald-100 transition-all hover:-translate-y-1 hover:bg-emerald-700">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        function previewImage() {
            const input = document.getElementById('input-ktp');
            const preview = document.getElementById('preview-ktp');

            // Pastikan ada file yang dipilih
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                // Saat file selesai dibaca
                reader.onload = function(e) {
                    // Ubah source gambar preview menjadi data URL file baru
                    preview.src = e.target.result;

                    // Tambahkan sedikit efek animasi saat berubah
                    preview.classList.add('scale-95');
                    setTimeout(() => {
                        preview.classList.remove('scale-95');
                    }, 100);
                }

                // Baca file sebagai Data URL
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
