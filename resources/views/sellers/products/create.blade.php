@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-xl font-bold mb-6">Register Seller</h1>

    <form action="{{ route('sellers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Nama Toko</label>
        <input type="text" name="store_name" class="border p-2 w-full mb-3">

        <label>Deskripsi Toko</label>
        <textarea name="store_description" class="border p-2 w-full mb-3"></textarea>

        <button class="bg-green-600 text-white px-3 py-2 rounded">
            Daftar
        </button>
    </form>
</div>
@endsection
