<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Ketua Kelompok - SPP BUMDes Bersama Betara</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Kembali ke Pattern Grid Abu-abu Semula Tanpa Rumus */
        .pattern-bg {
            background-color: #f1f5f9;
            background-image: linear-gradient(#e2e8f0 1.2px, transparent 1.2px), linear-gradient(90deg, #e2e8f0 1.2px, transparent 1.2px);
            background-size: 30px 30px;
        }
    </style>
</head>

{{-- Perbaikan: Menambahkan overflow-y-auto dan struktur flex agar halaman bisa di-scroll dengan aman --}}

<body class="pattern-bg flex flex-col min-h-screen items-center justify-center p-4 overflow-y-auto">

    <div
        class="w-full max-w-[450px] overflow-hidden rounded-[3rem] border border-slate-200 bg-white shadow-2xl my-auto">

        <div class="p-8 md:p-12">
            <div class="mb-10 text-center">
                {{-- Logo B Kembali Menjadi Emerald Seperti Semula --}}
                <div
                    class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-slate-900 text-2xl font-black text-emerald-500 shadow-xl">
                    B
                </div>
                <h1 class="text-2xl font-black tracking-tight text-slate-800">Pusat Kelompok SPP</h1>
                <p class="mt-2 text-sm text-slate-500">Masuk ke akun kepengurusan kelompok Anda</p>
            </div>

            {{-- Notifikasi Sukses --}}
            @if (session('success'))
                <div
                    class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-700 font-bold">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Notifikasi Gagal --}}
            @if (session('loginFailed'))
                <div
                    class="mb-6 flex items-center gap-3 rounded-2xl border border-red-100 bg-red-50 p-4 text-red-700 shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-red-500 text-white shadow-lg shadow-red-200">
                        <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                    </div>

                    <div class="flex flex-col">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-50">Gagal</span>
                        <span class="font-bold leading-tight text-xs mt-0.5">{{ session('loginFailed') }}</span>
                    </div>

                    <button type="button" class="ml-auto btn btn-ghost btn-xs btn-circle text-red-400"
                        onclick="this.parentElement.remove()">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            <form action="{{ url('/login-spp') }}" method="POST" class="space-y-5">
                @csrf

                <div class="form-control">
                    <label class="label ml-1 text-xs font-bold uppercase text-slate-600">Email Akun</label>
                    <div class="group relative">
                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 transition-colors group-focus-within:text-indigo-500">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 pl-11 transition-all focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 text-slate-700"
                            placeholder="nama@email.com">
                    </div>
                    @error('email')
                        <p class="ml-1 mt-1 text-[11px] font-bold text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-control">
                    <div class="mb-1 flex items-center justify-between">
                        <label class="label ml-1 text-xs font-bold uppercase text-slate-600">Password</label>
                    </div>
                    <div class="group relative">
                        <div
                            class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 transition-colors group-focus-within:text-indigo-500">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <input type="password" name="password" required
                            class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 pl-11 transition-all focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 text-slate-700"
                            placeholder="••••••••">
                    </div>
                </div>

                <button type="submit"
                    class="btn mt-2 h-14 w-full rounded-2xl border-none bg-indigo-600 text-sm font-black text-white shadow-xl shadow-indigo-100 transition-all hover:bg-indigo-700 active:scale-95">
                    Masuk ke Dashboard
                </button>
            </form>

            <div class="mt-10 text-center space-y-4">
                <p class="text-sm text-slate-500">
                    Belum mendaftarkan kelompok Anda?
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-3 sm:gap-6 text-xs mt-2">
                    {{-- Link Registrasi Ketua Kelompok SPP (Indigo) --}}
                    <a href="{{ url('/registrasi-spp') }}"
                        class="font-extrabold text-indigo-600 transition-colors hover:text-indigo-700 flex items-center gap-1.5">
                        <i class="fa-solid fa-users-line text-[10px]"></i> Daftar Ketua Kelompok SPP
                    </a>

                    <span class="hidden sm:inline text-slate-300">|</span>

                    {{-- Link Kembali ke Portal Utama Rental --}}
                    <a href="{{ url('/login') }}"
                        class="font-bold text-slate-500 transition-colors hover:text-slate-800 flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-arrow-left text-[10px]"></i> Portal Utama Rental
                    </a>
                </div>
            </div>

            <div class="mt-8 border-t border-slate-100 pt-6 text-center">
                <p class="text-[10px] font-bold uppercase tracking-[2px] text-slate-400">Simpan Pinjam Perempuan (SPP)
                </p>
                <p class="mt-1 text-[9px] uppercase tracking-widest text-slate-300">BUMDes Bersama Betara © 2026</p>
            </div>
        </div>
    </div>

</body>

</html>
