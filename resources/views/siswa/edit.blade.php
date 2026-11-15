@extends('layouts.app')

@section('title', 'Edit Siswa - E-BK')

@section('content')
<h2>Edit Data Siswa</h2>
<p><a href="{{ route('siswa.show', $siswa->id) }}">&larr; Kembali ke Detail Siswa</a></p>

<div class="card" style="max-width:500px;">
    <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label>Nomor Induk Siswa (NIS)</label>
            <input type="text" name="nis" value="{{ old('nis', $siswa->nis) }}" required>
        </div>

        <div class="form-group">
            <label>Nama Lengkap Siswa</label>
            <input type="text" name="nama" value="{{ old('nama', $siswa->nama) }}" required>
        </div>

        <div class="form-group">
            <label>Kelas</label>
            <select name="kelas" required>
                @foreach($kelases as $k)
                    <option value="{{ $k->nama }}" {{ old('kelas', $siswa->kelas) == $k->nama ? 'selected' : '' }}>Kelas {{ $k->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="jk" required>
                <option value="L" {{ old('jk', $siswa->jk) == 'L' ? 'selected' : '' }}>Laki-Laki (L)</option>
                <option value="P" {{ old('jk', $siswa->jk) == 'P' ? 'selected' : '' }}>Perempuan (P)</option>
            </select>
        </div>

        <div class="form-group">
            <label>Nama Wali <span style="font-weight:normal; color:#888;">(opsional)</span></label>
            <input type="text" name="nama_wali" value="{{ old('nama_wali', $siswa->nama_wali) }}" placeholder="Contoh: Bapak Ahmad">
        </div>

        <div class="form-group">
            <label>No. WhatsApp Wali <span style="font-weight:normal; color:#888;">(opsional)</span></label>
            <input type="text" name="no_wa_wali" value="{{ old('no_wa_wali', $siswa->no_wa_wali) }}" placeholder="Contoh: 08123456789">
        </div>

        <div class="form-group">
            <label>Status Siswa</label>
            <select name="status" required>
                <option value="Aktif" {{ old('status', $siswa->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Nonaktif" {{ old('status', $siswa->status) == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div style="margin-top:15px;">
            <button type="submit" class="btn btn-primary">Perbarui Data</button>
            <a href="{{ route('siswa.show', $siswa->id) }}" class="btn">Batal</a>
        </div>
    </form>
</div>
@endsection
