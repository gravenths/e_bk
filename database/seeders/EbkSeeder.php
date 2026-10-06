<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kelas;
use App\Models\TahunAjaran;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use App\Models\RiwayatPelanggaran;
use App\Models\SuratPeringatan;
use App\Models\SpSetting;

class EbkSeeder extends Seeder
{
    public function run(): void
    {
        // SpSettings
        SpSetting::updateOrCreate(['id' => 1], [
            'sp1' => 20,
            'sp2' => 40,
            'sp3' => 60,
        ]);

        // Users
        $users = [
            ['id' => 'u1', 'name' => 'Admin Sekolah', 'email' => 'admin@sekolah.sch.id', 'role' => 'Admin', 'status' => 'Aktif'],
            ['id' => 'u2', 'name' => 'Guru BK', 'email' => 'bk@sekolah.sch.id', 'role' => 'Guru BK', 'status' => 'Aktif'],
            ['id' => 'u3', 'name' => 'Budi Hartono', 'email' => 'budi@sekolah.sch.id', 'role' => 'Guru BK', 'status' => 'Aktif'],
            ['id' => 'u4', 'name' => 'Siti Rahma', 'email' => 'siti@sekolah.sch.id', 'role' => 'Admin', 'status' => 'Nonaktif'],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(['email' => $u['email']], [
                'id' => $u['id'],
                'name' => $u['name'],
                'password' => Hash::make('password'),
                'role' => $u['role'],
                'status' => $u['status'],
            ]);
        }

        // Tahun Ajaran
        $tahun = [
            ['id' => 'ta1', 'tahun' => '2026/2027', 'semester' => 'Ganjil', 'status' => 'Aktif'],
            ['id' => 'ta2', 'tahun' => '2026/2027', 'semester' => 'Genap', 'status' => 'Nonaktif'],
            ['id' => 'ta3', 'tahun' => '2025/2026', 'semester' => 'Ganjil', 'status' => 'Nonaktif'],
            ['id' => 'ta4', 'tahun' => '2025/2026', 'semester' => 'Genap', 'status' => 'Nonaktif'],
        ];
        foreach ($tahun as $t) {
            TahunAjaran::updateOrCreate(['id' => $t['id']], $t);
        }

        // Kelas
        $kelas = [
            ['id' => 'k1', 'nama' => '10-1', 'tingkat' => 10, 'status' => 'Aktif'],
            ['id' => 'k2', 'nama' => '10-2', 'tingkat' => 10, 'status' => 'Aktif'],
            ['id' => 'k3', 'nama' => '10-3', 'tingkat' => 10, 'status' => 'Aktif'],
            ['id' => 'k4', 'nama' => '11-1', 'tingkat' => 11, 'status' => 'Aktif'],
            ['id' => 'k5', 'nama' => '11-2', 'tingkat' => 11, 'status' => 'Aktif'],
            ['id' => 'k6', 'nama' => '11-3', 'tingkat' => 11, 'status' => 'Aktif'],
            ['id' => 'k7', 'nama' => '12-1', 'tingkat' => 12, 'status' => 'Aktif'],
            ['id' => 'k8', 'nama' => '12-2', 'tingkat' => 12, 'status' => 'Aktif'],
            ['id' => 'k9', 'nama' => '12-3', 'tingkat' => 12, 'status' => 'Aktif'],
        ];
        foreach ($kelas as $k) {
            Kelas::updateOrCreate(['id' => $k['id']], $k);
        }

        // Jenis Pelanggaran
        $jp = [
            ['id' => 'jp1', 'nama' => 'Terlambat', 'poin' => 2, 'status' => 'Aktif'],
            ['id' => 'jp2', 'nama' => 'Bolos', 'poin' => 20, 'status' => 'Aktif'],
            ['id' => 'jp3', 'nama' => 'Tidak memakai atribut', 'poin' => 5, 'status' => 'Aktif'],
            ['id' => 'jp4', 'nama' => 'Membolos jam pelajaran', 'poin' => 15, 'status' => 'Aktif'],
            ['id' => 'jp5', 'nama' => 'Berkata kasar', 'poin' => 25, 'status' => 'Aktif'],
            ['id' => 'jp6', 'nama' => 'Merokok', 'poin' => 50, 'status' => 'Aktif'],
            ['id' => 'jp7', 'nama' => 'Tidak mengerjakan tugas', 'poin' => 3, 'status' => 'Aktif'],
            ['id' => 'jp8', 'nama' => 'Berkelahi', 'poin' => 45, 'status' => 'Aktif'],
            ['id' => 'jp9', 'nama' => 'Mencontek', 'poin' => 10, 'status' => 'Aktif'],
            ['id' => 'jp10', 'nama' => 'Membawa HP saat ujian', 'poin' => 30, 'status' => 'Aktif'],
        ];
        foreach ($jp as $j) {
            JenisPelanggaran::updateOrCreate(['id' => $j['id']], $j);
        }

        // Siswa
        $siswa = [
            ['id' => 's1', 'nis' => '10001', 'nama' => 'Ahmad Fauzan', 'kelas' => '12-1', 'jk' => 'L', 'status' => 'Aktif'],
            ['id' => 's2', 'nis' => '10002', 'nama' => 'Rian Aditya', 'kelas' => '11-2', 'jk' => 'L', 'status' => 'Aktif'],
            ['id' => 's3', 'nis' => '10003', 'nama' => 'Dwi Ananda', 'kelas' => '12-3', 'jk' => 'P', 'status' => 'Aktif'],
            ['id' => 's4', 'nis' => '10004', 'nama' => 'Fajar Ramadhan', 'kelas' => '11-1', 'jk' => 'L', 'status' => 'Aktif'],
            ['id' => 's5', 'nis' => '10005', 'nama' => 'Siti Aisyah', 'kelas' => '11-3', 'jk' => 'P', 'status' => 'Aktif'],
            ['id' => 's6', 'nis' => '10006', 'nama' => 'Budi Santoso', 'kelas' => '11-2', 'jk' => 'L', 'status' => 'Aktif'],
            ['id' => 's7', 'nis' => '10007', 'nama' => 'Dewi Lestari', 'kelas' => '10-1', 'jk' => 'P', 'status' => 'Aktif'],
            ['id' => 's8', 'nis' => '10008', 'nama' => 'Eko Prasetyo', 'kelas' => '10-2', 'jk' => 'L', 'status' => 'Aktif'],
            ['id' => 's9', 'nis' => '10009', 'nama' => 'Fitri Handayani', 'kelas' => '12-1', 'jk' => 'P', 'status' => 'Aktif'],
            ['id' => 's10', 'nis' => '10010', 'nama' => 'Gilang Ramadhan', 'kelas' => '10-3', 'jk' => 'L', 'status' => 'Aktif'],
            ['id' => 's11', 'nis' => '10011', 'nama' => 'Hana Pertiwi', 'kelas' => '11-1', 'jk' => 'P', 'status' => 'Aktif'],
            ['id' => 's12', 'nis' => '10012', 'nama' => 'Indra Gunawan', 'kelas' => '12-2', 'jk' => 'L', 'status' => 'Aktif'],
            ['id' => 's13', 'nis' => '10013', 'nama' => 'Joko Widodo', 'kelas' => '10-1', 'jk' => 'L', 'status' => 'Nonaktif'],
            ['id' => 's14', 'nis' => '10014', 'nama' => 'Kartika Sari', 'kelas' => '11-3', 'jk' => 'P', 'status' => 'Aktif'],
            ['id' => 's15', 'nis' => '10015', 'nama' => 'Lina Marlina', 'kelas' => '12-2', 'jk' => 'P', 'status' => 'Aktif'],
            ['id' => 's16', 'nis' => '10016', 'nama' => 'Andi Saputra', 'kelas' => '10-2', 'jk' => 'L', 'status' => 'Aktif'],
            ['id' => 's17', 'nis' => '10017', 'nama' => 'Maya Anggraini', 'kelas' => '12-3', 'jk' => 'P', 'status' => 'Aktif'],
            ['id' => 's18', 'nis' => '10018', 'nama' => 'Rizki Maulana', 'kelas' => '10-3', 'jk' => 'L', 'status' => 'Aktif'],
        ];
        foreach ($siswa as $s) {
            Siswa::updateOrCreate(['id' => $s['id']], $s);
        }

        // Riwayat Pelanggaran
        $riwayat = [
            ['id' => 'r1', 'tanggal' => '2026-08-02', 'siswa_id' => 's1', 'pelanggaran_id' => 'jp1', 'keterangan' => '-', 'pencatat' => 'Admin'],
            ['id' => 'r2', 'tanggal' => '2026-08-05', 'siswa_id' => 's1', 'pelanggaran_id' => 'jp2', 'keterangan' => 'Tidak ada keterangan', 'pencatat' => 'Admin'],
            ['id' => 'r3', 'tanggal' => '2026-08-10', 'siswa_id' => 's1', 'pelanggaran_id' => 'jp3', 'keterangan' => '-', 'pencatat' => 'Guru BK'],
            ['id' => 'r4', 'tanggal' => '2026-08-15', 'siswa_id' => 's1', 'pelanggaran_id' => 'jp5', 'keterangan' => 'Membentak guru', 'pencatat' => 'Guru BK'],
            ['id' => 'r5', 'tanggal' => '2026-08-22', 'siswa_id' => 's1', 'pelanggaran_id' => 'jp2', 'keterangan' => '-', 'pencatat' => 'Admin'],
            ['id' => 'r6', 'tanggal' => '2026-09-01', 'siswa_id' => 's1', 'pelanggaran_id' => 'jp1', 'keterangan' => '-', 'pencatat' => 'Guru BK'],
            ['id' => 'r7', 'tanggal' => '2026-09-03', 'siswa_id' => 's1', 'pelanggaran_id' => 'jp1', 'keterangan' => 'Terlambat 30 menit', 'pencatat' => 'Guru BK'],

            ['id' => 'r8', 'tanggal' => '2026-08-06', 'siswa_id' => 's2', 'pelanggaran_id' => 'jp2', 'keterangan' => '-', 'pencatat' => 'Admin'],
            ['id' => 'r9', 'tanggal' => '2026-08-12', 'siswa_id' => 's2', 'pelanggaran_id' => 'jp3', 'keterangan' => '-', 'pencatat' => 'Guru BK'],
            ['id' => 'r10', 'tanggal' => '2026-08-18', 'siswa_id' => 's2', 'pelanggaran_id' => 'jp10', 'keterangan' => 'Saat ujian mid', 'pencatat' => 'Guru BK'],
            ['id' => 'r11', 'tanggal' => '2026-08-25', 'siswa_id' => 's2', 'pelanggaran_id' => 'jp1', 'keterangan' => '-', 'pencatat' => 'Admin'],
            ['id' => 'r12', 'tanggal' => '2026-09-02', 'siswa_id' => 's2', 'pelanggaran_id' => 'jp7', 'keterangan' => '-', 'pencatat' => 'Guru BK'],
            ['id' => 'r13', 'tanggal' => '2026-09-05', 'siswa_id' => 's2', 'pelanggaran_id' => 'jp7', 'keterangan' => '-', 'pencatat' => 'Guru BK'],

            ['id' => 'r14', 'tanggal' => '2026-08-04', 'siswa_id' => 's3', 'pelanggaran_id' => 'jp2', 'keterangan' => '-', 'pencatat' => 'Admin'],
            ['id' => 'r15', 'tanggal' => '2026-08-11', 'siswa_id' => 's3', 'pelanggaran_id' => 'jp3', 'keterangan' => '-', 'pencatat' => 'Guru BK'],
            ['id' => 'r16', 'tanggal' => '2026-08-19', 'siswa_id' => 's3', 'pelanggaran_id' => 'jp9', 'keterangan' => 'Mencontek ulangan', 'pencatat' => 'Guru BK'],
            ['id' => 'r17', 'tanggal' => '2026-08-27', 'siswa_id' => 's3', 'pelanggaran_id' => 'jp4', 'keterangan' => '-', 'pencatat' => 'Admin'],
            ['id' => 'r18', 'tanggal' => '2026-09-03', 'siswa_id' => 's3', 'pelanggaran_id' => 'jp3', 'keterangan' => '-', 'pencatat' => 'Guru BK'],

            ['id' => 'r19', 'tanggal' => '2026-08-07', 'siswa_id' => 's4', 'pelanggaran_id' => 'jp3', 'keterangan' => '-', 'pencatat' => 'Guru BK'],
            ['id' => 'r20', 'tanggal' => '2026-08-13', 'siswa_id' => 's4', 'pelanggaran_id' => 'jp2', 'keterangan' => '-', 'pencatat' => 'Admin'],
            ['id' => 'r21', 'tanggal' => '2026-08-20', 'siswa_id' => 's4', 'pelanggaran_id' => 'jp9', 'keterangan' => '-', 'pencatat' => 'Guru BK'],
            ['id' => 'r22', 'tanggal' => '2026-08-28', 'siswa_id' => 's4', 'pelanggaran_id' => 'jp1', 'keterangan' => '-', 'pencatat' => 'Admin'],
            ['id' => 'r23', 'tanggal' => '2026-09-04', 'siswa_id' => 's4', 'pelanggaran_id' => 'jp7', 'keterangan' => '-', 'pencatat' => 'Guru BK'],
            ['id' => 'r24', 'tanggal' => '2026-09-06', 'siswa_id' => 's4', 'pelanggaran_id' => 'jp3', 'keterangan' => '-', 'pencatat' => 'Guru BK'],

            ['id' => 'r25', 'tanggal' => '2026-08-08', 'siswa_id' => 's5', 'pelanggaran_id' => 'jp5', 'keterangan' => 'Berkata kasar pada teman', 'pencatat' => 'Guru BK'],
            ['id' => 'r26', 'tanggal' => '2026-08-14', 'siswa_id' => 's5', 'pelanggaran_id' => 'jp3', 'keterangan' => '-', 'pencatat' => 'Guru BK'],
            ['id' => 'r27', 'tanggal' => '2026-08-21', 'siswa_id' => 's5', 'pelanggaran_id' => 'jp9', 'keterangan' => '-', 'pencatat' => 'Guru BK'],
            ['id' => 'r28', 'tanggal' => '2026-09-05', 'siswa_id' => 's5', 'pelanggaran_id' => 'jp7', 'keterangan' => '-', 'pencatat' => 'Guru BK'],

            ['id' => 'r29', 'tanggal' => '2026-08-09', 'siswa_id' => 's6', 'pelanggaran_id' => 'jp1', 'keterangan' => '-', 'pencatat' => 'Admin'],
            ['id' => 'r30', 'tanggal' => '2026-08-16', 'siswa_id' => 's6', 'pelanggaran_id' => 'jp3', 'keterangan' => '-', 'pencatat' => 'Guru BK'],
            ['id' => 'r31', 'tanggal' => '2026-08-23', 'siswa_id' => 's6', 'pelanggaran_id' => 'jp7', 'keterangan' => '-', 'pencatat' => 'Guru BK'],

            ['id' => 'r32', 'tanggal' => '2026-08-12', 'siswa_id' => 's8', 'pelanggaran_id' => 'jp1', 'keterangan' => '-', 'pencatat' => 'Admin'],
            ['id' => 'r33', 'tanggal' => '2026-08-20', 'siswa_id' => 's10', 'pelanggaran_id' => 'jp3', 'keterangan' => '-', 'pencatat' => 'Guru BK'],
            ['id' => 'r34', 'tanggal' => '2026-08-22', 'siswa_id' => 's12', 'pelanggaran_id' => 'jp9', 'keterangan' => 'Mencontek PR', 'pencatat' => 'Guru BK'],
            ['id' => 'r35', 'tanggal' => '2026-08-25', 'siswa_id' => 's15', 'pelanggaran_id' => 'jp1', 'keterangan' => '-', 'pencatat' => 'Admin'],
            ['id' => 'r36', 'tanggal' => '2026-09-02', 'siswa_id' => 's11', 'pelanggaran_id' => 'jp3', 'keterangan' => '-', 'pencatat' => 'Guru BK'],
            ['id' => 'r37', 'tanggal' => '2026-09-04', 'siswa_id' => 's17', 'pelanggaran_id' => 'jp7', 'keterangan' => '-', 'pencatat' => 'Guru BK'],
        ];
        foreach ($riwayat as $r) {
            RiwayatPelanggaran::updateOrCreate(['id' => $r['id']], $r);
        }

        // Surat Peringatan
        $surat = [
            ['id' => 'sp1', 'tanggal' => '2026-08-20', 'siswa_id' => 's1', 'jenis_sp' => 'SP 1', 'nomor_surat' => '421/001'],
            ['id' => 'sp2', 'tanggal' => '2026-08-22', 'siswa_id' => 's2', 'jenis_sp' => 'SP 1', 'nomor_surat' => '421/002'],
            ['id' => 'sp3', 'tanggal' => '2026-08-25', 'siswa_id' => 's3', 'jenis_sp' => 'SP 1', 'nomor_surat' => '421/003'],
            ['id' => 'sp4', 'tanggal' => '2026-09-05', 'siswa_id' => 's1', 'jenis_sp' => 'SP 2', 'nomor_surat' => '421/004'],
        ];
        foreach ($surat as $sp) {
            SuratPeringatan::updateOrCreate(['id' => $sp['id']], $sp);
        }
    }
}
