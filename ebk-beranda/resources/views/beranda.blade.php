@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<h2 class="ebk-page-title">Beranda / Dashboard</h2>

{{-- ============ KARTU STATISTIK ============ --}}
<div class="row g-3">

    {{-- Total Siswa --}}
    <div class="col-12 col-md-6 col-xl">
        <div class="stat-card">
            <div class="stat-icon blue"><i class="bi bi-people-fill"></i></div>
            <div>
                <p class="stat-label">Total Siswa</p>
                <p class="stat-value">{{ number_format($stat['total_siswa'], 0, ',', '.') }}</p>
                <p class="stat-sub">
                    Aktif : {{ number_format($stat['siswa_aktif'], 0, ',', '.') }}<br>
                    Nonaktif : {{ number_format($stat['siswa_nonaktif'], 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Pelanggaran Hari Ini --}}
    <div class="col-12 col-md-6 col-xl">
        <div class="stat-card">
            <div class="stat-icon red"><i class="bi bi-clipboard2-check"></i></div>
            <div>
                <p class="stat-label">Pelanggaran Hari Ini</p>
                <p class="stat-value">{{ number_format($stat['pelanggaran_hari_ini'], 0, ',', '.') }}</p>
                <p class="stat-sub">
                    <a href="#" class="ebk-link">Lihat Detail <i class="bi bi-arrow-right"></i></a>
                </p>
            </div>
        </div>
    </div>

    {{-- Total Pelanggaran --}}
    <div class="col-12 col-md-6 col-xl">
        <div class="stat-card">
            <div class="stat-icon green"><i class="bi bi-calendar3"></i></div>
            <div>
                <p class="stat-label">Total Pelanggaran</p>
                <p class="stat-value">{{ number_format($stat['total_pelanggaran'], 0, ',', '.') }}</p>
                <p class="stat-sub">Tahun Ajaran Ini</p>
            </div>
        </div>
    </div>

    {{-- Surat Peringatan --}}
    <div class="col-12 col-md-6 col-xl">
        <div class="stat-card">
            <div class="stat-icon orange"><i class="bi bi-file-earmark-text-fill"></i></div>
            <div>
                <p class="stat-label">Surat Peringatan</p>
                <p class="stat-value">{{ number_format($stat['total_sp'], 0, ',', '.') }}</p>
                <p class="stat-sub">
                    SP Aktif : {{ $stat['sp_aktif'] }}<br>
                    SP Selesai : {{ $stat['sp_selesai'] }}
                </p>
            </div>
        </div>
    </div>

    {{-- Tahun Ajaran Aktif --}}
    <div class="col-12 col-md-6 col-xl">
        <div class="ebk-panel year-card">
            <div class="ebk-panel-head">Tahun Ajaran Aktif</div>
            <div class="ebk-panel-body">
                <p class="year-name">{{ $tahunAjaranAktif['nama'] }}</p>
                <p class="year-period">
                    Periode : {{ $tahunAjaranAktif['mulai'] }} s.d {{ $tahunAjaranAktif['selesai'] }}
                </p>
            </div>
        </div>
    </div>

</div>

{{-- ============ TABEL + MENU CEPAT ============ --}}
<div class="row g-3 mt-2">

    {{-- 5 Siswa Poin Tertinggi --}}
    <div class="col-12 col-lg-8 col-xl-9">
        <div class="ebk-panel">
            <div class="ebk-panel-head">5 Siswa dengan Poin Tertinggi</div>

            <div class="table-responsive">
                <table class="ebk-table">
                    <thead>
                        <tr>
                            <th style="width:70px">No</th>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Total Poin</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($siswaTeratas as $i => $s)
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $s['nis'] }}</td>
                                <td>{{ $s['nama'] }}</td>
                                <td>{{ $s['kelas'] }}</td>
                                <td>{{ $s['poin'] }}</td>
                                <td>
                                    @php
                                        $kelasBadge = match ($s['status']) {
                                            'SP 1'  => 'sp-1',
                                            'SP 2'  => 'sp-2',
                                            'SP 3'  => 'sp-3',
                                            default => 'sp-none',
                                        };
                                    @endphp
                                    <span class="sp-badge {{ $kelasBadge }}">{{ $s['status'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-muted">Belum ada data pelanggaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="ebk-panel-foot">
                <a href="#" class="ebk-link">Lihat Semua <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </div>

    {{-- Menu Cepat --}}
    <div class="col-12 col-lg-4 col-xl-3">
        <div class="ebk-panel quick-menu-panel">
            <div class="ebk-panel-head">Menu Cepat</div>
            <ul class="quick-menu">
                <li><a href="#"><i class="bi bi-plus-lg ic-green"></i><span>Tambah Pelanggaran</span></a></li>
                <li><a href="#"><i class="bi bi-person-fill ic-navy"></i><span>Data Siswa</span></a></li>
                <li><a href="#"><i class="bi bi-list-ul ic-maroon"></i><span>Data Pelanggaran</span></a></li>
                <li><a href="#"><i class="bi bi-file-earmark-text ic-orange"></i><span>Cetak Surat Peringatan</span></a></li>
                <li><a href="#"><i class="bi bi-box-arrow-up ic-purple"></i><span>Kenaikan Kelas</span></a></li>
            </ul>
        </div>
    </div>

</div>

@endsection
