@extends('layouts.app')

@section('title', 'List Pelanggaran - E-BK')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-top:8px;">
    <h2>List Pelanggaran</h2>
</div>

<div class="flex" style="margin-top:15px; margin-bottom:15px; align-items:flex-start;">

    {{-- Form Tambah Jenis Pelanggaran --}}
    <div class="card flex-1">
        <h3>Tambah Jenis Pelanggaran</h3>
        <form action="{{ route('pelanggaran.jenis.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Pelanggaran</label>
                <input type="text" name="nama" required placeholder="Contoh: Merokok di sekolah"
                       value="{{ old('nama') }}">
            </div>
            <div class="form-group">
                <label>Bobot Poin</label>
                <input type="number" name="poin" required min="1" placeholder="Poin"
                       value="{{ old('poin') }}">
            </div>
            <button type="submit" class="btn-tambah">
                <i class="bi bi-plus-circle-fill"></i> Simpan Pelanggaran
            </button>
        </form>
    </div>

    {{-- Tabel Daftar Jenis Pelanggaran --}}
    <div class="flex-1" style="flex:2;">
        <h3>Daftar Jenis Pelanggaran</h3>
        <form method="GET" action="{{ route('pelanggaran.index') }}" style="margin-bottom:10px;">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari nama pelanggaran..." style="padding:5px;">
            <button type="submit" class="btn">Filter</button>
        </form>

        <table class="tbl-center">
            <thead>
                <tr>
                    <th style="width:50px;">No</th>
                    <th class="td-left">Nama Pelanggaran</th>
                    <th>Poin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenisPelanggaran as $i => $jp)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td class="td-left"><strong>{{ $jp->nama }}</strong></td>
                    <td style="color:#cc0000; font-weight:bold;">+{{ $jp->poin }}</td>
                    <td>
                        <a href="{{ route('pelanggaran.jenis.edit', $jp->id) }}" class="btn">Edit</a>
                        <form action="{{ route('pelanggaran.jenis.destroy', $jp->id) }}" method="POST"
                              style="display:inline;"
                              onsubmit="return confirm('Hapus jenis pelanggaran ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center;">Belum ada jenis pelanggaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
