<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Daftar Produk Segera Dipesan</title>
    <style>
        @page {
            margin: 2cm 1.5cm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            text-align: center;
        }
        .header h2 {
            margin: 0 0 5px 0;
            font-size: 16pt;
            font-weight: bold;
        }
        .header p {
            margin: 3px 0;
            font-size: 10pt;
            font-style: italic;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 9pt;
        }
        table thead tr {
            background-color: #e0e0e0;
        }
        table th {
            border: 1px solid #000;
            padding: 8px 5px;
            text-align: center;
            font-weight: bold;
            font-size: 9pt;
        }
        table td {
            border: 1px solid #000;
            padding: 6px 5px;
            vertical-align: middle;
        }
        table td:nth-child(1) {
            text-align: center;
            width: 5%;
        }
        table td:nth-child(2) {
            width: 35%;
        }
        table td:nth-child(3) {
            width: 25%;
        }
        table td:nth-child(4) {
            text-align: right;
            width: 20%;
        }
        table td:nth-child(5) {
            text-align: center;
            width: 15%;
        }
        .footer-note {
            margin-top: 15px;
            font-size: 9pt;
            font-style: italic;
        }
        .product-name {
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Daftar Produk Segera Dipesan</h2>
        <p>Tanggal dibuat: {{ $tanggalDibuat }} oleh <strong>{{ $namaAkunPemroses }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="product-name">{{ $product->name }}</td>
                <td>{{ $product->category ? $product->category->name : '-' }}</td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ number_format($product->stock, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="footer-note">***) diurutkan berdasarkan kategori dan produk</p>
</body>
</html>
