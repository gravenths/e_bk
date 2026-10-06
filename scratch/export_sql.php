<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

$tables = [
    'users',
    'kelas',
    'tahun_ajaran',
    'siswa',
    'jenis_pelanggaran',
    'riwayat_pelanggaran',
    'surat_peringatan',
    'sp_settings',
];

$sqlOutput = "-- ==========================================\n";
$sqlOutput .= "-- Dump Database E-BK (Sistem Bimbingan Konseling)\n";
$sqlOutput .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
$sqlOutput .= "-- Compatible for MySQL / MariaDB & SQLite\n";
$sqlOutput .= "-- ==========================================\n\n";

$sqlOutput .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

// Table Schemas
$sqlOutput .= "-- ------------------------------------------\n";
$sqlOutput .= "-- Table structure for users\n";
$sqlOutput .= "-- ------------------------------------------\n";
$sqlOutput .= "CREATE TABLE IF NOT EXISTS `users` (\n";
$sqlOutput .= "  `id` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `name` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `email` VARCHAR(255) NOT NULL UNIQUE,\n";
$sqlOutput .= "  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  `password` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `role` VARCHAR(255) NOT NULL DEFAULT 'Admin',\n";
$sqlOutput .= "  `status` VARCHAR(255) NOT NULL DEFAULT 'Aktif',\n";
$sqlOutput .= "  `remember_token` VARCHAR(100) NULL DEFAULT NULL,\n";
$sqlOutput .= "  `created_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  `updated_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  PRIMARY KEY (`id`)\n";
$sqlOutput .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;\n\n";

$sqlOutput .= "-- Table structure for kelas\n";
$sqlOutput .= "CREATE TABLE IF NOT EXISTS `kelas` (\n";
$sqlOutput .= "  `id` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `nama` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `tingkat` INT NOT NULL,\n";
$sqlOutput .= "  `status` VARCHAR(255) NOT NULL DEFAULT 'Aktif',\n";
$sqlOutput .= "  `created_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  `updated_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  PRIMARY KEY (`id`)\n";
$sqlOutput .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;\n\n";

$sqlOutput .= "-- Table structure for tahun_ajaran\n";
$sqlOutput .= "CREATE TABLE IF NOT EXISTS `tahun_ajaran` (\n";
$sqlOutput .= "  `id` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `tahun` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `semester` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `status` VARCHAR(255) NOT NULL DEFAULT 'Nonaktif',\n";
$sqlOutput .= "  `created_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  `updated_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  PRIMARY KEY (`id`)\n";
$sqlOutput .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;\n\n";

$sqlOutput .= "-- Table structure for siswa\n";
$sqlOutput .= "CREATE TABLE IF NOT EXISTS `siswa` (\n";
$sqlOutput .= "  `id` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `nis` VARCHAR(255) NOT NULL UNIQUE,\n";
$sqlOutput .= "  `nama` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `kelas` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `jk` VARCHAR(1) NOT NULL,\n";
$sqlOutput .= "  `status` VARCHAR(255) NOT NULL DEFAULT 'Aktif',\n";
$sqlOutput .= "  `created_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  `updated_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  PRIMARY KEY (`id`)\n";
$sqlOutput .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;\n\n";

$sqlOutput .= "-- Table structure for jenis_pelanggaran\n";
$sqlOutput .= "CREATE TABLE IF NOT EXISTS `jenis_pelanggaran` (\n";
$sqlOutput .= "  `id` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `nama` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `kategori` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `poin` INT NOT NULL,\n";
$sqlOutput .= "  `status` VARCHAR(255) NOT NULL DEFAULT 'Aktif',\n";
$sqlOutput .= "  `created_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  `updated_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  PRIMARY KEY (`id`)\n";
$sqlOutput .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;\n\n";

$sqlOutput .= "-- Table structure for riwayat_pelanggaran\n";
$sqlOutput .= "CREATE TABLE IF NOT EXISTS `riwayat_pelanggaran` (\n";
$sqlOutput .= "  `id` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `tanggal` DATE NOT NULL,\n";
$sqlOutput .= "  `siswa_id` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `pelanggaran_id` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `keterangan` TEXT NULL,\n";
$sqlOutput .= "  `pencatat` VARCHAR(255) NOT NULL DEFAULT 'Admin',\n";
$sqlOutput .= "  `created_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  `updated_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  PRIMARY KEY (`id`)\n";
$sqlOutput .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;\n\n";

$sqlOutput .= "-- Table structure for surat_peringatan\n";
$sqlOutput .= "CREATE TABLE IF NOT EXISTS `surat_peringatan` (\n";
$sqlOutput .= "  `id` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `tanggal` DATE NOT NULL,\n";
$sqlOutput .= "  `siswa_id` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `jenis_sp` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `nomor_surat` VARCHAR(255) NOT NULL,\n";
$sqlOutput .= "  `created_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  `updated_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  PRIMARY KEY (`id`)\n";
$sqlOutput .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;\n\n";

$sqlOutput .= "-- Table structure for sp_settings\n";
$sqlOutput .= "CREATE TABLE IF NOT EXISTS `sp_settings` (\n";
$sqlOutput .= "  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,\n";
$sqlOutput .= "  `sp1` INT NOT NULL DEFAULT 20,\n";
$sqlOutput .= "  `sp2` INT NOT NULL DEFAULT 40,\n";
$sqlOutput .= "  `sp3` INT NOT NULL DEFAULT 60,\n";
$sqlOutput .= "  `created_at` TIMESTAMP NULL DEFAULT NULL,\n";
$sqlOutput .= "  `updated_at` TIMESTAMP NULL DEFAULT NULL\n";
$sqlOutput .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;\n\n";

// Table Data Inserts
foreach ($tables as $table) {
    $rows = DB::table($table)->get();
    if ($rows->count() > 0) {
        $sqlOutput .= "-- Inserts for {$table}\n";
        foreach ($rows as $row) {
            $cols = array_keys((array)$row);
            $vals = array_map(function ($v) {
                if ($v === null) return 'NULL';
                return "'" . addslashes((string)$v) . "'";
            }, array_values((array)$row));
            
            $sqlOutput .= "INSERT INTO `" . $table . "` (`" . implode("`, `", $cols) . "`) VALUES (" . implode(", ", $vals) . ");\n";
        }
        $sqlOutput .= "\n";
    }
}

$sqlOutput .= "SET FOREIGN_KEY_CHECKS=1;\n";

file_put_contents(__DIR__ . '/../database/database.sql', $sqlOutput);
echo "SQL database dump successfully generated at database/database.sql\n";
