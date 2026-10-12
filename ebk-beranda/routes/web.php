<?php

use App\Http\Controllers\BerandaController;
use Illuminate\Support\Facades\Route;

// Sementara tanpa login. Setelah authentication jadi, bungkus dengan middleware('auth').
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
