<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Rental - Bumdes Bersama Betara</title>
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
            /* Balancing logo width */
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
            /* Emerald green accent */
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
        }

        /* Content Styles */
        .report-title {
            text-align: center;
            margin: 20px 0;
        }

        .report-title h3 {
            margin: 0;
            font-size: 16px;
            text-decoration: underline;
            text-transform: uppercase;
        }

        .report-title p {
            margin: 5px 0;
            font-size: 12px;
            font-weight: bold;
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

        .footer-summary {
            margin-top: 15px;
            width: 100%;
        }

        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            color: white;
        }

        .bg-success {
            background-color: #16a34a;
        }

        .bg-warning {
            background-color: #ca8a04;
        }
    </style>
</head>

<body>
    <!-- Kop Surat -->
    <div class="header-container">
        <table class="header-table">
            <tr>
                <td width="80">
                    <img src="{{ public_path('Img/logo_betaraa.png') }}" class="logo">
                </td>
                <td class="kop-text">
                    <h2>Laporan Resmi</h2>
                    <h1>BUMDES BERSAMA BETARA</h1>
                    <p>Jl. Lintas Kuala Tungkal-Jambi, Mekar Jaya, Kec. Betara, Kabupaten Tanjung
                        Jabung Barat, Jambi</p>
                    <p>Telp: 0823 0651 1239</p>
                </td>
            </tr>
        </table>
    </div>
    <div class="double-line"></div>

    <!-- Title -->
    <div class="report-title">
        <h3>LAPORAN TRANSAKSI RENTAL MOBIL</h3>
        <p>Periode: {{ date('d/m/Y', strtotime($tanggal_awal)) }} s/d {{ date('d/m/Y', strtotime($tanggal_akhir)) }}
        </p>
    </div>

    <!-- Main Table -->
    <table class="table-main">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th>Nama Customer</th>
                <th width="8%">Tipe</th>
                <th>Unit Mobil</th>
                <th width="9%">Sopir</th> {{-- Kolom Baru --}}
                <th width="9%">Pinjam</th>
                <th width="9%">Kembali</th>
                <th width="9%">Dikembalikan</th>
                <th width="11%">Sewa (Rp)</th>
                <th width="11%">Denda (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $sumTotal = 0;
                $sumDenda = 0;
            @endphp
            @foreach ($rentals as $d)
                <tr class="{{ $loop->even ? 'row-even' : '' }}">
                    <td class="text-center" style="vertical-align: middle;">{{ $loop->iteration }}</td>
                    <td>
                        <span class="font-bold">{{ $d->customer->nama }}</span><br>
                        <small>{{ $d->customer->no_telepon }}</small>
                    </td>
                    <td class="text-center" style="vertical-align: middle;">
                        {{ $d->customer->tipe }}
                    </td>
                    <td class="text-center" style="vertical-align: middle;">{{ $d->vehicle->merek }}</td>

                    {{-- STATUS SEWA SOPIR (KOLOM BARU) --}}
                    <td class="text-center" style="vertical-align: middle;">
                        @if ($d->sewa_driver == 1)
                            <span style="color: #4f46e5; font-weight: bold;">Ya</span><br>
                            @php
                                // Menghitung durasi hari untuk rincian kecil biaya driver jika diperlukan
                                $tglAwal = \Carbon\Carbon::parse($d->tanggal_peminjaman);
                                $tglAkhir = \Carbon\Carbon::parse($d->tanggal_pengembalian);
                                $hari = $tglAwal->diffInDays($tglAkhir) + 1;
                            @endphp
                            <small style="color: #6366f1; font-size: 9px;">(Rp
                                {{ number_format($d->vehicle->sewa_driver * $hari, 0, ',', '.') }})</small>
                        @else
                            <span style="color: #64748b;">Tidak</span>
                        @endif
                    </td>

                    <td class="text-center" style="vertical-align: middle;">
                        {{ date('d/m/y', strtotime($d->tanggal_peminjaman)) }}</td>
                    <td class="text-center" style="vertical-align: middle;">
                        {{ date('d/m/y', strtotime($d->tanggal_pengembalian)) }}</td>
                    <td class="text-center" style="vertical-align: middle;">
                        {{ $d->tanggal_dikembalikan ? date('d/m/y', strtotime($d->tanggal_dikembalikan)) : '-' }}
                    </td>

                    @php
                        $sumTotal += $d->total_sewa;
                        // Antisipasi jika nilai total_denda di database null, set otomatis ke 0
                        $sumDenda += $d->total_denda ?? 0;
                    @endphp
                    <td class="text-right" style="vertical-align: middle;">
                        {{ number_format($d->total_sewa, 0, ',', '.') }}</td>
                    <td class="text-right" style="vertical-align: middle;">
                        {{ number_format($d->total_denda ?? 0, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr style="background-color: #eee;">
                <td colspan="8" class="text-right font-bold" style="padding: 10px;">TOTAL KESELURUHAN :</td>
                <td class="text-right font-bold">{{ number_format($sumTotal, 0, ',', '.') }}</td>
                <td class="text-right font-bold">{{ number_format($sumDenda, 0, ',', '.') }}</td>
            </tr>
            <tr style="background-color: #15803d; color: white;">
                <td colspan="8" class="text-right font-bold" style="padding: 10px;">GRAND TOTAL (SEWA + DENDA) :</td>
                <td colspan="2" class="text-center font-bold" style="font-size: 14px; padding: 10px;">
                    Rp {{ number_format($sumTotal + $sumDenda, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
    <!-- Signature Space -->
    {{-- <div style="margin-top: 50px; float: right; width: 200px; text-align: center;">
            <p>Jambi, {{ date("d F Y") }}</p>
            <p style="margin-bottom: 60px;">Manajer BUMDES,</p>
            <p class="font-bold">( ____________________ )</p>
        </div> --}}

</body>

</html>
