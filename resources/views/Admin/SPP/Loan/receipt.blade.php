<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kuitansi_Ags_{{ $installment->angsuran_ke }}_{{ $installment->loan->group->nama_kelompok }}</title>
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
            /* Menyeimbangkan logo kanan-kiri */
        }

        .kop-text h2 {
            margin: 0;
            font-size: 16px;
            text-transform: uppercase;
            color: #000;
            letter-spacing: 1px;
        }

        .kop-text h1 {
            margin: 2px 0;
            font-size: 20px;
            color: #15803d;
            /* Emerald green accent */
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 9px;
            font-style: italic;
        }

        .double-line {
            border-bottom: 1px solid #000;
            margin-top: 2px;
            width: 100%;
            margin-bottom: 15px;
        }

        /* Title Styles */
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

        /* Metadata Transaksi */
        .meta-box {
            width: 100%;
            margin-bottom: 15px;
            font-size: 10px;
        }

        .meta-box td {
            vertical-align: top;
            padding: 2px 0;
        }

        /* Table Styles */
        .table-main {
            width: 100%;
            border-collapse: collapse;
        }

        .table-main th {
            background-color: #f2f2f2;
            color: #000;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
            border: 1px solid #999;
            padding: 6px 4px;
        }

        .table-main td {
            border: 1px solid #ccc;
            padding: 6px 6px;
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

        .footer-summary {
            margin-top: 25px;
            width: 100%;
        }

        .footer-summary td {
            text-align: center;
            width: 50%;
            font-size: 10px;
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
                    <h2>Kuitansi Resmi Pembayaran</h2>
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
        <h3>TANDA TERIMA ANGSURAN SPP</h3>
    </div>

    <table class="meta-box">
        <tr>
            <td width="55%">
                {{-- No. Kuitansi: <span
                    class="font-bold">KW/SPP/{{ date('Ymd', strtotime($installment->tanggal_bayar)) }}/{{ $installment->id }}</span><br> --}}
                Nama Kelompok: <span class="font-bold">Kelompok {{ $installment->loan->group->nama_kelompok }}</span>
            </td>
            <td class="text-right">
                Tgl Jatuh Tempo: {{ date('d/m/Y', strtotime($installment->tanggal_jatuh_tempo)) }}<br>
                Tanggal Bayar: <span
                    class="font-bold">{{ date('d/m/Y', strtotime($installment->tanggal_bayar)) }}</span>
            </td>
        </tr>
    </table>

    <table class="table-main">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th>Rincian Komponen Pembayaran (Angsuran Ke-{{ $installment->angsuran_ke }})</th>
                <th width="30%">Subtotal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td>
                <td>Angsuran Pokok Pinjaman</td>
                <td class="text-right">{{ number_format($installment->jumlah_pokok, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Jasa Bunga Bulanan Program SPP</td>
                <td class="text-right">{{ number_format($installment->jumlah_bunga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Denda Keterlambatan Finansial</td>
                <td class="text-right" style="@if ($installment->denda_kumulatif > 0) color: red; font-weight: bold; @endif">
                    {{ number_format($installment->denda_kumulatif, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr style="background-color: #15803d; color: white;">
                <td colspan="2" class="text-right font-bold" style="padding: 8px;">TOTAL DANA DITERIMA :</td>
                <td class="text-right font-bold" style="font-size: 11px;">
                    Rp
                    {{ number_format($installment->jumlah_pokok + $installment->jumlah_bunga + $installment->denda_kumulatif, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    <table class="footer-summary">
        <tr>
            <td>
                <p>Penyetor,</p>
                <div style="margin-bottom: 50px;"></div>
                <p class="font-bold">( Perwakilan Kelompok )</p>
            </td>
            <td>
                <p>Jambi, {{ date('d F Y', strtotime($installment->tanggal_bayar)) }}</p>
                <p>Kasir & Admin BUMDes,</p>
                <div style="margin-bottom: 50px;"></div>
                <p class="font-bold">( ____________________ )</p>
            </td>
        </tr>
    </table>
</body>

</html>
