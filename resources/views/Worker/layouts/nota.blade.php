<!DOCTYPE html>
<html>
<head>
    <title>Nota Transaksi</title>
    <style>
        * {
            font-family: "Consolas", sans-serif;
            box-sizing: border-box;
        }
        body {
            width: 80mm; /* Lebar kertas */
            margin: 0; /* Hapus margin default */
            padding: 0; /* Hapus padding default */
            font-size: 8pt; /* Ukuran font untuk body */
        }
        .text-center {
            text-align: center;
        }
        .header {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 5px; /* Ruang di bawah header */
        }
        .info {
            display: flex;
            justify-content: space-between;
            width: 100%;
            margin-bottom: 5px; /* Ruang di bawah informasi transaksi */
        }
        p {
            margin: 0;
            padding: 2px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt; /* Ukuran font untuk tabel */
        }
        table td, table th {
            border: 1px solid #ddd;
            padding: 2px;
        }
        table th {
            background: #f4f4f4;
        }
        @media print {
            @page {
                margin: 5mm; /* Margin pada kertas */
                size: 70mm auto; /* Ukuran kertas */
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center">
        <h2 style="margin-bottom: 5px;">Surya Catering</h2>
        <p>Jl. Jogja Km. 12 Krendetan, Bagelen, Purworejo</p>
        <p>0896 0368 4703</p>
    </div>
    <div class="header">
        <p>Tanggal: {{ date('d-m-Y') }}</p>
		<p>Nomer Nota: {{ $nomerNota }}</p>
        <p>Kode Transaksi: {{ $transactions->first()->kodetransaksi }}</p>
        <p>Kasir: {{ strtoupper(auth()->user()->username) }}</p>
        @if ($transactions->isNotEmpty())
            @foreach ($transactions->groupBy('kodetransaksi') as $kodetransaksi => $items)
                <p>Penerima: {{ $items[0]->penerima }}</p>
                <p class="text-center">===================================</p>
    </div>
                <table>
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->product }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->subtotal }}</td>
                                
                            </tr>
                            @endforeach
                    </tbody>
                    <tfoot>
                            <tr>
                                <td colspan="3" style="text-align: right; font-weight: bold;">Total</td>
                                <td style="font-weight: bold;">{{ $item->grandtotal }}</td>                            </tr>
                    </tfoot>
                       
                </table>
            @endforeach
        @else
            <p class="text-center">Transaksi tidak ditemukan.</p>
        @endif
    </div>
    <p class="text-center">===================================</p>
    <p class="text-center">-- TERIMA KASIH --</p>
</body>
</html>
