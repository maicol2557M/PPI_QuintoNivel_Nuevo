<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
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
         * Forzar HTTPS en Render
         * Esto soluciona el problema de estilos CSS y JS que no cargan.
         */
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }

        /**
         * Configurar la URL de redirección cuando un usuario autenticado
         * intente acceder a rutas destinadas a invitados (middleware 'guest').
         */
        RedirectIfAuthenticated::redirectUsing(function ($request) {
            try {
                if (Auth::check()) {
                    $user = Auth::user();
                    if ($user && isset($user->rol) && $user->rol === 'Cliente') {
                        return route('home');
                    }
                    
                    // Verificamos si la ruta 'dashboard' existe antes de redirigir
                    if (\Route::has('dashboard')) {
                        return route('dashboard');
                    }
                }
            } catch (\Exception $e) {
                // Log del error si es necesario: \Log::error($e->getMessage());
            }

            return '/';
        });
    }
}
