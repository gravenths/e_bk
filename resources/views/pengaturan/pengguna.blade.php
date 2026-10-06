@extends('layouts.app')

@section('title', 'Pengaturan Pengguna - E-BK')

@section('content')
<h2>Pengaturan Pengguna</h2>
<p style="font-size:13px; color:#666;">Kelola akun Admin dan Guru Bimbingan Konseling (BK).</p>

<div class="flex" style="margin-top:15px;">
    <!-- Form Tambah -->
    <div class="card flex-1">
        <h3>Tambah Pengguna Baru</h3>
        <form action="{{ route('pengaturan.pengguna.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" required placeholder="Nama Pengguna">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="email@sekolah.sch.id">
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="••••••••">
            </div>

            <div class="form-group">
                <label>Peran (Role)</label>
                <select name="role" required>
                    <option value="Guru BK">Guru BK</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Pengguna</button>
        </form>
    </div>

    <!-- Table List -->
    <div class="flex-1" style="flex:2;">
        <h3>Daftar Pengguna</h3>
        <table>
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Peran</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td><strong>{{ $u->name }}</strong></td>
                    <td>{{ $u->email }}</td>
                    <td><span class="badge">{{ $u->role }}</span></td>
                    <td>{{ $u->status }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center;">Belum ada pengguna terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
