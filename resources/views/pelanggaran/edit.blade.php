@extends('layouts.app')

@section('title', 'Edit Jenis Pelanggaran - E-BK')

@section('content')
<h2>Edit Jenis Pelanggaran</h2>
<p><a href="{{ route('pelanggaran.index') }}">&larr; Kembali ke Master Pelanggaran</a></p>

<div class="card" style="max-width:500px;">
    <form action="{{ route('pelanggaran.jenis.update', $jp->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Pelanggaran</label>
            <input type="text" name="nama" value="{{ old('nama', $jp->nama) }}" required placeholder="Contoh: Merokok di sekolah">
        </div>

        <div class="form-group">
            <label>Bobot Poin</label>
            <input type="number" name="poin" value="{{ old('poin', $jp->poin) }}" required min="1" placeholder="Poin">
        </div>

        <div style="margin-top:15px;">
            <button type="submit" class="btn btn-primary">Perbarui Pelanggaran</button>
            <a href="{{ route('pelanggaran.index') }}" class="btn">Batal</a>
        </div>
    </form>
</div>
@endsection
