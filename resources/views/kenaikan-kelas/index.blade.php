@extends('layouts.app')

@section('title', 'Kenaikan Kelas Masal - E-BK')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center;">
    <h2>Proses Kenaikan Kelas Masal</h2>
    <form action="{{ route('kenaikan-kelas.proses') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memproses kenaikan kelas masal untuk seluruh siswa aktif?')">
        @csrf
        <button type="submit" class="btn btn-success">Proses Kenaikan Kelas Masal Sekarang</button>
    </form>
</div>

<div class="card" style="margin-top:15px; background:#eef6ff; border-color:#b8daff;">
    <strong>Ketentuan Kenaikan Kelas:</strong>
    <ul style="margin:5px 0 0 20px; padding:0; font-size:13px;">
        <li>Siswa Kelas 10-X akan naik ke Kelas 11-X</li>
        <li>Siswa Kelas 11-X akan naik ke Kelas 12-X</li>
        <li>Siswa Kelas 12-X akan dinyatakan Lulus / Nonaktif</li>
    </ul>
</div>

<h3>Pratinjau Kenaikan Kelas ({{ $preview->count() }} Siswa)</h3>
<table>
    <thead>
        <tr>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Kelas Saat Ini</th>
            <th>Hasil Kenaikan Kelas</th>
            <th>Status Baru</th>
        </tr>
    </thead>
    <tbody>
        @forelse($preview as $p)
        <tr>
            <td>{{ $p->nis }}</td>
            <td><strong>{{ $p->nama }}</strong></td>
            <td>Kelas {{ $p->kelas_lama }}</td>
            <td><strong>{{ $p->kelas_baru }}</strong></td>
            <td>{{ $p->status_baru }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center;">Tidak ada siswa aktif untuk diproses.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
