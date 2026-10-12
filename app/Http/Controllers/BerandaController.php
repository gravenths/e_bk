<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\RiwayatPelanggaran;
use App\Models\TahunAjaran;
use App\Models\SpSetting;

class BerandaController extends Controller
{
    public function index(): View
    {
        // --- Statistik siswa ---
        $totalSiswa    = Siswa::count();
        $siswaAktif    = Siswa::where('status', 'Aktif')->count();
        $siswaNonaktif = Siswa::where('status', 'Nonaktif')->count();

        // --- Pelanggaran ---
        $pelanggaranBulanIni = RiwayatPelanggaran::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        $totalPelanggaran = RiwayatPelanggaran::count();

        // --- Tahun ajaran aktif ---
        $ta = TahunAjaran::where('status', 'Aktif')->first();
        $tahunAjaranAktif = $ta
            ? ['nama' => $ta->tahun . ' - ' . $ta->semester]
            : ['nama' => 'Belum ada'];

        // --- 5 siswa dengan total poin tertinggi ---
        // Subquery menghitung poin di SQL agar tidak terjadi N+1 query.
        // Cara pengganti setelah model lengkap:
        //   Siswa::withSum('riwayatPelanggaran as total_poin_computed', 'jenisPelanggaran.poin')
        //   (butuh relasi hasManyThrough atau withSum + join)
        $spLimits = SpSetting::first() ?? (object)['sp1' => 20, 'sp2' => 40, 'sp3' => 60];

        $siswaTeratas = Siswa::select('siswa.*')
            ->addSelect(DB::raw('
                COALESCE((
                    SELECT SUM(jp.poin)
                    FROM riwayat_pelanggaran rp
                    LEFT JOIN jenis_pelanggaran jp ON jp.id = rp.pelanggaran_id
                    WHERE rp.siswa_id = siswa.id
                ), 0) AS total_poin_computed
            '))
            ->orderByDesc('total_poin_computed')
            ->limit(5)
            ->get()
            ->map(function ($s) use ($spLimits) {
                $poin = (int) $s->total_poin_computed;

                if ($poin >= $spLimits->sp3)     $status = 'SP 3';
                elseif ($poin >= $spLimits->sp2) $status = 'SP 2';
                elseif ($poin >= $spLimits->sp1) $status = 'SP 1';
                else                             $status = 'Belum';

                return [
                    'nis'    => $s->nis,
                    'nama'   => $s->nama,
                    'kelas'  => $s->kelas,
                    'poin'   => $poin,
                    'status' => $status,
                ];
            });

        $stat = [
            'total_siswa'           => $totalSiswa,
            'siswa_aktif'           => $siswaAktif,
            'siswa_nonaktif'        => $siswaNonaktif,
            'pelanggaran_bulan_ini' => $pelanggaranBulanIni,
            'total_pelanggaran'     => $totalPelanggaran,
        ];

        return view('beranda', [
            'tahunAjaranAktif' => $tahunAjaranAktif,
            'stat'             => $stat,
            'siswaTeratas'     => $siswaTeratas,
            'tanggalSekarang'  => now()->locale('id')->translatedFormat('l, d F Y'),
            'bulanIni'         => now()->locale('id')->translatedFormat('F Y'),
        ]);
    }
}
