<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DocumentoController extends Controller
{
    /**
     * Descargar un documento asociado a un expediente.
     */
    public function download(Documento $documento)
    {
        // Requiere estar autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        try {
            $path = $documento->ruta_archivo;
            if (!Storage::disk('public')->exists($path)) {
                return redirect()->back()->with('error', 'El archivo no existe en el servidor.');
            }

            $fullPath = Storage::disk('public')->path($path);
            return response()->download($fullPath, $documento->nombre_original);
        } catch (\Exception $e) {
            Log::error('Error al descargar documento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No fue posible descargar el archivo.');
        }
    }

    /**
     * Eliminar documento (archivo + registro BD).
     */
    public function destroy(Documento $documento)
    {
        // Solo Administrador o Abogado puede eliminar documentos
        if (!Auth::check() || !in_array(Auth::user()->rol, ['Administrador', 'Abogado'])) {
            abort(403, 'No tiene permiso para eliminar este documento.');
        }

        try {
            $path = $documento->ruta_archivo;
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            $documento->delete();

            return redirect()->back()->with('success', 'Documento eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar documento: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No fue posible eliminar el documento.');
        }
    }
}
