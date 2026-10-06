@extends('layouts.app')

@section('title', 'Riwayat Surat Peringatan - E-BK')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center;">
    <h2>Riwayat Surat Peringatan</h2>
    <a href="{{ route('surat-peringatan.index') }}" class="btn btn-primary">Terbitkan SP Baru</a>
</div>

<!-- Filter -->
<div class="card" style="margin-top:15px;">
    <form method="GET" action="{{ route('surat-peringatan.riwayat') }}">
        <div class="flex">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIS, Nama, atau Nomor Surat..." style="padding:6px; width:100%;">
            </div>
            <div>
                <select name="jenis_sp" onchange="this.form.submit()" style="padding:6px;">
                    <option value="">Semua Jenis SP</option>
                    <option value="SP 1" {{ request('jenis_sp') == 'SP 1' ? 'selected' : '' }}>SP 1</option>
                    <option value="SP 2" {{ request('jenis_sp') == 'SP 2' ? 'selected' : '' }}>SP 2</option>
                    <option value="SP 3" {{ request('jenis_sp') == 'SP 3' ? 'selected' : '' }}>SP 3</option>
                </select>
            </div>
            <div>
                <button type="submit" class="btn">Cari</button>
            </div>
        </div>
    </form>
</div>

<!-- Table -->
<table>
    <thead>
        <tr>
            <th>Nomor Surat</th>
            <th>Tanggal Terbit</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Jenis SP</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($suratList as $s)
        <tr>
            <td><strong>{{ $s->nomor_surat }}</strong></td>
            <td>{{ $s->tanggal->format('d/m/Y') }}</td>
            <td><a href="{{ route('siswa.show', $s->siswa_id) }}">{{ $s->siswa->nama ?? '-' }}</a></td>
            <td>{{ $s->siswa->kelas ?? '-' }}</td>
            <td>
                @if($s->jenis_sp === 'SP 3') <span class="badge badge-sp3">SP 3</span>
                @elseif($s->jenis_sp === 'SP 2') <span class="badge badge-sp2">SP 2</span>
                @elseif($s->jenis_sp === 'SP 1') <span class="badge badge-sp1">SP 1</span>
                @endif
            </td>
            <td>
                <a href="{{ route('surat-peringatan.cetak', $s->id) }}" target="_blank" class="btn">Cetak Surat</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;">Belum ada surat peringatan diterbitkan.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@if($suratList->hasPages())
<div style="margin-top:15px;">
    {{ $suratList->links() }}
</div>
@endif
@endsection
