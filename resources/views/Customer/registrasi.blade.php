<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pelanggan - Buberta Rent (BUMDes Bersama Betara)</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .pattern-bg {
            background-color: #f1f5f9;
            background-image: linear-gradient(#e2e8f0 1.2px, transparent 1.2px), linear-gradient(90deg, #e2e8f0 1.2px, transparent 1.2px);
            background-size: 30px 30px;
        }

        /* Style tambahan untuk preview */
        #ktp-input-container.has-image #ktp-placeholder {
            display: none;
        }

        #ktp-input-container.has-image #ktp-preview {
            display: block;
        }

        #ktp-input-container.has-image:hover #ktp-overlay {
            display: flex;
        }
    </style>
</head>

<body class="pattern-bg min-h-screen flex items-center justify-center p-4 md:p-10">

    <div
        class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-12 bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-slate-200">

        <div class="lg:col-span-5 bg-slate-900 p-10 lg:p-16 flex flex-col justify-between text-white">
            <div class="space-y-8">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 bg-emerald-500 rounded-2xl flex items-center justify-center font-black text-xl shadow-lg shadow-emerald-500/20">
                        B</div>
                    <div>
                        <h2 class="font-black text-xl tracking-tight leading-none">Buberta Rent</h2>
                        <p class="text-[10px] text-emerald-400 uppercase tracking-widest mt-1">BUMDes Bersama Betara</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <h1 class="text-4xl lg:text-5xl font-black leading-tight">Layanan Transportasi Milik <span
                            class="text-emerald-500">Desa.</span></h1>
                    <p class="text-slate-400 leading-relaxed">Daftarkan diri Anda untuk menikmati kemudahan akses armada
                        berkualitas dengan harga terjangkau untuk kebutuhan perjalanan Anda.</p>
                </div>
            </div>

            <div class="mt-10 p-6 bg-slate-800/50 rounded-[2rem] border border-slate-700">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                        <i class="fa-solid fa-user-shield text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Keamanan Data</p>
                        <p class="text-xs text-slate-500">Data KTP diverifikasi secara internal untuk keperluan
                            administrasi sewa.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="lg:col-span-7 p-8 md:p-14 bg-white">
            <div class="max-w-md mx-auto">
                <div class="mb-10">
                    <h3 class="text-2xl font-black text-slate-800">Pendaftaran Akun</h3>
                    <p class="text-sm text-slate-500">Silakan isi formulir sesuai dengan identitas resmi Anda.</p>
                </div>

                <form action="{{ url('/register-customer') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 gap-5">
                        <div class="form-control">
                            <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Nama Lengkap (Sesuai
                                KTP)</label>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                class="input input-bordered w-full rounded-2xl bg-slate-50 @error('nama') border-red-500 @else border-slate-200 @enderror focus:border-emerald-500 transition-all"
                                placeholder="Contoh: Budi Santoso">
                            @error('nama')
                                <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                        class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                            @enderror
                        </div>


                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-control">
                                <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="input input-bordered w-full rounded-2xl bg-slate-50 @error('email') border-red-500 @else border-slate-200 @enderror focus:border-emerald-500 transition-all"
                                    placeholder="email@domain.com">
                                @error('email')
                                    <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                            class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label class="label text-xs font-bold text-slate-600 uppercase ml-1">No.
                                    HP/WhatsApp</label>
                                <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                                    class="input input-bordered w-full rounded-2xl bg-slate-50 @error('no_telepon') border-red-500 @else border-slate-200 @enderror focus:border-emerald-500 transition-all"
                                    placeholder="0812xxxx">
                                @error('no_telepon')
                                    <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                            class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Alamat Domisili</label>
                        <textarea name="alamat"
                            class="textarea textarea-bordered w-full rounded-2xl bg-slate-50 @error('alamat') border-red-500 @else border-slate-200 @enderror focus:border-emerald-500 transition-all h-24"
                            placeholder="Tulis alamat lengkap Anda di sini...">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                    class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-control">
                        <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Password Akun</label>
                        <input type="text" name="password"
                            class="input input-bordered w-full rounded-2xl bg-slate-50 @error('password') border-red-500 @else border-slate-200 @enderror focus:border-emerald-500 transition-all"
                            placeholder="••••••••">
                        @error('password')
                            <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                    class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>


                    <div class="form-control">
                        <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Unggah Foto KTP</label>
                        <div id="ktp-input-container"
                            class="relative group h-44 rounded-[2rem] border-2 border-dashed @error('gambar_ktp') border-red-300 bg-red-50 @else border-slate-200 bg-slate-50 @enderror hover:bg-emerald-50 hover:border-emerald-200 transition-all overflow-hidden flex items-center justify-center cursor-pointer"
                            onclick="document.getElementById('ktp-input').click();">

                            <input type="file" name="gambar_ktp" id="ktp-input" class="hidden"
                                onchange="previewKTP(this)" accept="image/*">

                            <div id="ktp-placeholder" class="text-center transition-opacity duration-300">
                                <div
                                    class="w-12 h-12 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-3 @error('gambar_ktp') text-red-400 @else text-slate-400 @enderror group-hover:text-emerald-500 transition-colors">
                                    <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                </div>
                                <p
                                    class="text-xs font-bold @error('gambar_ktp') text-red-500 @else text-slate-500 @enderror">
                                    Klik untuk upload foto KTP</p>
                                <p class="text-[10px] text-slate-400 mt-1 uppercase">Format JPG/PNG (Maks 2MB)</p>
                            </div>

                            <img id="ktp-preview"
                                class="absolute inset-0 w-full h-full object-cover hidden z-0 transition-opacity duration-300">
                            <div id="ktp-overlay"
                                class="absolute inset-0 bg-emerald-900/50 backdrop-blur-sm hidden items-center justify-center text-white text-xs font-bold uppercase z-20 transition-opacity duration-300">
                                <i class="fa-solid fa-sync-alt mr-2"></i> Ganti Foto
                            </div>
                        </div>
                        @error('gambar_ktp')
                            <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                    class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="btn w-full h-14 bg-emerald-600 hover:bg-emerald-700 text-white border-none rounded-2xl font-black text-lg shadow-xl shadow-emerald-200 mt-4 transition-all active:scale-95">
                        Daftar Akun Pelanggan
                    </button>
                </form>

                <p class="text-center text-sm text-slate-500 mt-8">
                    Sudah terdaftar? <a href="/login" class="text-emerald-600 font-bold hover:underline">Masuk
                        Akun</a>
                </p>
            </div>
        </div> --}}

        <div class="lg:col-span-7 p-8 md:p-14 bg-white">
            <div class="max-w-md mx-auto">
                <div class="mb-10">
                    <h3 class="text-2xl font-black text-slate-800">Pendaftaran Akun</h3>
                    <p class="text-sm text-slate-500">Silakan isi formulir sesuai dengan identitas resmi Anda.</p>
                </div>

                <form action="{{ url('/register-customer') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-5">
                    @csrf

                    <div class="form-control bg-slate-50 p-4 rounded-2xl border border-slate-200">
                        <label class="label text-xs font-black text-slate-600 uppercase ml-1 mb-2">Pilih Tipe
                            Keanggotaan</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label
                                class="flex items-center gap-3 bg-white p-3 rounded-xl border border-slate-200 cursor-pointer transition-all hover:border-emerald-500 has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/50">
                                <input type="radio" name="tipe" value="individu" id="tipe-individu"
                                    class="radio radio-success"
                                    {{ old('tipe', 'individu') == 'individu' ? 'checked' : '' }}
                                    onchange="toggleFormType('individu')">
                                <span class="text-sm font-bold text-slate-700">Individu / Pribadi</span>
                            </label>
                            <label
                                class="flex items-center gap-3 bg-white p-3 rounded-xl border border-slate-200 cursor-pointer transition-all hover:border-indigo-500 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50/50">
                                <input type="radio" name="tipe" value="perusahaan" id="tipe-perusahaan"
                                    class="radio radio-primary" {{ old('tipe') == 'perusahaan' ? 'checked' : '' }}
                                    onchange="toggleFormType('perusahaan')">
                                <span class="text-sm font-bold text-slate-700">Perusahaan / PT</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5">
                        <div class="form-control">
                            <label id="label-nama" class="label text-xs font-bold text-slate-600 uppercase ml-1">Nama
                                Lengkap (Sesuai KTP)</label>
                            <input type="text" name="nama" id="input-nama" value="{{ old('nama') }}"
                                class="input input-bordered w-full rounded-2xl bg-slate-50 @error('nama') border-red-500 @else border-slate-200 @enderror focus:border-emerald-500 transition-all custom-focus"
                                placeholder="Contoh: Budi Santoso">
                            @error('nama')
                                <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                        class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-control">
                                <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Email</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="input input-bordered w-full rounded-2xl bg-slate-50 @error('email') border-red-500 @else border-slate-200 @enderror focus:border-emerald-500 transition-all custom-focus"
                                    placeholder="email@domain.com">
                                @error('email')
                                    <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                            class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-control">
                                <label id="label-telepon"
                                    class="label text-xs font-bold text-slate-600 uppercase ml-1">No.
                                    HP/WhatsApp</label>
                                <input type="text" name="no_telepon" value="{{ old('no_telepon') }}"
                                    class="input input-bordered w-full rounded-2xl bg-slate-50 @error('no_telepon') border-red-500 @else border-slate-200 @enderror focus:border-emerald-500 transition-all custom-focus"
                                    placeholder="0812xxxx">
                                @error('no_telepon')
                                    <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                            class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- <div class="form-control">
                        <label id="label-alamat" class="label text-xs font-bold text-slate-600 uppercase ml-1">Alamat
                            Domisili</label>
                        <textarea name="alamat" id="textarea-alamat"
                            class="textarea textarea-bordered w-full rounded-2xl bg-slate-50 @error('alamat') border-red-500 @else border-slate-200 @enderror focus:border-emerald-500 transition-all h-24 custom-focus"
                            placeholder="Tulis alamat lengkap Anda di sini...">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                    class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div> --}}

                    <div class="form-control">
                        <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Password Akun</label>
                        <input type="text" name="password"
                            class="input input-bordered w-full rounded-2xl bg-slate-50 @error('password') border-red-500 @else border-slate-200 @enderror focus:border-emerald-500 transition-all custom-focus"
                            placeholder="••••••••">
                        @error('password')
                            <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                    class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- <div class="form-control">
                        <label id="label-identitas"
                            class="label text-xs font-bold text-slate-600 uppercase ml-1">Unggah Foto KTP</label>
                        <div id="identitas-input-container"
                            class="relative group h-44 rounded-[2rem] border-2 border-dashed @error('file_identitas') border-red-300 bg-red-50 @else border-slate-200 bg-slate-50 @enderror hover:bg-emerald-50 hover:border-emerald-200 transition-all overflow-hidden flex items-center justify-center cursor-pointer"
                            onclick="document.getElementById('identitas-input').click();">

                            <input type="file" name="file_identitas" id="identitas-input" class="hidden"
                                onchange="previewIdentitas(this)" accept="image/*">

                            <div id="identitas-placeholder" class="text-center transition-opacity duration-300">
                                <div id="icon-container"
                                    class="w-12 h-12 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-3 @error('file_identitas') text-red-400 @else text-slate-400 @enderror group-hover:text-emerald-500 transition-colors">
                                    <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
                                </div>
                                <p id="text-placeholder-click"
                                    class="text-xs font-bold @error('file_identitas') text-red-500 @else text-slate-500 @enderror">
                                    Klik untuk upload foto KTP
                                </p>
                                <p class="text-[10px] text-slate-400 mt-1 uppercase">Format JPG/PNG (Maks 2MB)</p>
                            </div>

                            <img id="identitas-preview"
                                class="absolute inset-0 w-full h-full object-cover hidden z-0 transition-opacity duration-300">
                            <div id="identitas-overlay"
                                class="absolute inset-0 bg-emerald-900/50 backdrop-blur-sm hidden items-center justify-center text-white text-xs font-bold uppercase z-20 transition-opacity duration-300">
                                <i class="fa-solid fa-sync-alt mr-2"></i> Ganti File
                            </div>
                        </div>
                        @error('file_identitas')
                            <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                    class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div> --}}

                    <button type="submit" id="btn-submit"
                        class="btn w-full h-14 bg-emerald-600 hover:bg-emerald-700 text-white border-none rounded-2xl font-black text-lg shadow-xl shadow-emerald-200 mt-4 transition-all active:scale-95">
                        Daftar Akun Pelanggan
                    </button>
                </form>

                <p class="text-center text-sm text-slate-500 mt-8">
                    Sudah terdaftar? <a href="/login" id="link-login"
                        class="text-emerald-600 font-bold hover:underline">Masuk Akun</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function previewKTP(input) {
            const container = document.getElementById('ktp-input-container');
            const preview = document.getElementById('ktp-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    preview.src = e.target.result;
                    container.classList.add('has-image'); // Tambahkan class untuk kontrol CSS
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <script>
        function toggleFormType(type) {
            // Element-element yang akan dirubah karakteristiknya
            const labelNama = document.getElementById('label-nama');
            const inputNama = document.getElementById('input-nama');
            const labelTelepon = document.getElementById('label-telepon');
            const labelAlamat = document.getElementById('label-alamat');
            const textareaAlamat = document.getElementById('textarea-alamat');
            const labelIdentitas = document.getElementById('label-identitas');
            const textPlaceholderClick = document.getElementById('text-placeholder-click');

            // Container & Button Elements untuk Perubahan Warna Tema
            const containerUpload = document.getElementById('identitas-input-container');
            const iconContainer = document.getElementById('icon-container');
            const btnSubmit = document.getElementById('btn-submit');
            const linkLogin = document.getElementById('link-login');
            const focusInputs = document.querySelectorAll('.custom-focus');

            if (type === 'perusahaan') {
                // 1. Perubahan Teks Karakteristik Perusahaan (PT)
                labelNama.innerText = "Nama Perusahaan / PT (Sesuai Legalitas)";
                inputNama.placeholder = "Contoh: PT. Betara Sukses Mandiri";
                labelTelepon.innerText = "No. HP/Telepon Kantor (PIC)";
                labelAlamat.innerText = "Alamat Kantor Utama / Pusat";
                textareaAlamat.placeholder = "Tulis alamat lengkap kantor perusahaan di sini...";
                labelIdentitas.innerText = "Unggah Dokumen NPWP Perusahaan";
                textPlaceholderClick.innerText = "Klik untuk upload foto NPWP Perusahaan";

                // 2. Perubahan Skema Warna Tema ke INDIGO/PURPLE (Tema PT Korporat)
                btnSubmit.className =
                    "btn w-full h-14 bg-indigo-600 hover:bg-indigo-700 text-white border-none rounded-2xl font-black text-lg shadow-xl shadow-indigo-200 mt-4 transition-all active:scale-95";
                linkLogin.className = "text-indigo-600 font-bold hover:underline";

                // Mengubah hover class pada area upload berkas
                containerUpload.classList.remove('hover:bg-emerald-50', 'hover:border-emerald-200');
                containerUpload.classList.add('hover:bg-indigo-50', 'hover:border-indigo-200');
                iconContainer.classList.remove('group-hover:text-emerald-500');
                iconContainer.classList.add('group-hover:text-indigo-500');

                // Mengubah fokus input border menjadi Indigo saat diklik
                focusInputs.forEach(input => {
                    input.classList.remove('focus:border-emerald-500');
                    input.classList.add('focus:border-indigo-500');
                });

            } else {
                // 1. Kembalikan ke Karakteristik Individu
                labelNama.innerText = "Nama Lengkap (Sesuai KTP)";
                inputNama.placeholder = "Contoh: Budi Santoso";
                labelTelepon.innerText = "No. HP/WhatsApp";
                labelAlamat.innerText = "Alamat Domisili";
                textareaAlamat.placeholder = "Tulis alamat lengkap Anda di sini...";
                labelIdentitas.innerText = "Unggah Foto KTP";
                textPlaceholderClick.innerText = "Klik untuk upload foto KTP";

                // 2. Kembalikan ke Skema Warna Tema EMERALD/HIJAU (Tema Individu)
                btnSubmit.className =
                    "btn w-full h-14 bg-emerald-600 hover:bg-emerald-700 text-white border-none rounded-2xl font-black text-lg shadow-xl shadow-emerald-200 mt-4 transition-all active:scale-95";
                linkLogin.className = "text-emerald-600 font-bold hover:underline";

                containerUpload.classList.remove('hover:bg-indigo-50', 'hover:border-indigo-200');
                containerUpload.classList.add('hover:bg-emerald-50', 'hover:border-emerald-200');
                iconContainer.classList.remove('group-hover:text-indigo-500');
                iconContainer.classList.add('group-hover:text-emerald-500');

                focusInputs.forEach(input => {
                    input.classList.remove('focus:border-indigo-500');
                    input.classList.add('focus:border-emerald-500');
                });
            }
        }

        // Fungsi Preview Upload Gambar Dinamis
        function previewIdentitas(input) {
            const preview = document.getElementById('identitas-preview');
            const placeholder = document.getElementById('identitas-placeholder');
            const overlay = document.getElementById('identitas-overlay');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('opacity-0');

                    // Set overlay ganti foto saat hover
                    container = document.getElementById('identitas-input-container');
                    container.onmouseenter = () => overlay.className =
                        "absolute inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center text-white text-xs font-bold uppercase z-20 transition-opacity duration-300";
                    container.onmouseleave = () => overlay.className =
                        "absolute inset-0 bg-slate-900/50 backdrop-blur-sm hidden items-center justify-center text-white text-xs font-bold uppercase z-20 transition-opacity duration-300";
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Trigger state ketika form reload / ada error validation dari Laravel agar state radio-button tetap konsisten
        document.addEventListener("DOMContentLoaded", function() {
            if (document.getElementById('tipe-perusahaan').checked) {
                toggleFormType('perusahaan');
            }
        });
    </script>
</body>

</html>
