@extends('reports.layout')

@section('content')
    <div class="summary-box">
        <div class="summary-title">Toko: {{ $seller->store_name }}</div>
        <table style="width: 100%; border: none; margin: 0;">
            <tr>
                <td style="border: none; text-align: center; width: 50%;">
                    <div class="summary-value">{{ $total }}</div>
                    <div class="summary-label">Total Produk</div>
                </td>
                <td style="border: none; text-align: center; width: 50%;">
                    <div class="summary-value">{{ number_format($totalStock) }}</div>
                    <div class="summary-label">Total Stok</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Daftar Stok Produk (Diurutkan Berdasarkan Stok Tertinggi)</div>
    @if($products->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 35%;">Nama Produk</th>
                    <th style="width: 15%;">Kategori</th>
                    <th style="width: 15%;">Harga</th>
                    <th style="width: 15%;">Stok</th>
                    <th style="width: 15%;">Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="text-center {{ $product->stock < 2 ? 'low-stock' : '' }}">
                            {{ number_format($product->stock) }}
                        </td>
                        <td class="text-center">
                            <span class="rating-stars">★</span> {{ number_format($product->average_rating, 1) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; color: #666; padding: 20px;">Tidak ada produk.</p>
    @endif
@endsection
