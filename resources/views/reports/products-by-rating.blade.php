@extends('reports.layout')

@section('content')
    <div class="summary-box">
        <div class="summary-title">Ringkasan</div>
        <table style="width: 100%; border: none; margin: 0;">
            <tr>
                <td style="border: none; text-align: center;">
                    <div class="summary-value">{{ $total }}</div>
                    <div class="summary-label">Total Produk</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Daftar Produk (Diurutkan Berdasarkan Rating Tertinggi)</div>
    @if($products->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 25%;">Nama Produk</th>
                    <th style="width: 15%;">Nama Toko</th>
                    <th style="width: 15%;">Kategori</th>
                    <th style="width: 15%;">Harga</th>
                    <th style="width: 10%;">Lokasi</th>
                    <th style="width: 15%;">Rating</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->seller->store_name ?? '-' }}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->seller->pic_province ?? '-' }}</td>
                        <td class="text-center">
                            <span class="rating-stars">★</span> {{ number_format($product->average_rating, 1) }}
                            <span style="color: #666; font-size: 9px;">({{ $product->comments->count() }} ulasan)</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; color: #666; padding: 20px;">Tidak ada produk.</p>
    @endif
@endsection
