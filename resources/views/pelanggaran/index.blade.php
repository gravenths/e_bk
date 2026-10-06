@extends('layouts.app')

@section('title', 'Master Jenis Pelanggaran - E-BK')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center;">
    <h2>Master Data Pelanggaran</h2>
</div>

<!-- Tambah Form & Filter -->
<div class="flex" style="margin-top:15px; margin-bottom:15px;">
    <div class="card flex-1">
        <h3>Form Tambah Jenis Pelanggaran</h3>
        <form action="{{ route('pelanggaran.jenis.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Pelanggaran</label>
                <input type="text" name="nama" required placeholder="Contoh: Merokok di sekolah">
            </div>
            <div class="form-group">
                <label>Bobot Poin</label>
                <input type="number" name="poin" required min="1" placeholder="Poin">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan Pelanggaran</button>
        </form>
    </div>

    <div class="flex-1" style="flex:2;">
        <h3>Daftar Jenis Pelanggaran</h3>
        <form method="GET" action="{{ route('pelanggaran.index') }}" style="margin-bottom:10px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pelanggaran..." style="padding:5px;">
            <button type="submit" class="btn">Filter</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Nama Pelanggaran</th>
                    <th>Poin</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenisPelanggaran as $jp)
                <tr>
                    <td><strong>{{ $jp->nama }}</strong></td>
                    <td style="color:#cc0000; font-weight:bold;">+{{ $jp->poin }}</td>
                    <td>{{ $jp->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align:center;">Belum ada jenis pelanggaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
