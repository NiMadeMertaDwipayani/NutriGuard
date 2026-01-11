<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\Ingredient; // Tambahan
use App\Models\Disease; // <--- Tambahan
use App\Models\User;    // <--- Tambahan
use App\Observers\IngredientObserver; // Tambahan
use App\Observers\DiseaseObserver; // <--- Tambahan
use App\Observers\UserObserver;    // <--- Tambahan

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
        //Paksa HTTPS (Agar CSS tidak rusak di Ngrok)
        if (request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme('https');
        }

        // PAKSA URL UTAMA (Solusi Masalah Email Anda)
        // Ini memaksa Laravel menggunakan link Ngrok yang tertulis di .env
        // sebagai basis semua link yang digenerate (termasuk link email).
        if (config('app.url')) {
            URL::forceRootUrl(config('app.url'));
        }

        Ingredient::observe(IngredientObserver::class); // Nyalakan CCTV
        Disease::observe(DiseaseObserver::class); // <--- Aktifkan CCTV Penyakit
        User::observe(UserObserver::class);       // <--- Aktifkan CCTV User

    }
}
