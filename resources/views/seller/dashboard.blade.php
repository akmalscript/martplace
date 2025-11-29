@extends('layouts.master')

@section('title', 'Dashboard Penjual')

@push('head-scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="bg-olive/20 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8 scroll-reveal">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-forest">Dashboard Penjual</h1>
                    <p class="text-forest/60 mt-1">Selamat datang, {{ $seller->store_name }}</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('seller.products.create') }}" 
                       class="inline-flex items-center gap-2 bg-gradient-to-r from-sage to-forest text-cream px-5 py-2.5 rounded-xl font-medium hover:shadow-lg transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Tambah Produk
                    </a>
                    <a href="{{ route('seller.products') }}" 
                       class="inline-flex items-center gap-2 bg-white text-forest px-5 py-2.5 rounded-xl font-medium border border-olive hover:border-sage transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Kelola Produk
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stagger-item bg-white rounded-2xl p-6 border border-olive/20 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-sage/20 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-forest">{{ $products->count() }}</p>
                        <p class="text-sm text-forest/60">Total Produk</p>
                    </div>
                </div>
            </div>

            <div class="stagger-item bg-white rounded-2xl p-6 border border-olive/20 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-forest">{{ $products->sum('stock') }}</p>
                        <p class="text-sm text-forest/60">Total Stok</p>
                    </div>
                </div>
            </div>

            <div class="stagger-item bg-white rounded-2xl p-6 border border-olive/20 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-yellow-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <div>
                        @php
                            $avgRating = $products->avg('rating') / 10;
                        @endphp
                        <p class="text-2xl font-bold text-forest">{{ number_format($avgRating, 1) }}</p>
                        <p class="text-sm text-forest/60">Rating Rata-rata</p>
                    </div>
                </div>
            </div>

            <div class="stagger-item bg-white rounded-2xl p-6 border border-olive/20 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-forest">{{ $products->where('stock', '<', 2)->count() }}</p>
                        <p class="text-sm text-forest/60">Stok Menipis</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Section (SRS-MartPlace-08) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Stock Distribution Chart --}}
            <div class="bg-white rounded-2xl p-6 border border-olive/20 scroll-reveal chart-container">
                <h3 class="text-lg font-semibold text-forest mb-4">Sebaran Stok per Produk</h3>
                <div class="h-72">
                    <canvas id="stockChart"></canvas>
                </div>
            </div>

            {{-- Rating Distribution Chart --}}
            <div class="bg-white rounded-2xl p-6 border border-olive/20 scroll-reveal chart-container" style="animation-delay: 0.1s">
                <h3 class="text-lg font-semibold text-forest mb-4">Sebaran Rating per Produk</h3>
                <div class="h-72">
                    <canvas id="ratingChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Reports Section --}}
        <div class="bg-white rounded-2xl p-6 border border-olive/20 scroll-reveal">
            <h3 class="text-lg font-semibold text-forest mb-4">Laporan PDF (SRS-MartPlace 12-14)</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('seller.reports.stock-list') }}" 
                   target="_blank"
                   class="flex items-center gap-4 p-4 bg-cream rounded-xl border border-olive/20 hover:border-sage hover:shadow-md transition-all duration-300 group">
                    <div class="w-12 h-12 bg-sage/20 rounded-xl flex items-center justify-center group-hover:bg-sage/30 transition">
                        <svg class="w-6 h-6 text-sage" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-forest">Laporan Stok</p>
                        <p class="text-sm text-forest/60">Diurutkan berdasarkan stok</p>
                    </div>
                </a>

                <a href="{{ route('seller.reports.products-by-rating') }}" 
                   target="_blank"
                   class="flex items-center gap-4 p-4 bg-cream rounded-xl border border-olive/20 hover:border-sage hover:shadow-md transition-all duration-300 group">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center group-hover:bg-yellow-200 transition">
                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-forest">Laporan Rating</p>
                        <p class="text-sm text-forest/60">Diurutkan berdasarkan rating</p>
                    </div>
                </a>

                <a href="{{ route('seller.reports.low-stock') }}" 
                   target="_blank"
                   class="flex items-center gap-4 p-4 bg-cream rounded-xl border border-olive/20 hover:border-sage hover:shadow-md transition-all duration-300 group">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center group-hover:bg-red-200 transition">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-forest">Stok Menipis</p>
                        <p class="text-sm text-forest/60">Produk perlu restock (stok < 2)</p>
                    </div>
                </a>
            </div>
        </div>

        {{-- Low Stock Products Alert --}}
        @if($products->where('stock', '<', 2)->count() > 0)
        <div class="mt-8 bg-red-50 border border-red-200 rounded-2xl p-6 scroll-reveal">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="font-semibold text-red-800">Perhatian: Stok Menipis!</h4>
                    <p class="text-red-700 text-sm mt-1">Beberapa produk memiliki stok kurang dari 2 unit dan perlu segera di-restock:</p>
                    <ul class="mt-3 space-y-2">
                        @foreach($products->where('stock', '<', 2)->take(5) as $product)
                        <li class="flex items-center justify-between bg-white rounded-lg px-4 py-2">
                            <span class="text-sm text-forest">{{ $product->name }}</span>
                            <span class="text-sm font-medium text-red-600">Stok: {{ $product->stock }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Stock Chart
    const stockData = @json($stockByProduct->take(10));
    const stockCtx = document.getElementById('stockChart').getContext('2d');
    new Chart(stockCtx, {
        type: 'bar',
        data: {
            labels: stockData.map(item => item.name.substring(0, 15) + (item.name.length > 15 ? '...' : '')),
            datasets: [{
                label: 'Stok',
                data: stockData.map(item => item.stock),
                backgroundColor: 'rgba(161, 188, 152, 0.8)',
                borderColor: '#778873',
                borderWidth: 1,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 700,
                easing: 'easeInOutQuart'
            },
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(210, 220, 182, 0.3)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });

    // Rating Chart
    const ratingData = @json($ratingByProduct->take(10));
    const ratingCtx = document.getElementById('ratingChart').getContext('2d');
    new Chart(ratingCtx, {
        type: 'bar',
        data: {
            labels: ratingData.map(item => item.name.substring(0, 15) + (item.name.length > 15 ? '...' : '')),
            datasets: [{
                label: 'Rating',
                data: ratingData.map(item => item.rating),
                backgroundColor: 'rgba(251, 191, 36, 0.8)',
                borderColor: '#f59e0b',
                borderWidth: 1,
                borderRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 700,
                easing: 'easeInOutQuart',
                delay: 100
            },
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    grid: { color: 'rgba(210, 220, 182, 0.3)' }
                },
                x: {
                    grid: { display: false }
                }
            }
        }
    });
});
</script>
@endpush
@endsection
