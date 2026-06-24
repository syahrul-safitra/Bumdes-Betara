@extends('SPPMember.Layouts.main') {{-- Sesuaikan dengan nama layout portal kelompok Anda --}}

@section('content')
    <main class="p-6 md:p-10 space-y-6">
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Fasilitas Pinjaman SPP</h1>
            <p class="text-xs text-slate-400 mt-0.5">Pantau status pengajuan modal dan histori kartu angsuran kelompok Anda.
            </p>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table w-full border-none">
                    <thead>
                        <tr
                            class="bg-slate-50/70 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                            <th class="p-5">No. Kontrak</th>
                            <th class="p-5">Plafon Diajukan</th>
                            <th class="p-5">Tenor</th>
                            <th class="p-5">Status Pinjaman</th>
                            <th class="p-5">Pencairan Dana</th>
                            <th class="p-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700 text-xs font-semibold">
                        @forelse($loans as $loan)
                            <tr class="hover:bg-slate-50/30 transition-colors">
                                <td class="p-5 font-bold text-slate-800">
                                    {{ $loan->no_kontrak ?? 'Dalam Proses Verifikasi' }}</td>
                                <td class="p-5">Rp
                                    {{ number_format($loan->plafon_disetujui ?? $loan->plafon_diajukan, 0, ',', '.') }}</td>
                                <td class="p-5">{{ $loan->tenor_bulan }} Bulan</td>
                                <td class="p-5">
                                    @if ($loan->status_loan == 'review')
                                        <span
                                            class="badge bg-amber-50 text-amber-700 border-amber-200 font-bold text-[10px] rounded-lg py-2">Ditinjau
                                            Admin</span>
                                    @elseif($loan->status_loan == 'disetujui')
                                        <span
                                            class="badge bg-emerald-50 text-emerald-700 border-emerald-200 font-bold text-[10px] rounded-lg py-2">Cair
                                            Tahap 1</span>
                                    @elseif($loan->status_loan == 'berjalan')
                                        <span
                                            class="badge bg-indigo-50 text-indigo-700 border-indigo-200 font-bold text-[10px] rounded-lg py-2">Aktif
                                            Berjalan</span>
                                    @elseif($loan->status_loan == 'lunas')
                                        <span
                                            class="badge bg-slate-900 text-white border-none font-bold text-[10px] rounded-lg py-2">Lunas
                                            Total</span>
                                    @else
                                        <span
                                            class="badge bg-red-50 text-red-700 border-red-200 font-bold text-[10px] rounded-lg py-2">{{ $loan->status_loan }}</span>
                                    @endif
                                </td>
                                <td class="p-5">
                                    @if ($loan->status_pencairan == 'cair_awal')
                                        <span class="text-emerald-600 font-bold">Tahap 1 (Rp 2 Juta)</span>
                                    @elseif($loan->status_pencairan == 'cair_penuh')
                                        <span class="text-indigo-600 font-black">Cair Penuh (100%)</span>
                                    @else
                                        <span class="text-slate-400 font-normal">Belum Cair</span>
                                    @endif
                                </td>
                                <td class="p-5 text-center">
                                    @if ($loan->status_loan != 'review' && $loan->status_loan != 'ditolak')
                                        <a href="{{ url('/spp-group-all/' . $loan->id) }}"
                                            class="btn btn-xs bg-slate-900 hover:bg-slate-800 border-none text-white font-bold rounded-lg px-3 py-1.5 normal-case inline-flex items-center gap-1">
                                            <i class="fa-solid fa-receipt text-[10px]"></i> Lihat Kartu Angsuran
                                        </a>
                                    @else
                                        <span class="text-[11px] italic font-medium text-slate-400">Jadwal Belum
                                            Terbit</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-slate-400 font-medium">
                                    <i class="fa-solid fa-folder-open text-2xl block mb-2 text-slate-300"></i>
                                    Kelompok Anda belum memiliki riwayat pengajuan pinjaman SPP.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
