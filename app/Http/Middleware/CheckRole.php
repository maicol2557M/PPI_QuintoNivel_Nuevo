<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Si el usuario no está autenticado, redirigir al login
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'No autenticado'], 401);
            }
            return redirect('/login');
        }

        $user = Auth::user();
        $userRole = $user ? $user->rol : null;

        // Si no se especificaron roles, permitir el acceso
        if (empty($roles)) {
            return $next($request);
        }

        // Verificar si el rol del usuario está entre los roles permitidos
        foreach ($roles as $role) {
            if ($userRole === $role) {
                return $next($request);
            }
        }

        // Si el usuario es administrador, permitir acceso a todo
        if ($userRole === 'Administrador') {
            return $next($request);
        }

        // Si es asistente, verificar permisos especiales
        if ($userRole === 'Asistente') {
            // Permitir ver todos los expedientes
            if ($request->is('expedientes') || $request->is('expedientes/*')) {
                // No permitir crear, editar o eliminar expedientes
                if ($request->isMethod('post') || $request->isMethod('put') || 
                    $request->isMethod('patch') || $request->isMethod('delete')) {
                    if (strpos($request->path(), 'documentos/') === 0 && $request->isMethod('delete')) {
                        abort(403, 'No tiene permiso para eliminar documentos.');
                    }
                    if ($request->is('expedientes/create') || 
                        strpos($request->path(), 'expedientes/') === 0 && 
                        ($request->isMethod('put') || $request->isMethod('delete'))) {
                        abort(403, 'No tiene permiso para realizar esta acción.');
                    }
                }
                return $next($request);
            }
            
            // Permitir ver plazos críticos
            if ($request->is('reportes/plazos-criticos')) {
                return $next($request);
            }
            
            // Permitir ver y crear usuarios (solo abogados)
            if ($request->is('usuarios') || $request->is('usuarios/create')) {
                return $next($request);
            }
        }

        // Si no tiene permiso, mostrar error 403 personalizado
        $message = 'No tiene permiso para acceder a este recurso.';
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'error' => 'Acceso denegado',
                'message' => $message,
            ], 403);
        }
        
        // Redirigir a la ruta de error 403 personalizada
        return app(\App\Http\Controllers\ErrorController::class)->show403($message);
    }
}
