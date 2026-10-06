<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\SuratPeringatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\KenaikanKelasController;

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected App Routes
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Data Siswa
    Route::prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/', [SiswaController::class, 'index'])->name('index');
        Route::get('/tambah', [SiswaController::class, 'create'])->name('create');
        Route::post('/', [SiswaController::class, 'store'])->name('store');
        Route::get('/{id}', [SiswaController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [SiswaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [SiswaController::class, 'update'])->name('update');
        Route::delete('/{id}', [SiswaController::class, 'destroy'])->name('destroy');
    });

    // Data Pelanggaran
    Route::prefix('pelanggaran')->name('pelanggaran.')->group(function () {
        Route::get('/', [PelanggaranController::class, 'index'])->name('index');
        Route::post('/jenis', [PelanggaranController::class, 'storeJenis'])->name('jenis.store');
        Route::put('/jenis/{id}', [PelanggaranController::class, 'updateJenis'])->name('jenis.update');

        Route::get('/riwayat', [PelanggaranController::class, 'riwayat'])->name('riwayat');
        Route::get('/tambah', [PelanggaranController::class, 'tambah'])->name('tambah');
        Route::post('/riwayat', [PelanggaranController::class, 'storeRiwayat'])->name('riwayat.store');
        Route::delete('/riwayat/{id}', [PelanggaranController::class, 'destroyRiwayat'])->name('riwayat.destroy');
    });

    // Surat Peringatan
    Route::prefix('surat-peringatan')->name('surat-peringatan.')->group(function () {
        Route::get('/', [SuratPeringatanController::class, 'index'])->name('index');
        Route::post('/', [SuratPeringatanController::class, 'store'])->name('store');
        Route::get('/riwayat', [SuratPeringatanController::class, 'riwayat'])->name('riwayat');
        Route::get('/{id}/cetak', [SuratPeringatanController::class, 'cetak'])->name('cetak');
    });

    // Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/pelanggaran', [LaporanController::class, 'pelanggaran'])->name('pelanggaran');
        Route::get('/poin', [LaporanController::class, 'poin'])->name('poin');
        Route::get('/surat', [LaporanController::class, 'surat'])->name('surat');
    });

    // Pengaturan
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
        Route::get('/tahun-ajaran', [PengaturanController::class, 'tahunAjaran'])->name('tahun-ajaran');
        Route::post('/tahun-ajaran', [PengaturanController::class, 'storeTahun'])->name('tahun-ajaran.store');
        Route::post('/tahun-ajaran/{id}/aktif', [PengaturanController::class, 'setTahunAktif'])->name('tahun-ajaran.aktif');

        Route::get('/batas-sp', [PengaturanController::class, 'batasSp'])->name('batas-sp');
        Route::post('/batas-sp', [PengaturanController::class, 'updateBatasSp'])->name('batas-sp.update');

        Route::get('/kelas', [PengaturanController::class, 'kelas'])->name('kelas');
        Route::post('/kelas', [PengaturanController::class, 'storeKelas'])->name('kelas.store');
        Route::put('/kelas/{id}', [PengaturanController::class, 'updateKelas'])->name('kelas.update');

        Route::get('/pengguna', [PengaturanController::class, 'pengguna'])->name('pengguna');
        Route::post('/pengguna', [PengaturanController::class, 'storePengguna'])->name('pengguna.store');
        Route::put('/pengguna/{id}', [PengaturanController::class, 'updatePengguna'])->name('pengguna.update');
    });

    // Kenaikan Kelas
    Route::get('/kenaikan-kelas', [KenaikanKelasController::class, 'index'])->name('kenaikan-kelas.index');
    Route::post('/kenaikan-kelas/proses', [KenaikanKelasController::class, 'proses'])->name('kenaikan-kelas.proses');
});
