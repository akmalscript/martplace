<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih - MartPlace</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #F1F3E0;">
    <table role="presentation" style="width: 100%; border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table role="presentation" style="width: 600px; max-width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(119, 136, 115, 0.15);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #A1BC98 0%, #778873 100%); padding: 30px 40px; text-align: center;">
                            <h1 style="margin: 0; color: #F1F3E0; font-size: 28px; font-weight: bold;">MartPlace</h1>
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px;">
                            <h2 style="margin: 0 0 20px; color: #778873; font-size: 24px;">
                                Terima Kasih, {{ $comment->name }}! 🎉
                            </h2>
                            
                            <p style="margin: 0 0 20px; color: #666; font-size: 16px; line-height: 1.6;">
                                Kami sangat menghargai Anda telah meluangkan waktu untuk memberikan rating dan komentar pada produk kami.
                            </p>
                            
                            <!-- Product Card -->
                            <div style="background-color: #F1F3E0; border-radius: 12px; padding: 20px; margin: 20px 0;">
                                <p style="margin: 0 0 10px; color: #778873; font-size: 14px; font-weight: 600;">PRODUK YANG ANDA ULAS:</p>
                                <h3 style="margin: 0 0 10px; color: #778873; font-size: 18px;">{{ $product->name }}</h3>
                                <p style="margin: 0; color: #A1BC98; font-size: 20px; font-weight: bold;">{{ $product->formatted_price }}</p>
                            </div>
                            
                            <!-- Rating Display -->
                            <div style="background-color: #fff; border: 2px solid #D2DCB6; border-radius: 12px; padding: 20px; margin: 20px 0; text-align: center;">
                                <p style="margin: 0 0 10px; color: #778873; font-size: 14px;">RATING ANDA:</p>
                                <div style="font-size: 32px; color: #FFB800; letter-spacing: 4px;">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $comment->rating)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </div>
                                <p style="margin: 10px 0 0; color: #778873; font-size: 16px; font-weight: bold;">{{ $comment->rating }}/5</p>
                            </div>
                            
                            <!-- Comment Box -->
                            <div style="background-color: #f9f9f9; border-left: 4px solid #A1BC98; padding: 15px 20px; margin: 20px 0; border-radius: 0 8px 8px 0;">
                                <p style="margin: 0 0 5px; color: #778873; font-size: 14px; font-weight: 600;">KOMENTAR ANDA:</p>
                                <p style="margin: 0; color: #666; font-size: 15px; font-style: italic; line-height: 1.5;">"{{ $comment->comment }}"</p>
                            </div>
                            
                            <p style="margin: 20px 0; color: #666; font-size: 16px; line-height: 1.6;">
                                Ulasan Anda sangat berarti bagi kami dan membantu pembeli lain dalam membuat keputusan. Terima kasih telah menjadi bagian dari komunitas MartPlace!
                            </p>
                            
                            <!-- CTA Button -->
                            <div style="text-align: center; margin: 30px 0;">
                                <a href="{{ route('products.show', $product->id) }}" 
                                   style="display: inline-block; padding: 14px 32px; background: linear-gradient(135deg, #A1BC98 0%, #778873 100%); color: #F1F3E0; text-decoration: none; font-weight: bold; border-radius: 10px; font-size: 16px;">
                                    Lihat Produk Lainnya
                                </a>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #778873; padding: 25px 40px; text-align: center;">
                            <p style="margin: 0 0 10px; color: #D2DCB6; font-size: 14px;">
                                © {{ date('Y') }} MartPlace. All rights reserved.
                            </p>
                            <p style="margin: 0; color: #A1BC98; font-size: 12px;">
                                Email ini dikirim otomatis, mohon tidak membalas email ini.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
