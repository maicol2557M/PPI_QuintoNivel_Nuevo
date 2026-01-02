<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // 1. Forzar HTTPS en producción (Render)
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        } 

        // 2. Lógica de redirección simplificada
        RedirectIfAuthenticated::redirectUsing(function ($request) {
            if (Auth::check()) {
                $user = Auth::user();
                // Redirigir según el rol
                if ($user && isset($user->rol) && $user->rol === 'Cliente') {
                    return '/home'; // Usamos el string de la URL para evitar errores de Route::has
                }
                return '/dashboard';
            }
            return '/';
        });
    }
}
