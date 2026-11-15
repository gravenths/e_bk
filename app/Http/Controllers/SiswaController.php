<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\SpSetting;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $siswa = $query->with('riwayatPelanggaran.jenisPelanggaran')->orderBy('nama')->paginate(10);
        $kelases = Kelas::where('status', 'Aktif')->orderBy('nama')->get();
        $spLimits = SpSetting::first() ?? (object)['sp1' => 20, 'sp2' => 40, 'sp3' => 60];

        return view('siswa.index', compact('siswa', 'kelases', 'spLimits'));
    }

    public function create()
    {
        $kelases = Kelas::where('status', 'Aktif')->orderBy('nama')->get();
        return view('siswa.create', compact('kelases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string',
            'jk' => 'required|in:L,P',
            'status'     => 'required|in:Aktif,Nonaktif',
            'nama_wali'  => 'nullable|string|max:255',
            'no_wa_wali' => 'nullable|regex:/^(\+?62|0)[0-9]{8,13}$/',
        ]);

        $id = 's' . (Siswa::count() + 1) . substr(time(), -3);

        Siswa::create([
            'id' => $id,
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'jk' => $request->jk,
            'status'     => $request->status,
            'nama_wali'  => $request->nama_wali  ?: null,
            'no_wa_wali' => $request->no_wa_wali ?: null,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show($id)
    {
        $siswa = Siswa::with(['riwayatPelanggaran.jenisPelanggaran', 'suratPeringatan'])->findOrFail($id);
        $spLimits = SpSetting::first() ?? (object)['sp1' => 20, 'sp2' => 40, 'sp3' => 60];

        return view('siswa.show', compact('siswa', 'spLimits'));
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelases = Kelas::where('status', 'Aktif')->orderBy('nama')->get();

        return view('siswa.edit', compact('siswa', 'kelases'));
    }

    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);

        $request->validate([
            'nis' => 'required|unique:siswa,nis,' . $id,
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string',
            'jk' => 'required|in:L,P',
            'status'     => 'required|in:Aktif,Nonaktif',
            'nama_wali'  => 'nullable|string|max:255',
            'no_wa_wali' => 'nullable|regex:/^(\+?62|0)[0-9]{8,13}$/',
        ]);

        $siswa->update($request->only(['nis', 'nama', 'kelas', 'jk', 'status', 'nama_wali', 'no_wa_wali']));

        return redirect()->route('siswa.show', $id)->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
