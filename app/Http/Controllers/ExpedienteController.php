<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Persona;
use App\Models\Documento;
use App\Http\Requests\StoreExpedienteRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExpedienteController extends Controller
{
    // Muestra una lista de expedientes
    public function index()
    {
        $user = auth()->user();
        $query = Expediente::with(['partes', 'plazosActuaciones', 'documentos', 'abogadoResponsable']);

        // Solo los abogados ven sus propios expedientes
        if ($user->rol === 'Abogado') {
            $query->where('abogado_responsable_id', $user->usuario_id);
        }
        // Los asistentes y administradores ven todos los expedientes sin filtro

        // Filtro por búsqueda (N° Interno o Juzgado)
        if (request()->has('search') && !empty(request('search'))) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('num_expediente_interno', 'like', "%{$search}%")
                  ->orWhere('juzgado_tribunal', 'like', "%{$search}%");
            });
        }

        // Filtro por abogado (solo para administradores)
        if (Auth::user()->rol === 'Administrador' && request()->has('abogado_id')) {
            $query->where('abogado_responsable_id', request('abogado_id'));
        }
        // Si es Abogado, mostrar solo sus expedientes
        // Los asistentes y administradores ven todos los expedientes
        elseif (Auth::user()->rol === 'Abogado') {
            $query->where('abogado_responsable_id', Auth::id());
        }

        // Ordenamiento
        $sortBy = request('sort', 'fecha_inicio');
        $sortOrder = request('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Paginación
        $expedientes = $query->paginate(15)->withQueryString();

        return view('expedientes.index', compact('expedientes'));
    }

    // Muestra el formulario para crear un nuevo expediente
    public function create()
    {
        return view('expedientes.create');
    }

    /**
     * Almacena un nuevo Expediente, sus Partes (M:N), Plazos (1:M) y Documentos (1:M) de forma transaccional.
     */
    public function store(StoreExpedienteRequest $request)
    {
        // 1. INICIAR TRANSACCIÓN
        DB::beginTransaction();
        try {
            \Log::info('Iniciando proceso de guardado de expediente', ['data' => $request->all()]);

            // 2. CREAR EXPEDIENTE PRINCIPAL
            $expedienteData = $request->only([
                'num_expediente_interno', 
                'num_judicial', 
                'juzgado_tribunal',
                'materia', 
                'tipo_procedimiento', 
                'fecha_inicio', 
                'estado_flujo',
                'cuantia', 
                'resumen_asunto', 
                'fecha_ultima_actuacion',
                'ubicacion_archivo', 
                'observaciones_internas',
            ]);

            // Asegurarse que el abogado responsable sea el usuario autenticado
            $expedienteData['abogado_responsable_id'] = Auth::id();

            \Log::info('Datos del expediente a guardar:', $expedienteData);
            
            // Crear el expediente
            $expediente = Expediente::create($expedienteData);
            \Log::info('Expediente creado con ID: ' . $expediente->expediente_id);

            // En el método store, reemplazar la sección de partes con:
            if (!empty($request->partes)) {
                $partesToAttach = [];
                foreach ($request->partes as $parte) {
                    if (empty($parte['nombre_razonsocial'])) {
                        throw new \Exception("El campo 'Nombre/Razón Social' es obligatorio para todas las partes.");
                    }

                    $persona = Persona::firstOrCreate(
                        ['ruc_cc' => $parte['ruc_cc']],
                        [
                            'ruc_cc' => $parte['ruc_cc'],
                            'nombre_razonsocial' => $parte['nombre_razonsocial'],
                            'telefono' => $parte['telefono'] ?? null,
                            'email' => $parte['email'] ?? null,
                            'domicilio_completo' => $parte['domicilio_completo'] ?? null,
                            'tipo_persona' => $parte['tipo_persona'] ?? 'Física'
                        ]
                    );

                    $partesToAttach[$persona->persona_id] = [
                        'rol_en_caso' => $parte['rol_en_caso'],
                        'posicion_procesal' => $parte['posicion_procesal'],
                    ];
                }
                $expediente->partes()->sync($partesToAttach);
            }

            // 4. PROCESAR PLAZOS Y ACTUACIONES (1:M)
            if (!empty($request->plazos)) {
                \Log::info('Procesando plazos en store:', $request->plazos);
                
                foreach ($request->plazos as $plazoData) {
                    \Log::info('Datos del plazo a guardar en store:', $plazoData);
                    
                    // Mapear campos del formulario a los campos de la base de datos
                    $datosPlazo = [
                        'descripcion_actuacion' => $plazoData['descripcion_actuacion'] ?? $plazoData['descripcion'] ?? 'Sin descripción',
                        'fecha_limite' => $plazoData['fecha_limite'] ?? null,
                        'responsable' => $plazoData['responsable'] ?? 'No especificado',
                        'estado' => $plazoData['estado'] ?? 'Pendiente',
                        'notas' => $plazoData['notas'] ?? $plazoData['observaciones'] ?? null,
                    ];
                    
                    // Validar que la fecha límite no sea nula
                    if (empty($datosPlazo['fecha_limite'])) {
                        \Log::error('Error en store: fecha_limite es requerida', ['plazo' => $plazoData]);
                        throw new \Exception("La fecha límite es requerida para todos los plazos.");
                    }
                    
                    // Validar el formato de la fecha
                    try {
                        $fechaValidada = \Carbon\Carbon::parse($datosPlazo['fecha_limite']);
                        $datosPlazo['fecha_limite'] = $fechaValidada->format('Y-m-d');
                    } catch (\Exception $e) {
                        \Log::error('Formato de fecha inválido en store', [
                            'fecha' => $datosPlazo['fecha_limite'],
                            'error' => $e->getMessage()
                        ]);
                        throw new \Exception("El formato de la fecha límite no es válido. Use el formato AAAA-MM-DD.");
                    }
                    
                    // Crear el plazo
                    $expediente->plazosActuaciones()->create($datosPlazo);
                }
                \Log::info('Plazos procesados correctamente en store');
            }

            // 5. PROCESAR DOCUMENTOS DIGITALES (1:M)
            if ($request->hasFile('documentos')) {
                $documentosMetadata = [];
                $descripcionGeneral = $request->input('descripcion_documentos') ?? 'Documento adjunto en la creación del expediente.';

                foreach ($request->file('documentos') as $file) {
                    $ruta_relativa = $file->store('expedientes/' . $expediente->expediente_id, 'public');

                    $documentosMetadata[] = [
                        'nombre_original' => $file->getClientOriginalName(),
                        'ruta_archivo' => $ruta_relativa,
                        'tipo_mime' => $file->getClientMimeType(),
                        'tamano_bytes' => $file->getSize(),
                        'descripcion' => $descripcionGeneral,
                    ];
                }

                $expediente->documentos()->createMany($documentosMetadata);
                \Log::info('Documentos procesados correctamente');
            }

            // Si todo sale bien, hacer commit de la transacción
            DB::commit();
            \Log::info('Expediente creado exitosamente', ['expediente_id' => $expediente->expediente_id]);
            
            return redirect()->route('expedientes.show', $expediente->expediente_id)
                            ->with('success', 'Expediente creado correctamente.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            // Registrar el error completo para depuración
            $errorMessage = $e->getMessage();
            $errorDetails = [
                'exception' => get_class($e),
                'message' => $errorMessage,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'input' => $request->except(['_token', 'documentos'])
            ];
            
            \Log::error('Error al crear el expediente', $errorDetails);
            
            // Mensaje de error más amigable
            $userFriendlyMessage = $errorMessage;
            
            // Detectar errores comunes
            if (str_contains($errorMessage, 'SQLSTATE[23502]')) {
                if (str_contains($errorMessage, 'fecha_vencimiento')) {
                    $userFriendlyMessage = 'La fecha de vencimiento es obligatoria para todos los plazos.';
                } elseif (str_contains($errorMessage, 'num_expediente_interno')) {
                    $userFriendlyMessage = 'El número de expediente interno ya existe o es inválido.';
                } else {
                    $userFriendlyMessage = 'Faltan campos obligatorios en el formulario. Por favor, verifica la información.';
                }
            } elseif (str_contains($errorMessage, 'SQLSTATE[23505]')) {
                $userFriendlyMessage = 'Error de duplicado: Ya existe un registro con estos datos. Verifica la información e inténtalo de nuevo.';
            } elseif (str_contains($errorMessage, 'SQLSTATE[HY000]') || str_contains($errorMessage, 'Connection')) {
                $userFriendlyMessage = 'Error de conexión con la base de datos. Por favor, inténtalo de nuevo más tarde.';
            }
            
            return back()
                ->withInput()
                ->with('error', $userFriendlyMessage)
                ->with('error_details', $errorDetails);
        }
    }

    /**
     * Muestra el detalle de un expediente específico.
     */
    public function show(Expediente $expediente)
    {
        // Cargar las relaciones necesarias
        $expediente->load([
            'documentos',
            'partes',
            'plazosActuaciones',
            'abogadoResponsable',
        ]);

        return view('expedientes.show', compact('expediente'));
    }

    /**
     * Muestra el formulario para editar un expediente.
     */
    public function edit(Expediente $expediente)
    {
        $expediente->load([
            'partes',
            'plazosActuaciones',
            'documentos',
        ]);
        
        return view('expedientes.edit', compact('expediente'));
    }

    /**
     * Actualiza un expediente existente.
     */
    public function update(Request $request, Expediente $expediente)
    {
        // Normalizar la codificación de caracteres en la solicitud
        $request->merge(collect($request->all())->map(function($value) {
            if (is_string($value)) {
                // Convertir de Windows-1252 a UTF-8 si es necesario
                if (!mb_check_encoding($value, 'UTF-8')) {
                    return mb_convert_encoding($value, 'UTF-8', 'Windows-1252');
                }
                return $value;
            }
            if (is_array($value)) {
                return array_map(function($item) {
                    if (is_string($item)) {
                        return mb_convert_encoding($item, 'UTF-8', 'Windows-1252');
                    }
                    return $item;
                }, $value);
            }
            return $value;
        })->all());

        \Log::info('Iniciando actualización de expediente', ['expediente_id' => $expediente->expediente_id]);
        \Log::info('Datos recibidos (después de normalización):', $request->except(['_token', '_method']));

        // Validar los datos
        $validated = $request->validate([
            'num_expediente_interno' => 'required|string|max:50|unique:expedientes,num_expediente_interno,' . $expediente->expediente_id . ',expediente_id',
            'num_judicial' => 'nullable|string|max:50',
            'juzgado_tribunal' => 'required|string|max:100',
            'materia' => 'required|string|max:50',
            'tipo_procedimiento' => 'required|string|max:50',
            'fecha_inicio' => 'required|date',
            'estado_flujo' => 'required|in:Abierto,En Litigio,Suspendido,Cerrado,Archivado',
            'cuantia' => 'nullable|numeric|between:0,9999999999999.99',
            'resumen_asunto' => 'nullable|string',
            'fecha_ultima_actuacion' => 'nullable|date|after_or_equal:fecha_inicio',
            'ubicacion_archivo' => 'nullable|string|max:100',
            'observaciones_internas' => 'nullable|string',
        ]);

        // Iniciar transacción
        DB::beginTransaction();
        try {
            // Actualizar el expediente
            $expediente->update($validated);
            \Log::info('Datos básicos del expediente actualizados');

            // Actualizar partes si existen
            if ($request->has('partes')) {
                $partesData = [];
                foreach ($request->partes as $parte) {
                    $persona = Persona::updateOrCreate(
                        ['ruc_cc' => $parte['ruc_cc']],
                        [
                            'nombre_razonsocial' => $parte['nombre_razonsocial'],
                            'tipo_persona' => $parte['tipo_persona'] ?? 'Física',
                            'telefono' => $parte['telefono'] ?? null,
                            'email' => $parte['email'] ?? null,
                            'domicilio_completo' => $parte['domicilio_completo'] ?? null,
                        ]
                    );

                    $partesData[$persona->persona_id] = [
                        'rol_en_caso' => $parte['rol_en_caso'] ?? 'No especificado',
                        'posicion_procesal' => $parte['posicion_procesal'] ?? 'No especificada',
                    ];
                }
                $expediente->partes()->sync($partesData);
                \Log::info('Partes actualizadas correctamente');
            }

            // Actualizar plazos si existen
            if ($request->has('plazos')) {
                \Log::info('Procesando plazos:', $request->plazos);
                
                // Eliminar plazos existentes
                $expediente->plazosActuaciones()->delete();
                
                // Crear nuevos plazos
                foreach ($request->plazos as $plazoData) {
                    \Log::info('Datos del plazo a guardar:', $plazoData);
                    
                    // Normalizar el formato de la fecha
                    $fechaVencimiento = null;
                    
                    // Verificar y formatear la fecha de vencimiento
                    if (!empty($plazoData['fecha_vencimiento'])) {
                        $fechaVencimiento = $plazoData['fecha_vencimiento'];
                    } elseif (!empty($plazoData['fecha_limite'])) {
                        $fechaVencimiento = $plazoData['fecha_limite'];
                    }
                    
                    // Validar que la fecha tenga un formato correcto
                    try {
                        $fechaValidada = \Carbon\Carbon::parse($fechaVencimiento)->format('Y-m-d');
                    } catch (\Exception $e) {
                        \Log::error('Formato de fecha inválido', [
                            'fecha' => $fechaVencimiento,
                            'error' => $e->getMessage()
                        ]);
                        throw new \Exception("El formato de la fecha de vencimiento no es válido. Use el formato AAAA-MM-DD.");
                    }
                    
                    if (empty($fechaVencimiento)) {
                        \Log::error('Error: fecha_vencimiento es requerido', ['plazo' => $plazoData]);
                        throw new \Exception("La fecha límite es requerida para todos los plazos.");
                    }
                    
                    $expediente->plazosActuaciones()->create([
                        'descripcion_actuacion' => $plazoData['descripcion_actuacion'] ?? $plazoData['descripcion'] ?? 'Sin descripción',
                        'fecha_limite' => $fechaValidada, // Changed from fecha_vencimiento to fecha_limite
                        'responsable' => $plazoData['responsable'] ?? 'No especificado',
                        'estado' => $plazoData['estado'] ?? 'Pendiente',
                        'notas' => $plazoData['observaciones'] ?? $plazoData['notas'] ?? null, // Changed from observaciones to notas
                    ]);
                }
                \Log::info('Plazos actualizados correctamente');
            }
            // Procesar documentos si se adjuntaron
            if ($request->hasFile('documentos')) {
                foreach ($request->file('documentos') as $file) {
                    $path = $file->store('documentos', 'public');
                    $expediente->documentos()->create([
                        'nombre_original' => $file->getClientOriginalName(),
                        'ruta_archivo' => $path,
                        'tipo_mime' => $file->getMimeType(),
                        'tamano_bytes' => $file->getSize(),
                    ]);
                }
                \Log::info('Documentos procesados correctamente');
            }

            DB::commit();
            \Log::info('Expediente actualizado exitosamente', ['expediente_id' => $expediente->expediente_id]);
            
            // Forzar la recarga de las relaciones
            $expediente->load(['partes', 'plazosActuaciones', 'documentos']);
            
            return redirect()->route('expedientes.show', $expediente->expediente_id)
                            ->with('success', 'Expediente actualizado correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Registrar el error completo para depuración
            $errorMessage = $e->getMessage();
            $errorDetails = [
                'exception' => get_class($e),
                'message' => $errorMessage,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'input' => $request->except(['_token', '_method'])
            ];
            
            \Log::error('Error al actualizar el expediente', $errorDetails);
            
            // Mensaje de error más amigable
            $userFriendlyMessage = $errorMessage;
            
            // Detectar errores comunes
            if (str_contains($errorMessage, 'SQLSTATE[23502]')) {
                if (str_contains($errorMessage, 'fecha_vencimiento')) {
                    $userFriendlyMessage = 'La fecha de vencimiento es obligatoria para todos los plazos.';
                } elseif (str_contains($errorMessage, 'num_expediente_interno')) {
                    $userFriendlyMessage = 'El número de expediente interno ya existe o es inválido.';
                } else {
                    $userFriendlyMessage = 'Faltan campos obligatorios en el formulario. Por favor, verifica la información.';
                }
            } elseif (str_contains($errorMessage, 'SQLSTATE[23505]')) {
                $userFriendlyMessage = 'Error de duplicado: Ya existe un registro con estos datos. Verifica la información e inténtalo de nuevo.';
            } elseif (str_contains($errorMessage, 'SQLSTATE[HY000]') || str_contains($errorMessage, 'Connection')) {
                $userFriendlyMessage = 'Error de conexión con la base de datos. Por favor, inténtalo de nuevo más tarde.';
            }
            
            return back()
                ->withInput()
                ->with('error', $userFriendlyMessage)
                ->with('error_details', $errorDetails);
        }
    }

    /**
     * Elimina un expediente y sus documentos asociados.
     */
    public function destroy(Expediente $expediente)
    {
        // Verificar permisos: Solo Administrador puede eliminar
        if (Auth::user()->rol !== 'Administrador') {
            abort(403, 'No tiene permiso para eliminar expedientes.');
        }

        try {
            DB::beginTransaction();

            // Limpiar documentos del almacenamiento
            Storage::disk('public')->deleteDirectory('expedientes/' . $expediente->expediente_id);

            // Eliminar el expediente (cascada elimina partes, plazos, documentos)
            $expediente->delete();

            DB::commit();

            return redirect()->route('expedientes.index')
                            ->with('success', 'Expediente eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error("Error al eliminar expediente: " . $e->getMessage());

            return redirect()->back()
                            ->with('error', 'Error al eliminar el expediente.');
        }
    }
}
