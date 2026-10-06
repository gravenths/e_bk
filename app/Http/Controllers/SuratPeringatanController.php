<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\SuratPeringatan;
use App\Models\SpSetting;

class SuratPeringatanController extends Controller
{
    // Siswa Memenuhi Batas SP
    public function index()
    {
        $spLimits = SpSetting::first() ?? (object)['sp1' => 20, 'sp2' => 40, 'sp3' => 60];

        $siswaAktif = Siswa::where('status', 'Aktif')
            ->with(['riwayatPelanggaran.jenisPelanggaran', 'suratPeringatan'])
            ->get();

        $daftarKandidat = [];

        foreach ($siswaAktif as $s) {
            $poin = $s->total_poin;
            if ($poin >= $spLimits->sp1) {
                // Determine highest eligible SP status
                $statusSP = 'SP 1';
                if ($poin >= $spLimits->sp3) {
                    $statusSP = 'SP 3';
                } elseif ($poin >= $spLimits->sp2) {
                    $statusSP = 'SP 2';
                }

                // Check if already issued
                $sudahDiterbitkan = $s->suratPeringatan->contains('jenis_sp', $statusSP);
                $suratTerakhir = $s->suratPeringatan->sortByDesc('tanggal')->first();

                $daftarKandidat[] = (object) [
                    'siswa' => $s,
                    'total_poin' => $poin,
                    'jenis_sp' => $statusSP,
                    'sudah_diterbitkan' => $sudahDiterbitkan,
                    'surat_terakhir' => $suratTerakhir,
                ];
            }
        }

        return view('surat-peringatan.index', compact('daftarKandidat', 'spLimits'));
    }

    // Terbitkan SP
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_sp' => 'required|in:SP 1,SP 2,SP 3',
            'tanggal' => 'required|date',
            'nomor_surat' => 'nullable|string',
        ]);

        $count = SuratPeringatan::count() + 1;
        $nomorSurat = $request->nomor_surat ?: ('421/' . str_pad($count, 3, '0', STR_PAD_LEFT));
        $id = 'sp' . $count . substr(time(), -3);

        SuratPeringatan::create([
            'id' => $id,
            'tanggal' => $request->tanggal,
            'siswa_id' => $request->siswa_id,
            'jenis_sp' => $request->jenis_sp,
            'nomor_surat' => $nomorSurat,
        ]);

        return redirect()->route('surat-peringatan.riwayat')->with('success', "Surat Peringatan {$request->jenis_sp} berhasil diterbitkan.");
    }

    // Riwayat Surat Peringatan
    public function riwayat(Request $request)
    {
        $query = SuratPeringatan::with(['siswa']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            })->orWhere('nomor_surat', 'like', "%{$search}%");
        }

        if ($request->filled('jenis_sp')) {
            $query->where('jenis_sp', $request->jenis_sp);
        }

        $suratList = $query->orderBy('tanggal', 'desc')->paginate(15);

        return view('surat-peringatan.riwayat', compact('suratList'));
    }

    // Cetak Surat SP
    public function cetak($id)
    {
        $surat = SuratPeringatan::with(['siswa.riwayatPelanggaran.jenisPelanggaran'])->findOrFail($id);
        $spLimits = SpSetting::first() ?? (object)['sp1' => 20, 'sp2' => 40, 'sp3' => 60];

        return view('surat-peringatan.cetak', compact('surat', 'spLimits'));
    }
}
