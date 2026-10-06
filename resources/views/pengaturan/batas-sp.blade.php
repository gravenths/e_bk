@extends('layouts.app')

@section('title', 'Batas Surat Peringatan - E-BK')

@section('content')
<h2>Batas Surat Peringatan</h2>
<p style="font-size:13px; color:#666;">Atur threshold poin untuk penerbitan SP 1, SP 2, dan SP 3.</p>

<div class="card" style="max-width:450px;">
    <form action="{{ route('pengaturan.batas-sp.update') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Ambang Poin SP 1 (Surat Peringatan 1)</label>
            <input type="number" name="sp1" value="{{ old('sp1', $spLimits->sp1) }}" required min="1">
            <span style="font-size:11px; color:#666;">Siswa mencapai poin ini berhak mendapat SP 1</span>
        </div>

        <div class="form-group">
            <label>Ambang Poin SP 2 (Surat Peringatan 2)</label>
            <input type="number" name="sp2" value="{{ old('sp2', $spLimits->sp2) }}" required min="1">
            <span style="font-size:11px; color:#666;">Siswa mencapai poin ini berhak mendapat SP 2</span>
        </div>

        <div class="form-group">
            <label>Ambang Poin SP 3 (Surat Peringatan 3)</label>
            <input type="number" name="sp3" value="{{ old('sp3', $spLimits->sp3) }}" required min="1">
            <span style="font-size:11px; color:#666;">Siswa mencapai poin ini berhak mendapat SP 3</span>
        </div>

        <div style="margin-top:15px;">
            <button type="submit" class="btn btn-primary">Simpan Pengaturan Batas SP</button>
        </div>
    </form>
</div>
@endsection
