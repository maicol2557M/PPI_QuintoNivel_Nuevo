<?php

namespace App\Http\Controllers;

use App\Models\PlazoActuacion; // Asegúrate de tener este modelo
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Usuario;

class ReporteController extends Controller
{
    /**
     * Muestra el reporte de Plazos Críticos (Vencidos y Pendientes).
     */
    public function plazosCriticos()
    {
        // 1. Definir la fecha actual para la lógica de 'Vencido'
        $today = Carbon::today();
        $user = auth()->user();

        // 2. Consulta de Plazos Críticos
        $plazos = PlazoActuacion::whereHas('expediente', function($query) use ($user) {
            // Si el usuario es administrador o asistente, ver todos los expedientes
            if (in_array($user->rol, ['Administrador', 'Asistente'])) {
                return $query;
            }
            // Si es abogado, solo sus expedientes
            return $query->where('abogado_responsable_id', $user->usuario_id);
        })
        // Incluye plazos 'Pendientes' O plazos cuya 'fecha_limite' es anterior a hoy.
        ->where(function ($query) use ($today) {
            $query->where('estado', 'Pendiente')
                ->orWhereDate('fecha_limite', '<', $today);
        })
        // Cargar relaciones necesarias
        ->with(['expediente.abogadoResponsable'])
        ->orderBy('fecha_limite', 'asc') // Plazos más cercanos/vencidos primero
        ->get();

        // 3. Categorizar para la vista
        $reporteData = [
            'vencidos' => $plazos->filter(fn($p) => Carbon::parse($p->fecha_limite)->isBefore($today)),
            'pendientes' => $plazos->filter(fn($p) => Carbon::parse($p->fecha_limite)->isSameDay($today) || Carbon::parse($p->fecha_limite)->isAfter($today)),
        ];

        return view('reportes.plazos_criticos', compact('reporteData'));
    }

    public function cargaCasosPorAbogado()
    {
        // Cargar los usuarios que tienen el rol de 'Abogado' o 'Administrador'
        // y contar el número de expedientes relacionados ('expedientes' es la relación 1:N)
        $cargaCasos = \App\Models\User::whereIn('rol', ['Administrador', 'Abogado'])
            // 'expedientes' debe ser el nombre de la relación hasMany en el modelo Usuario/User
            ->withCount('expedientes')
            ->orderBy('expedientes_count', 'desc') // Ordenar por mayor carga
            ->get();

        // Aquí $cargaCasos es una colección que incluye: nombre, email, rol, y expedientes_count.

        return view('reportes.carga_casos', compact('cargaCasos'));
    }
}
