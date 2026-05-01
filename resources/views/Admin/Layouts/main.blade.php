<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - BUMDes Betara IKD</title>
    @vite('resources/css/app.css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- <link rel="stylesheet" href="{{ asset('Js/fw_all.min.css') }}"> --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">

    <style>
        /* Styling khusus agar Trix menyatu dengan tema Emerald */
        trix-toolbar .trix-button--active {
            background-color: var(--color-emerald-50) !important;
        }

        trix-editor {
            min-height: 350px !important;
            border-radius: 1rem !important;
            border-color: var(--color-slate-200) !important;
            background-color: var(--color-slate-50) !important;
            padding: 1rem !important;
            font-family: inherit !important;
        }

        trix-editor:focus {
            outline: none !important;
            border-color: var(--color-emerald-500) !important;
            background-color: white !important;
            box-shadow: 0 0 0 2px var(--color-emerald-100) !important;
        }

        /* Menghilangkan tombol upload file di trix jika hanya teks */
        .trix-button-group--file-tools {
            display: none !important;
        }
    </style>

</head>

<body class="bg-[#f8fafc]">

    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />

        <div class="drawer-content flex flex-col">

            <div class="navbar bg-white/80 backdrop-blur-md sticky top-0 z-30 border-b border-slate-100 px-4 lg:px-8">
                <div class="flex-none lg:hidden">
                    <label for="my-drawer-2" class="btn btn-square btn-ghost drawer-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            class="inline-block w-5 h-5 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16">
                            </path>
                        </svg>
                    </label>
                </div>
                <div class="flex-1">
                    <h2 class="text-lg font-bold text-slate-800 ml-2 lg:ml-0">Dashboard Overview</h2>
                </div>
                <div class="flex-none gap-2">
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                            <div class="w-10 rounded-full border-2 border-emerald-500">
                                <img src="https://ui-avatars.com/api/?name=Syahrul&background=10b981&color=fff" />
                            </div>
                        </div>
                        <ul tabindex="0"
                            class="mt-3 z-[1] p-2 shadow-xl menu menu-sm dropdown-content bg-white rounded-2xl w-52 border border-slate-100">
                            {{-- <li><a>Profile</a></li>
                            <li><a>Settings</a></li> --}}

                            <form action="{{ url('/logout') }}" method="POST">
                                @csrf
                                <li><button class="text-red-500">Logout</button></li>
                            </form>
                        </ul>
                    </div>
                </div>
            </div>

            @yield('content')
        </div>

        @include('Admin.Partials.sidebar')
    </div>

</body>

<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

</html>
