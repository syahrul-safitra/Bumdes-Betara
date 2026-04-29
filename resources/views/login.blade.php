<!DOCTYPE html>
<html lang="id" data-theme="light">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - Buberta Rent (BUMDes Bersama Betara)</title>
        @vite(["resources/css/app.css", "resources/js/app.js"])
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

    <body class="pattern-bg flex min-h-screen items-center justify-center p-4">

        <div class="w-full max-w-[450px] overflow-hidden rounded-[3rem] border border-slate-200 bg-white shadow-2xl">

            <div class="p-8 md:p-12">
                <div class="mb-10 text-center">
                    <div
                        class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-[1.5rem] bg-slate-900 text-2xl font-black text-emerald-500 shadow-xl">
                        B
                    </div>
                    <h1 class="text-2xl font-black tracking-tight text-slate-800">Selamat Datang Kembali</h1>
                    <p class="mt-2 text-sm text-slate-500">Masuk ke akun Buberta Rent Anda</p>
                </div>

                @if (session("success"))
                    <div
                        class="mb-6 flex animate-bounce items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 p-4 text-sm text-emerald-700">
                        <i class="fa-solid fa-circle-check text-lg"></i>
                        <span class="font-bold">{{ session("success") }}</span>
                    </div>
                @endif

                <form action="{{ url("/login") }}" method="POST" class="space-y-5">
                    @csrf

                    <div class="form-control">
                        <label class="label ml-1 text-xs font-bold uppercase text-slate-600">Email</label>
                        <div class="group relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 transition-colors group-focus-within:text-emerald-500">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <input type="email" name="email" value="{{ old("email") }}" required
                                class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 pl-11 transition-all focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50"
                                placeholder="nama@email.com">
                        </div>
                        @error("email")
                            <p class="ml-1 mt-1 text-[11px] font-bold text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-control">
                        <div class="mb-1 flex items-center justify-between">
                            <label class="label ml-1 text-xs font-bold uppercase text-slate-600">Password</label>
                            <a href="#" class="text-[11px] font-bold text-emerald-600 hover:underline">Lupa
                                Password?</a>
                        </div>
                        <div class="group relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 transition-colors group-focus-within:text-emerald-500">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input type="password" name="password" required
                                class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 pl-11 transition-all focus:border-emerald-500 focus:ring-4 focus:ring-emerald-50"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit"
                        class="btn mt-2 h-14 w-full rounded-2xl border-none bg-emerald-600 text-lg font-black text-white shadow-xl shadow-emerald-200 transition-all hover:bg-emerald-700 active:scale-95">
                        Masuk Sekarang
                    </button>
                </form>

                <div class="mt-10 text-center">
                    <p class="text-sm text-slate-500">
                        Belum punya akun? <br>
                        <a href="{{ url("/registrasi") }}"
                            class="font-extrabold text-emerald-600 transition-colors hover:text-emerald-700">Daftar
                            sebagai Pelanggan Baru</a>
                    </p>
                </div>

                <div class="mt-8 border-t border-slate-100 pt-6 text-center">
                    <p class="text-[10px] font-bold uppercase tracking-[2px] text-slate-400">Buberta Rent © 2026</p>
                    <p class="mt-1 text-[9px] uppercase tracking-widest text-slate-300">BUMDes Bersama Betara</p>
                </div>
            </div>
        </div>

    </body>

</html>
