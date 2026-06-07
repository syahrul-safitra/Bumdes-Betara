<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan_SPP_{{ $loan->group->nama_kelompok }}</title>
    <style>
        @page {
            margin: 1cm;
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
            width: 80px;
        }

        .kop-text {
            text-align: center;
            padding-right: 80px;
        }

        .kop-text h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            color: #000;
        }

        .kop-text h1 {
            margin: 2px 0;
            font-size: 22px;
            color: #15803d;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 10px;
            font-style: italic;
        }

        .double-line {
            border-bottom: 1px solid #000;
            margin-top: 2px;
            width: 100%;
            margin-bottom: 15px;
        }

        /* Content Styles */
        .report-title {
            text-align: center;
            margin: 15px 0;
        }

        .report-title h3 {
            margin: 0;
            font-size: 14px;
            text-decoration: underline;
            text-transform: uppercase;
        }

        /* Ringkasan Informasi Pinjaman */
        .info-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
            font-size: 10px;
        }

        /* Table Styles */
        .table-main {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-main th {
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            border: 1px solid #999;
            padding: 8px 4px;
        }

        .table-main td {
            border: 1px solid #ccc;
            padding: 6px 4px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }

        .row-even {
            background-color: #fafafa;
        }

        .footer-sign {
            margin-top: 40px;
            width: 100%;
        }

        .footer-sign td {
            text-align: center;
            width: 50%;
        }
    </style>
</head>

<body>
    <div class="header-container">
        <table class="header-table">
            <tr>
                <td width="80">
                    <img src="{{ public_path('Img/logo_betaraa.png') }}" class="logo">
                </td>
                <td class="kop-text">
                    <h2>Laporan Resmi</h2>
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

    <table class="info-table">
        <tr>
            <td width="18%">Nama Kelompok</td>
            <td width="2%">:</td>
            <td width="30%" class="font-bold">Kelompok {{ $loan->group->nama_kelompok }}</td>
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
            <td>Suku Jasa Bunga</td>
            <td>:</td>
            <td>{{ $loan->bunga_persen }}% / Bulan</td>
        </tr>
    </table>

    <table class="table-main">
        <thead>
            <tr>
                <th width="4%">Bln</th>
                <th width="15%">Jatuh Tempo</th>
                <th width="15%">Tgl Bayar</th>
                <th>Pokok (Rp)</th>
                <th>Bunga (Rp)</th>
                <th>Denda (Rp)</th>
                <th width="15%">Status</th>
                <th>Total Setor (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loan->installments as $ins)
                <tr class="{{ $loop->even ? 'row-even' : '' }}">
                    <td class="text-center font-bold">{{ $ins->angsuran_ke }}</td>
                    <td class="text-center">{{ date('d/m/Y', strtotime($ins->tanggal_jatuh_tempo)) }}</td>
                    <td class="text-center">
                        {{ $ins->tanggal_bayar ? date('d/m/Y', strtotime($ins->tanggal_bayar)) : '-' }}
                    </td>
                    <td class="text-right">{{ number_format($ins->jumlah_pokok, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($ins->jumlah_bunga, 0, ',', '.') }}</td>
                    <td class="text-right" style="@if ($ins->denda_kumulatif > 0) color: red; @endif">
                        {{ number_format($ins->denda_kumulatif, 0, ',', '.') }}
                    </td>
                    <td class="text-center uppercase font-bold" style="font-size: 8px;">
                        @if ($ins->status_bayar == 'lunas')
                            <span style="color: #16a34a;">Lunas</span>
                        @else
                            <span style="color: #94a3b8;">Belum Bayar</span>
                        @endif
                    </td>
                    <td class="text-right font-bold">
                        Rp
                        {{ number_format($ins->jumlah_pokok + $ins->jumlah_bunga + $ins->denda_kumulatif, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #f2f2f2; font-weight: bold;">
                <td colspan="3" class="text-right" style="padding: 6px;">TOTAL TERBUKU :</td>
                <td class="text-right">{{ number_format($totalPokok, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($totalBunga, 0, ',', '.') }}</td>
                <td class="text-right" style="color: red;">{{ number_format($totalDenda, 0, ',', '.') }}</td>
                <td class="text-center">-</td>
                <td class="text-right" style="color: #15803d;">Rp {{ number_format($totalSetoran, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <table class="footer-sign">
        <tr>
            <td></td>
            <td>
                <p>Jambi, {{ date('d F Y') }}</p>
                <p style="margin-bottom: 50px;">Manajer Unit SPP BUMDes,</p>
                <p class="font-bold">( ____________________ )</p>
            </td>
        </tr>
    </table>
</body>

</html>
