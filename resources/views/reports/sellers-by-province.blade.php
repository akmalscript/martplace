@extends('reports.layout')

@section('content')
    <div class="summary-box">
        <div class="summary-title">Provinsi: {{ $province }}</div>
        <table style="width: 100%; border: none; margin: 0;">
            <tr>
                <td style="border: none; text-align: center;">
                    <div class="summary-value">{{ $total }}</div>
                    <div class="summary-label">Total Penjual di Provinsi Ini</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Daftar Penjual di {{ $province }}</div>
    @if($sellers->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Nama Toko</th>
                    <th style="width: 15%;">Nama PIC</th>
                    <th style="width: 15%;">Kab/Kota</th>
                    <th style="width: 15%;">No. Telepon</th>
                    <th style="width: 20%;">Email</th>
                    <th style="width: 10%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sellers as $index => $seller)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $seller->store_name }}</td>
                        <td>{{ $seller->pic_name }}</td>
                        <td>{{ $seller->pic_city }}</td>
                        <td>{{ $seller->pic_phone }}</td>
                        <td>{{ $seller->pic_email }}</td>
                        <td>
                            @if($seller->status->value === 'ACTIVE')
                                <span class="status-badge status-active">AKTIF</span>
                            @elseif($seller->status->value === 'PENDING')
                                <span class="status-badge status-pending">PENDING</span>
                            @else
                                <span class="status-badge status-rejected">DITOLAK</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; color: #666; padding: 20px;">Tidak ada penjual di provinsi {{ $province }}.</p>
    @endif
@endsection
