<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - E-BK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; background: #f4f4f4; margin: 0; padding: 40px 20px; }
        .box { max-width: 380px; margin: 0 auto; background: #fff; padding: 20px; border: 1px solid #ccc; }
        h2 { margin-top: 0; font-size: 20px; text-align: center; }
        .form-group { margin-bottom: 12px; }
        .form-group label { display: block; margin-bottom: 4px; font-size: 14px; }
        .form-group input, .form-group select { width: 100%; padding: 6px; box-sizing: border-box; border: 1px solid #ccc; font-family: 'Open Sans', sans-serif; font-size: 14px; }
        .btn { width: 100%; padding: 8px; background: #0066cc; color: #fff; border: none; cursor: pointer; font-weight: bold; font-family: 'Open Sans', sans-serif; font-size: 14px; }
        .alert { padding: 8px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; font-size: 13px; margin-bottom: 12px; }
        .links { margin-top: 15px; font-size: 13px; text-align: center; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Daftar Akun E-BK</h2>

        @if($errors->any())
            <div class="alert">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="form-group">
                <label>Peran (Role)</label>
                <select name="role" required>
                    <option value="Guru BK">Guru BK</option>
                    <option value="Admin">Admin Sekolah</option>
                </select>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn">Daftar</button>
        </form>

        <div class="links">
            Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
        </div>
    </div>
</body>
</html>
