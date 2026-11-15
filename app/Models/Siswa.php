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
        'nama_wali',
        'no_wa_wali',
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

    /**
     * Ubah nomor WA ke format internasional tanpa "+" (untuk wa.me).
     * Kembalikan null jika kosong.
     */
    public function noWaInternasional(): ?string
    {
        $no = $this->no_wa_wali;
        if (empty($no)) {
            return null;
        }

        // Buang semua karakter non-digit kecuali tanda "+" di awal
        $no = preg_replace('/[^\d+]/', '', $no);

        if (str_starts_with($no, '+62')) {
            $no = '62' . substr($no, 3);
        } elseif (str_starts_with($no, '0')) {
            $no = '62' . substr($no, 1);
        }

        return $no;
    }

    /**
     * Buat tautan wa.me dengan pesan terisi otomatis.
     */
    public function waLink(string $pesan): ?string
    {
        $no = $this->noWaInternasional();
        if ($no === null) {
            return null;
        }

        return 'https://wa.me/' . $no . '?text=' . rawurlencode($pesan);
    }
}
