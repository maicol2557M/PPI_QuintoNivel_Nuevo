<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\User;
use App\Models\PlazoActuacion;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProductividadController extends Controller
{
    /**
     * Mostrar reporte de productividad por abogado.
     */
    public function index()
    {
        // Solo Administrador puede ver este reporte
        if (Auth::user()->rol !== 'Administrador') {
            abort(403, 'No tiene permisos para ver este reporte.');
        }

        // Obtener todos los abogados
        $abogados = User::where('rol', 'Abogado')
            ->where('activo', true)
            ->get();

        // Calcular métricas de productividad
        $productividad = $abogados->map(function ($abogado) {
            $expedientes = Expediente::where('abogado_responsable_id', $abogado->usuario_id)->get();

            return [
                'abogado' => $abogado,
                'total_casos' => $expedientes->count(),
                'casos_abiertos' => $expedientes->where('estado_flujo', 'Abierto')->count(),
                'casos_cerrados' => $expedientes->where('estado_flujo', 'Cerrado')->count(),
                'casos_en_litigio' => $expedientes->where('estado_flujo', 'En Litigio')->count(),
                'porcentaje_cierre' => $expedientes->count() > 0
                    ? round(($expedientes->where('estado_flujo', 'Cerrado')->count() / $expedientes->count()) * 100, 2)
                    : 0,
            ];
        })->sortByDesc('casos_cerrados');

        return view('reportes.productividad', compact('productividad'));
    }
}
