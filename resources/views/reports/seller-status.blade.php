@extends('reports.layout')

@section('content')
    <div class="summary-box">
        <div class="summary-title">Ringkasan</div>
        <table style="width: 100%; border: none; margin: 0;">
            <tr>
                <td style="border: none; text-align: center; width: 33%;">
                    <div class="summary-value">{{ $totalActive }}</div>
                    <div class="summary-label">Penjual Aktif</div>
                </td>
                <td style="border: none; text-align: center; width: 33%;">
                    <div class="summary-value">{{ $totalInactive }}</div>
                    <div class="summary-label">Penjual Tidak Aktif</div>
                </td>
                <td style="border: none; text-align: center; width: 33%;">
                    <div class="summary-value">{{ $totalActive + $totalInactive }}</div>
                    <div class="summary-label">Total Penjual</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="section-title">Daftar Penjual Aktif ({{ $totalActive }})</div>
    @if($activeSellers->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Nama Toko</th>
                    <th style="width: 20%;">Nama PIC</th>
                    <th style="width: 25%;">Email</th>
                    <th style="width: 15%;">Lokasi</th>
                    <th style="width: 15%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activeSellers as $index => $seller)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $seller->store_name }}</td>
                        <td>{{ $seller->pic_name }}</td>
                        <td>{{ $seller->pic_email }}</td>
                        <td>{{ $seller->pic_city }}, {{ $seller->pic_province }}</td>
                        <td><span class="status-badge status-active">AKTIF</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; color: #666; padding: 20px;">Tidak ada penjual aktif.</p>
    @endif

    <div class="section-title" style="margin-top: 30px;">Daftar Penjual Tidak Aktif ({{ $totalInactive }})</div>
    @if($inactiveSellers->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Nama Toko</th>
                    <th style="width: 20%;">Nama PIC</th>
                    <th style="width: 25%;">Email</th>
                    <th style="width: 15%;">Lokasi</th>
                    <th style="width: 15%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inactiveSellers as $index => $seller)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $seller->store_name }}</td>
                        <td>{{ $seller->pic_name }}</td>
                        <td>{{ $seller->pic_email }}</td>
                        <td>{{ $seller->pic_city }}, {{ $seller->pic_province }}</td>
                        <td>
                            @if($seller->status->value === 'PENDING')
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
        <p style="text-align: center; color: #666; padding: 20px;">Tidak ada penjual tidak aktif.</p>
    @endif
@endsection
