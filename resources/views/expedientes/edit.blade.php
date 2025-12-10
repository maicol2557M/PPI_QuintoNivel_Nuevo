@extends('layouts.app')

@section('content')
<div class="container-fluid px-4" style="padding-top: 110rem;">
    <h1 class="mt-4">Editar Expediente</h1>
    

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i>
            Editar Expediente #{{ $expediente->num_expediente_interno }}
        </div>
        <div class="card-body">
            <form action="{{ route('expedientes.update', $expediente->expediente_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Sección de Datos Básicos -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-info-circle me-1"></i>
                        Datos Básicos del Expediente
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="num_expediente_interno" class="form-label">N° Interno <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('num_expediente_interno') is-invalid @enderror" 
                                           id="num_expediente_interno" name="num_expediente_interno" 
                                           value="{{ old('num_expediente_interno', $expediente->num_expediente_interno) }}" required>
                                    @error('num_expediente_interno')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="num_judicial" class="form-label">N° Judicial</label>
                                    <input type="text" class="form-control @error('num_judicial') is-invalid @enderror" 
                                           id="num_judicial" name="num_judicial" 
                                           value="{{ old('num_judicial', $expediente->num_judicial) }}">
                                    @error('num_judicial')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="juzgado_tribunal" class="form-label">Juzgado/Tribunal <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('juzgado_tribunal') is-invalid @enderror" 
                                           id="juzgado_tribunal" name="juzgado_tribunal" 
                                           value="{{ old('juzgado_tribunal', $expediente->juzgado_tribunal) }}" required>
                                    @error('juzgado_tribunal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="materia" class="form-label">Materia <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('materia') is-invalid @enderror" 
                                           id="materia" name="materia" 
                                           value="{{ old('materia', $expediente->materia) }}" required>
                                    @error('materia')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo_procedimiento" class="form-label">Tipo de Procedimiento <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('tipo_procedimiento') is-invalid @enderror" 
                                           id="tipo_procedimiento" name="tipo_procedimiento" 
                                           value="{{ old('tipo_procedimiento', $expediente->tipo_procedimiento) }}" required>
                                    @error('tipo_procedimiento')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="fecha_inicio" class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                           id="fecha_inicio" name="fecha_inicio" 
                                           value="{{ old('fecha_inicio', is_string($expediente->fecha_inicio) ? \Carbon\Carbon::parse($expediente->fecha_inicio)->format('Y-m-d') : $expediente->fecha_inicio->format('Y-m-d')) }}" required>
                                    @error('fecha_inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="estado_flujo" class="form-label">Estado del Flujo <span class="text-danger">*</span></label>
                                    <select class="form-select @error('estado_flujo') is-invalid @enderror" 
                                            id="estado_flujo" name="estado_flujo" required>
                                        <option value="">Seleccione un estado</option>
                                        <option value="Abierto" {{ old('estado_flujo', $expediente->estado_flujo) == 'Abierto' ? 'selected' : '' }}>Abierto</option>
                                        <option value="En Litigio" {{ old('estado_flujo', $expediente->estado_flujo) == 'En Litigio' ? 'selected' : '' }}>En Litigio</option>
                                        <option value="Suspendido" {{ old('estado_flujo', $expediente->estado_flujo) == 'Suspendido' ? 'selected' : '' }}>Suspendido</option>
                                        <option value="Cerrado" {{ old('estado_flujo', $expediente->estado_flujo) == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                                        <option value="Archivado" {{ old('estado_flujo', $expediente->estado_flujo) == 'Archivado' ? 'selected' : '' }}>Archivado</option>
                                    </select>
                                    @error('estado_flujo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="cuantia" class="form-label">Cuantía</label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" step="0.01" class="form-control @error('cuantia') is-invalid @enderror" 
                                               id="cuantia" name="cuantia" 
                                               value="{{ old('cuantia', $expediente->cuantia) }}">
                                        @error('cuantia')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="resumen_asunto" class="form-label">Resumen del Asunto</label>
                            <textarea class="form-control @error('resumen_asunto') is-invalid @enderror" 
                                      id="resumen_asunto" name="resumen_asunto" 
                                      rows="3">{{ old('resumen_asunto', $expediente->resumen_asunto) }}</textarea>
                            @error('resumen_asunto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fecha_ultima_actuacion" class="form-label">Última Actuación</label>
                                    <input type="date" class="form-control @error('fecha_ultima_actuacion') is-invalid @enderror" 
                                           id="fecha_ultima_actuacion" name="fecha_ultima_actuacion" 
                                           value="{{ old('fecha_ultima_actuacion', $expediente->fecha_ultima_actuacion ? (is_string($expediente->fecha_ultima_actuacion) ? \Carbon\Carbon::parse($expediente->fecha_ultima_actuacion)->format('Y-m-d') : $expediente->fecha_ultima_actuacion->format('Y-m-d')) : '') }}">
                                    @error('fecha_ultima_actuacion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ubicacion_archivo" class="form-label">Ubicación Física</label>
                                    <input type="text" class="form-control @error('ubicacion_archivo') is-invalid @enderror" 
                                           id="ubicacion_archivo" name="ubicacion_archivo" 
                                           value="{{ old('ubicacion_archivo', $expediente->ubicacion_archivo) }}">
                                    @error('ubicacion_archivo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="observaciones_internas" class="form-label">Observaciones Internas</label>
                            <textarea class="form-control @error('observaciones_internas') is-invalid @enderror" 
                                      id="observaciones_internas" name="observaciones_internas" 
                                      rows="2">{{ old('observaciones_internas', $expediente->observaciones_internas) }}</textarea>
                            @error('observaciones_internas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Sección de Partes -->
                <div class="card mb-4" id="partes-section">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-users me-1"></i>
                        Partes en el Proceso
                        <button type="button" class="btn btn-sm btn-light float-end" id="agregar-parte">
                            <i class="fas fa-plus"></i> Agregar Parte
                        </button>
                    </div>
                    <div class="card-body" id="partes-container">
                        @if(old('partes', null) !== null)
                            @foreach(old('partes') as $index => $parte)
                                <div class="parte-item border p-3 mb-3">
                                    <input type="hidden" name="partes[{{ $index }}][parte_id]" value="{{ $parte['parte_id'] ?? '' }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nombre/Razón Social <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   name="partes[{{ $index }}][nombre_razonsocial]" 
                                                   class="form-control @error('partes.'.$index.'.nombre_razonsocial') is-invalid @enderror" 
                                                   value="{{ $parte['nombre_razonsocial'] ?? '' }}" required>
                                            @error('partes.'.$index.'.nombre_razonsocial')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">RUC/CC <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   name="partes[{{ $index }}][ruc_cc]" 
                                                   class="form-control @error('partes.'.$index.'.ruc_cc') is-invalid @enderror" 
                                                   value="{{ $parte['ruc_cc'] ?? '' }}" required>
                                            @error('partes.'.$index.'.ruc_cc')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Tipo de Persona</label>
                                            <select name="partes[{{ $index }}][tipo_persona]" 
                                                    class="form-select @error('partes.'.$index.'.tipo_persona') is-invalid @enderror">
                                                <option value="Física" {{ (old('partes.'.$index.'.tipo_persona', $parte['tipo_persona'] ?? '') == 'Física') ? 'selected' : '' }}>Física</option>
                                                <option value="Jurídica" {{ (old('partes.'.$index.'.tipo_persona', $parte['tipo_persona'] ?? '') == 'Jurídica') ? 'selected' : '' }}>Jurídica</option>
                                            </select>
                                            @error('partes.'.$index.'.tipo_persona')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Rol en el Caso</label>
                                            <input type="text" 
                                                   name="partes[{{ $index }}][rol_en_caso]" 
                                                   class="form-control @error('partes.'.$index.'.rol_en_caso') is-invalid @enderror" 
                                                   value="{{ $parte['rol_en_caso'] ?? '' }}">
                                            @error('partes.'.$index.'.rol_en_caso')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Posición Procesal</label>
                                            <input type="text" 
                                                   name="partes[{{ $index }}][posicion_procesal]" 
                                                   class="form-control @error('partes.'.$index.'.posicion_procesal') is-invalid @enderror" 
                                                   value="{{ $parte['posicion_procesal'] ?? '' }}">
                                            @error('partes.'.$index.'.posicion_procesal')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Teléfono</label>
                                            <input type="text" 
                                                   name="partes[{{ $index }}][telefono]" 
                                                   class="form-control @error('partes.'.$index.'.telefono') is-invalid @enderror" 
                                                   value="{{ $parte['telefono'] ?? '' }}">
                                            @error('partes.'.$index.'.telefono')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" 
                                                   name="partes[{{ $index }}][email]" 
                                                   class="form-control @error('partes.'.$index.'.email') is-invalid @enderror" 
                                                   value="{{ $parte['email'] ?? '' }}">
                                            @error('partes.'.$index.'.email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Domicilio</label>
                                        <input type="text" 
                                               name="partes[{{ $index }}][domicilio_completo]" 
                                               class="form-control @error('partes.'.$index.'.domicilio_completo') is-invalid @enderror" 
                                               value="{{ $parte['domicilio_completo'] ?? '' }}">
                                        @error('partes.'.$index.'.domicilio_completo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-sm btn-danger eliminar-parte">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @forelse($expediente->partes as $index => $parte)
                                <div class="parte-item border p-3 mb-3">
                                    <input type="hidden" name="partes[{{ $index }}][parte_id]" value="{{ $parte->pivot->persona_id }}">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Nombre/Razón Social <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   name="partes[{{ $index }}][nombre_razonsocial]" 
                                                   class="form-control" 
                                                   value="{{ old('partes.'.$index.'.nombre_razonsocial', $parte->nombre_razonsocial) }}" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">RUC/CC <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   name="partes[{{ $index }}][ruc_cc]" 
                                                   class="form-control" 
                                                   value="{{ old('partes.'.$index.'.ruc_cc', $parte->ruc_cc) }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Tipo de Persona</label>
                                            <select name="partes[{{ $index }}][tipo_persona]" class="form-select">
                                                <option value="Física" {{ (old('partes.'.$index.'.tipo_persona', $parte->tipo_persona) == 'Física') ? 'selected' : '' }}>Física</option>
                                                <option value="Jurídica" {{ (old('partes.'.$index.'.tipo_persona', $parte->tipo_persona) == 'Jurídica') ? 'selected' : '' }}>Jurídica</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Rol en el Caso</label>
                                            <input type="text" 
                                                   name="partes[{{ $index }}][rol_en_caso]" 
                                                   class="form-control" 
                                                   value="{{ old('partes.'.$index.'.rol_en_caso', $parte->pivot->rol_en_caso) }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Posición Procesal</label>
                                            <input type="text" 
                                                   name="partes[{{ $index }}][posicion_procesal]" 
                                                   class="form-control" 
                                                   value="{{ old('partes.'.$index.'.posicion_procesal', $parte->pivot->posicion_procesal) }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Teléfono</label>
                                            <input type="text" 
                                                   name="partes[{{ $index }}][telefono]" 
                                                   class="form-control" 
                                                   value="{{ old('partes.'.$index.'.telefono', $parte->telefono) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input type="email" 
                                                   name="partes[{{ $index }}][email]" 
                                                   class="form-control" 
                                                   value="{{ old('partes.'.$index.'.email', $parte->email) }}">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Domicilio</label>
                                        <input type="text" 
                                               name="partes[{{ $index }}][domicilio_completo]" 
                                               class="form-control" 
                                               value="{{ old('partes.'.$index.'.domicilio_completo', $parte->domicilio_completo) }}">
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-sm btn-danger eliminar-parte">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">
                                    No hay partes registradas para este expediente.
                                </div>
                            @endforelse
                        @endif
                    </div>
                </div>

                <!-- Sección de Plazos y Actuaciones -->
                <div class="card mb-4" id="plazos-section">
                    <div class="card-header bg-warning">
                        <i class="fas fa-calendar-alt me-1"></i>
                        Plazos y Actuaciones
                        <button type="button" class="btn btn-sm btn-light float-end" id="agregar-plazo">
                            <i class="fas fa-plus"></i> Agregar Plazo
                        </button>
                    </div>
                    <div class="card-body" id="plazos-container">
                        @if(old('plazos', null) !== null)
                            @foreach(old('plazos') as $index => $plazo)
                                <div class="plazo-item border p-3 mb-3">
                                    <input type="hidden" name="plazos[{{ $index }}][plazo_id]" value="{{ $plazo['plazo_id'] ?? '' }}">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Descripción <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   name="plazos[{{ $index }}][descripcion_actuacion]" 
                                                   class="form-control @error('plazos.'.$index.'.descripcion_actuacion') is-invalid @enderror" 
                                                   value="{{ $plazo['descripcion_actuacion'] ?? '' }}" required>
                                            @error('plazos.'.$index.'.descripcion_actuacion')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Fecha Límite <span class="text-danger">*</span></label>
                                            <input type="date" 
                                                   name="plazos[{{ $index }}][fecha_vencimiento]" 
                                                   class="form-control @error('plazos.'.$index.'.fecha_vencimiento') is-invalid @enderror" 
                                                   value="{{ $plazo['fecha_vencimiento'] ?? '' }}" required>
                                            @error('plazos.'.$index.'.fecha_vencimiento')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Responsable</label>
                                            <input type="text" 
                                                   name="plazos[{{ $index }}][responsable]" 
                                                   class="form-control @error('plazos.'.$index.'.responsable') is-invalid @enderror" 
                                                   value="{{ $plazo['responsable'] ?? '' }}">
                                            @error('plazos.'.$index.'.responsable')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label">Estado</label>
                                            <select name="plazos[{{ $index }}][estado]" 
                                                    class="form-select @error('plazos.'.$index.'.estado') is-invalid @enderror">
                                                <option value="Pendiente" {{ (old('plazos.'.$index.'.estado', $plazo['estado'] ?? '') == 'Pendiente') ? 'selected' : '' }}>Pendiente</option>
                                                <option value="En Proceso" {{ (old('plazos.'.$index.'.estado', $plazo['estado'] ?? '') == 'En Proceso') ? 'selected' : '' }}>En Proceso</option>
                                                <option value="Completado" {{ (old('plazos.'.$index.'.estado', $plazo['estado'] ?? '') == 'Completado') ? 'selected' : '' }}>Completado</option>
                                                <option value="Vencido" {{ (old('plazos.'.$index.'.estado', $plazo['estado'] ?? '') == 'Vencido') ? 'selected' : '' }}>Vencido</option>
                                            </select>
                                            @error('plazos.'.$index.'.estado')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Observaciones</label>
                                            <textarea name="plazos[{{ $index }}][observaciones]" 
                                                      class="form-control @error('plazos.'.$index.'.observaciones') is-invalid @enderror" 
                                                      rows="2">{{ $plazo['observaciones'] ?? '' }}</textarea>
                                            @error('plazos.'.$index.'.observaciones')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-sm btn-danger eliminar-plazo">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @forelse($expediente->plazosActuaciones as $index => $plazo)
                                <div class="plazo-item border p-3 mb-3">
                                    <input type="hidden" name="plazos[{{ $index }}][plazo_id]" value="{{ $plazo->plazo_actuacion_id }}">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Descripción <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   name="plazos[{{ $index }}][descripcion_actuacion]" 
                                                   class="form-control" 
                                                   value="{{ old('plazos.'.$index.'.descripcion_actuacion', $plazo->descripcion_actuacion) }}" 
                                                   required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Fecha Límite <span class="text-danger">*</span></label>
                                            <input type="date" 
                                                   name="plazos[{{ $index }}][fecha_vencimiento]" 
                                                   class="form-control" 
                                                   value="{{ old('plazos.'.$index.'.fecha_vencimiento', $plazo->fecha_vencimiento ? (is_string($plazo->fecha_vencimiento) ? \Carbon\Carbon::parse($plazo->fecha_vencimiento)->format('Y-m-d') : $plazo->fecha_vencimiento->format('Y-m-d')) : '') }}" 
                                                   required>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label class="form-label">Responsable</label>
                                            <input type="text" 
                                                   name="plazos[{{ $index }}][responsable]" 
                                                   class="form-control" 
                                                   value="{{ old('plazos.'.$index.'.responsable', $plazo->responsable) }}">
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <label class="form-label">Estado</label>
                                            <select name="plazos[{{ $index }}][estado]" class="form-select">
                                                <option value="Pendiente" {{ (old('plazos.'.$index.'.estado', $plazo->estado) == 'Pendiente') ? 'selected' : '' }}>Pendiente</option>
                                                <option value="En Proceso" {{ (old('plazos.'.$index.'.estado', $plazo->estado) == 'En Proceso') ? 'selected' : '' }}>En Proceso</option>
                                                <option value="Completado" {{ (old('plazos.'.$index.'.estado', $plazo->estado) == 'Completado') ? 'selected' : '' }}>Completado</option>
                                                <option value="Vencido" {{ (old('plazos.'.$index.'.estado', $plazo->estado) == 'Vencido') ? 'selected' : '' }}>Vencido</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <label class="form-label">Observaciones</label>
                                            <textarea name="plazos[{{ $index }}][observaciones]" 
                                                      class="form-control" 
                                                      rows="2">{{ old('plazos.'.$index.'.observaciones', $plazo->observaciones) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-sm btn-danger eliminar-plazo">
                                            <i class="fas fa-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-info">
                                    No hay plazos registrados para este expediente.
                                </div>
                            @endforelse
                        @endif
                    </div>
                </div>

                <!-- Sección de Documentos Adjuntos -->
                <div class="card mb-4">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-paperclip me-1"></i>
                        Documentos Adjuntos
                    </div>
                    <div class="card-body">
                        @if($expediente->documentos->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre del Archivo</th>
                                            <th>Tipo</th>
                                            <th>Tamaño</th>
                                            <th>Fecha de Carga</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($expediente->documentos as $documento)
                                            <tr>
                                                <td>
                                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                                    {{ $documento->nombre_original }}
                                                </td>
                                                <td>{{ $documento->tipo_mime }}</td>
                                                <td>{{ number_format($documento->tamano_bytes / 1024, 2) }} KB</td>
                                                <td>{{ $documento->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <a href="{{ Storage::disk('public')->url($documento->ruta_archivo) }}" 
                                                       class="btn btn-sm btn-primary" target="_blank" title="Ver">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ Storage::disk('public')->url($documento->ruta_archivo) }}" 
                                                       class="btn btn-sm btn-success" download title="Descargar">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger eliminar-documento" 
                                                            data-documento-id="{{ $documento->documento_id }}" title="Eliminar">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="alert alert-info mb-3">
                                No hay documentos adjuntos a este expediente.
                            </div>
                        @endif

                        <div class="mt-4">
                            <h5 class="mb-3">Agregar Nuevos Documentos</h5>
                            <div class="mb-3">
                                <label for="documentos" class="form-label">Seleccionar Archivos</label>
                                <input class="form-control @error('documentos.*') is-invalid @enderror" 
                                       type="file" id="documentos" name="documentos[]" multiple>
                                @error('documentos.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Puedes seleccionar múltiples archivos. Formatos permitidos: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG.
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="descripcion_documentos" class="form-label">Descripción General (opcional)</label>
                                <textarea class="form-control" id="descripcion_documentos" name="descripcion_documentos" 
                                          rows="2" placeholder="Descripción general para los documentos adjuntos">{{ old('descripcion_documentos') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Volver al Listado
                    </a>
                    <div>
                        <a href="{{ route('expedientes.show', $expediente->expediente_id) }}" class="btn btn-info text-white me-2">
                            <i class="fas fa-eye me-1"></i> Ver Detalles
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Guardar Cambios
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal para confirmar eliminación de documento -->
<div class="modal fade" id="confirmarEliminarDocumento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este documento? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="formEliminarDocumento" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Manejar eliminación de partes
        document.addEventListener('click', function(e) {
            if (e.target.closest('.eliminar-parte')) {
                e.preventDefault();
                if (confirm('¿Está seguro de eliminar esta parte?')) {
                    e.target.closest('.parte-item').remove();
                    // Renumerar los índices de las partes restantes
                    actualizarIndicesPartes();
                }
            }
        });

        // Función para actualizar índices de partes
        function actualizarIndicesPartes() {
            document.querySelectorAll('.parte-item').forEach((item, index) => {
                // Actualizar índices en los nombres de los campos
                item.querySelectorAll('[name^="partes["]').forEach(input => {
                    const name = input.getAttribute('name');
                    const newName = name.replace(/partes\[\d+\]/, `partes[${index}]`);
                    input.setAttribute('name', newName);
                });
            });
        }

        // Agregar nueva parte
        document.getElementById('agregar-parte').addEventListener('click', function() {
            const container = document.getElementById('partes-container');
            const index = document.querySelectorAll('.parte-item').length;
            const template = `
            <div class="parte-item border p-3 mb-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre/Razón Social <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="partes[${index}][nombre_razonsocial]" 
                               class="form-control" 
                               required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">RUC/CC <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="partes[${index}][ruc_cc]" 
                               class="form-control" 
                               required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Tipo de Persona</label>
                        <select name="partes[${index}][tipo_persona]" class="form-select">
                            <option value="Física">Física</option>
                            <option value="Jurídica">Jurídica</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Rol en el Caso</label>
                        <input type="text" 
                               name="partes[${index}][rol_en_caso]" 
                               class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Posición Procesal</label>
                        <input type="text" 
                               name="partes[${index}][posicion_procesal]" 
                               class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Teléfono</label>
                        <input type="text" 
                               name="partes[${index}][telefono]" 
                               class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" 
                               name="partes[${index}][email]" 
                               class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Domicilio</label>
                    <input type="text" 
                           name="partes[${index}][domicilio_completo]" 
                           class="form-control">
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-sm btn-danger eliminar-parte">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>`;

            container.insertAdjacentHTML('beforeend', template);
        });

        // Manejar eliminación de plazos
        document.addEventListener('click', function(e) {
            if (e.target.closest('.eliminar-plazo')) {
                e.preventDefault();
                if (confirm('¿Está seguro de eliminar este plazo?')) {
                    e.target.closest('.plazo-item').remove();
                    // Renumerar los índices de los plazos restantes
                    actualizarIndicesPlazos();
                }
            }
        });

        // Función para actualizar índices de plazos
        function actualizarIndicesPlazos() {
            document.querySelectorAll('.plazo-item').forEach((item, index) => {
                // Actualizar índices en los nombres de los campos
                item.querySelectorAll('[name^="plazos["]').forEach(input => {
                    const name = input.getAttribute('name');
                    const newName = name.replace(/plazos\[\d+\]/, `plazos[${index}]`);
                    input.setAttribute('name', newName);
                });
            });
        }

        // Agregar nuevo plazo
        document.getElementById('agregar-plazo').addEventListener('click', function() {
            const container = document.getElementById('plazos-container');
            const index = document.querySelectorAll('.plazo-item').length;
            const template = `
            <div class="plazo-item border p-3 mb-3">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Descripción <span class="text-danger">*</span></label>
                        <input type="text"
                               name="plazos[${index}][descripcion_actuacion]"
                               class="form-control"
                               required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Fecha Límite <span class="text-danger">*</span></label>
                        <input type="date"
                               name="plazos[${index}][fecha_vencimiento]"
                               class="form-control"
                               required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Responsable</label>
                        <input type="text"
                               name="plazos[${index}][responsable]"
                               class="form-control">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Estado</label>
                        <select name="plazos[${index}][estado]" class="form-select">
                            <option value="Pendiente">Pendiente</option>
                            <option value="En Proceso">En Proceso</option>
                            <option value="Completado">Completado</option>
                            <option value="Vencido">Vencido</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea name="plazos[${index}][observaciones]"
                                 class="form-control"
                                 rows="2"></textarea>
                    </div>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-sm btn-danger eliminar-plazo">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </div>
            </div>`;

            container.insertAdjacentHTML('beforeend', template);
        });

        // Manejar eliminación de documentos
        document.querySelectorAll('.eliminar-documento').forEach(button => {
            button.addEventListener('click', function() {
                const documentoId = this.getAttribute('data-documento-id');
                const form = document.getElementById('formEliminarDocumento');
                form.action = `/documentos/${documentoId}`;
                
                const modal = new bootstrap.Modal(document.getElementById('confirmarEliminarDocumento'));
                modal.show();
            });
        });
    });
</script>
@endpush