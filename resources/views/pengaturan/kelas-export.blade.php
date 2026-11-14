@extends('layouts.app')

@section('title', 'Export Data Kelas ' . $k->nama . ' - E-BK')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center;" class="no-print">
    <h2>Export Data Siswa Kelas {{ $k->nama }}</h2>
    <div>
        <a href="{{ route('pengaturan.kelas') }}" class="btn" style="background:#666; color:#fff;">&larr; Kembali</a>
        <button onclick="window.print()" class="btn btn-primary">Cetak / Print Laporan</button>
    </div>
</div>

<h3 style="text-align:center; margin-top:20px;">DATA SISWA KELAS {{ strtoupper($k->nama) }}</h3>
<p style="text-align:center; font-size:12px; color:#666;">Tanggal Cetak: {{ date('d F Y') }}</p>

<!-- Table -->
<table>
    <thead>
        <tr>
            <th style="width:40px; text-align:center;">No</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th style="text-align:center;">L/P</th>
            <th style="text-align:center;">Jumlah Pelanggaran</th>
            <th style="text-align:center;">Total Poin</th>
            <th style="text-align:center;">Status SP</th>
            <th style="text-align:center;">Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse($k->siswa as $idx => $s)
        @php
            $poin = $s->total_poin;
            $sp = $s->status_sp;
        @endphp
        <tr>
            <td style="text-align:center;">{{ $idx + 1 }}</td>
            <td>{{ $s->nis }}</td>
            <td><strong>{{ $s->nama }}</strong></td>
            <td style="text-align:center;">{{ $s->jk }}</td>
            <td style="text-align:center;">{{ $s->riwayatPelanggaran->count() }} Kali</td>
            <td style="color:#cc0000; font-weight:bold; text-align:center;">{{ $poin }} Poin</td>
            <td style="text-align:center;">
                @if($sp === 'SP 3') <span class="badge badge-sp3">SP 3</span>
                @elseif($sp === 'SP 2') <span class="badge badge-sp2">SP 2</span>
                @elseif($sp === 'SP 1') <span class="badge badge-sp1">SP 1</span>
                @else Belum @endif
            </td>
            <td style="text-align:center;">{{ $s->status }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center;">Belum ada siswa di kelas ini.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
