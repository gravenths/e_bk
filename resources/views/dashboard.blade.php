@extends('layouts.app')

@section('title', 'Beranda - E-BK')

@section('content')
<h2>Beranda / Dashboard</h2>
<p style="font-size:13px; color:#666;">Ringkasan statistik bimbingan konseling dan catatan pelanggaran siswa.</p>

<!-- Stat Summary Grid -->
<div class="flex" style="margin-bottom:20px;">
    <div class="card flex-1">
        <h4 style="margin:0; font-size:13px; color:#666;">Total Siswa Aktif</h4>
        <h2 style="margin:5px 0 0 0;">{{ $totalSiswa }} Siswa</h2>
    </div>
    <div class="card flex-1">
        <h4 style="margin:0; font-size:13px; color:#666;">Jenis Pelanggaran</h4>
        <h2 style="margin:5px 0 0 0;">{{ $totalJenis }} Jenis</h2>
    </div>
    <div class="card flex-1">
        <h4 style="margin:0; font-size:13px; color:#666;">Pelanggaran Bulan Ini</h4>
        <h2 style="margin:5px 0 0 0;">{{ $pelanggaranBulanIni }} Kasus</h2>
    </div>
    <div class="card flex-1">
        <h4 style="margin:0; font-size:13px; color:#666;">Siswa Mencapai SP</h4>
        <h2 style="margin:5px 0 0 0; color:#cc0000;">{{ $countSpTotal }} Siswa</h2>
    </div>
</div>

<div class="flex">
    <!-- Pelanggaran Terbaru -->
    <div class="flex-1" style="flex:2;">
        <h3>Pelanggaran Terbaru</h3>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Siswa</th>
                    <th>Kelas</th>
                    <th>Pelanggaran</th>
                    <th>Poin</th>
                    <th>Pencatat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatTerbaru as $r)
                <tr>
                    <td>{{ $r->tanggal->format('d/m/Y') }}</td>
                    <td><a href="{{ route('siswa.show', $r->siswa_id) }}">{{ $r->siswa->nama ?? '-' }}</a></td>
                    <td>{{ $r->siswa->kelas ?? '-' }}</td>
                    <td>{{ $r->jenisPelanggaran->nama ?? '-' }}</td>
                    <td style="color:#cc0000; font-weight:bold;">+{{ $r->jenisPelanggaran->poin ?? 0 }}</td>
                    <td>{{ $r->pencatat }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;">Belum ada data riwayat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <p><a href="{{ route('pelanggaran.riwayat') }}">Lihat Seluruh Riwayat Pelanggaran &rarr;</a></p>
    </div>

    <!-- Siswa Poin Tertinggi -->
    <div class="flex-1">
        <h3>Siswa Poin Tertinggi</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Total Poin</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topSiswa as $s)
                <tr>
                    <td><a href="{{ route('siswa.show', $s->id) }}">{{ $s->nama }}</a></td>
                    <td>{{ $s->kelas }}</td>
                    <td style="color:#cc0000; font-weight:bold;">{{ $s->total_poin }}</td>
                    <td>
                        @php $sp = $s->status_sp; @endphp
                        @if($sp === 'SP 3') <span class="badge badge-sp3">SP 3</span>
                        @elseif($sp === 'SP 2') <span class="badge badge-sp2">SP 2</span>
                        @elseif($sp === 'SP 1') <span class="badge badge-sp1">SP 1</span>
                        @else Belum @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
