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
        /* Induk wrapper DataTables */
        .dataTables_wrapper {
            @apply font-sans;
        }

        /* Input Pencarian */
        .dataTables_filter input {
            @apply bg-slate-50 border border-slate-200 text-sm rounded-2xl px-4 py-2 outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 !important;
            margin-left: 10px !important;
            min-width: 250px;
        }

        /* Select Length (Tampilkan ...) */
        .dataTables_length select {
            @apply bg-slate-50 border border-slate-200 text-sm rounded-xl px-3 py-1 outline-none focus:border-emerald-500 !important;
            margin: 0 5px !important;
        }

        /* Merapikan Info & Pagination di bawah */
        .dataTables_info {
            @apply text-xs font-bold uppercase tracking-widest text-slate-400 !important;
            padding-top: 1.5rem !important;
        }

        .dataTables_paginate {
            @apply pt-4 !important;
        }

        /* Tombol Pagination */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            @apply rounded-xl border-none font-bold text-xs !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            @apply bg-emerald-600 text-white !important;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current) {
            @apply bg-emerald-50 text-emerald-600 !important;
        }

        /* Hilangkan garis default DataTables */
        table.dataTable.no-footer {
            border-bottom: 1px solid #f1f5f9 !important;
        }
    </style>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

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
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500 text-white shadow-lg shadow-emerald-500/30">
                                <i class="fa-solid fa-leaf text-lg"></i>
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
