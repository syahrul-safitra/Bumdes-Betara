@extends('Admin.Layouts.main') {{-- Sesuaikan dengan nama layout admin Anda --}}

@section('content')
    <div class="p-6 max-w-7xl mx-auto space-y-6">

        {{-- Alert Notifikasi Sukses/Gagal --}}
        @if (session('success'))
            <div class="alert alert-success rounded-2xl border-none text-white font-bold shadow-md shadow-emerald-100 mb-4">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Top Header --}}
        <div
            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div>
                <h1 class="text-xl font-black text-slate-800 tracking-tight flex items-center gap-2">
                    <span class="p-2 bg-indigo-50 text-indigo-600 rounded-xl"><i class="fa-solid fa-people-roof"></i></span>
                    Manajemen Kelompok SPP
                </h1>
                <p class="text-xs text-slate-400 mt-1">Kelola data induk kelompok perempuan dan berkas KTP anggota BUMDes.
                </p>
            </div>

            {{-- Tombol Tambah Kelompok Baru --}}
            <a href="{{ url('/spp-group/create') }}"
                class="btn rounded-2xl border-none bg-indigo-600 hover:bg-indigo-700 text-white font-black uppercase tracking-wider text-xs px-6 shadow-xl shadow-indigo-100 transition-all hover:-translate-y-0.5">
                <i class="fa-solid fa-plus-circle mr-1.5 text-sm"></i> Tambah Kelompok
            </a>
        </div>

        {{-- Tabel List Kelompok --}}
        <div class="bg-white p-6 rounded-[2.5rem] border border-slate-100 shadow-sm">
            <div class="overflow-x-auto w-full">
                <table class="table w-full">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 text-xs uppercase font-black tracking-wider">
                            <th class="bg-transparent w-12 text-center">No</th>
                            <th class="bg-transparent">Nama Kelompok</th>
                            <th class="bg-transparent">Ketua Kelompok (PIC)</th>
                            <th class="bg-transparent text-center">Jumlah Anggota</th>
                            <th class="bg-transparent text-center">Status</th>
                            <th class="bg-transparent text-center w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($groups as $index => $group)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                {{-- Nomor urut --}}
                                <td class="text-center bg-transparent font-bold text-slate-400 text-sm">
                                    {{ $index + 1 }}
                                </td>

                                {{-- Nama Kelompok & Wilayah --}}
                                <td class="bg-transparent">
                                    <div class="font-black text-slate-800 text-sm tracking-tight">
                                        Kelompok {{ $group->nama_kelompok }}
                                    </div>
                                    <div class="text-[11px] text-slate-400 mt-0.5 flex items-center gap-1">
                                        <i class="fa-solid fa-location-dot text-slate-300"></i>
                                        {{ Str::limit($group->alamat_kelompok, 40) }}
                                    </div>
                                </td>

                                {{-- Ketua Kelompok & Kontak --}}
                                <td class="bg-transparent">
                                    <div class="font-bold text-slate-700 text-sm">
                                        {{ $group->nama_ketua }}
                                    </div>
                                    <div class="text-[11px] text-indigo-600 font-semibold mt-0.5 flex items-center gap-1">
                                        <i class="fa-solid fa-phone text-indigo-400 text-[10px]"></i>
                                        {{ $group->no_hp_ketua }}
                                    </div>
                                </td>

                                {{-- Jumlah Anggota --}}
                                <td class="text-center bg-transparent">
                                    <span
                                        class="badge border-none bg-slate-100 text-slate-700 font-black px-3 py-2.5 rounded-xl text-xs">
                                        <i
                                            class="fa-solid fa-users mr-1.5 text-slate-400 text-[10px]"></i>{{ $group->members_count + 1 }}
                                        Orang
                                    </span>
                                </td>

                                {{-- Status Keaktifan --}}
                                <td class="text-center bg-transparent">
                                    @if ($group->status == 'aktif')
                                        <span
                                            class="badge badge-xs border-none bg-emerald-100 text-emerald-700 font-bold uppercase text-[9px] px-2.5 py-2 rounded-lg">Aktif</span>
                                    @else
                                        <span
                                            class="badge badge-xs border-none bg-slate-100 text-slate-400 font-bold uppercase text-[9px] px-2.5 py-2 rounded-lg">Non-Aktif</span>
                                    @endif
                                </td>

                                {{-- Tombol Aksi Kerja --}}
                                <td class="text-center bg-transparent">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Tombol Detail Kelompok (Melihat list KTP anggota) --}}
                                        <a href="{{ url('/spp-group/' . $group->id) }}"
                                            class="btn btn-square btn-sm rounded-xl border-none bg-indigo-50 text-indigo-600 hover:bg-indigo-100 shadow-sm"
                                            title="Lihat Anggota & Berkas">
                                            <i class="fa-solid fa-folder-open text-xs"></i>
                                        </a>

                                        {{-- Tombol Edit Data Kelompok --}}
                                        <a href="{{ url('/spp-group/' . $group->id . '/edit') }}"
                                            class="btn btn-square btn-sm rounded-xl border-none bg-amber-50 text-amber-600 hover:bg-amber-100 shadow-sm"
                                            title="Edit Kelompok">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{-- State jika data masih kosong --}}
                            <tr>
                                <td colspan="6" class="text-center bg-transparent py-12">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="p-4 bg-slate-50 text-slate-300 rounded-full text-2xl"><i
                                                class="fa-solid fa-people-group"></i></div>
                                        <div class="text-sm font-black text-slate-400">Belum Ada Kelompok Terdaftar</div>
                                        <p class="text-xs text-slate-400 max-w-xs -mt-1">Silakan tekan tombol "Tambah
                                            Kelompok" di atas untuk mendaftarkan kelompok perempuan pertama.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
