@extends('SPPMember.Layouts.main')

@section('content')

    <main class="flex-1 p-6 md:p-10">

        {{-- Header Dashboard --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Selamat Datang, {{ $spp->nama_ketua }}</h1>
                <p class="text-sm text-slate-500 mt-1">Panel pemantauan dan pengajuan dana bergulir SPP.</p>
            </div>
            <div class="px-5 py-3 bg-white rounded-2xl border border-slate-200 shadow-sm flex items-center gap-3">
                <div
                    class="w-2.5 h-2.5 rounded-full {{ $spp->status_validasi == 'valid' ? 'bg-emerald-500' : ($spp->status_validasi == 'ditolak' ? 'bg-red-500' : 'bg-amber-500') }}">
                </div>
                <span class="text-xs font-black uppercase tracking-wider text-slate-600">
                    Kelompok: {{ $spp->nama_kelompok }}
                </span>
            </div>
        </div>

        {{-- Logika 2 Kondisi Berdasarkan Variabel $spp --}}
        @if ($spp->status_validasi == 'pending')
            {{-- ================= KONDISI 1: JIKA STATUS PENDING ================= --}}
            <div class="grid grid-cols-1 gap-8">
                {{-- Banner Peringatan Onboarding --}}
                <div
                    class="p-8 bg-amber-50 rounded-[2.5rem] border border-amber-200 flex flex-col md:flex-row items-start gap-6 shadow-sm">
                    <div
                        class="w-14 h-14 bg-amber-500 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg shadow-amber-500/20 shrink-0">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-xl font-black text-amber-900">Berkas Pendaftaran Sedang Ditinjau</h3>
                        <p class="text-sm text-amber-700 leading-relaxed max-w-3xl">
                            Akun ketua berhasil dibuat. Agar admin dapat memvalidasi kelompok Anda, silakan pastikan Anda
                            telah melengkapi <strong>Profil Kelompok</strong>, mengunggah <strong>Foto KTP</strong>, dan
                            memasukkan data minimal pengurus di menu <strong>Data Anggota</strong>.
                        </p>
                        <div class="pt-2 flex flex-wrap gap-3">
                            <a href="{{ url('/spp-group-rev') }}"
                                class="btn btn-sm bg-amber-600 hover:bg-amber-700 border-none text-white font-bold rounded-xl px-4 text-xs">
                                <i class="fa-solid fa-building-user mr-1.5"></i> Lengkapi Profil
                            </a>

                            {{-- TOMBOL BARU: Hubungi Admin via WhatsApp --}}
                            @if (isset($no_telepon) && $no_telepon)
                                @php
                                    // Bersihkan nomor telepon dari karakter spasi, strip, atau plus agar formatnya bersih
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $no_telepon);
                                    // Jika nomor dimulai dengan '0', ubah menjadi kode negara '62'
                                    if (str_starts_with($cleanPhone, '0')) {
                                        $cleanPhone = '62' . substr($cleanPhone, 1);
                                    }

                                @endphp
                                <a href="https://api.whatsapp.com/send?phone={{ $cleanPhone }}&text=Halo%20Admin%20BUMDes%2C%20kami%20dari%20kelompok%20baru%20sudah%20mendaftar%20di%20portal%20SPP.%20Mohon%20bantuannya%20untuk%20proses%20validasi%20berkas.%20Terima%20kasih."
                                    target="_blank"
                                    class="btn btn-sm bg-emerald-600 hover:bg-emerald-700 border-none text-white font-bold rounded-xl px-4 text-xs flex items-center gap-1.5 shadow-md shadow-emerald-100">
                                    <i class="fa-brands fa-whatsapp text-sm"></i> Hubungi Admin
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Stepper Alur Pengajuan --}}
                <div class="bg-white p-8 rounded-[3rem] border border-slate-200 shadow-sm">
                    <h4 class="text-xs font-black uppercase tracking-widest text-slate-400 mb-6"><i
                            class="fa-solid fa-route mr-1.5"></i> Tahapan Prosedur SPP</h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative">
                        <div class="p-5 bg-indigo-50/50 rounded-2xl border border-indigo-100 relative">
                            <span class="absolute top-4 right-4 text-xs font-black text-indigo-400">01</span>
                            <i class="fa-solid fa-user-check text-xl text-indigo-600 mb-3 block"></i>
                            <p class="text-sm font-bold text-slate-800">Buat Akun</p>
                            <p class="text-xs text-slate-400 mt-1">Registrasi dasar ketua kelompok.</p>
                        </div>
                        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 relative">
                            <span class="absolute top-4 right-4 text-xs font-black text-slate-300">02</span>
                            <i class="fa-solid fa-file-invoice text-xl text-slate-400 mb-3 block"></i>
                            <p class="text-sm font-bold text-slate-600">Lengkapi Berkas</p>
                            <p class="text-xs text-slate-400 mt-1">Isi data kelompok & KTP anggota.</p>
                        </div>
                        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 relative">
                            <span class="absolute top-4 right-4 text-xs font-black text-slate-300">03</span>
                            <i class="fa-solid fa-user-shield text-xl text-slate-400 mb-3 block"></i>
                            <p class="text-sm font-bold text-slate-600">Validasi Admin</p>
                            <p class="text-xs text-slate-400 mt-1">Pemeriksaan kelayakan oleh BUMDes.</p>
                        </div>
                        <div class="p-5 bg-slate-50 rounded-2xl border border-slate-200 relative">
                            <span class="absolute top-4 right-4 text-xs font-black text-slate-300">04</span>
                            <i class="fa-solid fa-hand-holding-dollar text-xl text-slate-400 mb-3 block"></i>
                            <p class="text-sm font-bold text-slate-600">Ajukan Pinjaman</p>
                            <p class="text-xs text-slate-400 mt-1">Pencairan modal usaha kelompok.</p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($spp->status_validasi == 'ditolak')
            {{-- ================= KONDISI TAMBAHAN: JIKA STATUS DITOLAK ================= --}}
            <div
                class="p-8 bg-red-50 rounded-[2.5rem] border border-red-200 flex flex-col md:flex-row items-start gap-6 shadow-sm">
                <div
                    class="w-14 h-14 bg-red-500 rounded-2xl flex items-center justify-center text-white text-2xl shadow-lg shadow-red-500/20 shrink-0">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
                <div class="space-y-1">
                    <h3 class="text-xl font-black text-red-900">Berkas Kelompok Ditolak Admin</h3>
                    <p class="text-sm text-red-700 leading-relaxed">
                        Mohon maaf, berkas pendaftaran Anda belum memenuhi syarat verifikasi internal dengan alasan
                        penolakan berikut:
                    </p>
                    <div
                        class="p-4 bg-white/80 rounded-xl border border-red-200 mt-2 text-sm font-bold text-red-800 italic">
                        "{{ $spp->alasan_ditolak ?? 'Berkas tidak jelas atau tidak lengkap.' }}"
                    </div>
                    <p class="text-xs text-red-500 pt-2">Silakan perbaiki data profil kelompok atau hubungi admin BUMDes
                        untuk informasi lebih lanjut.</p>
                </div>
            </div>
        @else
            {{-- ================= KONDISI 2: JIKA STATUS VALID ================= --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Total Anggota --}}
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-5">
                    <div
                        class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 text-xl">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Anggota</p>
                        <p class="text-2xl font-black text-slate-800 mt-0.5">{{ $totalAnggota ?? 0 }} Orang</p>
                    </div>
                </div>
                {{-- Status Kredit --}}
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-5">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 text-xl">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status Pinjaman</p>
                        <p class="text-lg font-black text-slate-800 mt-1">{{ $statusLoan ?? 'Tidak Ada Pinjaman' }}</p>
                    </div>
                </div>
                {{-- Sisa Hutang --}}
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-5">
                    <div
                        class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 text-xl">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sisa Pokok Hutang</p>
                        <p class="text-2xl font-black text-slate-800 mt-0.5">Rp
                            {{ number_format($sisaHutang ?? 0, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Grid Informasi Utama & Billing Alert --}}
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                {{-- Kolom Kiri: Riwayat Pengajuan --}}
                <div class="lg:col-span-7 bg-white p-8 rounded-[3rem] border border-slate-200 shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-black text-slate-800">Riwayat Pengajuan Terakhir</h3>
                        <a href="{{ url('/group/loans') }}" class="text-xs font-bold text-indigo-600 hover:underline">Lihat
                            Semua</a>
                    </div>

                    @if (empty($recentLoan))
                        <div class="text-center py-12 border-2 border-dashed border-slate-100 rounded-2xl">
                            <img src="https://illustrations.popsy.co/slate/financial-statement.svg"
                                class="w-32 mx-auto mb-4 opacity-60" alt="">
                            <p class="text-sm font-bold text-slate-400">Belum ada riwayat pengajuan pinjaman modal.</p>
                            <a href="{{ url('/group/loans') }}"
                                class="btn btn-sm bg-indigo-600 hover:bg-indigo-700 text-white font-bold border-none rounded-xl text-xs mt-3 px-4">
                                <i class="fa-solid fa-plus mr-1"></i> Ajukan Sekarang
                            </a>
                        </div>
                    @else
                        {{-- Iterasi data riwayat pinjaman --}}
                    @endif
                </div>

                {{-- Kolom Kanan: Billing Alert Card --}}
                <div class="lg:col-span-5 space-y-6">
                    <div
                        class="bg-slate-900 p-6 rounded-[2.5rem] text-white relative overflow-hidden shadow-xl shadow-indigo-900/10">
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-600/20 rounded-full blur-xl"></div>

                        <span
                            class="badge border-none bg-indigo-500/20 text-indigo-400 font-bold px-3 py-3 rounded-xl text-[10px] uppercase tracking-wider mb-4 block w-fit">
                            <i class="fa-solid fa-clock-history mr-1.5"></i> Informasi Tagihan
                        </span>

                        @if (isset($tagihanBulanIni))
                            <p class="text-xs text-slate-400 font-medium">Angsuran Bulan Ini</p>
                            <h4 class="text-3xl font-black text-white mt-1">Rp
                                {{ number_format($tagihanBulanIni, 0, ',', '.') }}</h4>
                            <div class="mt-4 pt-4 border-t border-slate-800 flex justify-between text-xs text-slate-400">
                                <span>Jatuh Tempo:</span>
                                <span class="font-bold text-indigo-400">{{ $jatuhTempo ?? '-' }}</span>
                            </div>
                        @else
                            <div class="py-4 text-center">
                                <i class="fa-solid fa-shield-cat text-3xl text-slate-700 mb-2"></i>
                                <p class="text-xs text-slate-400 leading-relaxed font-semibold">Tidak ada tagihan angsuran
                                    aktif yang perlu dibayar saat ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    </main>
@endsection
