<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckClientAccess
{
    /**
     * Redirige clientes a la página pública si intentan acceder a áreas administrativas.
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->rol === 'Cliente') {
            return redirect()->route('home')
                ->with('info', 'Los clientes no tienen acceso al área administrativa.');
        }

        return $next($request);
    }
}
