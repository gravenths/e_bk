<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-BK - Sistem Bimbingan Konseling')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
        }
        header h1 {
            margin: 0;
            font-size: 20px;
            display: inline-block;
            font-family: 'Open Sans', sans-serif;
        }
        nav {
            background-color: #eee;
            padding: 8px 20px;
            border-bottom: 1px solid #ccc;
            font-family: 'Open Sans', sans-serif;
        }
        nav a {
            color: #0066cc;
            text-decoration: none;
            margin-right: 15px;
            font-weight: bold;
            font-size: 15px;
        }
        nav a:hover, nav a.active {
            text-decoration: underline;
            color: #003366;
        }
        .container {
            padding: 20px;
            max-width: 1100px;
            margin: 0 auto;
            background-color: #fff;
            min-height: 500px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 15px;
            font-family: 'Open Sans', sans-serif;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px 12px;
            text-align: left;
            font-size: 15px;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            display: inline-block;
            padding: 5px 10px;
            background-color: #e0e0e0;
            color: #333;
            text-decoration: none;
            border: 1px solid #aaa;
            cursor: pointer;
            font-size: 14px;
            border-radius: 3px;
            font-family: 'Open Sans', sans-serif;
        }
        .btn-primary {
            background-color: #0066cc;
            color: #fff;
            border-color: #004080;
        }
        .btn-danger {
            background-color: #cc0000;
            color: #fff;
            border-color: #990000;
        }
        .btn-success {
            background-color: #28a745;
            color: #fff;
            border-color: #1e7e34;
        }
        .alert {
            padding: 10px 15px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-family: 'Open Sans', sans-serif;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
        .form-group {
            margin-bottom: 12px;
        }
        .form-group label {
            display: block;
            margin-bottom: 4px;
            font-weight: bold;
            font-size: 14px;
            font-family: 'Open Sans', sans-serif;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 6px 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-family: 'Open Sans', sans-serif;
            font-size: 14px;
        }
        .card {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #fafafa;
        }
        .badge {
            padding: 2px 6px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 13px;
            font-weight: bold;
            font-family: 'Open Sans', sans-serif;
        }
        .badge-sp1 { background-color: #fff3cd; color: #856404; border-color: #ffeeba; }
        .badge-sp2 { background-color: #ffe8d6; color: #a74800; border-color: #ffd8b8; }
        .badge-sp3 { background-color: #f8d7da; color: #721c24; border-color: #f5c6cb; }
        .flex { display: flex; gap: 15px; }
        .flex-1 { flex: 1; }
        @media print {
            header, nav, .no-print { display: none !important; }
            body { background: #fff; }
            .container { padding: 0; margin: 0; max-width: 100%; }
        }
    </style>
</head>
<body>
    <header>
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div>
                <h1 style="margin:0;">E-BK (Sistem Bimbingan Konseling)</h1>
            </div>
            @auth
            <div style="font-size:14px;">
                Pengguna: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->role }}) |
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:none; border:none; color:#ff9999; text-decoration:underline; cursor:pointer; font-family:'Open Sans', sans-serif;">Logout</button>
                </form>
            </div>
            @endauth
        </div>
    </header>

    @auth
    <nav class="no-print">
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Beranda</a>
        <a href="{{ route('siswa.index') }}" class="{{ request()->routeIs('siswa.*') ? 'active' : '' }}">Data Siswa</a>
        <a href="{{ route('pelanggaran.index') }}" class="{{ request()->routeIs('pelanggaran.index') ? 'active' : '' }}">Master Pelanggaran</a>
        <a href="{{ route('pelanggaran.riwayat') }}" class="{{ request()->routeIs('pelanggaran.riwayat*') || request()->routeIs('pelanggaran.tambah') ? 'active' : '' }}">Riwayat Pelanggaran</a>
        <a href="{{ route('surat-peringatan.index') }}" class="{{ request()->routeIs('surat-peringatan.*') ? 'active' : '' }}">Surat Peringatan</a>
        <a href="{{ route('laporan.pelanggaran') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">Laporan</a>
        <a href="{{ route('pengaturan.tahun-ajaran') }}" class="{{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">Pengaturan</a>
        <a href="{{ route('kenaikan-kelas.index') }}" class="{{ request()->routeIs('kenaikan-kelas.*') ? 'active' : '' }}">Kenaikan Kelas</a>
    </nav>
    @endauth

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi Kesalahan:</strong>
                <ul style="margin: 5px 0 0 20px; padding:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
