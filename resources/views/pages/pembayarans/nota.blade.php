<!DOCTYPE html>
<html>
<head>
    <title>Payment Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            width: 100%;
            margin: auto;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .products-table th, .products-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .products-table th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 12px;
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Nota Pembelian</h2>
    </div>
    <div class="content">
        <p><strong>Tanggal:</strong> {{ $pesanan->tgl_pemesanan }}</p>
        <p><strong>Transaction ID:</strong> {{ $pesanan->id }}</p>
        <p><strong>Total Bayar:</strong> Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</p>

        <h3>Products Purchased:</h3>
        <table class="products-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produks as $produk)
                <tr>
                    <td>{{ $produk->nama_produk }}</td>
                    <td>{{ $produk->jml }}</td>
                    <td>Rp {{ number_format($produk->harga_bayar, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($produk->sub_total, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="footer">
        <p>Thank you for your payment.</p>
    </div>

    <div class="no-print" style="text-align: center; margin-top: 20px;">
        <button onclick="window.print();">Print Receipt</button>
    </div>
</body>
</html>
