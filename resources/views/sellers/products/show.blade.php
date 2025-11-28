@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-xl font-bold mb-4">Detail Seller</h1>

    <p><b>ID:</b> {{ $seller->id }}</p>
    <p><b>Nama Toko:</b> {{ $seller->store_name }}</p>
    <p><b>PIC:</b> {{ $seller->pic_name }}</p>
    <p><b>Status:</b> {{ $seller->status }}</p>

    <a href="{{ route('sellers.index') }}" class="text-blue-600 mt-3 inline-block">Kembali</a>
</div>
@endsection
