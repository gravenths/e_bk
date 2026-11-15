@extends('layouts.app')

@section('title', 'List Pelanggaran - E-BK')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-top:8px;">
    <h2>List Pelanggaran</h2>
</div>

<div class="flex" style="margin-top:15px; align-items:flex-start;">

    {{-- Kolom Kiri: Form Tambah + Batas SP --}}
    <div style="display:flex; flex-direction:column; gap:15px; flex:1;">

        {{-- Form Tambah Jenis Pelanggaran --}}
        <div class="card" style="margin-bottom:0;">
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

        {{-- Batas Surat Peringatan --}}
        <div class="card" style="margin-bottom:0;">
            <h3>Batas Poin Surat Peringatan</h3>
            <p style="font-size:13px; color:#666; margin-top:-4px;">Atur threshold poin untuk penerbitan SP 1, SP 2, dan SP 3.</p>
            <form action="{{ route('pengaturan.batas-sp.update') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Ambang Poin SP 1</label>
                    <input type="number" name="sp1" value="{{ old('sp1', $spLimits->sp1) }}" required min="1">
                    <span style="font-size:11px; color:#666;">Siswa mencapai poin ini berhak mendapat SP 1</span>
                </div>
                <div class="form-group">
                    <label>Ambang Poin SP 2</label>
                    <input type="number" name="sp2" value="{{ old('sp2', $spLimits->sp2) }}" required min="1">
                    <span style="font-size:11px; color:#666;">Siswa mencapai poin ini berhak mendapat SP 2</span>
                </div>
                <div class="form-group">
                    <label>Ambang Poin SP 3</label>
                    <input type="number" name="sp3" value="{{ old('sp3', $spLimits->sp3) }}" required min="1">
                    <span style="font-size:11px; color:#666;">Siswa mencapai poin ini berhak mendapat SP 3</span>
                </div>
                <div style="margin-top:15px;">
                    <button type="submit" class="btn btn-primary">Simpan Pengaturan Batas SP</button>
                </div>
            </form>
        </div>

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
