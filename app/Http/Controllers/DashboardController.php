<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Documento;
use App\Models\PlazoActuacion;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard del usuario.
     */
    public function index()
    {
        $user = Auth::user();
        $data = [];

        // Métricas generales
        $data['totalExpedientes'] = Expediente::count();
        $data['expedientesActivos'] = Expediente::where('estado_flujo', 'Abierto')->count();
        $data['totalDocumentos'] = Documento::count();

        // Plazos críticos: próximos 7 días
        $proximosSieteDias = Carbon::now()->addDays(7);
        $data['plazosCriticos'] = PlazoActuacion::whereBetween('fecha_limite', [
            Carbon::now(),
            $proximosSieteDias
        ])->count();

        // Mis expedientes (asignados al usuario actual)
        if ($user->rol === 'Abogado' || $user->rol === 'Administrador') {
            $data['misExpedientes'] = Expediente::where('abogado_responsable_id', $user->usuario_id)->count();
        }

        return view('dashboard', $data);
    }
}
