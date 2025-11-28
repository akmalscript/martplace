@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-10">
    <h1 class="text-2xl font-bold mb-6">Daftar Seller</h1>

    @if (session('success'))
        <div class="p-3 bg-green-200 text-green-900 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="table-auto w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="p-2 border">ID</th>
                <th class="p-2 border">Nama Toko</th>
                <th class="p-2 border">PIC</th>
                <th class="p-2 border">Telepon</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sellers as $seller)
            <tr>
                <td class="p-2 border">{{ $seller->id }}</td>
                <td class="p-2 border">{{ $seller->store_name }}</td>
                <td class="p-2 border">{{ $seller->pic_name }}</td>
                <td class="p-2 border">{{ $seller->pic_phone }}</td>
                <td class="p-2 border">{{ $seller->status }}</td>
                <td class="p-2 border">
                    <a href="{{ route('sellers.show', $seller->id) }}" class="text-blue-600">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $sellers->links() }}
    </div>
</div>
@endsection
