@extends('layouts.app')

@section('title', 'Riwayat Pelanggaran - E-BK')

@section('content')

@php
    // Form catat otomatis terbuka jika ada error validasi
    $showForm = $errors->any() || old('kelas');
@endphp

<div style="display:flex; justify-content:space-between; align-items:center; margin-top:8px;">
    <h2>Riwayat Pelanggaran</h2>
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

            {{-- 1. Pilih Kelas --}}
            <div class="form-group">
                <label>Pilih Kelas</label>
                <select id="kelasSelectInline" name="kelas" required onchange="muatSiswaInline(this.value)">
                    <option value="">-- Pilih Kelas Dulu --</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->nama }}" {{ old('kelas') == $k->nama ? 'selected' : '' }}>
                            Kelas {{ $k->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 2. Pilih Siswa (dinamis) --}}
            <div class="form-group">
                <label>Pilih Siswa</label>
                <select id="siswaSelectInline" name="siswa_id" required disabled>
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
                <select name="urutkan" onchange="this.form.submit()" style="padding:6px;">
                    <option value="terbaru" {{ request('urutkan', 'terbaru') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="terlama" {{ request('urutkan') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                </select>
            </div>
        </div>
        <div class="flex" style="margin-top:8px; align-items:center;">
            <div style="display:flex; align-items:center; gap:6px;">
                <label style="margin:0; white-space:nowrap;">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" style="padding:6px;">
            </div>
            <div style="display:flex; align-items:center; gap:6px;">
                <label style="margin:0; white-space:nowrap;">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" style="padding:6px;">
            </div>
            <div>
                <button type="submit" class="btn">Cari</button>
                <a href="{{ route('pelanggaran.riwayat') }}" class="btn">Reset</a>
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

<script>
const siswaByKelasUrlInline = "{{ route('pelanggaran.siswa-by-kelas') }}";
const oldSiswaIdInline = "{{ old('siswa_id') }}";

function muatSiswaInline(kelas) {
    const select = document.getElementById('siswaSelectInline');
    select.innerHTML = '<option value="">Memuat...</option>';
    select.disabled = true;

    if (!kelas) {
        select.innerHTML = '<option value="">-- Pilih Kelas Dulu --</option>';
        return;
    }

    fetch(siswaByKelasUrlInline + '?kelas=' + encodeURIComponent(kelas))
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
                    if (oldSiswaIdInline && oldSiswaIdInline == s.id) opt.selected = true;
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

// Auto-load siswa jika ada old kelas (setelah validasi gagal)
document.addEventListener('DOMContentLoaded', function () {
    const kelasVal = document.getElementById('kelasSelectInline').value;
    if (kelasVal) muatSiswaInline(kelasVal);
});
</script>

@endsection
