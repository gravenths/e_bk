@extends('layouts.app')

@section('title', 'Laporan Surat Peringatan - E-BK')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center;" class="no-print">
    <h2>Laporan Penerbitan Surat Peringatan</h2>
    <button onclick="window.print()" class="btn btn-primary">Cetak / Print Laporan</button>
</div>

<!-- Filter Form -->
<div class="card no-print" style="margin-top:15px;">
    <form method="GET" action="{{ route('laporan.surat') }}">
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
                <label>Jenis SP</label>
                <select name="jenis_sp">
                    <option value="">Semua Jenis SP</option>
                    <option value="SP 1" {{ request('jenis_sp') == 'SP 1' ? 'selected' : '' }}>SP 1</option>
                    <option value="SP 2" {{ request('jenis_sp') == 'SP 2' ? 'selected' : '' }}>SP 2</option>
                    <option value="SP 3" {{ request('jenis_sp') == 'SP 3' ? 'selected' : '' }}>SP 3</option>
                </select>
            </div>
            <div style="align-self:flex-end; margin-bottom:12px;">
                <button type="submit" class="btn">Filter</button>
            </div>
        </div>
    </form>
</div>

<h3 style="text-align:center; margin-top:20px;">LAPORAN REKAPITULASI PENERBITAN SURAT PERINGATAN</h3>
<p style="text-align:center; font-size:12px; color:#666;">Tanggal Cetak: {{ date('d F Y') }}</p>

<!-- Table -->
<table>
    <thead>
        <tr>
            <th style="width:40px; text-align:center;">No</th>
            <th>Nomor Surat</th>
            <th>Tanggal Terbit</th>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th style="text-align:center;">Jenis SP</th>
        </tr>
    </thead>
    <tbody>
        @forelse($suratList as $idx => $s)
        <tr>
            <td style="text-align:center;">{{ $idx + 1 }}</td>
            <td><strong>{{ $s->nomor_surat }}</strong></td>
            <td>{{ $s->tanggal->format('d/m/Y') }}</td>
            <td>{{ $s->siswa->nis ?? '-' }}</td>
            <td><strong>{{ $s->siswa->nama ?? '-' }}</strong></td>
            <td>{{ $s->siswa->kelas ?? '-' }}</td>
            <td style="text-align:center;">
                @if($s->jenis_sp === 'SP 3') <span class="badge badge-sp3">SP 3</span>
                @elseif($s->jenis_sp === 'SP 2') <span class="badge badge-sp2">SP 2</span>
                @elseif($s->jenis_sp === 'SP 1') <span class="badge badge-sp1">SP 1</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" style="text-align:center;">Tidak ada surat peringatan diterbitkan.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
