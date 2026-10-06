@extends('layouts.app')

@section('title', 'Tambah Siswa - E-BK')

@section('content')
<h2>Tambah Siswa Baru</h2>
<p><a href="{{ route('siswa.index') }}">&larr; Kembali ke Daftar Siswa</a></p>

<div class="card" style="max-width:500px;">
    <form action="{{ route('siswa.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Nomor Induk Siswa (NIS)</label>
            <input type="text" name="nis" value="{{ old('nis') }}" required placeholder="Contoh: 10019">
        </div>

        <div class="form-group">
            <label>Nama Lengkap Siswa</label>
            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Nama Siswa">
        </div>

        <div class="form-group">
            <label>Kelas</label>
            <select name="kelas" required>
                <option value="">-- Pilih Kelas --</option>
                @foreach($kelases as $k)
                    <option value="{{ $k->nama }}" {{ old('kelas') == $k->nama ? 'selected' : '' }}>Kelas {{ $k->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jk" required>
                <option value="L" {{ old('jk') == 'L' ? 'selected' : '' }}>Laki-Laki (L)</option>
                <option value="P" {{ old('jk') == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Status Siswa</label>
            <select name="status" required>
                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div style="margin-top:15px;">
            <button type="submit" class="btn btn-primary">Simpan Siswa</button>
            <a href="{{ route('siswa.index') }}" class="btn">Batal</a>
        </div>
    </form>
</div>
@endsection
