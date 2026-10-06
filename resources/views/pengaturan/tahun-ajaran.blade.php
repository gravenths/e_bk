@extends('layouts.app')

@section('title', 'Pengaturan Tahun Ajaran - E-BK')

@section('content')
<h2>Pengaturan Tahun Ajaran</h2>
<p style="font-size:13px; color:#666;">Kelola data tahun ajaran dan semester aktif sekolah.</p>

<div class="flex" style="margin-top:15px;">
    <!-- Form Tambah -->
    <div class="card flex-1">
        <h3>Tambah Tahun Ajaran Baru</h3>
        <form action="{{ route('pengaturan.tahun-ajaran.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Tahun Ajaran</label>
                <input type="text" name="tahun" required placeholder="Contoh: 2026/2027">
            </div>

            <div class="form-group">
                <label>Semester</label>
                <select name="semester" required>
                    <option value="Ganjil">Ganjil</option>
                    <option value="Genap">Genap</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Tahun Ajaran</button>
        </form>
    </div>

    <!-- Table List -->
    <div class="flex-1" style="flex:2;">
        <h3>Daftar Tahun Ajaran</h3>
        <table>
            <thead>
                <tr>
                    <th>Tahun Ajaran</th>
                    <th>Semester</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tahunList as $t)
                <tr>
                    <td><strong>{{ $t->tahun }}</strong></td>
                    <td>{{ $t->semester }}</td>
                    <td>
                        @if($t->status === 'Aktif')
                            <span class="badge" style="background:#d4edda; color:#155724;">Aktif</span>
                        @else
                            <span class="badge">Nonaktif</span>
                        @endif
                    </td>
                    <td>
                        @if($t->status !== 'Aktif')
                        <form action="{{ route('pengaturan.tahun-ajaran.aktif', $t->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn">Set Aktif</button>
                        </form>
                        @else
                            <span style="font-size:12px; color:#666; font-style:italic;">Sedang Aktif</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center;">Belum ada data tahun ajaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
