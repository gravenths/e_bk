@extends('layouts.app')

@section('title', 'Catat Pelanggaran - E-BK')

@section('content')
<h2>Catat Pelanggaran Siswa Baru</h2>
<p><a href="{{ route('pelanggaran.riwayat') }}">&larr; Kembali ke Riwayat Pelanggaran</a></p>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card card-form-tambah" style="max-width:550px;">
    <form action="{{ route('pelanggaran.riwayat.store') }}" method="POST">
        @csrf
        <input type="hidden" name="redirect_tambah" value="0">

        {{-- 1. Pilih Kelas --}}
        <div class="form-group">
            <label>Pilih Kelas</label>
            <select id="kelasSelect" name="kelas" required onchange="muatSiswa(this.value)">
                <option value="">-- Pilih Kelas Dulu --</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->nama }}"
                        {{ (old('kelas', $initKelas) == $k->nama) ? 'selected' : '' }}>
                        Kelas {{ $k->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 2. Pilih Siswa (dinamis) --}}
        <div class="form-group">
            <label>Pilih Siswa</label>
            <select id="siswaSelect" name="siswa_id" required disabled>
                <option value="">-- Pilih Kelas Dulu --</option>
            </select>
        </div>

        {{-- 3. Jenis Pelanggaran --}}
        <div class="form-group">
            <label style="display:flex; justify-content:space-between; align-items:center;">
                <span>Jenis Pelanggaran</span>
                <a href="{{ route('pelanggaran.index') }}" target="_blank"
                   style="font-size:0.78rem; font-weight:normal; white-space:nowrap;"
                   title="Buka halaman tambah jenis pelanggaran di tab baru">
                    <i class="bi bi-plus-circle"></i> Tambah Jenis
                </a>
            </label>
            <select name="pelanggaran_id" required>
                <option value="">-- Pilih Pelanggaran --</option>
                @foreach($jenisList as $j)
                    <option value="{{ $j->id }}" {{ old('pelanggaran_id') == $j->id ? 'selected' : '' }}>
                        {{ $j->nama }} (+{{ $j->poin }} Poin)
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 4. Tanggal --}}
        <div class="form-group">
            <label>Tanggal Kejadian</label>
            <input type="date" name="tanggal" value="{{ old('tanggal', $initTanggal ?? date('Y-m-d')) }}" required>
        </div>

        {{-- 5. Keterangan --}}
        <div class="form-group">
            <label>Keterangan Tambahan (Opsional)</label>
            <textarea name="keterangan" rows="3" placeholder="Catatan detail...">{{ old('keterangan') }}</textarea>
        </div>

        {{-- Tombol aksi --}}
        <div style="margin-top:15px; display:flex; gap:8px; flex-wrap:wrap;">
            <button type="submit" name="redirect_tambah" value="0"
                    class="btn btn-danger" style="flex:1; min-width:140px;">
                <i class="bi bi-check-circle-fill"></i> Simpan Pelanggaran
            </button>
            <button type="submit" name="redirect_tambah" value="1"
                    class="btn btn-warning" style="flex:1; min-width:140px;">
                <i class="bi bi-arrow-repeat"></i> Simpan & Catat Lagi
            </button>
            <a href="{{ route('pelanggaran.riwayat') }}" class="btn" style="min-width:80px;">Batal</a>
        </div>
    </form>
</div>

<script>
const siswaByKelasUrl = "{{ route('pelanggaran.siswa-by-kelas') }}";
const oldSiswaId      = "{{ old('siswa_id', $initSiswaId ?? '') }}";
const initKelas       = "{{ $initKelas ?? '' }}";

function muatSiswa(kelas, targetSiswaId) {
    const select = document.getElementById('siswaSelect');
    select.innerHTML = '<option value="">Memuat...</option>';
    select.disabled = true;

    if (!kelas) {
        select.innerHTML = '<option value="">-- Pilih Kelas Dulu --</option>';
        return;
    }

    const resolvedId = targetSiswaId !== undefined ? targetSiswaId : oldSiswaId;

    fetch(siswaByKelasUrl + '?kelas=' + encodeURIComponent(kelas))
        .then(r => r.json())
        .then(data => {
            if (data.length === 0) {
                select.innerHTML = '<option value="">Tidak ada siswa di kelas ini</option>';
            } else {
                select.innerHTML = '<option value="">-- Pilih Siswa --</option>';
                data.forEach(s => {
                    const opt = document.createElement('option');
                    opt.value = s.id;
                    opt.textContent = s.nama + ' (NIS: ' + s.nis + ')';
                    if (resolvedId && resolvedId == s.id) opt.selected = true;
                    select.appendChild(opt);
                });
            }
            select.disabled = false;
        })
        .catch(() => {
            select.innerHTML = '<option value="">Gagal memuat siswa</option>';
            select.disabled = false;
        });
}

document.addEventListener('DOMContentLoaded', function () {
    const kelasVal = document.getElementById('kelasSelect').value;
    if (kelasVal) muatSiswa(kelasVal);
});
</script>
@endsection
