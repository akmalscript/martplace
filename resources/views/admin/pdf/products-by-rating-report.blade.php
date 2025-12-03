<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Daftar Produk Berdasarkan Rating</title>
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
            text-align: center;
            margin-bottom: 5px;
        }
        .header h2 {
            margin: 0;
            font-size: 14pt;
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
            font-size: 10pt;
        }
        table thead tr {
            background-color: #f0f0f0;
        }
        table th {
            border: 1px solid #000;
            padding: 8px 5px;
            text-align: center;
            font-weight: bold;
        }
        table td {
            border: 1px solid #000;
            padding: 6px 5px;
            vertical-align: top;
        }
        table td:nth-child(1) {
            text-align: center;
            width: 5%;
        }
        table td:nth-child(2) {
            width: 18%;
        }
        table td:nth-child(3) {
            width: 13%;
        }
        table td:nth-child(4) {
            width: 13%;
            text-align: right;
        }
        table td:nth-child(5) {
            text-align: center;
            width: 10%;
        }
        table td:nth-child(6) {
            width: 20%;
        }
        table td:nth-child(7) {
            width: 16%;
        }
        .footer-note {
            margin-top: 10px;
            font-size: 9pt;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Daftar Produk Berdasarkan Rating</h2>
        <p>Tanggal dibuat: {{ $tanggalDibuat }} oleh {{ $namaAkunPemroses }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Rating</th>
                <th>Nama Toko</th>
                <th>Provinsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->product_name }}</td>
                <td>{{ $product->category_name ?? '-' }}</td>
                <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ number_format($product->avg_rating ?? 0, 1) }}</td>
                <td>{{ $product->store_name ?? '-' }}</td>
                <td>{{ $product->provinces ?? '-' }}</td>
            </tr>
            @endforeach
            @if($products->isEmpty())
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">Tidak ada data</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer-note">
        ***) kolom provinsi berisi provinsi pemberi rating
    </div>
</body>
</html>
