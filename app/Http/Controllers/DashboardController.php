<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\JenisPelanggaran;
use App\Models\RiwayatPelanggaran;
use App\Models\SuratPeringatan;
use App\Models\SpSetting;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $spLimits = SpSetting::first() ?? (object)['sp1' => 20, 'sp2' => 40, 'sp3' => 60];

        $totalSiswa = Siswa::where('status', 'Aktif')->count();
        $totalJenis = JenisPelanggaran::where('status', 'Aktif')->count();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $pelanggaranBulanIni = RiwayatPelanggaran::whereBetween('tanggal', [$startOfMonth, $endOfMonth])->count();

        // Calculate SP breakdown
        $siswaAktif = Siswa::where('status', 'Aktif')->with('riwayatPelanggaran.jenisPelanggaran')->get();

        $countSp1 = 0;
        $countSp2 = 0;
        $countSp3 = 0;
        $countSpTotal = 0;

        foreach ($siswaAktif as $s) {
            $poin = $s->total_poin;
            if ($poin >= $spLimits->sp3) {
                $countSp3++;
                $countSpTotal++;
            } elseif ($poin >= $spLimits->sp2) {
                $countSp2++;
                $countSpTotal++;
            } elseif ($poin >= $spLimits->sp1) {
                $countSp1++;
                $countSpTotal++;
            }
        }

        $riwayatTerbaru = RiwayatPelanggaran::with(['siswa', 'jenisPelanggaran'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(7)
            ->get();

        // Top students with highest points
        $topSiswa = $siswaAktif->sortByDesc(function ($s) {
            return $s->total_poin;
        })->take(5);

        return view('dashboard', compact(
            'totalSiswa',
            'totalJenis',
            'pelanggaranBulanIni',
            'countSpTotal',
            'countSp1',
            'countSp2',
            'countSp3',
            'riwayatTerbaru',
            'topSiswa',
            'spLimits'
        ));
    }
}
