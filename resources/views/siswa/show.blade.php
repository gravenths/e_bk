@extends('layouts.app')

@section('title', 'Detail Siswa - ' . $siswa->nama)

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h2>{{ $siswa->nama }}</h2>
        <p style="font-size:13px; color:#666;">NIS: {{ $siswa->nis }} | Kelas: {{ $siswa->kelas }} | JK: {{ $siswa->jk }}</p>
    </div>
    <div>
        <a href="{{ route('pelanggaran.riwayat') }}?siswa_id={{ $siswa->id }}" class="btn-tambah">
            <i class="bi bi-plus-circle-fill"></i> Catat Pelanggaran
        </a>
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
        <tr>
            <td style="border:none; padding:4px 15px 4px 0;"><strong>Nama Wali:</strong></td>
            <td style="border:none; padding:4px 0;">{{ $siswa->nama_wali ?: '-' }}</td>
        </tr>
        <tr>
            <td style="border:none; padding:4px 15px 4px 0;"><strong>No. WhatsApp Wali:</strong></td>
            <td style="border:none; padding:4px 0;">
                @if($siswa->noWaInternasional())
                    <a href="{{ $siswa->waLink('Assalamu\'alaikum Bapak/Ibu ' . $siswa->nama_wali . ', kami dari SMA Negeri 8 Banjarmasin ingin menyampaikan informasi terkait putra/putri Anda, ' . $siswa->nama . ' (Kelas ' . $siswa->kelas . '). Saat ini total poin pelanggaran: ' . $siswa->total_poin . ' poin. Mohon berkenan berkoordinasi dengan Guru BK kami. Terima kasih.') }}"
                       target="_blank" rel="noopener" class="btn btn-success btn-sm">
                        <i class="bi bi-whatsapp"></i> Chat WA ({{ $siswa->no_wa_wali }})
                    </a>
                @else
                    {{ $siswa->no_wa_wali ?: '-' }}
                @endif
            </td>
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
