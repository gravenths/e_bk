<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nis',
        'nama',
        'kelas',
        'jk',
        'status',
    ];

    public function riwayatPelanggaran()
    {
        return $this->hasMany(RiwayatPelanggaran::class, 'siswa_id');
    }

    public function suratPeringatan()
    {
        return $this->hasMany(SuratPeringatan::class, 'siswa_id');
    }

    public function getTotalPoinAttribute()
    {
        return $this->riwayatPelanggaran->sum(function ($riwayat) {
            return $riwayat->jenisPelanggaran ? $riwayat->jenisPelanggaran->poin : 0;
        });
    }

    public function getStatusSpAttribute()
    {
        $limits = SpSetting::first() ?? (object)['sp1' => 20, 'sp2' => 40, 'sp3' => 60];
        $poin = $this->total_poin;

        if ($poin >= $limits->sp3) return 'SP 3';
        if ($poin >= $limits->sp2) return 'SP 2';
        if ($poin >= $limits->sp1) return 'SP 1';
        return 'Belum';
    }
}
