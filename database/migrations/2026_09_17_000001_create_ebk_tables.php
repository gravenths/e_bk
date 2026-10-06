<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Modify or update users table columns if needed
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('Admin')->after('email');
            }
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('Aktif')->after('role');
            }
        });

        Schema::create('kelas', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nama');
            $table->integer('tingkat');
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });

        Schema::create('tahun_ajaran', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('tahun');
            $table->string('semester');
            $table->string('status')->default('Nonaktif');
            $table->timestamps();
        });

        Schema::create('siswa', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nis')->unique();
            $table->string('nama');
            $table->string('kelas');
            $table->string('jk', 1);
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });

        Schema::create('jenis_pelanggaran', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('nama');
            $table->string('kategori');
            $table->integer('poin');
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });

        Schema::create('riwayat_pelanggaran', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->date('tanggal');
            $table->string('siswa_id');
            $table->string('pelanggaran_id');
            $table->text('keterangan')->nullable();
            $table->string('pencatat')->default('Admin');
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
            $table->foreign('pelanggaran_id')->references('id')->on('jenis_pelanggaran')->onDelete('cascade');
        });

        Schema::create('surat_peringatan', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->date('tanggal');
            $table->string('siswa_id');
            $table->string('jenis_sp');
            $table->string('nomor_surat');
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
        });

        Schema::create('sp_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('sp1')->default(20);
            $table->integer('sp2')->default(40);
            $table->integer('sp3')->default(60);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sp_settings');
        Schema::dropIfExists('surat_peringatan');
        Schema::dropIfExists('riwayat_pelanggaran');
        Schema::dropIfExists('jenis_pelanggaran');
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('tahun_ajaran');
        Schema::dropIfExists('kelas');
    }
};
