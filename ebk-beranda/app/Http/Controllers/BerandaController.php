<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class BerandaController extends Controller
{
    /**
     * Halaman beranda / dashboard.
     *
     * CATATAN: semua data di bawah masih DUMMY agar tampilan bisa langsung dilihat.
     * Ganti dengan query Eloquent setelah migration & model siap, contohnya:
     *
     *   Total siswa aktif   : Siswa::where('status', 'aktif')->count()
     *   Pelanggaran hari ini: RiwayatPelanggaran::whereDate('tanggal', today())->count()
     *   Total pelanggaran   : RiwayatPelanggaran::where('tahun_ajaran_id', $ta->id)->count()
     *   Poin tertinggi      : RiwayatPelanggaran::join('pelanggaran', ...)
     *                           ->selectRaw('siswa_id, SUM(pelanggaran.poin) AS total_poin')
     *                           ->groupBy('siswa_id')->orderByDesc('total_poin')->limit(5)
     *   Status SP           : bandingkan total_poin dengan batas SP dari pengaturan sekolah
     */
    public function index(): View
    {
        $tahunAjaranAktif = [
            'nama'    => '2026/2027 - Ganjil',
            'mulai'   => '14 Juli 2026',
            'selesai' => '20 Desember 2026',
        ];

        $stat = [
            'total_siswa'          => 1245,
            'siswa_aktif'          => 1198,
            'siswa_nonaktif'       => 47,
            'pelanggaran_hari_ini' => 12,
            'total_pelanggaran'    => 328,
            'total_sp'             => 27,
            'sp_aktif'             => 5,
            'sp_selesai'           => 22,
        ];

        $siswaTeratas = [
            ['nis' => '10023', 'nama' => 'Ahmad Fauzan',   'kelas' => '12-1', 'poin' => 76, 'status' => 'SP 2'],
            ['nis' => '10017', 'nama' => 'Rian Aditya',    'kelas' => '11-2', 'poin' => 63, 'status' => 'SP 2'],
            ['nis' => '10045', 'nama' => 'Dwi Ananda',     'kelas' => '12-3', 'poin' => 58, 'status' => 'SP 2'],
            ['nis' => '10011', 'nama' => 'Fajar Ramadhan', 'kelas' => '11-1', 'poin' => 47, 'status' => 'SP 1'],
            ['nis' => '10038', 'nama' => 'Siti Aisyah',    'kelas' => '11-3', 'poin' => 45, 'status' => 'SP 1'],
        ];

        // Nanti diganti dengan Auth::user()
        $user = [
            'nama' => 'Admin',
            'role' => 'Administrator',
        ];

        return view('beranda', [
            'tahunAjaranAktif' => $tahunAjaranAktif,
            'stat'             => $stat,
            'siswaTeratas'     => $siswaTeratas,
            'user'             => $user,
            'tanggalSekarang'  => now()->locale('id')->translatedFormat('l, d F Y'),
        ]);
    }
}
