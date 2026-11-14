@extends('layouts.app')

@section('title', 'Data Kelas - E-BK')

@section('content')
<div style="display:flex; align-items:center; gap:12px; margin-bottom:4px;">
    <a href="{{ route('siswa.index') }}" class="btn" title="Kembali ke halaman Data Siswa">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <h2 style="margin:0;">Data Kelas</h2>
</div>
<p style="font-size:13px; color:#666;">Kelola data kelas dan tingkat pendidikan.</p>

<div class="flex" style="margin-top:15px; align-items:flex-start; gap:20px;">
    <!-- Form Tambah (diperkecil: ~1/4 dari lebar total, sekitar setengah dari lebar awal) -->
    <div class="card" style="flex:0 0 auto; width:280px; min-width:220px;">
        <h3>Tambah Kelas Baru</h3>
        <form action="{{ route('pengaturan.kelas.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Kelas (Contoh: 10-1)</label>
                <input type="text" name="nama" required placeholder="Contoh: 10-1">
            </div>

            <div class="form-group">
                <label>Tingkat</label>
                <select name="tingkat" required>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Kelas</button>
        </form>
    </div>

    <!-- Table List -->
    <div style="flex:1; min-width:0;">
        <h3>Daftar Kelas</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Kelas</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelases as $k)
                {{-- Baris nama kelas --}}
                <tr>
                    <td>
                        <button
                            type="button"
                            class="btn-kelas-toggle"
                            onclick="toggleSiswa('kelas-{{ $loop->index }}')"
                            title="Lihat siswa di kelas ini"
                            aria-expanded="false"
                        >
                            <i class="bi bi-chevron-right toggle-icon" id="icon-kelas-{{ $loop->index }}"></i>
                        </button>
                        <strong>Kelas {{ $k->nama }}</strong>
                    </td>
                    <td>{{ $k->status }}</td>
                    <td style="white-space:nowrap;">
                        <form action="{{ route('pengaturan.kelas.update', $k->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="nama" value="{{ $k->nama }}">
                            <input type="hidden" name="tingkat" value="{{ $k->tingkat }}">
                            <input type="hidden" name="status" value="{{ $k->status === 'Aktif' ? 'Nonaktif' : 'Aktif' }}">
                            <button type="submit" class="btn">{{ $k->status === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}</button>
                        </form>
                        <a href="{{ route('pengaturan.kelas.export', $k->id) }}" class="btn" title="Export / cetak laporan data siswa kelas ini">
                            <i class="bi bi-file-earmark-spreadsheet"></i> Export
                        </a>
                    </td>
                </tr>
                {{-- Baris daftar siswa (tersembunyi, muncul saat dropdown ditekan) --}}
                <tr id="kelas-{{ $loop->index }}" class="kelas-siswa-row" style="display:none;">
                    <td colspan="3" style="padding:0; background:#f7f9ff; border-top:none;">
                        @if($k->siswa->isEmpty())
                            <p style="margin:10px 16px; font-size:13px; color:#888;">Belum ada siswa di kelas ini.</p>
                        @else
                            <table style="margin:0; font-size:13px; border:none; width:100%;">
                                <thead>
                                    <tr style="background:#eef1fb;">
                                        <th style="width:40px; text-align:center;">No</th>
                                        <th style="width:110px; text-align:center;">NIS</th>
                                        <th style="text-align:left;">Nama Siswa</th>
                                        <th style="width:50px; text-align:center;">L/P</th>
                                        <th style="width:90px; text-align:center;">Total Poin</th>
                                        <th style="width:80px; text-align:center;">Status SP</th>
                                        <th style="width:80px; text-align:center;">Status</th>
                                        <th style="width:150px; text-align:center;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($k->siswa as $i => $s)
                                    @php $sp = $s->status_sp; @endphp
                                    <tr>
                                        <td style="text-align:center;">{{ $i + 1 }}</td>
                                        <td style="text-align:center;">{{ $s->nis }}</td>
                                        <td style="text-align:left;">
                                            <a href="{{ route('siswa.show', $s->id) }}"><strong>{{ $s->nama }}</strong></a>
                                        </td>
                                        <td style="text-align:center;">{{ $s->jk }}</td>
                                        <td style="text-align:center; color:#cc0000; font-weight:bold;">{{ $s->total_poin }} Poin</td>
                                        <td style="text-align:center;">
                                            @if($sp === 'SP 3') <span class="badge badge-sp3">SP 3</span>
                                            @elseif($sp === 'SP 2') <span class="badge badge-sp2">SP 2</span>
                                            @elseif($sp === 'SP 1') <span class="badge badge-sp1">SP 1</span>
                                            @else <span style="color:#888;">Belum</span>
                                            @endif
                                        </td>
                                        <td style="text-align:center;">{{ $s->status }}</td>
                                        <td style="text-align:center; white-space:nowrap;">
                                            <a href="{{ route('siswa.show', $s->id) }}" class="btn">Detail</a>
                                            <a href="{{ route('siswa.edit', $s->id) }}" class="btn">Edit</a>
                                            <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data siswa ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align:center;">Belum ada data kelas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
function toggleSiswa(id) {
    var row = document.getElementById(id);
    var index = id.replace('kelas-', '');
    var icon = document.getElementById('icon-kelas-' + index);
    var btn = icon ? icon.closest('button') : null;

    if (row.style.display === 'none') {
        row.style.display = '';
        icon && icon.classList.replace('bi-chevron-right', 'bi-chevron-down');
        btn && btn.setAttribute('aria-expanded', 'true');
    } else {
        row.style.display = 'none';
        icon && icon.classList.replace('bi-chevron-down', 'bi-chevron-right');
        btn && btn.setAttribute('aria-expanded', 'false');
    }
}
</script>
@endpush

@push('styles')
<style>
.btn-kelas-toggle {
    background: none;
    border: 1px solid #bbb;
    border-radius: 3px;
    padding: 1px 5px;
    cursor: pointer;
    color: #1a2f6e;
    font-size: 12px;
    line-height: 1;
    margin-right: 6px;
    vertical-align: middle;
    transition: background .15s;
}
.btn-kelas-toggle:hover {
    background: #dde5f4;
    border-color: #1a2f6e;
}
.toggle-icon {
    display: inline-block;
    transition: transform .15s;
}
</style>
@endpush

@endsection
