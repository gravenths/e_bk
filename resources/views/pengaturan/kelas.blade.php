@extends('layouts.app')

@section('title', 'Data Kelas - E-BK')

@section('content')
<h2>Data Kelas</h2>
<p style="font-size:13px; color:#666;">Kelola data kelas dan tingkat pendidikan.</p>

<div class="flex" style="margin-top:15px;">
    <!-- Form Tambah -->
    <div class="card flex-1">
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
    <div class="flex-1" style="flex:2;">
        <h3>Daftar Kelas</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Kelas</th>
                    <th>Tingkat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelases as $k)
                <tr>
                    <td><strong>Kelas {{ $k->nama }}</strong></td>
                    <td>Tingkat {{ $k->tingkat }}</td>
                    <td>{{ $k->status }}</td>
                    <td>
                        <form action="{{ route('pengaturan.kelas.update', $k->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="nama" value="{{ $k->nama }}">
                            <input type="hidden" name="tingkat" value="{{ $k->tingkat }}">
                            <input type="hidden" name="status" value="{{ $k->status === 'Aktif' ? 'Nonaktif' : 'Aktif' }}">
                            <button type="submit" class="btn">Toggle Status ({{ $k->status === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }})</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center;">Belum ada data kelas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
