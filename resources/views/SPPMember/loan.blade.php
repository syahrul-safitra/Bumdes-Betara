 @extends('SPPMember.Layouts.main')

 @section('content')
     <main class="p-6 md:p-10 space-y-8">

         {{-- Judul Halaman --}}
         <div>
             <h1 class="text-3xl font-black text-slate-800 tracking-tight">Pengajuan Dana Modal SPP</h1>
             <p class="text-sm text-slate-500 mt-1">Simulasikan angsuran kelompok secara transparan dan ajukan bantuan modal
                 keuangan BUMDes.</p>
         </div>

         {{-- Alert Notifikasi Sukses / Gagal --}}
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

         {{-- Grid Utama --}}
         <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

             {{-- KOLOM KIRI (LEBAR: 3/5): FORM DAN KALKULATOR SIMULASI INTERAKTIF --}}
             <div class="lg:col-span-3">

                 {{-- Cek Apakah Kelompok Memiliki Pinjaman Aktif Yang Belum Lunas --}}
                 @php
                     $hasActiveLoan = $loans
                         ->whereIn('status_loan', ['review', 'disetujui', 'berjalan', 'macet'])
                         ->first();
                 @endphp

                 @if ($hasActiveLoan)
                     {{-- Panel Pengunci Form jika Ada Pinjaman Berjalan --}}
                     <div class="bg-amber-50 border border-amber-200 p-8 rounded-[2.5rem] text-center space-y-4">
                         <div
                             class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center text-xl mx-auto shadow-sm">
                             <i class="fa-solid fa-hand-holding-dollar"></i>
                         </div>
                         <div class="max-w-md mx-auto">
                             <h3 class="font-black text-lg text-amber-900">Form Pengajuan Dikunci</h3>
                             <p class="text-xs text-amber-700 leading-relaxed mt-1">
                                 Kelompok Anda saat ini memiliki pengajuan pinjaman yang sedang berstatus <span
                                     class="font-bold uppercase text-amber-900 bg-amber-200/50 px-2 py-0.5 rounded-md">[{{ $hasActiveLoan->status_loan }}]</span>.
                                 Berdasarkan aturan BUMDes, pelunasan atau penyelesaian peninjauan pinjaman sebelumnya wajib
                                 diselesaikan sebelum mengajukan modal baru.
                             </p>
                         </div>

                         {{-- Tombol Hubungi Admin via WhatsApp --}}

                         <div class="pt-2">
                             <a href="https://wa.me/{{ '62' . substr($noHp[0]->no_telepon, 1) }}?text=Halo%20Admin%20BUMDes%2C%20saya%20Ketua%20Kelompok%20ingin%20bertanya%20mengenai%20status%20pengajuan%20pinjaman%20kami%20yang%20sedang%20dalam%20status%20%5B{{ $hasActiveLoan->status_loan }}%5D."
                                 target="_blank"
                                 class="btn btn-sm inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 border-none text-white text-xs font-black rounded-xl px-5 py-2.5 transition-all shadow-md shadow-emerald-100 active:scale-95 normal-case">
                                 <i class="fa-brands fa-whatsapp text-sm"></i>
                                 Hubungi Admin BUMDes
                             </a>
                         </div>
                     </div>
                 @else
                     {{-- Form Pengajuan Aktif --}}
                     <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-6">
                         <div class="flex items-center gap-3 border-b border-slate-100 pb-4">
                             <div
                                 class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-base">
                                 <i class="fa-solid fa-calculator"></i>
                             </div>
                             <div>
                                 <h2 class="text-md font-black text-slate-800">Simulasi & Formulir Digital</h2>
                                 <p class="text-xs text-slate-400">Tentukan nominal dan jangka waktu pengembalian dana.</p>
                             </div>
                         </div>

                         <form action="{{ url('/spp-group-loan') }}" method="POST" class="space-y-6">
                             @csrf

                             <input type="hidden" name="group_id" value="{{ auth()->guard('spp')->user()->id }}">

                             {{-- Input Nominal Dana --}}
                             <div class="form-control">
                                 {{-- Label Judul Input --}}
                                 <label class="label ml-1 text-xs font-bold uppercase text-slate-500 tracking-wider">
                                     Nominal Dana Yang Diajukan
                                 </label>

                                 {{-- Pembungkus Relative KHUSUS untuk Input dan Icon/Teks Absolute --}}
                                 <div class="relative">
                                     <div
                                         class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 font-black text-sm text-slate-400">
                                         Rp
                                     </div>
                                     <input type="number" name="nominal_pengajuan" id="input_nominal" required
                                         min="2000000" step="500000" max="20000000"
                                         class="input input-bordered w-full rounded-2xl border-slate-200 bg-slate-50/50 pl-12 font-bold text-slate-700 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50"
                                         placeholder="Contoh: 10000000" oninput="validasiDanHitung()">
                                 </div> {{-- Penutup Relative dipindah ke sini --}}

                                 {{-- Teks indikator & Error diletakkan di LUAR wadah relative --}}
                                 @error('nominal_pengajuan')
                                     <p class="ml-1 mt-1 text-[11px] font-bold text-red-500">{{ $message }}</p>
                                 @else
                                     <p class="ml-1 mt-1 text-[10px] text-slate-400 font-medium">
                                         Batas pengajuan dana modal: <span class="font-bold text-slate-600">Rp 2.000.000 s/d Rp
                                             20.000.000</span>.
                                     </p>
                                 @enderror
                             </div>

                             {{-- Pilihan Tenor Jangka Waktu (Buttons Pills) --}}
                             <div class="form-control">
                                 <label class="label ml-1 text-xs font-bold uppercase text-slate-500 tracking-wider">Tenor
                                     Jangka Waktu Angsuran</label>
                                 <div class="grid grid-cols-4 gap-2">
                                     @foreach ([6, 10, 12, 24] as $bulan)
                                         <label class="cursor-pointer">
                                             <input type="radio" name="tenor_bulan" value="{{ $bulan }}"
                                                 {{ $bulan == 12 ? 'checked' : '' }} class="peer hidden"
                                                 onchange="hitungSimulasi()">
                                             <div
                                                 class="p-3 text-center border border-slate-200 rounded-xl font-bold text-xs bg-slate-50/40 text-slate-500 transition-all peer-checked:bg-slate-900 peer-checked:text-white peer-checked:border-slate-900 hover:bg-slate-100">
                                                 {{ $bulan }} Bulan
                                             </div>
                                         </label>
                                     @endforeach
                                 </div>
                             </div>

                             {{-- Tujuan Keperluan --}}
                             <div class="form-control">
                                 <label class="label ml-1 text-xs font-bold uppercase text-slate-500 tracking-wider">Tujuan
                                     Penggunaan Modal Usaha</label>
                                 <textarea name="keperluan" required rows="3"
                                     placeholder="Jelaskan jenis usaha kelompok yang akan dikembangkan menggunakan dana ini..."
                                     class="textarea textarea-bordered w-full rounded-2xl bg-slate-50/50 border-slate-200 focus:border-indigo-500 font-semibold text-xs leading-relaxed text-slate-700"></textarea>
                             </div>

                             {{-- PANEL LIVE PREVIEW JALUR LIVE JAVASCRIPT --}}
                             <div class="p-5 bg-slate-50 border border-slate-100 rounded-2xl space-y-3">
                                 <h4
                                     class="text-[11px] font-black uppercase text-slate-400 tracking-widest flex items-center gap-1.5">
                                     <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span> Estimasi Angsuran Bulanan
                                     (Jasa 0.5% Flat)
                                 </h4>
                                 <div class="grid grid-cols-3 gap-2 pt-1 border-t border-slate-200/60 text-xs">
                                     <div>
                                         <p class="text-slate-400 font-medium">Angsuran Pokok</p>
                                         <p class="font-black text-slate-700 mt-0.5" id="view_pokok">Rp 0</p>
                                     </div>
                                     <div>
                                         <p class="text-slate-400 font-medium">Jasa BUMDes (0.5%)</p>
                                         <p class="font-black text-slate-700 mt-0.5" id="view_jasa">Rp 0</p>
                                     </div>
                                     <div class="text-right">
                                         <p class="text-indigo-600 font-bold">Total / Bulan</p>
                                         <p class="font-black text-base text-indigo-600 mt-0.5" id="view_total">Rp 0</p>
                                     </div>
                                 </div>
                             </div>

                             {{-- Tombol Kirim Form --}}
                             <button type="submit"
                                 class="btn h-12 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black rounded-xl border-none text-xs shadow-lg shadow-indigo-100 transition-all active:scale-95">
                                 <i class="fa-solid fa-paper-plane mr-1.5"></i> Kirim Pengajuan Modal
                             </button>
                         </form>
                     </div>
                 @endif
             </div>

             {{-- KOLOM KANAN (LEBAR: 2/5): TABEL RIWAYAT PENGAJUAN DAN FILE PERJANJIAN --}}
             <div class="lg:col-span-2 space-y-6">

                 <div class="bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm space-y-4">
                     <div class="flex items-center gap-2">
                         <i class="fa-solid fa-clock-rotate-left text-slate-400 text-sm"></i>
                         <h3 class="text-sm font-black text-slate-800">Riwayat Pengajuan</h3>
                     </div>

                     <div class="space-y-3">
                         @forelse($loans as $loan)
                             <div class="p-4 bg-slate-50/70 border border-slate-100 rounded-2xl space-y-3">
                                 <div class="flex justify-between items-start">
                                     <div>
                                         <p class="text-xs font-black text-slate-800">Rp
                                             {{ number_format($loan->nominal_pengajuan, 0, ',', '.') }}</p>
                                         <p class="text-[10px] text-slate-400 font-medium mt-0.5">Tenor
                                             {{ $loan->tenor_bulan }} Bulan &bull;
                                             {{ $loan->created_at->format('d M Y') }}
                                         </p>
                                     </div>

                                     {{-- Status Loan Badge --}}
                                     <div>
                                         @if ($loan->status_loan == 'review')
                                             <span
                                                 class="badge bg-amber-50 text-amber-700 border-amber-200 font-bold text-[10px] py-2 rounded-lg">Ditinjau</span>
                                         @elseif($loan->status_loan == 'disetujui' || $loan->status_loan == 'berjalan')
                                             <span
                                                 class="badge bg-emerald-50 text-emerald-700 border-emerald-200 font-bold text-[10px] py-2 rounded-lg">Aktif</span>
                                         @elseif($loan->status_loan == 'lunas')
                                             <span
                                                 class="badge bg-indigo-50 text-indigo-700 border-indigo-200 font-bold text-[10px] py-2 rounded-lg">Lunas</span>
                                         @else
                                             <span
                                                 class="badge bg-red-50 text-red-700 border-red-200 font-bold text-[10px] py-2 rounded-lg">Ditolak</span>
                                         @endif
                                     </div>
                                 </div>

                                 {{-- Informasi Tambahan Jika Disetujui (Dokumen Kontrak / No Surat) --}}
                                 @if (($loan->status_loan == 'disetujui' || $loan->status_loan == 'berjalan') && $loan->no_kontrak)
                                     <div
                                         class="pt-2 border-t border-slate-200/60 flex justify-between items-center text-[11px]">
                                         <div class="font-medium text-slate-500">
                                             <p class="text-[9px] uppercase tracking-wider text-slate-400">No Kontrak Resmi
                                             </p>
                                             <span class="font-bold text-slate-700">{{ $loan->no_kontrak }}</span>
                                         </div>
                                         @if ($loan->file_dokumen_perjanjian)
                                             <a href="{{ asset('File/SPP/Berkas/' . $loan->file_dokumen_perjanjian) }}"
                                                 target="_blank" class="text-indigo-600 hover:underline font-black">
                                                 <i class="fa-solid fa-file-pdf mr-0.5"></i> Unduh Dokumen
                                             </a>
                                         @endif
                                     </div>
                                 @endif

                                 {{-- Catatan Penolakan Admin --}}
                                 @if ($loan->status_loan == 'ditolak' && $loan->alasan_penolakan_loan)
                                     <div
                                         class="p-2 bg-red-50 border border-red-100 rounded-xl text-[10px] text-red-700 leading-relaxed italic">
                                         <strong>Alasan BUMDes:</strong> "{{ $loan->alasan_penolakan_loan }}"
                                     </div>
                                 @endif
                             </div>
                         @empty
                             <div class="text-center py-8 text-slate-400 italic text-xs">
                                 Belum pernah melakukan pengajuan dana bantuan modal.
                             </div>
                         @endforelse
                     </div>
                 </div>

             </div>
         </div>
     </main>

     {{-- ================= JAVASCRIPT LOGIK KALKULATOR SIMULASI INSTAN ================= --}}
     {{-- <script>
          function hitungSimulasi() {
              const inputNominal = document.getElementById('input_nominal');
              const viewPokok = document.getElementById('view_pokok');
              const viewJasa = document.getElementById('view_jasa');
              const viewTotal = document.getElementById('view_total');

              // Ambil nominal angka murni
              let nominal = parseFloat(inputNominal.value);

              // Proteksi jika inputan kosong atau bernilai negatif
              if (!nominal || nominal <= 0) {
                  viewPokok.innerText = 'Rp 0';
                  viewJasa.innerText = 'Rp 0';
                  viewTotal.innerText = 'Rp 0';
                  return;
              }

              // Ambil nilai tenor dari radio buttons yang sedang dipilih
              const selectedTenor = document.querySelector('input[name="tenor_bulan"]:checked').value;
              let tenor = parseInt(selectedTenor);

              // Perhitungan Rumus Bisnis Finansial BUMDes
              let pokokPerBulan = Math.round(nominal / tenor);
              let jasaPerBulan = Math.round(nominal * 0.005); // Bunga 0.5% flat dari total plafon awal
              let totalPerBulan = pokokPerBulan + jasaPerBulan;

              // Tampilkan hasil kalkulasi dengan format Rupiah Indonesia
              viewPokok.innerText = formatRupiah(pokokPerBulan);
              viewJasa.innerText = formatRupiah(jasaPerBulan);
              viewTotal.innerText = formatRupiah(totalPerBulan);
          }

         function validasiDanHitung() {
             const inputNominal = document.getElementById('input_nominal');
             let nominal = parseFloat(inputNominal.value);

             // KUNCI MAKSIMAL: Jika user mengetik manual melebihi 20.000.000, paksa potong nilainya ke 20000000
             if (nominal > 20000000) {
                 inputNominal.value = 20000000;
                 nominal = 20000000;
             }

             // Panggil fungsi hitung angka simulasi
             hitungSimulasi(nominal);
         }

         function hitungSimulasi(nominal Terdefinisi = null) {
             const inputNominal = document.getElementById('input_nominal');
             const viewPokok = document.getElementById('view_pokok');
             const viewJasa = document.getElementById('view_jasa');
             const viewTotal = document.getElementById('view_total');

             // Gunakan nominal yang sudah divalidasi atau ambil langsung dari input jika kosong
             let nominal = nominalTerdefinisi !== null ? nominalTerdefinisi : parseFloat(inputNominal.value);

             if (!nominal || nominal <= 0) {
                 viewPokok.innerText = 'Rp 0';
                 viewJasa.innerText = 'Rp 0';
                 viewTotal.innerText = 'Rp 0';
                 return;
             }

             const selectedTenor = document.querySelector('input[name="tenor_bulan"]:checked').value;
             let tenor = parseInt(selectedTenor);

             // Perhitungan Rumus Bisnis Finansial BUMDes
             let pokokPerBulan = Math.round(nominal / tenor);
             let jasaPerBulan = Math.round(nominal * 0.005); // Bunga 0.5% flat
             let totalPerBulan = pokokPerBulan + jasaPerBulan;

             // Tampilkan hasil kalkulasi
             viewPokok.innerText = formatRupiah(pokokPerBulan);
             viewJasa.innerText = formatRupiah(jasaPerBulan);
             viewTotal.innerText = formatRupiah(totalPerBulan);
         }

         function formatRupiah(angka) {
             return 'Rp ' + angka.toLocaleString('id-ID', {
                 minimumFractionDigits: 0,
                 maximumFractionDigits: 0
             });
         }

         // Jalankan kalkulasi pertama kali saat halaman dimuat
         document.addEventListener("DOMContentLoaded", function() {
             validasiDanHitung();
         });

         // Jalankan kalkulasi pertama kali untuk menetapkan nilai default Rp 0
         document.addEventListener("DOMContentLoaded", function() {
             hitungSimulasi();
         });
     </script> --}}


     <script>
         function validasiDanHitung() {
             const inputNominal = document.getElementById('input_nominal');
             let nominal = parseFloat(inputNominal.value);

             // KUNCI MAKSIMAL: Jika user mengetik manual melebihi 20.000.000, paksa potong nilainya ke 20000000
             if (nominal > 20000000) {
                 inputNominal.value = 20000000;
                 nominal = 20000000;
             }

             // Panggil fungsi hitung angka simulasi
             hitungSimulasi(nominal);
         }

         // PERBAIKAN: Spasi pada nama parameter sudah dihapus
         function hitungSimulasi(nominalTerdefinisi = null) {
             const inputNominal = document.getElementById('input_nominal');
             const viewPokok = document.getElementById('view_pokok');
             const viewJasa = document.getElementById('view_jasa');
             const viewTotal = document.getElementById('view_total');

             // Gunakan nominal yang sudah divalidasi atau ambil langsung dari input jika kosong
             let nominal = nominalTerdefinisi !== null ? nominalTerdefinisi : parseFloat(inputNominal.value);

             if (!nominal || nominal <= 0) {
                 viewPokok.innerText = 'Rp 0';
                 viewJasa.innerText = 'Rp 0';
                 viewTotal.innerText = 'Rp 0';
                 return;
             }

             const selectedTenor = document.querySelector('input[name="tenor_bulan"]:checked').value;
             let tenor = parseInt(selectedTenor);

             // Perhitungan Rumus Bisnis Finansial BUMDes
             let pokokPerBulan = Math.round(nominal / tenor);
             let jasaPerBulan = Math.round(nominal * 0.005); // Bunga 0.5% flat
             let totalPerBulan = pokokPerBulan + jasaPerBulan;

             // Tampilkan hasil kalkulasi
             viewPokok.innerText = formatRupiah(pokokPerBulan);
             viewJasa.innerText = formatRupiah(jasaPerBulan);
             viewTotal.innerText = formatRupiah(totalPerBulan);
         }

         function formatRupiah(angka) {
             return 'Rp ' + angka.toLocaleString('id-ID', {
                 minimumFractionDigits: 0,
                 maximumFractionDigits: 0
             });
         }

         // Jalankan kalkulasi pertama kali saat halaman dimuat
         document.addEventListener("DOMContentLoaded", function() {
             validasiDanHitung();
         });
     </script>
 @endsection
