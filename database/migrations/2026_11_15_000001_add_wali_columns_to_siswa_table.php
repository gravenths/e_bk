<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (!Schema::hasColumn('siswa', 'nama_wali')) {
                $table->string('nama_wali', 50)->nullable()->after('jk');
            }
            if (!Schema::hasColumn('siswa', 'no_wa_wali')) {
                $table->string('no_wa_wali', 15)->nullable()->after('nama_wali');
            }
        });
    }

    public function down(): void
    {
        Schema::table('siswa', function (Blueprint $table) {
            if (Schema::hasColumn('siswa', 'no_wa_wali')) {
                $table->dropColumn('no_wa_wali');
            }
            if (Schema::hasColumn('siswa', 'nama_wali')) {
                $table->dropColumn('nama_wali');
            }
        });
    }
};
