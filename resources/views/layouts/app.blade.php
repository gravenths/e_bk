<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda') | E-BK SMA Negeri 8 Kota Banjarmasin</title>

    {{-- Bootstrap 5 + Bootstrap Icons (CDN). Untuk produksi/offline, unduh dan simpan di public/vendor --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/ebk.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>

{{-- ================= HEADER ================= --}}
<header class="ebk-header">
    <div class="container-fluid px-4">
        <div class="row align-items-center g-3">
            <div class="col-lg-8 d-flex align-items-center gap-3">
                <img src="{{ asset('img/logo-sman8.png') }}" alt="Logo SMA Negeri 8 Kota Banjarmasin" class="ebk-logo">
                <div>
                    <h1 class="ebk-title">Sistem Informasi<br>Bimbingan Konseling</h1>
                    <p class="ebk-school">SMA Negeri 8 Kota Banjarmasin</p>
                    <p class="ebk-year">Tahun Ajaran {{ $tahunAjaranAktif['nama'] ?? '-' }}</p>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="d-flex justify-content-lg-end align-items-start gap-3">
                    <div class="ebk-userbox">
                        <div class="welcome">
                            Selamat datang,
                            @auth{{ Auth::user()->name }}@else Admin @endauth
                        </div>
                        <div>
                            Role :
                            @auth{{ Auth::user()->role ?? 'Administrator' }}@else Administrator @endauth
                        </div>
                        <div>
                            {{ $tanggalSekarang ?? now()->locale('id')->translatedFormat('l, d F Y') }}
                            | <span id="jam-live">{{ now()->format('H:i:s') }}</span>
                        </div>
                    </div>
                    <div class="ebk-avatar" aria-hidden="true"><i class="bi bi-person-fill"></i></div>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- ================= NAVBAR ================= --}}
<nav class="navbar navbar-expand-lg ebk-nav">
    <div class="container-fluid px-4">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#menuUtama" aria-controls="menuUtama" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menuUtama">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}"
                       href="{{ route('beranda') }}">Beranda</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('siswa.*') ? 'active' : '' }}"
                       href="{{ route('siswa.index') }}">Data Siswa</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('pelanggaran.*') ? 'active' : '' }}"
                       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pelanggaran</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('pelanggaran.riwayat') }}">Data Pelanggaran</a></li>
                        <li><a class="dropdown-item" href="{{ route('pelanggaran.tambah') }}">Tambah Pelanggaran</a></li>
                        <li><a class="dropdown-item" href="{{ route('pelanggaran.index') }}">Master Jenis Pelanggaran</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('surat-peringatan.*') ? 'active' : '' }}"
                       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Surat Peringatan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('surat-peringatan.index') }}">Siswa Memenuhi Syarat SP</a></li>
                        <li><a class="dropdown-item" href="{{ route('surat-peringatan.riwayat') }}">Riwayat Surat Peringatan</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('laporan.*') ? 'active' : '' }}"
                       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Laporan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('laporan.pelanggaran') }}">Laporan Pelanggaran</a></li>
                        <li><a class="dropdown-item" href="#">Export Excel</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}"
                       href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pengaturan</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('pengaturan.kelas') }}">Data Kelas</a></li>
                        <li><a class="dropdown-item" href="{{ route('pengaturan.tahun-ajaran') }}">Tahun Ajaran</a></li>
                        <li><a class="dropdown-item" href="{{ route('pengaturan.batas-sp') }}">Batas Poin SP</a></li>
                        <li><a class="dropdown-item" href="{{ route('pengaturan.pengguna') }}">Data Pengguna</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kenaikan-kelas.*') ? 'active' : '' }}"
                       href="{{ route('kenaikan-kelas.index') }}">Kenaikan Kelas</a>
                </li>

                @auth
                <li class="nav-item">
                    <a class="nav-link" href="#"
                       onclick="event.preventDefault(); document.getElementById('form-logout').submit();">Logout</a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@auth
<form id="form-logout" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
@endauth

{{-- ================= KONTEN ================= --}}
<main class="ebk-main">
    <div class="container-fluid px-4 pt-3">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                <strong>Terjadi Kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @yield('content')
    </div>
</main>

{{-- ================= FOOTER ================= --}}
<footer class="ebk-footer">
    &copy; {{ now()->year }} Sistem Informasi Bimbingan Konseling - SMA Negeri 8 Kota Banjarmasin
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Jam berjalan di header (mengikuti jam perangkat pengguna)
    (function () {
        var el = document.getElementById('jam-live');
        if (!el) return;
        function pad(n) { return String(n).padStart(2, '0'); }
        function tick() {
            var d = new Date();
            el.textContent = pad(d.getHours()) + ':' + pad(d.getMinutes()) + ':' + pad(d.getSeconds());
        }
        tick();
        setInterval(tick, 1000);
    })();
</script>
@stack('scripts')
</body>
</html>
