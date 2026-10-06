@extends('layouts.app')

@section('title', 'Catat Pelanggaran - E-BK')

@section('content')
<h2>Catat Pelanggaran Siswa Baru</h2>
<p><a href="{{ route('pelanggaran.riwayat') }}">&larr; Kembali ke Riwayat Pelanggaran</a></p>

<div class="card" style="max-width:550px;">
    <form action="{{ route('pelanggaran.riwayat.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Pilih Siswa</label>
            <select name="siswa_id" required>
                <option value="">-- Pilih Siswa --</option>
                @foreach($siswaList as $s)
                    <option value="{{ $s->id }}" {{ request('siswa_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->nama }} (NIS: {{ $s->nis }} - Kelas {{ $s->kelas }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Jenis Pelanggaran</label>
            <select name="pelanggaran_id" required>
                <option value="">-- Pilih Pelanggaran --</option>
                @foreach($jenisList as $j)
                    <option value="{{ $j->id }}">
                        {{ $j->nama }} (+{{ $j->poin }} Poin)
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Tanggal Kejadian</label>
            <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label>Keterangan Tambahan (Opsional)</label>
            <textarea name="keterangan" rows="3" placeholder="Catatan detail..."></textarea>
        </div>

        <div style="margin-top:15px;">
            <button type="submit" class="btn btn-danger">Simpan Pelanggaran</button>
            <a href="{{ route('pelanggaran.riwayat') }}" class="btn">Batal</a>
        </div>
    </form>
</div>
@endsection
