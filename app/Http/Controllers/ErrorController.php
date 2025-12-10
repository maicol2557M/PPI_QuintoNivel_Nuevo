<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    /**
     * Muestra un error 403 personalizado con SweetAlert2
     */
    public function show403($message = null)
    {
        $defaultMessage = 'No tiene permiso para acceder a este recurso.';
        $message = $message ?? $defaultMessage;
        
        // Si es una petición AJAX, devolver JSON
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'error' => 'Acceso denegado',
                'message' => $message,
            ], 403);
        }
        
        // Redirigir a la página anterior con el mensaje de error
        return back()->with('error', $message);
    }
}
