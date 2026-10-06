@extends('layouts.app')

@section('title', 'Laporan Pelanggaran - E-BK')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center;" class="no-print">
    <h2>Laporan Rekapitulasi Pelanggaran Siswa</h2>
    <button onclick="window.print()" class="btn btn-primary">Cetak / Print Laporan</button>
</div>

<!-- Filter Form -->
<div class="card no-print" style="margin-top:15px;">
    <form method="GET" action="{{ route('laporan.pelanggaran') }}">
        <div class="flex">
            <div class="form-group flex-1">
                <label>Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}">
            </div>
            <div class="form-group flex-1">
                <label>Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}">
            </div>
            <div class="form-group flex-1">
                <label>Kelas</label>
                <select name="kelas">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $k)
                    <option value="{{ $k->nama }}" {{ request('kelas') == $k->nama ? 'selected' : '' }}>Kelas {{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div style="align-self:flex-end; margin-bottom:12px;">
                <button type="submit" class="btn">Filter</button>
            </div>
        </div>
    </form>
</div>

<h3 style="text-align:center; margin-top:20px;">LAPORAN REKAPITULASI PELANGGARAN SISWA</h3>
<p style="text-align:center; font-size:12px; color:#666;">Tanggal Cetak: {{ date('d F Y') }}</p>

<!-- Table -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Jenis Pelanggaran</th>
            <th>Poin</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        @forelse($riwayat as $idx => $r)
        <tr>
            <td style="text-align:center;">{{ $idx + 1 }}</td>
            <td>{{ $r->tanggal->format('d/m/Y') }}</td>
            <td><strong>{{ $r->siswa->nama ?? '-' }}</strong></td>
            <td>{{ $r->siswa->kelas ?? '-' }}</td>
            <td>{{ $r->jenisPelanggaran->nama ?? '-' }}</td>
            <td style="color:#cc0000; font-weight:bold; text-align:center;">+{{ $r->jenisPelanggaran->poin ?? 0 }}</td>
            <td>{{ $r->keterangan ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center;">Tidak ada data pelanggaran ditemukan.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
