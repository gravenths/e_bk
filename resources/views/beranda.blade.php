@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

<h2 class="ebk-page-title">Beranda / Dashboard</h2>

{{-- ============ KARTU STATISTIK ============ --}}
<div class="row g-3">

    {{-- 1. Total Siswa → Data Siswa --}}
    <div class="col-12 col-md-6 col-xl">
        <a href="{{ route('siswa.index') }}" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-icon blue"><i class="bi bi-people-fill"></i></div>
                <div>
                    <p class="stat-label">Total Siswa</p>
                    <p class="stat-value">{{ number_format($stat['total_siswa'], 0, ',', '.') }}</p>
                    <p class="stat-sub">
                        Aktif&nbsp;: {{ number_format($stat['siswa_aktif'], 0, ',', '.') }}<br>
                        Nonaktif : {{ number_format($stat['siswa_nonaktif'], 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </a>
    </div>

    {{-- 2. Pelanggaran Bulan Ini → Riwayat Pelanggaran --}}
    <div class="col-12 col-md-6 col-xl">
        <a href="{{ route('pelanggaran.riwayat') }}" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-icon red"><i class="bi bi-clipboard2-check"></i></div>
                <div>
                    <p class="stat-label">Pelanggaran Bulan Ini</p>
                    <p class="stat-value">{{ number_format($stat['pelanggaran_bulan_ini'], 0, ',', '.') }}</p>
                    <p class="stat-sub">{{ $bulanIni }}</p>
                </div>
            </div>
        </a>
    </div>

    {{-- 3. Total Pelanggaran → Riwayat Pelanggaran --}}
    <div class="col-12 col-md-6 col-xl">
        <a href="{{ route('pelanggaran.riwayat') }}" class="stat-card-link">
            <div class="stat-card">
                <div class="stat-icon green"><i class="bi bi-calendar3"></i></div>
                <div>
                    <p class="stat-label">Total Pelanggaran</p>
                    <p class="stat-value">{{ number_format($stat['total_pelanggaran'], 0, ',', '.') }}</p>
                    <p class="stat-sub">Seluruh catatan</p>
                </div>
            </div>
        </a>
    </div>

    {{-- 4. Tahun Ajaran Aktif (digeser dari posisi 5) → Pengaturan Tahun Ajaran --}}
    <div class="col-12 col-md-6 col-xl">
        <a href="{{ route('pengaturan.tahun-ajaran') }}" class="stat-card-link">
            <div class="ebk-panel year-card" style="height:100%;">
                <div class="ebk-panel-head">Tahun Ajaran Aktif</div>
                <div class="ebk-panel-body">
                    <p class="year-name">{{ $tahunAjaranAktif['nama'] }}</p>
                    <p class="year-period">Klik untuk kelola tahun ajaran</p>
                </div>
            </div>
        </a>
    </div>

    {{-- 5. Mini Menu Cepat (menggantikan posisi Tahun Ajaran) --}}
    <div class="col-12 col-md-6 col-xl">
        <div class="ebk-panel quick-mini-panel" style="height:100%;">
            <div class="ebk-panel-head">Menu Cepat</div>
            <div class="quick-mini-body">
                <a href="{{ route('pelanggaran.riwayat') }}" class="quick-mini-btn">
                    <i class="bi bi-plus-circle-fill"></i>
                    <span>Tambah Pelanggaran</span>
                </a>
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
                <a href="{{ route('pelanggaran.riwayat') }}" class="ebk-link">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>



</div>

@endsection
