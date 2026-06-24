<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan_Riwayat_Pinjaman_{{ $loan->group->nama_kelompok }}</title>
    <style>
        @page {
            margin: 1.2cm;
        }

        * {
            box-sizing: border-box;
            font-family: 'Helvetica', 'Arial', sans-serif;
        }

        body {
            margin: 0;
            padding: 0;
            font-size: 10px;
            color: #333;
            line-height: 1.4;
        }

        /* Kop Surat Styles */
        .header-container {
            width: 100%;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 2px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: middle;
        }

        .logo {
            width: 75px;
        }

        .kop-text {
            text-align: center;
            padding-right: 75px;
            /* Keseimbangan margin kanan kiri */
        }

        .kop-text h2 {
            margin: 0;
            font-size: 13px;
            text-transform: uppercase;
            color: #000;
            letter-spacing: 0.5px;
        }

        .kop-text h1 {
            margin: 2px 0;
            font-size: 18px;
            color: #15803d;
            /* Warna hijau khas BUMDes */
        }

        .kop-text p {
            margin: 1px 0;
            font-size: 9px;
            font-style: italic;
            color: #4b5563;
        }

        .double-line {
            border-bottom: 1px solid #000;
            margin-top: 2px;
            width: 100%;
            margin-bottom: 15px;
        }

        /* Judul Dokumen */
        .report-title {
            text-align: center;
            margin: 12px 0 18px 0;
        }

        .report-title h3 {
            margin: 0;
            font-size: 12px;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Info Grid Ringkasan Atas */
        .info-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 10px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 2px;
            vertical-align: top;
        }

        .font-bold {
            font-weight: bold;
        }

        /* Table Utama Laporan */
        .table-main {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .table-main th {
            background-color: #f3f4f6;
            color: #000;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            border: 1px solid #6b7280;
            padding: 7px 4px;
            font-size: 9px;
        }

        .table-main td {
            border: 1px solid #d1d5db;
            padding: 6px 6px;
            vertical-align: middle;
        }

        .row-even {
            background-color: #f9fafb;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        /* Footer Tanda Tangan */
        .footer-sign {
            margin-top: 30px;
            width: 100%;
            border-collapse: collapse;
        }

        .footer-sign td {
            width: 50%;
            text-align: center;
            font-size: 10px;
            vertical-align: top;
        }
    </style>
</head>

<body>
    {{-- Header Kop Surat Resmi BUMDes --}}
    <div class="header-container">
        <table class="header-table">
            <tr>
                <td width="75">
                    <img src="{{ public_path('Img/logo_betaraa.png') }}" class="logo">
                </td>
                <td class="kop-text">
                    <h2>Laporan Resmi Pembukuan</h2>
                    <h1>BUMDES BERSAMA BETARA</h1>
                    <p>Jl. Lintas Kuala Tungkal-Jambi, Mekar Jaya, Kec. Betara, Kabupaten Tanjung Jabung Barat, Jambi
                    </p>
                    <p>Telp: 0823 0651 1239</p>
                </td>
            </tr>
        </table>
    </div>
    <div class="double-line"></div>

    <div class="report-title">
        <h3>REKAPITULASI RIWAYAT ANGSURAN PINJAMAN</h3>
    </div>

    {{-- Tabel Profil Pinjaman --}}
    <table class="info-table">
        <tr>
            <td width="16%">Nama Kelompok</td>
            <td width="2%">:</td>
            <td width="32%" class="font-bold"> {{ $loan->group->nama_kelompok }}</td>
            <td width="18%">Total Plafon Kontrak</td>
            <td width="2%">:</td>
            <td class="font-bold">Rp {{ number_format($loan->plafon_disetujui, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Status Kredit</td>
            <td>:</td>
            <td class="font-bold uppercase"
                style="color: {{ $loan->status_loan == 'berjalan' ? '#0284c7' : '#16a34a' }}">
                {{ $loan->status_loan }}
            </td>
            <td>Total Dana Dicairkan</td>
            <td>:</td>
            <td class="font-bold" style="color: #15803d;">Rp {{ number_format($loan->total_dicairkan, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td>Tenor Pinjaman</td>
            <td>:</td>
            <td>{{ $loan->tenor_bulan }} Bulan</td>
            <td>Suku Jasa Bunga Program</td>
            <td>:</td>
            <td>0.5% / Bulan</td>
        </tr>
    </table>

    {{-- Tabel Riwayat Angsuran --}}
    <table class="table-main">
        <thead>
            <tr>
                <th width="4%">Bln</th>
                <th width="14%">Jatuh Tempo</th>
                <th width="14%">Tgl Bayar</th>
                <th width="14%">Pokok (Rp)</th>
                <th width="14%">Bunga (Rp)</th>
                <th width="12%">Denda (Rp)</th>
                <th width="12%">Status</th>
                <th width="16%">Total Setor (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loan->installments as $ins)
                @php
                    $dendaTampil = $ins->denda_kumulatif;
                    $totalRow = $ins->jumlah_pokok + $ins->jumlah_bunga + $ins->denda_kumulatif;

                    // Hitung denda real-time berjalan jika kelompok menunggak
                    if (
                        $ins->status_bayar == 'belum_bayar' &&
                        \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($ins->tanggal_jatuh_tempo))
                    ) {
                        $hariTelat = \Carbon\Carbon::parse($ins->tanggal_jatuh_tempo)->diffInDays(
                            \Carbon\Carbon::now(),
                        );
                        $dendaTampil = $hariTelat * 5000;
                        $totalRow = $ins->jumlah_pokok + $ins->jumlah_bunga + $dendaTampil;
                    }
                @endphp
                <tr class="{{ $loop->even ? 'row-even' : '' }}">
                    <td class="text-center font-bold">{{ $ins->angsuran_ke }}</td>
                    <td class="text-center">{{ date('d/m/Y', strtotime($ins->tanggal_jatuh_tempo)) }}</td>
                    <td class="text-center">
                        {{ $ins->tanggal_bayar ? date('d/m/Y', strtotime($ins->tanggal_bayar)) : '-' }}
                    </td>
                    <td class="text-right">{{ number_format($ins->jumlah_pokok, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($ins->jumlah_bunga, 0, ',', '.') }}</td>

                    {{-- Kolom Denda --}}
                    <td class="text-right"
                        style="@if ($dendaTampil > 0) color: #b91c1c; font-weight: bold; @endif">
                        {{ number_format($dendaTampil, 0, ',', '.') }}
                    </td>

                    {{-- Kolom Status --}}
                    <td class="text-center uppercase font-bold" style="font-size: 8px;">
                        @if ($ins->status_bayar == 'lunas')
                            <span style="color: #16a34a;">Lunas</span>
                        @else
                            <span style="color: #ef4444;">Menunggak</span>
                        @endif
                    </td>

                    {{-- Kolom Total Row --}}
                    <td class="text-right font-bold">
                        Rp {{ number_format($totalRow, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #f3f4f6; font-weight: bold;">
                <td colspan="3" class="text-right" style="padding: 7px; border: 1px solid #6b7280;">TOTAL TERBUKU :
                </td>
                <td class="text-right" style="border: 1px solid #6b7280;">{{ number_format($totalPokok, 0, ',', '.') }}
                </td>
                <td class="text-right" style="border: 1px solid #6b7280;">{{ number_format($totalBunga, 0, ',', '.') }}
                </td>
                <td class="text-right" style="color: #b91c1c; border: 1px solid #6b7280;">
                    {{ number_format($totalDenda, 0, ',', '.') }}</td>
                <td class="text-center" style="border: 1px solid #6b7280;">-</td>
                <td class="text-right" style="color: #15803d; border: 1px solid #6b7280; font-size: 11px;">
                    Rp {{ number_format($totalSetoran, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    {{-- Bagian Tanda Tangan Pembukuan --}}
    <table class="footer-sign">
        <tr>
            <td>
                <p>Penyetor / Ketua Kelompok,</p>
                <div style="margin-bottom: 50px;"></div>
                <p class="font-bold">( {{ $loan->group->nama_ketua }} )</p>
            </td>
            <td>
                <p>Jambi, {{ date('d F Y') }}</p>
                <p>Admin BUMDes Bersama,</p>
                <div style="margin-bottom: 50px;"></div>
                <p class="font-bold">( {{ $nama_admin }} )</p>
            </td>
        </tr>
    </table>
</body>

</html>
