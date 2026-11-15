@extends('layouts.app')

@section('title', 'Daftar Siswa - E-BK')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center; margin-top:8px;">
    <div style="display:flex; align-items:center; gap:12px;">
        <h2 style="margin:0;">Daftar Siswa</h2>
        <a href="{{ route('pengaturan.kelas') }}" class="btn btn-secondary" style="font-size:13px; padding:5px 12px;">
            <i class="bi bi-grid-3x3-gap-fill"></i> Lihat Daftar Kelas
        </a>
    </div>
    <a href="{{ route('siswa.create') }}" class="btn-tambah">
        <i class="bi bi-plus-circle-fill"></i> Tambah Siswa Baru
    </a>
</div>

<!-- Filter -->
<div class="card" style="margin-top:15px;">
    <form method="GET" action="{{ route('siswa.index') }}">
        {{-- Baris 1: Kelas (auto-submit) + Status (auto-submit) --}}
        <div class="row g-2 mb-2">
            <div class="col-12 col-md-4">
                <select name="kelas" onchange="this.form.submit()" style="padding:6px; width:100%; font-size:16px; min-height:44px;">
                    <option value="">Semua Kelas</option>
                    @foreach($kelases as $k)
                        <option value="{{ $k->nama }}" {{ request('kelas') == $k->nama ? 'selected' : '' }}>Kelas {{ $k->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3">
                <select name="status" onchange="this.form.submit()" style="padding:6px; width:100%; font-size:16px; min-height:44px;">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-12 col-md-5 d-flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari NIS atau Nama Siswa..." style="padding:6px; width:100%; font-size:16px; min-height:44px;">
                <button type="submit" class="btn" style="white-space:nowrap; min-height:44px;">Cari</button>
            </div>
        </div>
    </form>
</div>

{{-- ===== TABEL (md ke atas) ===== --}}
<div class="d-none d-md-block">
    <div class="table-responsive">
        <table class="tbl-center">
            <thead>
                <tr>
                    <th>NIS</th>
                    <th class="td-left">Nama Siswa</th>
                    <th>Kelas</th>
                    <th>L/P</th>
                    <th>Total Poin</th>
                    <th>Status SP</th>
                    <th>Status</th>
                    <th>Aksi</th>
                    <th>Chat Wali Siswa</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswa as $s)
                @php $sp = $s->status_sp; @endphp
                <tr>
                    <td>{{ $s->nis }}</td>
                    <td class="td-left"><a href="{{ route('siswa.show', $s->id) }}"><strong>{{ $s->nama }}</strong></a></td>
                    <td>{{ $s->kelas }}</td>
                    <td>{{ $s->jk }}</td>
                    <td style="color:#cc0000; font-weight:bold;">{{ $s->total_poin }} Poin</td>
                    <td>
                        @if($sp === 'SP 3') <span class="badge badge-sp3">SP 3</span>
                        @elseif($sp === 'SP 2') <span class="badge badge-sp2">SP 2</span>
                        @elseif($sp === 'SP 1') <span class="badge badge-sp1">SP 1</span>
                        @else Belum @endif
                    </td>
                    <td>{{ $s->status }}</td>
                    <td>
                        <a href="{{ route('siswa.show', $s->id) }}" class="btn">Detail</a>
                        <a href="{{ route('siswa.edit', $s->id) }}" class="btn">Edit</a>
                        <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus data siswa ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                    <td>
                        @php
                            $pesanIndex = 'Assalamu\'alaikum Bapak/Ibu ' . ($s->nama_wali ?: 'Wali') . ', kami dari SMA Negeri 8 Banjarmasin ingin menyampaikan informasi terkait putra/putri Anda, ' . $s->nama . ' (Kelas ' . $s->kelas . '). Saat ini total poin pelanggaran tercatat: ' . $s->total_poin . ' poin. Mohon berkenan berkoordinasi dengan Guru BK kami untuk penanganan lebih lanjut. Terima kasih.';
                        @endphp
                        @if($s->noWaInternasional())
                            <a href="{{ $s->waLink($pesanIndex) }}" target="_blank" rel="noopener" class="btn btn-success btn-sm">
                                <i class="bi bi-whatsapp"></i> Chat WA
                            </a>
                        @else
                            <button class="btn btn-secondary btn-sm" disabled title="Nomor wali belum diisi">
                                <i class="bi bi-whatsapp"></i> Chat WA
                            </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9">Tidak ada data siswa ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ===== KARTU MOBILE (di bawah md) ===== --}}
<div class="d-md-none" style="margin-top:10px;">
    @forelse($siswa as $s)
    @php $sp = $s->status_sp; @endphp
    <div class="siswa-card-mobile">
        <div class="siswa-nama">
            <a href="{{ route('siswa.show', $s->id) }}" style="color:inherit; text-decoration:none;">{{ $s->nama }}</a>
        </div>
        <div class="siswa-meta">
            NIS: {{ $s->nis }} &nbsp;|&nbsp; Kelas {{ $s->kelas }} &nbsp;|&nbsp; {{ $s->jk }}
        </div>
        <div style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">
            <span class="siswa-poin">{{ $s->total_poin }} Poin</span>
            @if($sp === 'SP 3') <span class="badge badge-sp3">SP 3</span>
            @elseif($sp === 'SP 2') <span class="badge badge-sp2">SP 2</span>
            @elseif($sp === 'SP 1') <span class="badge badge-sp1">SP 1</span>
            @else <span style="font-size:.85rem; color:#888;">Belum SP</span>
            @endif
            <span style="font-size:.82rem; color:#666;">{{ $s->status }}</span>
        </div>
        <div class="aksi-baris">
            {{-- Tombol Catat Pelanggaran --}}
            <a href="{{ route('pelanggaran.tambah') }}?kelas={{ urlencode($s->kelas) }}&siswa_id={{ $s->id }}"
               class="btn btn-danger" style="flex:1; min-width:90px;">
                <i class="bi bi-plus-circle-fill"></i> Catat
            </a>
            {{-- Detail --}}
            <a href="{{ route('siswa.show', $s->id) }}" class="btn btn-primary btn-sm">
                <i class="bi bi-person-lines-fill"></i> Detail
            </a>
            {{-- Chat WA --}}
            @php
                $pesanMobile = 'Assalamu\'alaikum Bapak/Ibu ' . ($s->nama_wali ?: 'Wali') . ', kami dari SMA Negeri 8 Banjarmasin ingin menyampaikan informasi terkait putra/putri Anda, ' . $s->nama . ' (Kelas ' . $s->kelas . '). Total poin pelanggaran: ' . $s->total_poin . ' poin. Mohon berkoordinasi dengan Guru BK kami. Terima kasih.';
            @endphp
            @if($s->noWaInternasional())
                <a href="{{ $s->waLink($pesanMobile) }}" target="_blank" rel="noopener" class="btn btn-success btn-sm">
                    <i class="bi bi-whatsapp"></i>
                </a>
            @else
                <button class="btn btn-secondary btn-sm" disabled title="Nomor wali belum diisi">
                    <i class="bi bi-whatsapp"></i>
                </button>
            @endif
            {{-- Dropdown Edit & Hapus --}}
            <div class="dropdown">
                <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="min-height:44px;">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('siswa.edit', $s->id) }}"><i class="bi bi-pencil"></i> Edit</a></li>
                    <li>
                        <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Hapus data siswa ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-trash"></i> Hapus</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @empty
    <p class="text-muted text-center mt-3">Tidak ada data siswa ditemukan.</p>
    @endforelse
</div>

@if($siswa->hasPages())
    <div class="mt-2">{{ $siswa->links() }}</div>
@endif

@endsection
