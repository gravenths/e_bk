<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPelanggaran;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class PelanggaranController extends Controller
{
    // Master Jenis Pelanggaran
    public function index(Request $request)
    {
        $query = JenisPelanggaran::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%");
        }

        $jenisPelanggaran = $query->orderBy('nama')->get();

        return view('pelanggaran.index', compact('jenisPelanggaran'));
    }

    public function storeJenis(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'poin' => 'required|integer|min:1',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $id = 'jp' . (JenisPelanggaran::count() + 1) . substr(time(), -3);

        JenisPelanggaran::create([
            'id' => $id,
            'nama' => $request->nama,
            'poin' => $request->poin,
            'status' => $request->status,
        ]);

        return redirect()->route('pelanggaran.index')->with('success', 'Jenis pelanggaran berhasil ditambahkan.');
    }

    public function updateJenis(Request $request, $id)
    {
        $jp = JenisPelanggaran::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'poin' => 'required|integer|min:1',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $jp->update($request->only(['nama', 'poin', 'status']));

        return redirect()->route('pelanggaran.index')->with('success', 'Jenis pelanggaran berhasil diperbarui.');
    }

    // Riwayat Pelanggaran
    public function riwayat(Request $request)
    {
        $query = RiwayatPelanggaran::with(['siswa', 'jenisPelanggaran']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kelas')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        if ($request->filled('pencatat')) {
            $query->where('pencatat', $request->pencatat);
        }

        $riwayat = $query->orderBy('tanggal', 'desc')->orderBy('created_at', 'desc')->paginate(15);
        $kelases = Kelas::where('status', 'Aktif')->orderBy('nama')->get();

        return view('pelanggaran.riwayat', compact('riwayat', 'kelases'));
    }

    // Form Catat Pelanggaran
    public function tambah()
    {
        $siswaList = Siswa::where('status', 'Aktif')->orderBy('nama')->get();
        $jenisList = JenisPelanggaran::where('status', 'Aktif')->orderBy('nama')->get();

        return view('pelanggaran.tambah', compact('siswaList', 'jenisList'));
    }

    public function storeRiwayat(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'siswa_id' => 'required|exists:siswa,id',
            'pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'keterangan' => 'nullable|string',
        ]);

        $id = 'r' . (RiwayatPelanggaran::count() + 1) . substr(time(), -3);
        $pencatat = Auth::check() ? Auth::user()->role : 'Guru BK';

        RiwayatPelanggaran::create([
            'id' => $id,
            'tanggal' => $request->tanggal,
            'siswa_id' => $request->siswa_id,
            'pelanggaran_id' => $request->pelanggaran_id,
            'keterangan' => $request->keterangan ?? '-',
            'pencatat' => $pencatat,
        ]);

        return redirect()->route('pelanggaran.riwayat')->with('success', 'Catatan pelanggaran siswa berhasil disimpan.');
    }

    public function destroyRiwayat($id)
    {
        $riwayat = RiwayatPelanggaran::findOrFail($id);
        $riwayat->delete();

        return redirect()->route('pelanggaran.riwayat')->with('success', 'Riwayat pelanggaran berhasil dihapus.');
    }
}
