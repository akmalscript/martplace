<!DOCTYPE html>
<html>

<head>
    <title>Informasi Akun Toko MartPlace</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Halo, {{ $user->name }}!</h2>

    <p>Selamat! Pendaftaran toko Anda di <strong>MartPlace</strong> telah berhasil.</p>

    <p>Berikut adalah informasi akun Anda untuk masuk ke sistem:</p>

    <div style="background-color: #f4f4f4; padding: 15px; border-radius: 5px; margin: 20px 0;">
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Password:</strong> {{ $password }}</p>
    </div>

    <p>Harap segera mengganti password Anda setelah berhasil masuk demi keamanan akun.</p>

    <p>
        <a href="{{ route('login') }}"
            style="background-color: #059669; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Masuk
            ke MartPlace</a>
    </p>

    <p>Terima kasih,<br>Tim MartPlace</p>
</body>

</html>
