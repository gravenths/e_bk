<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;

class KenaikanKelasController extends Controller
{
    public function index()
    {
        $siswaAktif = Siswa::where('status', 'Aktif')->orderBy('kelas')->orderBy('nama')->get();

        $preview = $siswaAktif->map(function ($s) {
            $parts = explode('-', $s->kelas);
            $tingkat = isset($parts[0]) ? (int)$parts[0] : 10;
            $suffix = isset($parts[1]) ? $parts[1] : '1';

            if ($tingkat >= 12) {
                $kelasBaru = 'Lulus / Alumni';
                $statusBaru = 'Nonaktif';
            } else {
                $kelasBaru = ($tingkat + 1) . '-' . $suffix;
                $statusBaru = 'Aktif';
            }

            return (object) [
                'id' => $s->id,
                'nis' => $s->nis,
                'nama' => $s->nama,
                'kelas_lama' => $s->kelas,
                'kelas_baru' => $kelasBaru,
                'status_baru' => $statusBaru,
            ];
        });

        return view('kenaikan-kelas.index', compact('preview'));
    }

    public function proses(Request $request)
    {
        $siswaAktif = Siswa::where('status', 'Aktif')->get();
        $totalSiswa = 0;

        foreach ($siswaAktif as $s) {
            $parts = explode('-', $s->kelas);
            $tingkat = isset($parts[0]) ? (int)$parts[0] : 10;
            $suffix = isset($parts[1]) ? $parts[1] : '1';

            if ($tingkat >= 12) {
                $s->status = 'Nonaktif';
            } else {
                $s->kelas = ($tingkat + 1) . '-' . $suffix;
            }
            $s->save();
            $totalSiswa++;
        }

        return redirect()->route('kenaikan-kelas.index')->with('success', "Proses kenaikan kelas masal berhasil dilakukan untuk {$totalSiswa} siswa!");
    }
}
