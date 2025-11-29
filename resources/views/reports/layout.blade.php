<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $title ?? 'Laporan MartPlace' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #333;
            background: #fff;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 3px solid #778873;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #778873;
            margin-bottom: 5px;
        }

        .logo span {
            color: #A1BC98;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin-top: 10px;
        }

        .report-date {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }

        .content {
            padding: 0 20px;
        }

        .summary-box {
            background: #F1F3E0;
            border: 1px solid #D2DCB6;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .summary-title {
            font-size: 12px;
            font-weight: bold;
            color: #778873;
            margin-bottom: 10px;
        }

        .summary-grid {
            display: table;
            width: 100%;
        }

        .summary-item {
            display: table-cell;
            text-align: center;
            padding: 10px;
        }

        .summary-value {
            font-size: 20px;
            font-weight: bold;
            color: #778873;
        }

        .summary-label {
            font-size: 9px;
            color: #666;
            margin-top: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background: #778873;
            color: #fff;
            padding: 10px 8px;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
        }

        td {
            padding: 8px;
            border-bottom: 1px solid #D2DCB6;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background: #F1F3E0;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }

        .status-active {
            background: #A1BC98;
            color: #fff;
        }

        .status-pending {
            background: #fbbf24;
            color: #fff;
        }

        .status-rejected {
            background: #ef4444;
            color: #fff;
        }

        .rating-stars {
            color: #fbbf24;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #778873;
            margin: 20px 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 2px solid #D2DCB6;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            padding: 10px;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #D2DCB6;
        }

        .page-number:after {
            content: counter(page);
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-sage {
            color: #A1BC98;
        }

        .text-forest {
            color: #778873;
        }

        .note-box {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 5px;
            padding: 10px;
            margin-top: 20px;
            font-size: 10px;
        }

        .note-title {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 5px;
        }

        .low-stock {
            color: #ef4444;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">mart<span>Place</span></div>
        <div class="report-title">{{ $title }}</div>
        <div class="report-date">Dicetak pada: {{ $date }}</div>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <div class="footer">
        <span>&copy; {{ date('Y') }} MartPlace - Marketplace Terpercaya</span>
        <span style="float: right;">Halaman <span class="page-number"></span></span>
    </div>
</body>
</html>
