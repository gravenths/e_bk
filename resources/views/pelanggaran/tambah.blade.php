@extends('layouts.app')

@section('title', 'Catat Pelanggaran - E-BK')

@section('content')
<h2>Catat Pelanggaran Siswa Baru</h2>
<p><a href="{{ route('pelanggaran.riwayat') }}">&larr; Kembali ke Riwayat Pelanggaran</a></p>

<div class="card" style="max-width:550px;">
    <form action="{{ route('pelanggaran.riwayat.store') }}" method="POST">
        @csrf

        {{-- 1. Pilih Kelas --}}
        <div class="form-group">
            <label>Pilih Kelas</label>
            <select id="kelasSelect" name="kelas" required onchange="muatSiswa(this.value)">
                <option value="">-- Pilih Kelas Dulu --</option>
                @foreach($kelasList as $k)
                    <option value="{{ $k->nama }}" {{ old('kelas') == $k->nama ? 'selected' : '' }}>
                        Kelas {{ $k->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- 2. Pilih Siswa (dinamis berdasarkan kelas) --}}
        <div class="form-group">
            <label>Pilih Siswa</label>
            <select id="siswaSelect" name="siswa_id" required disabled>
                <option value="">-- Pilih Kelas Dulu --</option>
            </select>
        </div>

        {{-- 3. Jenis Pelanggaran + link cepat --}}
        <div class="form-group">
            <label style="display:flex; justify-content:space-between; align-items:center;">
                <span>Jenis Pelanggaran</span>
                <a href="{{ route('pelanggaran.index') }}" target="_blank"
                   style="font-size:0.78rem; font-weight:normal; white-space:nowrap;"
                   title="Buka halaman tambah jenis pelanggaran di tab baru">
                    <i class="bi bi-plus-circle"></i> Tambah Jenis Pelanggaran
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
            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required>
        </div>

        {{-- 5. Keterangan --}}
        <div class="form-group">
            <label>Keterangan Tambahan (Opsional)</label>
            <textarea name="keterangan" rows="3" placeholder="Catatan detail...">{{ old('keterangan') }}</textarea>
        </div>

        <div style="margin-top:15px;">
            <button type="submit" class="btn btn-danger">Simpan Pelanggaran</button>
            <a href="{{ route('pelanggaran.riwayat') }}" class="btn">Batal</a>
        </div>
    </form>
</div>

<script>
const siswaByKelasUrl = "{{ route('pelanggaran.siswa-by-kelas') }}";
const oldSiswaId = "{{ old('siswa_id') }}";

function muatSiswa(kelas) {
    const select = document.getElementById('siswaSelect');
    select.innerHTML = '<option value="">Memuat...</option>';
    select.disabled = true;

    if (!kelas) {
        select.innerHTML = '<option value="">-- Pilih Kelas Dulu --</option>';
        return;
    }

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
                    if (oldSiswaId && oldSiswaId == s.id) opt.selected = true;
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

// Auto-load siswa jika ada old kelas (misal setelah validasi gagal)
document.addEventListener('DOMContentLoaded', function () {
    const kelasVal = document.getElementById('kelasSelect').value;
    if (kelasVal) muatSiswa(kelasVal);
});
</script>
@endsection
