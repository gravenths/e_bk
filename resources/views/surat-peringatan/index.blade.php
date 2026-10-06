@extends('layouts.app')

@section('title', 'Siswa Memenuhi Batas SP - E-BK')

@section('content')
<h2>Siswa Memenuhi Batas Surat Peringatan</h2>
<p style="font-size:13px; color:#666;">Daftar siswa yang telah mencapai ambang batas poin Surat Peringatan (SP).</p>

<div class="card">
    <strong>Ambang Batas Poin SP:</strong>
    <span class="badge badge-sp1">SP 1: ≥ {{ $spLimits->sp1 }} Poin</span> | 
    <span class="badge badge-sp2">SP 2: ≥ {{ $spLimits->sp2 }} Poin</span> | 
    <span class="badge badge-sp3">SP 3: ≥ {{ $spLimits->sp3 }} Poin</span>
</div>

<table>
    <thead>
        <tr>
            <th>NIS</th>
            <th>Nama Siswa</th>
            <th>Kelas</th>
            <th>Total Poin</th>
            <th>Status Kelayakan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($daftarKandidat as $k)
        <tr>
            <td>{{ $k->siswa->nis }}</td>
            <td><a href="{{ route('siswa.show', $k->siswa->id) }}"><strong>{{ $k->siswa->nama }}</strong></a></td>
            <td>{{ $k->siswa->kelas }}</td>
            <td style="color:#cc0000; font-weight:bold;">{{ $k->total_poin }} Poin</td>
            <td>
                @if($k->jenis_sp === 'SP 3') <span class="badge badge-sp3">SP 3</span>
                @elseif($k->jenis_sp === 'SP 2') <span class="badge badge-sp2">SP 2</span>
                @elseif($k->jenis_sp === 'SP 1') <span class="badge badge-sp1">SP 1</span>
                @endif
            </td>
            <td>
                <form action="{{ route('surat-peringatan.store') }}" method="POST" style="display:inline;">
                    @csrf
                    <input type="hidden" name="siswa_id" value="{{ $k->siswa->id }}">
                    <input type="hidden" name="jenis_sp" value="{{ $k->jenis_sp }}">
                    <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
                    <button type="submit" class="btn btn-primary">Terbitkan {{ $k->jenis_sp }}</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;">Tidak ada siswa yang memenuhi batas SP saat ini.</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection
