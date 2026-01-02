<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Import URL facade
use Illuminate\Support\Facades\URL;

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
        // Tambahkan baris ini untuk memaksa HTTPS jika menggunakan Dev Tunnel
        if (str_contains(request()->getHost(), 'devtunnels.ms')) {
            URL::forceScheme('https');
        }
    }
}