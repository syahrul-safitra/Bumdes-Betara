@extends('Admin.Layouts.main')

@section('content')
    <main class="p-6 md:p-10 space-y-8">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Verifikasi & Pengesahan Pinjaman</h1>
                <p class="text-sm text-slate-500 mt-1">Tinjau berkas, sahkan nomor kontrak, dan kelola skema pencairan dana
                    bertahap kelompok SPP.</p>
            </div>
        </div>

        {{-- Flash Message --}}
        @if (session('success'))
            <div class="alert alert-success rounded-2xl shadow-sm text-sm font-bold text-white bg-emerald-500 border-none">
                <i class="fa-solid fa-circle-check text-base"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error rounded-2xl shadow-sm text-sm font-bold text-white bg-red-500 border-none">
                <i class="fa-solid fa-circle-xmark text-base"></i> {{ session('error') }}
            </div>
        @endif

        {{-- 🔥 REVISI BARU: Menampilkan Semua Eror Validasi Form --}}
        @if ($errors->any())
            <div
                class="alert alert-error rounded-2xl shadow-sm text-sm font-bold text-white bg-red-500 border-none flex flex-col items-start gap-1">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-base"></i>
                    <span>Terjadi Kesalahan Pengisian:</span>
                </div>
                <ul class="list-disc list-inside text-xs font-semibold pl-6 space-y-0.5 opacity-90">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Tab Navigasi Status --}}
        <div class="tabs tabs-boxed bg-slate-100 p-1.5 rounded-2xl inline-flex gap-1">
            <a href="{{ url('/spp-loan?status=review') }}"
                class="tab rounded-xl font-bold text-xs px-5 transition-all {{ $status == 'review' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                Menunggu Review
            </a>
            <a href="{{ url('/spp-loan?status=disetujui') }}"
                class="tab rounded-xl font-bold text-xs px-5 transition-all {{ $status == 'disetujui' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                Disetujui / Cair Awal
            </a>
            <a href="{{ url('/spp-loan?status=berjalan') }}"
                class="tab rounded-xl font-bold text-xs px-5 transition-all {{ $status == 'berjalan' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                Sedang Berjalan
            </a>
            <a href="{{ url('/spp-loan?status=lunas') }}"
                class="tab rounded-xl font-bold text-xs px-5 transition-all {{ $status == 'lunas' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                Lunas Total
            </a>
            <a href="{{ url('/spp-loan?status=ditolak') }}"
                class="tab rounded-xl font-bold text-xs px-5 transition-all {{ $status == 'ditolak' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                Ditolak
            </a>
        </div>

        {{-- Tabel Utama Data Pengajuan --}}
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="table w-full border-none">
                    <thead>
                        <tr
                            class="bg-slate-50/70 border-b border-slate-100 text-slate-500 text-xs uppercase tracking-wider font-bold">
                            <th class="p-5">Kelompok SPP</th>
                            <th class="p-5">Pengajuan Dana</th>
                            <th class="p-5">Tenor & Jasa</th>
                            <th class="p-5">Keperluan Usaha</th>
                            <th class="p-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($loans as $loan)
                            <tr class="hover:bg-slate-50/40 transition-colors">
                                {{-- Info Kelompok --}}
                                <td class="p-5">
                                    <div class="font-black text-slate-800 text-sm">
                                        {{ $loan->group->nama_kelompok ?? 'Kelompok Tidak Ditemukan' }}</div>
                                    <div class="text-[11px] text-slate-400 font-medium mt-0.5">Diajukan:
                                        {{ $loan->created_at->format('d M Y - H:i') }} WIB</div>
                                </td>

                                {{-- Nominal Dana --}}
                                <td class="p-5">
                                    <div class="font-black text-slate-800 text-sm">Rp
                                        {{ number_format($loan->nominal_pengajuan, 0, ',', '.') }}</div>
                                    @if ($loan->status_pencairan == 'cair_awal')
                                        <div
                                            class="text-[10px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-md inline-block mt-1">
                                            Cair Awal Rp 2.000.000</div>
                                    @endif
                                </td>

                                {{-- Tenor & Jasa --}}
                                <td class="p-5">
                                    <div class="font-bold text-slate-700 text-sm">{{ $loan->tenor_bulan }} Bulan</div>
                                    <div class="text-[11px] text-slate-400 font-medium mt-0.5">Jasa
                                        {{ $loan->bunga_percent ?? '0.5' }}% / Bulan</div>
                                </td>

                                {{-- Keperluan --}}
                                <td class="p-5 max-w-xs">
                                    <p class="text-xs text-slate-500 leading-relaxed truncate hover:text-clip hover:whitespace-normal transition-all"
                                        title="{{ $loan->keperluan }}">
                                        {{ $loan->keperluan }}
                                    </p>
                                </td>

                                {{-- Tombol Aksi --}}
                                <td class="p-5 text-center">
                                    @if ($loan->status_loan == 'review')
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Tombol Setuju --}}
                                            <button
                                                onclick="openApproveModal({{ $loan->id }}, '{{ $loan->group->nama_kelompok }}', {{ $loan->nominal_pengajuan }}, '{{ $loan->group->no_rek ?? '-' }}')"
                                                class="btn btn-xs bg-emerald-600 hover:bg-emerald-700 border-none text-white font-bold rounded-lg px-3 py-1.5 normal-case">
                                                <i class="fa-solid fa-check mr-1"></i> Setujui
                                            </button>

                                            {{-- Tombol Tolak --}}
                                            <button
                                                onclick="openRejectModal({{ $loan->id }}, '{{ $loan->group->nama_kelompok }}')"
                                                class="btn btn-xs bg-red-100 hover:bg-red-200 border-none text-red-700 font-bold rounded-lg px-3 py-1.5 normal-case">
                                                <i class="fa-solid fa-xmark mr-1"></i> Tolak
                                            </button>
                                        </div>
                                    @else
                                        <a href="{{ url('/spp-loan/' . $loan->id) }}"
                                            class="btn btn-xs bg-slate-900 hover:bg-slate-800 border-none text-white font-bold rounded-lg px-3 py-1.5 normal-case inline-flex items-center gap-1">
                                            <i class="fa-solid fa-money-bill-transfer text-[10px]"></i> Kelola Angsuran
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12 text-slate-400 italic text-xs">
                                    Tidak ada data pengajuan pinjaman dengan status [{{ $status }}].
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    {{-- ================= MODAL DIALOG: SETUJUI PINJAMAN (APPROVE) ================= --}}
    <dialog id="modal_approve" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box rounded-[2rem] border border-slate-200 p-8 shadow-2xl">
            <h3 class="font-black text-lg text-slate-800 flex items-center gap-2">
                <span class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm"><i
                        class="fa-solid fa-signature"></i></span>
                Sahkan Dokumen Perjanjian
            </h3>
            <p class="text-xs text-slate-400 mt-1">Kelompok: <span id="approve_nama_kelompok"
                    class="font-bold text-slate-700"></span> &bull; Pengajuan: <span id="approve_nominal"
                    class="font-bold text-slate-700"></span></p>

            <form id="form_approve" method="POST" enctype="multipart/form-data" class="space-y-4 mt-6">
                @csrf
                @method('PUT')

                {{-- Info Rekening Tujuan Transfer Ketua (TAMPILAN INFORMASI) --}}
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3.5">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider block mb-1">Rekening Tujuan
                        Pencairan (Ketua)</span>
                    <div class="flex items-center gap-2.5">
                        <div
                            class="w-7 h-7 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-credit-card text-xs"></i>
                        </div>
                        <div>
                            <p id="modal_info_rekening" class="text-xs font-extrabold text-slate-800 tracking-wide">-</p>
                        </div>
                    </div>
                </div>

                {{-- Nomor Kontrak --}}
                <div class="form-control">
                    <label class="label text-xs font-bold uppercase text-slate-500 tracking-wider">Nomor Kontrak / SPK
                        Resmi</label>
                    <input type="text" name="no_kontrak" required placeholder="Contoh: SPK/BUMDES/01/VI/2026"
                        class="input input-bordered w-full rounded-xl border-slate-200 bg-slate-50/50 font-bold text-xs text-slate-700 focus:border-indigo-500">
                </div>

                {{-- Berkas Perjanjian --}}
                <div class="form-control">
                    <label class="label text-xs font-bold uppercase text-slate-500 tracking-wider">Upload Berkas PDF
                        Perjanjian</label>
                    <input type="file" name="file_dokumen_perjanjian" required accept="application/pdf"
                        class="file-input file-input-bordered file-input-md w-full rounded-xl border-slate-200 bg-slate-50/50 text-xs font-bold text-slate-700">
                </div>

                {{-- Upload Bukti Transfer Pencairan --}}
                <div class="form-control">
                    <label class="label text-xs font-bold uppercase text-slate-500 tracking-wider">Upload Bukti Transfer
                        Pencairan (JPG/PNG/PDF)</label>
                    <input type="file" name="bukti_transfer" accept="image/*,application/pdf"
                        class="file-input file-input-bordered file-input-md w-full rounded-xl border-slate-200 bg-slate-50/50 text-xs font-bold text-slate-700">
                    <label class="label text-[10px] text-slate-400 font-medium mt-0.5">Sistem akan otomatis mencatatkan
                        pencairan dana awal sebesar <span class="font-bold text-emerald-600">Rp 2.000.000</span>.</label>
                </div>

                <div class="modal-action gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('modal_approve').close()"
                        class="btn btn-sm bg-slate-100 hover:bg-slate-200 border-none text-slate-600 font-bold rounded-xl px-4">Batal</button>
                    <button type="submit"
                        class="btn btn-sm bg-emerald-600 hover:bg-emerald-700 border-none text-white font-black rounded-xl px-5">Sahkan
                        & Cairkan Rp 2 Juta</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- ================= MODAL DIALOG: TOLAK PINJAMAN (REJECT) ================= --}}
    <dialog id="modal_reject" class="modal modal-bottom sm:modal-middle">
        <div class="modal-box rounded-[2rem] border border-slate-200 p-8 shadow-2xl">
            <h3 class="font-black text-lg text-slate-800 flex items-center gap-2">
                <span class="w-8 h-8 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-sm"><i
                        class="fa-solid fa-circle-exclamation"></i></span>
                Tolak Pengajuan Modal
            </h3>
            <p class="text-xs text-slate-400 mt-1">Kelompok: <span id="reject_nama_kelompok"
                    class="font-bold text-slate-700"></span></p>

            <form id="form_reject" method="POST" class="space-y-4 mt-6">
                @csrf
                @method('PUT')

                <div class="form-control">
                    <label class="label text-xs font-bold uppercase text-slate-500 tracking-wider">Alasan Penolakan</label>
                    <textarea name="alasan_penolakan_loan" required rows="3"
                        placeholder="Tuliskan alasan mengapa berkas pengajuan modal kelompok ini ditolak..."
                        class="textarea textarea-bordered w-full rounded-xl bg-slate-50/50 border-slate-200 text-xs font-semibold leading-relaxed text-slate-700 focus:border-red-500"></textarea>
                </div>

                <div class="modal-action gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('modal_reject').close()"
                        class="btn btn-sm bg-slate-100 hover:bg-slate-200 border-none text-slate-600 font-bold rounded-xl px-4">Batal</button>
                    <button type="submit"
                        class="btn btn-sm bg-red-600 hover:bg-red-700 border-none text-white font-black rounded-xl px-5">Tolak
                        Pengajuan</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- ================= JAVASCRIPT MODAL BINDER ================= --}}
    <script>
        function openApproveModal(id, namaKelompok, nominal, noRekening) {
            document.getElementById('approve_nama_kelompok').innerText = namaKelompok;
            document.getElementById('approve_nominal').innerText = 'Rp ' + nominal.toLocaleString('id-ID');

            // 🔥 Masukkan info nomor rekening ketua ke dalam modal
            document.getElementById('modal_info_rekening').innerText = noRekening && noRekening !== '-' ? noRekening :
                'Tidak ada data nomor rekening';

            document.getElementById('form_approve').action = `spp-loan-approve/${id}`;
            document.getElementById('modal_approve').showModal();
        }

        function openRejectModal(id, namaKelompok) {
            document.getElementById('reject_nama_kelompok').innerText = namaKelompok;
            document.getElementById('form_reject').action = `/spp-loan-reject/${id}`;
            document.getElementById('modal_reject').showModal();
        }
    </script>
@endsection
