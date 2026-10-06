-- ==========================================
-- Dump Database E-BK (Sistem Bimbingan Konseling)
-- Generated: 2026-09-17 05:09:03
-- Compatible for MySQL / MariaDB & SQLite
-- ==========================================

SET FOREIGN_KEY_CHECKS=0;

-- ------------------------------------------
-- Table structure for users
-- ------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` VARCHAR(255) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` VARCHAR(255) NOT NULL DEFAULT 'Admin',
  `status` VARCHAR(255) NOT NULL DEFAULT 'Aktif',
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for kelas
CREATE TABLE IF NOT EXISTS `kelas` (
  `id` VARCHAR(255) NOT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `tingkat` INT NOT NULL,
  `status` VARCHAR(255) NOT NULL DEFAULT 'Aktif',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for tahun_ajaran
CREATE TABLE IF NOT EXISTS `tahun_ajaran` (
  `id` VARCHAR(255) NOT NULL,
  `tahun` VARCHAR(255) NOT NULL,
  `semester` VARCHAR(255) NOT NULL,
  `status` VARCHAR(255) NOT NULL DEFAULT 'Nonaktif',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for siswa
CREATE TABLE IF NOT EXISTS `siswa` (
  `id` VARCHAR(255) NOT NULL,
  `nis` VARCHAR(255) NOT NULL UNIQUE,
  `nama` VARCHAR(255) NOT NULL,
  `kelas` VARCHAR(255) NOT NULL,
  `jk` VARCHAR(1) NOT NULL,
  `status` VARCHAR(255) NOT NULL DEFAULT 'Aktif',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for jenis_pelanggaran
CREATE TABLE IF NOT EXISTS `jenis_pelanggaran` (
  `id` VARCHAR(255) NOT NULL,
  `nama` VARCHAR(255) NOT NULL,
  `kategori` VARCHAR(255) NOT NULL,
  `poin` INT NOT NULL,
  `status` VARCHAR(255) NOT NULL DEFAULT 'Aktif',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for riwayat_pelanggaran
CREATE TABLE IF NOT EXISTS `riwayat_pelanggaran` (
  `id` VARCHAR(255) NOT NULL,
  `tanggal` DATE NOT NULL,
  `siswa_id` VARCHAR(255) NOT NULL,
  `pelanggaran_id` VARCHAR(255) NOT NULL,
  `keterangan` TEXT NULL,
  `pencatat` VARCHAR(255) NOT NULL DEFAULT 'Admin',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for surat_peringatan
CREATE TABLE IF NOT EXISTS `surat_peringatan` (
  `id` VARCHAR(255) NOT NULL,
  `tanggal` DATE NOT NULL,
  `siswa_id` VARCHAR(255) NOT NULL,
  `jenis_sp` VARCHAR(255) NOT NULL,
  `nomor_surat` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for sp_settings
CREATE TABLE IF NOT EXISTS `sp_settings` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `sp1` INT NOT NULL DEFAULT 20,
  `sp2` INT NOT NULL DEFAULT 40,
  `sp3` INT NOT NULL DEFAULT 60,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Inserts for users
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `status`) VALUES ('u1', 'Admin Sekolah', 'admin@sekolah.sch.id', NULL, '$2y$12$Gji0nU1/IwK1WGBcrhQpje.t53YTJWi5ZoIItPYCjaUDD0uV0DPxu', NULL, '2026-09-17 02:52:45', '2026-09-17 02:52:45', 'Admin', 'Aktif');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `status`) VALUES ('u2', 'Guru BK', 'bk@sekolah.sch.id', NULL, '$2y$12$bh9rd2KswRUl1YMkEhb57u6NAvkafHhPZjLlsgGTWPQUyWqs3SB8S', NULL, '2026-09-17 02:52:46', '2026-09-17 02:52:46', 'Guru BK', 'Aktif');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `status`) VALUES ('u3', 'Budi Hartono', 'budi@sekolah.sch.id', NULL, '$2y$12$goA0Ov8kY5EhZwUO/D5z2.5UEA3Fibrf9wgl.o2QztGuNi2ZPMYwu', NULL, '2026-09-17 02:52:46', '2026-09-17 02:52:46', 'Guru BK', 'Aktif');
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `status`) VALUES ('u4', 'Siti Rahma', 'siti@sekolah.sch.id', NULL, '$2y$12$rKH8ZCQOTQ30PuJRZrXZhez2PDxG5RULvxwU4Kz.jgNc.vhK3yp2a', NULL, '2026-09-17 02:52:46', '2026-09-17 02:52:46', 'Admin', 'Nonaktif');

-- Inserts for kelas
INSERT INTO `kelas` (`id`, `nama`, `tingkat`, `status`, `created_at`, `updated_at`) VALUES ('k1', '10-1', '10', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `kelas` (`id`, `nama`, `tingkat`, `status`, `created_at`, `updated_at`) VALUES ('k2', '10-2', '10', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `kelas` (`id`, `nama`, `tingkat`, `status`, `created_at`, `updated_at`) VALUES ('k3', '10-3', '10', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `kelas` (`id`, `nama`, `tingkat`, `status`, `created_at`, `updated_at`) VALUES ('k4', '11-1', '11', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `kelas` (`id`, `nama`, `tingkat`, `status`, `created_at`, `updated_at`) VALUES ('k5', '11-2', '11', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `kelas` (`id`, `nama`, `tingkat`, `status`, `created_at`, `updated_at`) VALUES ('k6', '11-3', '11', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `kelas` (`id`, `nama`, `tingkat`, `status`, `created_at`, `updated_at`) VALUES ('k7', '12-1', '12', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `kelas` (`id`, `nama`, `tingkat`, `status`, `created_at`, `updated_at`) VALUES ('k8', '12-2', '12', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `kelas` (`id`, `nama`, `tingkat`, `status`, `created_at`, `updated_at`) VALUES ('k9', '12-3', '12', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');

-- Inserts for tahun_ajaran
INSERT INTO `tahun_ajaran` (`id`, `tahun`, `semester`, `status`, `created_at`, `updated_at`) VALUES ('ta1', '2026/2027', 'Ganjil', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `tahun_ajaran` (`id`, `tahun`, `semester`, `status`, `created_at`, `updated_at`) VALUES ('ta2', '2026/2027', 'Genap', 'Nonaktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `tahun_ajaran` (`id`, `tahun`, `semester`, `status`, `created_at`, `updated_at`) VALUES ('ta3', '2025/2026', 'Ganjil', 'Nonaktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `tahun_ajaran` (`id`, `tahun`, `semester`, `status`, `created_at`, `updated_at`) VALUES ('ta4', '2025/2026', 'Genap', 'Nonaktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');

-- Inserts for siswa
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s1', '10001', 'Ahmad Fauzan', '12-1', 'L', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s2', '10002', 'Rian Aditya', '11-2', 'L', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s3', '10003', 'Dwi Ananda', '12-3', 'P', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s4', '10004', 'Fajar Ramadhan', '11-1', 'L', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s5', '10005', 'Siti Aisyah', '11-3', 'P', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s6', '10006', 'Budi Santoso', '11-2', 'L', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s7', '10007', 'Dewi Lestari', '10-1', 'P', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s8', '10008', 'Eko Prasetyo', '10-2', 'L', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s9', '10009', 'Fitri Handayani', '12-1', 'P', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s10', '10010', 'Gilang Ramadhan', '10-3', 'L', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s11', '10011', 'Hana Pertiwi', '11-1', 'P', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s12', '10012', 'Indra Gunawan', '12-2', 'L', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s13', '10013', 'Joko Widodo', '10-1', 'L', 'Nonaktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s14', '10014', 'Kartika Sari', '11-3', 'P', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s15', '10015', 'Lina Marlina', '12-2', 'P', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s16', '10016', 'Andi Saputra', '10-2', 'L', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s17', '10017', 'Maya Anggraini', '12-3', 'P', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jk`, `status`, `created_at`, `updated_at`) VALUES ('s18', '10018', 'Rizki Maulana', '10-3', 'L', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');

-- Inserts for jenis_pelanggaran
INSERT INTO `jenis_pelanggaran` (`id`, `nama`, `kategori`, `poin`, `status`, `created_at`, `updated_at`) VALUES ('jp1', 'Terlambat', 'Kedisiplinan', '2', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `jenis_pelanggaran` (`id`, `nama`, `kategori`, `poin`, `status`, `created_at`, `updated_at`) VALUES ('jp2', 'Bolos', 'Kehadiran', '20', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `jenis_pelanggaran` (`id`, `nama`, `kategori`, `poin`, `status`, `created_at`, `updated_at`) VALUES ('jp3', 'Tidak memakai atribut', 'Kerapian', '5', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `jenis_pelanggaran` (`id`, `nama`, `kategori`, `poin`, `status`, `created_at`, `updated_at`) VALUES ('jp4', 'Membolos jam pelajaran', 'Kehadiran', '15', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `jenis_pelanggaran` (`id`, `nama`, `kategori`, `poin`, `status`, `created_at`, `updated_at`) VALUES ('jp5', 'Berkata kasar', 'Perilaku', '25', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `jenis_pelanggaran` (`id`, `nama`, `kategori`, `poin`, `status`, `created_at`, `updated_at`) VALUES ('jp6', 'Merokok', 'Perilaku', '50', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `jenis_pelanggaran` (`id`, `nama`, `kategori`, `poin`, `status`, `created_at`, `updated_at`) VALUES ('jp7', 'Tidak mengerjakan tugas', 'Kedisiplinan', '3', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `jenis_pelanggaran` (`id`, `nama`, `kategori`, `poin`, `status`, `created_at`, `updated_at`) VALUES ('jp8', 'Berkelahi', 'Perilaku', '45', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `jenis_pelanggaran` (`id`, `nama`, `kategori`, `poin`, `status`, `created_at`, `updated_at`) VALUES ('jp9', 'Mencontek', 'Akademik', '10', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `jenis_pelanggaran` (`id`, `nama`, `kategori`, `poin`, `status`, `created_at`, `updated_at`) VALUES ('jp10', 'Membawa HP saat ujian', 'Akademik', '30', 'Aktif', '2026-09-17 02:52:46', '2026-09-17 02:52:46');

-- Inserts for riwayat_pelanggaran
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r1', '2026-08-02 00:00:00', 's1', 'jp1', '-', 'Admin', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r2', '2026-08-05 00:00:00', 's1', 'jp2', 'Tidak ada keterangan', 'Admin', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r3', '2026-08-10 00:00:00', 's1', 'jp3', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r4', '2026-08-15 00:00:00', 's1', 'jp5', 'Membentak guru', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r5', '2026-08-22 00:00:00', 's1', 'jp2', '-', 'Admin', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r6', '2026-09-01 00:00:00', 's1', 'jp1', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r7', '2026-09-03 00:00:00', 's1', 'jp1', 'Terlambat 30 menit', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r8', '2026-08-06 00:00:00', 's2', 'jp2', '-', 'Admin', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r9', '2026-08-12 00:00:00', 's2', 'jp3', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r10', '2026-08-18 00:00:00', 's2', 'jp10', 'Saat ujian mid', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r11', '2026-08-25 00:00:00', 's2', 'jp1', '-', 'Admin', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r12', '2026-09-02 00:00:00', 's2', 'jp7', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r13', '2026-09-05 00:00:00', 's2', 'jp7', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r14', '2026-08-04 00:00:00', 's3', 'jp2', '-', 'Admin', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r15', '2026-08-11 00:00:00', 's3', 'jp3', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r16', '2026-08-19 00:00:00', 's3', 'jp9', 'Mencontek ulangan', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r17', '2026-08-27 00:00:00', 's3', 'jp4', '-', 'Admin', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r18', '2026-09-03 00:00:00', 's3', 'jp3', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r19', '2026-08-07 00:00:00', 's4', 'jp3', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r20', '2026-08-13 00:00:00', 's4', 'jp2', '-', 'Admin', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r21', '2026-08-20 00:00:00', 's4', 'jp9', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r22', '2026-08-28 00:00:00', 's4', 'jp1', '-', 'Admin', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r23', '2026-09-04 00:00:00', 's4', 'jp7', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r24', '2026-09-06 00:00:00', 's4', 'jp3', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r25', '2026-08-08 00:00:00', 's5', 'jp5', 'Berkata kasar pada teman', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r26', '2026-08-14 00:00:00', 's5', 'jp3', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r27', '2026-08-21 00:00:00', 's5', 'jp9', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r28', '2026-09-05 00:00:00', 's5', 'jp7', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r29', '2026-08-09 00:00:00', 's6', 'jp1', '-', 'Admin', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r30', '2026-08-16 00:00:00', 's6', 'jp3', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r31', '2026-08-23 00:00:00', 's6', 'jp7', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r32', '2026-08-12 00:00:00', 's8', 'jp1', '-', 'Admin', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r33', '2026-08-20 00:00:00', 's10', 'jp3', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r34', '2026-08-22 00:00:00', 's12', 'jp9', 'Mencontek PR', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r35', '2026-08-25 00:00:00', 's15', 'jp1', '-', 'Admin', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r36', '2026-09-02 00:00:00', 's11', 'jp3', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `riwayat_pelanggaran` (`id`, `tanggal`, `siswa_id`, `pelanggaran_id`, `keterangan`, `pencatat`, `created_at`, `updated_at`) VALUES ('r37', '2026-09-04 00:00:00', 's17', 'jp7', '-', 'Guru BK', '2026-09-17 02:52:46', '2026-09-17 02:52:46');

-- Inserts for surat_peringatan
INSERT INTO `surat_peringatan` (`id`, `tanggal`, `siswa_id`, `jenis_sp`, `nomor_surat`, `created_at`, `updated_at`) VALUES ('sp1', '2026-08-20 00:00:00', 's1', 'SP 1', '421/001', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `surat_peringatan` (`id`, `tanggal`, `siswa_id`, `jenis_sp`, `nomor_surat`, `created_at`, `updated_at`) VALUES ('sp2', '2026-08-22 00:00:00', 's2', 'SP 1', '421/002', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `surat_peringatan` (`id`, `tanggal`, `siswa_id`, `jenis_sp`, `nomor_surat`, `created_at`, `updated_at`) VALUES ('sp3', '2026-08-25 00:00:00', 's3', 'SP 1', '421/003', '2026-09-17 02:52:46', '2026-09-17 02:52:46');
INSERT INTO `surat_peringatan` (`id`, `tanggal`, `siswa_id`, `jenis_sp`, `nomor_surat`, `created_at`, `updated_at`) VALUES ('sp4', '2026-09-05 00:00:00', 's1', 'SP 2', '421/004', '2026-09-17 02:52:46', '2026-09-17 02:52:46');

-- Inserts for sp_settings
INSERT INTO `sp_settings` (`id`, `sp1`, `sp2`, `sp3`, `created_at`, `updated_at`) VALUES ('1', '20', '40', '60', '2026-09-17 02:52:45', '2026-09-17 02:52:45');

SET FOREIGN_KEY_CHECKS=1;
