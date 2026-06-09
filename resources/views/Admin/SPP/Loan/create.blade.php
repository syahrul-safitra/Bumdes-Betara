@extends('Admin.Layouts.main')

@section('content')
    <div class="p-6 max-w-3xl mx-auto space-y-6">

        {{-- Error Validation Alert --}}
        @if ($errors->any())
            <div class="alert alert-error rounded-2xl border-none text-white font-bold shadow-md p-4">
                <div class="flex flex-col gap-1">
                    <span class="text-sm font-black flex items-center gap-2">
                        <i class="fa-solid fa-triangle-exclamation"></i> Terjadi Kesalahan Input:
                    </span>
                    <ul class="list-disc list-inside text-xs font-medium pl-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- Header --}}
        <div class="flex items-center gap-4 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-2xl"><i class="fa-solid fa-file-signature text-xl"></i></div>
            <div>
                <h1 class="text-xl font-black text-slate-800 tracking-tight">Buat Pengajuan Kontrak SPP</h1>
                <p class="text-xs text-slate-400 mt-0.5">Daftarkan jumlah plafon pinjaman baru dan tenor angsuran untuk
                    kelompok aktif.</p>
            </div>
        </div>

        {{-- Form Utama --}}
        <form action="{{ url('/spp-loan') }}" method="POST">
            @csrf

            <div class="rounded-[2.5rem] border border-slate-100 bg-white p-8 shadow-xl shadow-slate-100/50 space-y-6">
                <h2 class="text-xs font-black uppercase tracking-[0.2em] text-indigo-600 mb-2">
                    <i class="fa-solid fa-calculator mr-1"></i> Parameter Pembiayaan
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Pilih Kelompok --}}
                    <div class="flex w-full flex-col md:col-span-2">
                        <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Kelompok Perempuan (Penerima
                            Manfaat)</label>
                        <select name="group_id"
                            class="select select-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0 font-medium"
                            required>
                            <option value="" disabled selected>-- Pilih Kelompok SPP --</option>
                            @foreach ($groups as $group)
                                <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                                    Kelompok {{ $group->nama_kelompok }} (Ketua: {{ $group->nama_ketua }} - Anggota:
                                    {{ $group->members->count() + 1 }} Orang)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nomor Kontrak Pinjaman --}}
                    <div class="flex w-full flex-col">
                        <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Nomor Kontrak / Perjanjian</label>
                        <input type="text" name="no_kontrak" value="{{ old('no_kontrak') }}"
                            placeholder="Contoh: SPP/PUPR/{{ date('Y') }}/001"
                            class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0"
                            required />
                    </div>

                    {{-- Plafon Disetujui --}}
                    <div class="flex w-full flex-col">
                        <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Nominal Plafon Disetujui (Rp)</label>
                        <input type="number" name="plafon_disetujui" value="{{ old('plafon_disetujui') }}"
                            placeholder="Contoh: 10000000"
                            class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0"
                            required />
                    </div>

                    {{-- Suku Bunga Bulanan --}}
                    <div class="flex w-full flex-col">
                        <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Suku Bunga Bulanan (%)</label>
                        <input type="number" step="0.01" name="bunga_persen" value="{{ old('bunga_persen', 0.5) }}"
                            placeholder="Contoh: 0.5"
                            class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0 font-bold text-indigo-600"
                            required />
                        <span class="text-[10px] text-slate-400 mt-1 ml-1">* Ketentuan default BUMDes umumnya 0.5% <br> 0.5
                            = 5%</span>
                    </div>

                    {{-- Tenor Masa Pinjaman --}}
                    <div class="flex w-full flex-col">
                        <label class="mb-2 ml-1 text-sm font-bold text-slate-600">Tenor Jangka Waktu (Bulan)</label>
                        <select name="tenor_bulan"
                            class="select select-bordered w-full rounded-2xl border-slate-200 bg-slate-50 px-5 focus:border-indigo-500 focus:outline-none focus:ring-0 font-medium"
                            required>
                            <option value="6" {{ old('tenor_bulan') == 6 ? 'selected' : '' }}>6 Bulan</option>
                            <option value="10" {{ old('tenor_bulan', 10) == 10 ? 'selected' : '' }}>10 Bulan</option>
                            <option value="12" {{ old('tenor_bulan') == 12 ? 'selected' : '' }}>12 Bulan</option>
                            <option value="24" {{ old('tenor_bulan') == 24 ? 'selected' : '' }}>24 Bulan</option>
                        </select>
                    </div>
                </div>

                {{-- FOOTER ACTION --}}
                <div class="flex items-center justify-end gap-4 border-t border-slate-100 pt-6 mt-4">
                    <a href="{{ url('/spp-loan') }}"
                        class="btn btn-ghost rounded-2xl px-10 font-black uppercase tracking-widest text-slate-400">
                        Batal
                    </a>
                    <button type="submit"
                        class="btn rounded-2xl border-none bg-indigo-600 px-12 font-black uppercase tracking-widest text-white shadow-xl shadow-indigo-100 transition-all hover:-translate-y-1 hover:bg-indigo-700">
                        Simpan Pengajuan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
