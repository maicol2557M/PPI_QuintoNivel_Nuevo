<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route; // ESTA LÍNEA ES VITAL
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

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
        /**
         * 1. Forzar HTTPS en Render para arreglar CSS/JS
         */
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }

        /**
         * 2. Configurar la URL de redirección
         */
        RedirectIfAuthenticated::redirectUsing(function ($request) {
            try {
                if (Auth::check()) {
                    $user = Auth::user();
                    
                    if ($user && isset($user->rol) && $user->rol === 'Cliente') {
                        return route('home');
                    }
                    
                    if (Route::has('dashboard')) {
                        return route('dashboard');
                    }
                }
            } catch (\Exception $e) {
                // Error silencioso
            }

            return '/';
        });
    }
}
