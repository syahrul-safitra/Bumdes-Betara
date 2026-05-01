@extends('Customer.Layouts.main')

@section('content')
    <div class="min-h-screen bg-slate-50 py-10">
        <div class="container mx-auto px-4 md:px-10">

            {{-- Header Halaman --}}
            <div class="mb-8">
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Riwayat Sewa & Profil</h1>
                <p class="text-sm text-slate-500 font-medium">Pantau aktivitas penyewaan kendaraan Anda di sini.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- KOLOM KIRI: PROFIL CUSTOMER --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="h-24 bg-emerald-600"></div>
                        <div class="px-6 pb-8">
                            {{-- Foto/Avatar --}}
                            <div class="relative -mt-12 mb-4">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->nama) }}&background=10b981&color=fff&size=128"
                                    class="w-24 h-24 rounded-2xl border-4 border-white shadow-md mx-auto object-cover"
                                    alt="Avatar">
                            </div>

                            <div class="text-center mb-6">
                                <h2 class="text-xl font-bold text-slate-800">{{ $customer->nama }}</h2>
                                <p class="text-sm text-emerald-600 font-bold uppercase tracking-widest">
                                    {{ $customer->email }}</p>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                    <i class="fa-solid fa-phone text-emerald-500 w-5"></i>
                                    <span class="text-sm font-semibold text-slate-600">{{ $customer->no_telepon }}</span>
                                </div>
                                <div class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                                    <i class="fa-solid fa-location-dot text-emerald-500 mt-1 w-5"></i>
                                    <span
                                        class="text-sm font-semibold text-slate-600 leading-relaxed">{{ $customer->alamat }}</span>
                                </div>

                                {{-- Preview KTP --}}
                                <div class="mt-6">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2 px-1">
                                        Identitas KTP</p>
                                    <div
                                        class="group relative overflow-hidden rounded-2xl border-2 border-dashed border-slate-200 aspect-video">
                                        <img src="{{ asset('File/' . $customer->gambar_ktp) }}"
                                            class="w-full h-full object-cover transition-transform group-hover:scale-110"
                                            alt="KTP Customer">
                                        <div
                                            class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <a href="{{ asset('File/' . $customer->gambar_ktp) }}" target="_blank"
                                                class="btn btn-sm btn-white rounded-xl">Lihat Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: TABEL RIWAYAT SEWA --}}
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="font-bold text-lg text-slate-800">Daftar Transaksi</h3>
                            <span class="badge badge-emerald badge-outline font-bold">{{ $customer->rental->count() }}
                                Sewa</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="table table-zebra w-full">
                                <thead>
                                    <tr
                                        class="text-slate-400 uppercase text-[10px] tracking-widest border-b border-slate-50">
                                        <th>Kendaraan</th>
                                        <th>Tanggal Sewa</th>
                                        <th>Total Bayar</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-slate-600 font-medium">
                                    @forelse($customer->rental as $item)
                                        <tr class="border-b border-slate-50 hover:bg-slate-50/50">
                                            <td>
                                                <div class="flex items-center gap-3">
                                                    <div
                                                        class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                                        <i class="fa-solid fa-car"></i>
                                                    </div>
                                                    <span
                                                        class="font-bold text-slate-800">{{ $item->vehicle->nama_kendaraan }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-bold">{{ $item->tanggal_mulai }}</span>
                                                    <span class="text-[10px] text-slate-400 italic">s/d
                                                        {{ $item->tanggal_selesai }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="font-black text-emerald-700">Rp
                                                    {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                                            </td>
                                            <td>
                                                @if ($item->status == 'selesai')
                                                    <div class="badge badge-success gap-2 py-3 px-4 font-bold text-white">
                                                        Selesai</div>
                                                @elseif($item->status == 'proses')
                                                    <div class="badge badge-warning gap-2 py-3 px-4 font-bold text-white">
                                                        Berjalan</div>
                                                @else
                                                    <div class="badge badge-ghost gap-2 py-3 px-4 font-bold opacity-50">
                                                        Dibatalkan</div>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ url('/rental/' . $item->id) }}"
                                                    class="btn btn-ghost btn-sm btn-square rounded-xl hover:bg-emerald-50 hover:text-emerald-600">
                                                    <i class="fa-solid fa-eye text-lg"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-20 text-slate-400 italic">Belum ada
                                                riwayat penyewaan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
