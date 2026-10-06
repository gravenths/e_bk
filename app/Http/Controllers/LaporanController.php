<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\JenisPelanggaran;
use App\Models\SuratPeringatan;
use App\Models\SpSetting;

class LaporanController extends Controller
{
    public function pelanggaran(Request $request)
    {
        $query = RiwayatPelanggaran::with(['siswa', 'jenisPelanggaran']);

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        $riwayat = $query->orderBy('tanggal', 'desc')->get();
        $kelases = Kelas::where('status', 'Aktif')->orderBy('nama')->get();

        return view('laporan.pelanggaran', compact('riwayat', 'kelases'));
    }

    public function poin(Request $request)
    {
        $query = Siswa::where('status', 'Aktif')->with('riwayatPelanggaran.jenisPelanggaran');

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        $siswaList = $query->get()->sortByDesc(function ($s) {
            return $s->total_poin;
        });

        $spLimits = SpSetting::first() ?? (object)['sp1' => 20, 'sp2' => 40, 'sp3' => 60];
        $kelases = Kelas::where('status', 'Aktif')->orderBy('nama')->get();

        if ($request->filled('status_sp')) {
            $statusFilter = $request->status_sp;
            $siswaList = $siswaList->filter(function ($s) use ($statusFilter) {
                return $s->status_sp === $statusFilter;
            });
        }

        return view('laporan.poin', compact('siswaList', 'kelases', 'spLimits'));
    }

    public function surat(Request $request)
    {
        $query = SuratPeringatan::with('siswa');

        if ($request->filled('start_date')) {
            $query->whereDate('tanggal', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('tanggal', '<=', $request->end_date);
        }

        if ($request->filled('jenis_sp')) {
            $query->where('jenis_sp', $request->jenis_sp);
        }

        $suratList = $query->orderBy('tanggal', 'desc')->get();

        return view('laporan.surat', compact('suratList'));
    }
}
