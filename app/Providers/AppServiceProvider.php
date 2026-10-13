<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\TahunAjaran;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gunakan template Bootstrap 5 untuk pagination (bukan Tailwind default)
        Paginator::useBootstrapFive();

        // Bagikan data Tahun Ajaran Aktif ke semua halaman yang memakai layouts.app
        // sehingga header selalu menampilkan tahun ajaran yang benar tanpa perlu
        // masing-masing controller meneruskan variabel ini.
        View::composer('layouts.app', function ($view) {
            $ta = TahunAjaran::where('status', 'Aktif')->first();
            $view->with('tahunAjaranAktif', $ta
                ? ['nama' => $ta->tahun . ' - ' . $ta->semester]
                : ['nama' => '-']);
        });
    }
}
