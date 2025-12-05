<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        h2 {
            color: #2d3748;
            margin-bottom: 10px;
        }

        p {
            color: #4a5568;
            font-size: 14px;
            line-height: 1.6;
        }

        .rating-box {
            background: #fef3c7;
            border-left: 4px solid #facc15;
            padding: 12px;
            margin: 15px 0;
            border-radius: 6px;
        }

        .footer {
            margin-top: 25px;
            text-align: center;
            color: #718096;
            font-size: 13px;
        }

        .product-box {
            background: #f9fafb;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            border: 1px solid #e5e7eb;
        }

        .signature {
            margin-top: 20px;
            font-weight: bold;
            color: #2d3748;
        }
    </style>
</head>

<body>

<div class="email-container">

    <h2>Halo {{ $review->name }},</h2>

    <p>Terima kasih telah memberikan ulasan untuk produk:</p>

    <!-- Product name box -->
    <div class="product-box">
        <strong>{{ $review->product->name }}</strong>
    </div>

    <!-- Rating section -->
    <div class="rating-box">
        <p><strong>Rating Anda:</strong> {{ $review->rating }} ⭐</p>
    </div>

    <!-- Comment section -->
    @if($review->comment)
        <p><strong>Komentar Anda:</strong></p>
        <p style="background:#f9fafb; padding:12px; border-radius:6px; border:1px solid #e5e7eb;">
            "{{ $review->comment }}"
        </p>
    @endif

    <p style="margin-top: 20px;">
        Kami sangat menghargai waktu dan pendapat Anda. Masukan Anda membantu pembeli lain dan membantu kami menjaga kualitas layanan.
    </p>

    <p class="signature">
        Salam hangat,<br>
        MartPlace
    </p>
</div>

<div class="footer">
    &copy; {{ date('Y') }} MartPlace. Semua hak dilindungi.
</div>

</body>
</html>
