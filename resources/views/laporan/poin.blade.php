@extends('layouts.app')

@section('title', 'Laporan Poin Siswa - E-BK')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center;" class="no-print">
    <h2>Laporan Akumulasi Poin Pelanggaran Siswa</h2>
    <button onclick="window.print()" class="btn btn-primary">Cetak / Print Laporan</button>
</div>

<!-- Filter Form -->
<div class="card no-print" style="margin-top:15px;">
    <form method="GET" action="{{ route('laporan.poin') }}">
        <div class="flex">
            <div class="form-group flex-1">
                <label>Kelas</label>
                <select name="kelas" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $k)
                    <option value="{{ $k->nama }}" {{ request('kelas') == $k->nama ? 'selected' : '' }}>Kelas {{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group flex-1">
                <label>Status SP</label>
                <select name="status_sp" onchange="this.form.submit()">
                    <option value="">Semua Status SP</option>
                    <option value="SP 1" {{ request('status_sp') == 'SP 1' ? 'selected' : '' }}>SP 1</option>
                    <option value="SP 2" {{ request('status_sp') == 'SP 2' ? 'selected' : '' }}>SP 2</option>
                    <option value="SP 3" {{ request('status_sp') == 'SP 3' ? 'selected' : '' }}>SP 3</option>
                    <option value="Belum" {{ request('status_sp') == 'Belum' ? 'selected' : '' }}>Belum SP</option>
                </select>
            </div>
        </div>
    </form>
</div>

<h3 style="text-align:center; margin-top:20px;">LAPORAN AKUMULASI POIN PELANGGARAN SISWA</h3>
<p style="text-align:center; font-size:12px; color:#666;">Tanggal Cetak: {{ date('d F Y') }}</p>

<!-- Table -->
<table>
    <thead>
        <tr>
            <th style="width:40px; text-align:center;">No</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th style="text-align:center;">Jumlah Pelanggaran</th>
            <th style="text-align:center;">Total Poin</th>
            <th style="text-align:center;">Status SP</th>
        </tr>
    </thead>
    <tbody>
        @forelse($siswaList as $idx => $s)
        @php
            $poin = $s->total_poin;
            $sp = $s->status_sp;
        @endphp
        <tr>
            <td style="text-align:center;">{{ $loop->iteration }}</td>
            <td>{{ $s->nis }}</td>
            <td><strong>{{ $s->nama }}</strong></td>
            <td>{{ $s->kelas }}</td>
            <td style="text-align:center;">{{ $s->riwayatPelanggaran->count() }} Kali</td>
            <td style="color:#cc0000; font-weight:bold; text-align:center;">{{ $poin }} Poin</td>
            <td style="text-align:center;">
                @if($sp === 'SP 3') <span class="badge badge-sp3">SP 3</span>
                @elseif($sp === 'SP 2') <span class="badge badge-sp2">SP 2</span>
                @elseif($sp === 'SP 1') <span class="badge badge-sp1">SP 1</span>
                @else Belum @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center;">Tidak ada data siswa.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
