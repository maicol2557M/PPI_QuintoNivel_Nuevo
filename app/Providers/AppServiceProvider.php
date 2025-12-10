<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
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
        // Configurar la URL de redirección cuando un usuario autenticado
        // intente acceder a rutas destinadas a invitados (middleware 'guest').
        RedirectIfAuthenticated::redirectUsing(function ($request) {
            try {
                if (Auth::check()) {
                    $user = Auth::user();
                    if ($user && isset($user->rol) && $user->rol === 'Cliente') {
                        return route('home');
                    }
                    // Por defecto, redirigir a dashboard si existe
                    if (route('dashboard', [], false)) {
                        return route('dashboard');
                    }
                }
            } catch (\Exception $e) {
                // En caso de error, caemos al fallback '/'
            }

            return '/';
        });
    }
}
