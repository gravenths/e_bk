@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $siswa->nama)

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h2>{{ $siswa->nama }}</h2>
        <p style="font-size:13px; color:#666;">NIS: {{ $siswa->nis }} | Kelas: {{ $siswa->kelas }} | JK: {{ $siswa->jk }}</p>
    </div>
    <div>
        <a href="{{ route('pelanggaran.tambah') }}?siswa_id={{ $siswa->id }}" class="btn btn-danger">+ Catat Pelanggaran</a>
        <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn">Edit Siswa</a>
        <a href="{{ route('siswa.index') }}" class="btn">&larr; Kembali</a>
    </div>
</div>

<!-- Profile Info Box -->
<div class="card" style="margin-top:15px;">
    <table style="width:auto; border:none; margin:0;">
        <tr>
            <td style="border:none; padding:4px 15px 4px 0;"><strong>Total Akumulasi Poin:</strong></td>
            <td style="border:none; padding:4px 0;"><span style="color:#cc0000; font-weight:bold; font-size:16px;">{{ $siswa->total_poin }} Poin</span></td>
        </tr>
        <tr>
            <td style="border:none; padding:4px 15px 4px 0;"><strong>Status Surat Peringatan:</strong></td>
            <td style="border:none; padding:4px 0;">
                @php $sp = $siswa->status_sp; @endphp
                @if($sp === 'SP 3') <span class="badge badge-sp3">SP 3</span>
                @elseif($sp === 'SP 2') <span class="badge badge-sp2">SP 2</span>
                @elseif($sp === 'SP 1') <span class="badge badge-sp1">SP 1</span>
                @else Belum @endif
            </td>
        </tr>
        <tr>
            <td style="border:none; padding:4px 15px 4px 0;"><strong>Status Keaktifan:</strong></td>
            <td style="border:none; padding:4px 0;">{{ $siswa->status }}</td>
        </tr>
    </table>
</div>

<!-- Catatan Pelanggaran Siswa -->
<h3>Riwayat Catatan Pelanggaran Siswa</h3>
<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jenis Pelanggaran</th>
            <th>Poin</th>
            <th>Keterangan</th>
            <th>Pencatat</th>
        </tr>
    </thead>
    <tbody>
        @forelse($siswa->riwayatPelanggaran->sortByDesc('tanggal') as $r)
        <tr>
            <td>{{ $r->tanggal->format('d/m/Y') }}</td>
            <td><strong>{{ $r->jenisPelanggaran->nama ?? '-' }}</strong></td>
            <td style="color:#cc0000; font-weight:bold;">+{{ $r->jenisPelanggaran->poin ?? 0 }}</td>
            <td>{{ $r->keterangan ?? '-' }}</td>
            <td>{{ $r->pencatat }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="text-align:center;">Siswa ini belum memiliki catatan pelanggaran.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<!-- Surat Peringatan Diterbitkan -->
@if($siswa->suratPeringatan->count() > 0)
<h3>Daftar Surat Peringatan Diterbitkan</h3>
<table>
    <thead>
        <tr>
            <th>Nomor Surat</th>
            <th>Tanggal Terbit</th>
            <th>Jenis SP</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($siswa->suratPeringatan->sortByDesc('tanggal') as $spItem)
        <tr>
            <td>{{ $spItem->nomor_surat }}</td>
            <td>{{ $spItem->tanggal->format('d/m/Y') }}</td>
            <td><strong>{{ $spItem->jenis_sp }}</strong></td>
            <td>
                <a href="{{ route('surat-peringatan.cetak', $spItem->id) }}" target="_blank" class="btn">Cetak Surat</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection
