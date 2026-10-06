@extends('layouts.app')

@section('title', 'Daftar Siswa - E-BK')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center;">
    <h2>Daftar Siswa</h2>
    <a href="{{ route('siswa.create') }}" class="btn btn-primary">+ Tambah Siswa Baru</a>
</div>

<!-- Filter -->
<div class="card" style="margin-top:15px;">
    <form method="GET" action="{{ route('siswa.index') }}">
        <div class="flex">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIS atau Nama Siswa..." style="padding:6px; width:100%;">
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
                <select name="status" onchange="this.form.submit()" style="padding:6px;">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
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
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>L/P</th>
            <th>Total Poin</th>
            <th>Status SP</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($siswa as $s)
        @php
            $sp = $s->status_sp;
        @endphp
        <tr>
            <td>{{ $s->nis }}</td>
            <td><a href="{{ route('siswa.show', $s->id) }}"><strong>{{ $s->nama }}</strong></a></td>
            <td>{{ $s->kelas }}</td>
            <td>{{ $s->jk }}</td>
            <td style="color:#cc0000; font-weight:bold;">{{ $s->total_poin }} Poin</td>
            <td>
                @if($sp === 'SP 3') <span class="badge badge-sp3">SP 3</span>
                @elseif($sp === 'SP 2') <span class="badge badge-sp2">SP 2</span>
                @elseif($sp === 'SP 1') <span class="badge badge-sp1">SP 1</span>
                @else Belum @endif
            </td>
            <td>{{ $s->status }}</td>
            <td>
                <a href="{{ route('siswa.show', $s->id) }}" class="btn">Detail</a>
                <a href="{{ route('siswa.edit', $s->id) }}" class="btn">Edit</a>
                <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data siswa ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" style="text-align:center;">Tidak ada data siswa ditemukan.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@if($siswa->hasPages())
<div style="margin-top:15px;">
    {{ $siswa->links() }}
</div>
@endif
@endsection
