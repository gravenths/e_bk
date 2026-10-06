<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak {{ $surat->jenis_sp }} - {{ $surat->siswa->nama ?? 'Siswa' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Open Sans', sans-serif; background: #fff; color: #000; margin: 0; padding: 20px; }
        .document { max-width: 800px; margin: 0 auto; border: 1px solid #000; padding: 30px; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop h2 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .kop h1 { margin: 5px 0; font-size: 20px; text-transform: uppercase; }
        .kop p { margin: 0; font-size: 13px; font-family: 'Open Sans', sans-serif; }
        .title { text-align: center; margin-bottom: 20px; }
        .title h3 { margin: 0; text-decoration: underline; font-size: 16px; }
        .title p { margin: 2px 0 0 0; font-size: 13px; font-family: 'Open Sans', sans-serif; }
        .content { font-family: 'Open Sans', sans-serif; font-size: 14px; line-height: 1.6; }
        .info-table { margin: 15px 0; width: 100%; border-collapse: collapse; font-size: 14px; font-family: 'Open Sans', sans-serif; }
        .info-table td { border: none; padding: 3px 0; }
        table.data { width: 100%; border-collapse: collapse; margin: 15px 0; font-family: 'Open Sans', sans-serif; }
        table.data th, table.data td { border: 1px solid #000; padding: 6px 8px; font-size: 13px; text-align: left; }
        table.data th { background: #eee; }
        .signatures { margin-top: 40px; display: flex; justify-content: space-between; font-family: 'Open Sans', sans-serif; font-size: 14px; text-align: center; }
        .sig-box { width: 45%; }
        .no-print { margin-bottom: 20px; text-align: right; }
        .btn { padding: 6px 12px; background: #0066cc; color: #fff; border: none; cursor: pointer; text-decoration: none; font-size: 13px; font-family: 'Open Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
            .document { border: none; padding: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <a href="{{ route('surat-peringatan.riwayat') }}" class="btn" style="background:#666;">&larr; Kembali</a>
        <button onclick="window.print()" class="btn">Cetak Dokumen / Simpan PDF</button>
    </div>

    <div class="document">
        <div class="kop">
            <h2>PEMERINTAH PROVINSI / DAERAH</h2>
            <h1>SMA / SMK NEGERI E-BK DEMO</h1>
            <p>Jl. Pendidikan No. 1, Telp: (021) 1234567, Website: www.sekolah.sch.id</p>
        </div>

        <div class="title">
            <h3>SURAT PERINGATAN ({{ $surat->jenis_sp }})</h3>
            <p>Nomor: {{ $surat->nomor_surat }}</p>
        </div>

        <div class="content">
            <p>Yang bertanda tangan di bawah ini, Tim Bimbingan Konseling menerbitkan <strong>Surat Peringatan {{ $surat->jenis_sp }}</strong> kepada siswa berikut:</p>

            <table class="info-table">
                <tr><td style="width:150px;"><strong>Nama Siswa</strong></td><td>: {{ $surat->siswa->nama ?? '-' }}</td></tr>
                <tr><td><strong>NIS</strong></td><td>: {{ $surat->siswa->nis ?? '-' }}</td></tr>
                <tr><td><strong>Kelas</strong></td><td>: {{ $surat->siswa->kelas ?? '-' }}</td></tr>
                <tr><td><strong>Jenis Kelamin</strong></td><td>: {{ ($surat->siswa->jk ?? '') === 'L' ? 'Laki-Laki' : 'Perempuan' }}</td></tr>
                <tr><td><strong>Total Akumulasi Poin</strong></td><td>: <strong>{{ $surat->siswa->total_poin ?? 0 }} Poin</strong></td></tr>
            </table>

            <p>Daftar rincian poin pelanggaran tata tertib sekolah yang telah dicapai:</p>

            <table class="data">
                <thead>
                    <tr>
                        <th style="width:30px; text-align:center;">No</th>
                        <th>Tanggal</th>
                        <th>Jenis Pelanggaran</th>
                        <th style="text-align:center;">Poin</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surat->siswa->riwayatPelanggaran ?? [] as $index => $r)
                    <tr>
                        <td style="text-align:center;">{{ $index + 1 }}</td>
                        <td>{{ $r->tanggal->format('d/m/Y') }}</td>
                        <td><strong>{{ $r->jenisPelanggaran->nama ?? '-' }}</strong></td>
                        <td style="text-align:center; color:#cc0000; font-weight:bold;">+{{ $r->jenisPelanggaran->poin ?? 0 }}</td>
                        <td>{{ $r->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;">Belum ada riwayat pelanggaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <p>Demikian Surat Peringatan ini dibuat agar siswa yang bersangkutan dapat memperbaiki sikap dan tidak mengulangi pelanggaran aturan tata tertib sekolah.</p>
        </div>

        <div class="signatures">
            <div class="sig-box">
                <p>Mengetahui,<br>Guru Bimbingan Konseling (BK)</p>
                <br><br><br>
                <p><u><strong>Budi Hartono, S.Pd.</strong></u><br>NIP. 19850101 201001 1 001</p>
            </div>
            <div class="sig-box">
                <p>Diterbitkan tanggal: {{ $surat->tanggal->format('d F Y') }}<br>Kepala Sekolah</p>
                <br><br><br>
                <p><u><strong>Drs. H. Ahmad Dahlan, M.Pd.</strong></u><br>NIP. 19700315 199503 1 002</p>
            </div>
        </div>
    </div>
</body>
</html>
