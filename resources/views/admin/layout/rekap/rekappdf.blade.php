<!DOCTYPE html>
<html>
<head>
    <title>Rekap Transaksi</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2 class="center">Surya Catering</h2>
    <h3>Rekap Transaksi</h3>
    <p>Periode : {{ date('d-m-Y', strtotime($start_date)) }} s/d {{ date('d-m-Y', strtotime($end_date)) }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Jumlah Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
                $index = 1;
            @endphp
            @foreach ($rekap as $date => $details)
                @php
                    $amount = $details['total']; // Ambil nilai total
                @endphp
                <tr>
                    <td>{{ $index++ }}</td>
                    <td>{{ date('d-m-Y', strtotime($date)) }}</td>
                    <td>Rp. {{ is_numeric($amount) ? number_format($amount, 2, ',', '.') : 'Invalid amount' }}</td>
                </tr>
                @php 
                    $total += is_numeric($amount) ? $amount : 0; 
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2"><strong>Total Pendapatan</strong></td>
                <td><strong>Rp. {{ number_format($total, 2, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
