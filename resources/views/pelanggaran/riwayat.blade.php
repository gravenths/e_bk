@extends('layouts.app')

@section('title', 'Pelanggaran Siswa - E-BK')

@section('content')

@php
    // Form catat otomatis terbuka jika ada error validasi atau siswa_id di URL
    $showForm = $errors->any() || request('siswa_id') || old('siswa_id');
@endphp

<div style="display:flex; justify-content:space-between; align-items:center; margin-top:8px;">
    <h2>Pelanggaran Siswa</h2>
    <button class="btn-tambah" type="button"
            data-bs-toggle="collapse" data-bs-target="#formCatat" aria-expanded="{{ $showForm ? 'true' : 'false' }}">
        <i class="bi bi-plus-circle-fill"></i> Catat Pelanggaran Baru
    </button>
</div>

{{-- ======= FORM CATAT PELANGGARAN (collapsible) ======= --}}
<div class="collapse {{ $showForm ? 'show' : '' }}" id="formCatat">
    <div class="card" style="margin-top:15px; max-width:560px;">
        <h3 style="margin-top:0;">Catat Pelanggaran Baru</h3>
        <form action="{{ route('pelanggaran.riwayat.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Pilih Siswa</label>
                <select name="siswa_id" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswaList as $s)
                        <option value="{{ $s->id }}"
                            {{ (old('siswa_id', request('siswa_id')) == $s->id) ? 'selected' : '' }}>
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
                        <option value="{{ $j->id }}" {{ old('pelanggaran_id') == $j->id ? 'selected' : '' }}>
                            {{ $j->nama }} (+{{ $j->poin }} Poin)
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Tanggal Kejadian</label>
                <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
            </div>

            <div class="form-group">
                <label>Keterangan Tambahan (Opsional)</label>
                <textarea name="keterangan" rows="3"
                          placeholder="Catatan detail...">{{ old('keterangan') }}</textarea>
            </div>

            <div style="display:flex; gap:8px; margin-top:15px;">
                <button type="submit" class="btn-tambah">
                    <i class="bi bi-check-circle-fill"></i> Simpan Pelanggaran
                </button>
                <button type="button" class="btn"
                        data-bs-toggle="collapse" data-bs-target="#formCatat">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ======= FILTER ======= --}}
<div class="card" style="margin-top:15px;">
    <form method="GET" action="{{ route('pelanggaran.riwayat') }}">
        <div class="flex">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari nama siswa atau NIS..." style="padding:6px; width:100%;">
            </div>
            <div>
                <select name="kelas" onchange="this.form.submit()" style="padding:6px;">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->nama }}" {{ request('kelas') == $k->nama ? 'selected' : '' }}>
                            Kelas {{ $k->nama }}
                        </option>
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

{{-- ======= TABEL RIWAYAT ======= --}}
<table class="tbl-center">
    <thead>
        <tr>
            <th>Tanggal</th>
            <th class="td-left">Nama Siswa</th>
            <th>Kelas</th>
            <th class="td-left">Pelanggaran</th>
            <th>Poin</th>
            <th class="td-left">Keterangan</th>
            <th>Pencatat</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($riwayat as $r)
        <tr>
            <td>{{ $r->tanggal->format('d/m/Y') }}</td>
            <td class="td-left">
                <a href="{{ route('siswa.show', $r->siswa_id) }}">
                    <strong>{{ $r->siswa->nama ?? '-' }}</strong>
                </a>
            </td>
            <td>{{ $r->siswa->kelas ?? '-' }}</td>
            <td class="td-left">{{ $r->jenisPelanggaran->nama ?? '-' }}</td>
            <td style="color:#cc0000; font-weight:bold;">+{{ $r->jenisPelanggaran->poin ?? 0 }}</td>
            <td class="td-left">{{ $r->keterangan ?? '-' }}</td>
            <td>{{ $r->pencatat }}</td>
            <td>
                <form action="{{ route('pelanggaran.riwayat.destroy', $r->id) }}" method="POST"
                      style="display:inline;"
                      onsubmit="return confirm('Hapus riwayat pelanggaran ini?')">
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
    {{ $riwayat->links() }}
@endif

@endsection
