@extends('layouts.app')

@section('title', 'Riwayat Pelanggaran - E-BK')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center;">
    <h2>Riwayat Pelanggaran Siswa</h2>
    <a href="{{ route('pelanggaran.tambah') }}" class="btn btn-danger">+ Catat Pelanggaran Baru</a>
</div>

<!-- Filter -->
<div class="card" style="margin-top:15px;">
    <form method="GET" action="{{ route('pelanggaran.riwayat') }}">
        <div class="flex">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa atau NIS..." style="padding:6px; width:100%;">
            </div>
            <div>
                <select name="kelas" onchange="this.form.submit()" style="padding:6px;">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->nama }}" {{ request('kelas') == $k->nama ? 'selected' : '' }}>Kelas {{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="pencatat" onchange="this.form.submit()" style="padding:6px;">
                    <option value="">Semua Pencatat</option>
                    <option value="Admin" {{ request('pencatat') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Guru BK" {{ request('pencatat') == 'Guru BK' ? 'selected' : '' }}>Guru BK</option>
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
            <th>Tanggal</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Pelanggaran</th>
            <th>Poin</th>
            <th>Keterangan</th>
            <th>Pencatat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($riwayat as $r)
        <tr>
            <td>{{ $r->tanggal->format('d/m/Y') }}</td>
            <td><a href="{{ route('siswa.show', $r->siswa_id) }}"><strong>{{ $r->siswa->nama ?? '-' }}</strong></a></td>
            <td>{{ $r->siswa->kelas ?? '-' }}</td>
            <td>{{ $r->jenisPelanggaran->nama ?? '-' }}</td>
            <td style="color:#cc0000; font-weight:bold;">+{{ $r->jenisPelanggaran->poin ?? 0 }}</td>
            <td>{{ $r->keterangan ?? '-' }}</td>
            <td>{{ $r->pencatat }}</td>
            <td>
                <form action="{{ route('pelanggaran.riwayat.destroy', $r->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus riwayat ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center;">Belum ada riwayat pelanggaran.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@if($riwayat->hasPages())
<div style="margin-top:15px;">
    {{ $riwayat->links() }}
</div>
@endif
@endsection
