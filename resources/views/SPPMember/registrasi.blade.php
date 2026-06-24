<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun Ketua Kelompok SPP - BUMDes Bersama Betara</title>
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
    </style>
</head>

<body class="pattern-bg min-h-screen flex items-center justify-center p-4 md:p-10">

    <div
        class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-12 bg-white rounded-[3rem] shadow-2xl overflow-hidden border border-slate-200">

        {{-- Kolom Kiri: Informasi Program SPP --}}
        <div class="lg:col-span-5 bg-slate-900 p-10 lg:p-16 flex flex-col justify-between text-white">
            <div class="space-y-8">
                <div class="flex items-center gap-3">
                    <div
                        class="w-12 h-12 bg-indigo-500 rounded-2xl flex items-center justify-center font-black text-xl shadow-lg shadow-indigo-500/20">
                        S</div>
                    <div>
                        <h2 class="font-black text-xl tracking-tight leading-none">Simpan Pinjam</h2>
                        <p class="text-[10px] text-indigo-400 uppercase tracking-widest mt-1">Perempuan (SPP) Betara</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <h1 class="text-4xl lg:text-5xl font-black leading-tight">Pemberdayaan Ekonomi <span
                            class="text-indigo-400">Wanita Desa.</span></h1>
                    <p class="text-slate-400 leading-relaxed">Daftarkan akun dasar Anda selaku Ketua Kelompok untuk
                        memulai pengajuan dana bergulir modal usaha kelompok perempuan secara transparan.</p>
                </div>
            </div>

            <div class="mt-10 p-6 bg-slate-800/50 rounded-[2rem] border border-slate-700">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-full bg-indigo-500/10 flex items-center justify-center text-indigo-400">
                        <i class="fa-solid fa-bolt text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold">Minimalist Onboarding</p>
                        <p class="text-xs text-slate-500">Cukup buat akun dasar sekarang. Profil kelompok dan data
                            anggota dilengkapi nanti setelah login.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Form Pendaftaran Ketua --}}
        <div class="lg:col-span-7 p-8 md:p-14 bg-white">
            <div class="max-w-md mx-auto">
                <div class="mb-10">
                    <span
                        class="badge border-none bg-indigo-50 text-indigo-700 font-bold px-3 py-3 rounded-xl text-xs mb-3">
                        <i class="fa-solid fa-user-gear mr-1.5"></i> Registrasi Tahap 1
                    </span>
                    <h3 class="text-2xl font-black text-slate-800">Pendaftaran Akun Ketua</h3>
                    <p class="text-sm text-slate-500">Silakan isi identitas diri Anda selaku penanggung jawab kelompok.
                    </p>
                </div>

                <form action="{{ url('/registrasi-spp') }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 gap-5">
                        {{-- Input Nama Ketua --}}
                        <div class="form-control">
                            <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Nama Lengkap
                                Ketua</label>
                            <input type="text" name="nama_ketua" value="{{ old('nama_ketua') }}"
                                class="input input-bordered w-full rounded-2xl bg-slate-50 @error('nama_ketua') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500 transition-all"
                                placeholder="Contoh: Siti Aminah">
                            @error('nama_ketua')
                                <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                        class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input NIK Ketua --}}
                        <div class="form-control">
                            <label class="label text-xs font-bold text-slate-600 uppercase ml-1">NIK Ketua (16
                                Digit)</label>
                            <input type="text" name="nik_ketua" maxlength="16" value="{{ old('nik_ketua') }}"
                                class="input input-bordered w-full rounded-2xl bg-slate-50 @error('nik_ketua') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500 transition-all"
                                placeholder="Masukkan 16 digit NIK resmi">
                            @error('nik_ketua')
                                <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                        class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            {{-- Input Email --}}
                            <div class="form-control">
                                <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Email (Untuk
                                    Login)</label>
                                <input type="email" name="email" value="{{ old('email') }}"
                                    class="input input-bordered w-full rounded-2xl bg-slate-50 @error('email') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500 transition-all"
                                    placeholder="nama@email.com">
                                @error('email')
                                    <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                            class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Input No HP --}}
                            <div class="form-control">
                                <label class="label text-xs font-bold text-slate-600 uppercase ml-1">No.
                                    HP/WhatsApp</label>
                                <input type="text" name="no_hp_ketua" value="{{ old('no_hp_ketua') }}"
                                    class="input input-bordered w-full rounded-2xl bg-slate-50 @error('no_hp_ketua') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500 transition-all"
                                    placeholder="0812xxxx">
                                @error('no_hp_ketua')
                                    <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                            class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Input Password --}}
                    <div class="form-control">
                        <label class="label text-xs font-bold text-slate-600 uppercase ml-1">Kata Sandi
                            (Password)</label>
                        <input type="text" name="password"
                            class="input input-bordered w-full rounded-2xl bg-slate-50 @error('password') border-red-500 @else border-slate-200 @enderror focus:border-indigo-500 transition-all"
                            placeholder="••••••••">
                        @error('password')
                            <p class="mt-1 ml-1 text-[11px] font-bold text-red-500"><i
                                    class="fa-solid fa-circle-exclamation mr-1"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Button Submit --}}
                    <button type="submit"
                        class="btn w-full h-14 bg-indigo-600 hover:bg-indigo-700 text-white border-none rounded-2xl font-black text-lg shadow-xl shadow-indigo-200 mt-4 transition-all active:scale-95">
                        Lanjut ke Pengisian Profil Kelompok
                    </button>
                </form>

                <p class="text-center text-sm text-slate-500 mt-8">
                    Kelompok sudah terdaftar? <a href="{{ url('/login-spp') }}"
                        class="text-indigo-600 font-bold hover:underline">Masuk Akun</a>
                </p>
            </div>
        </div>
    </div>

</body>

</html>
