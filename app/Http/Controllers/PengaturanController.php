<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAjaran;
use App\Models\SpSetting;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
    // Tahun Ajaran
    public function tahunAjaran()
    {
        $tahunList = TahunAjaran::orderBy('tahun', 'desc')->get();
        return view('pengaturan.tahun-ajaran', compact('tahunList'));
    }

    public function storeTahun(Request $request)
    {
        $request->validate([
            'tahun' => 'required|string',
            'semester' => 'required|in:Ganjil,Genap',
        ]);

        $id = 'ta' . (TahunAjaran::count() + 1) . substr(time(), -3);

        TahunAjaran::create([
            'id' => $id,
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'status' => 'Nonaktif',
        ]);

        return redirect()->route('pengaturan.tahun-ajaran')->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function setTahunAktif($id)
    {
        TahunAjaran::query()->update(['status' => 'Nonaktif']);
        $ta = TahunAjaran::findOrFail($id);
        $ta->status = 'Aktif';
        $ta->save();

        return redirect()->route('pengaturan.tahun-ajaran')->with('success', "Tahun ajaran {$ta->tahun} ({$ta->semester}) ditetapkan sebagai Aktif.");
    }

    // Batas SP
    public function batasSp()
    {
        $spLimits = SpSetting::first() ?? SpSetting::create(['sp1' => 20, 'sp2' => 40, 'sp3' => 60]);
        return view('pengaturan.batas-sp', compact('spLimits'));
    }

    public function updateBatasSp(Request $request)
    {
        $request->validate([
            'sp1' => 'required|integer|min:1',
            'sp2' => 'required|integer|gt:sp1',
            'sp3' => 'required|integer|gt:sp2',
        ]);

        $spLimits = SpSetting::first() ?? new SpSetting();
        $spLimits->sp1 = $request->sp1;
        $spLimits->sp2 = $request->sp2;
        $spLimits->sp3 = $request->sp3;
        $spLimits->save();

        return redirect()->route('pengaturan.batas-sp')->with('success', 'Batas Poin Surat Peringatan berhasil diperbarui.');
    }

    // Data Kelas
    public function kelas()
    {
        $kelases = Kelas::orderBy('tingkat')->orderBy('nama')->get();
        return view('pengaturan.kelas', compact('kelases'));
    }

    public function storeKelas(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|unique:kelas,nama',
            'tingkat' => 'required|integer|in:10,11,12',
        ]);

        $id = 'k' . (Kelas::count() + 1) . substr(time(), -3);

        Kelas::create([
            'id' => $id,
            'nama' => $request->nama,
            'tingkat' => $request->tingkat,
            'status' => 'Aktif',
        ]);

        return redirect()->route('pengaturan.kelas')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function updateKelas(Request $request, $id)
    {
        $k = Kelas::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|unique:kelas,nama,' . $id,
            'tingkat' => 'required|integer|in:10,11,12',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $k->update($request->only(['nama', 'tingkat', 'status']));

        return redirect()->route('pengaturan.kelas')->with('success', 'Data kelas berhasil diperbarui.');
    }

    // Pengguna
    public function pengguna()
    {
        $users = User::orderBy('name')->get();
        return view('pengaturan.pengguna', compact('users'));
    }

    public function storePengguna(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:Admin,Guru BK',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $id = 'u' . (User::count() + 1) . substr(time(), -3);

        User::create([
            'id' => $id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('pengaturan.pengguna')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function updatePengguna(Request $request, $id)
    {
        $u = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:Admin,Guru BK',
            'status' => 'required|in:Aktif,Nonaktif',
        ]);

        $u->name = $request->name;
        $u->email = $request->email;
        $u->role = $request->role;
        $u->status = $request->status;

        if ($request->filled('password')) {
            $u->password = Hash::make($request->password);
        }

        $u->save();

        return redirect()->route('pengaturan.pengguna')->with('success', 'Data pengguna berhasil diperbarui.');
    }
}
