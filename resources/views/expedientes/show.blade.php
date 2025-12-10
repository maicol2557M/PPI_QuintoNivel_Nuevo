@extends('layouts.app')

@section('title', 'Detalle - ASESORO')

@section('content')
<div class="container" style="padding-top: 45rem;">
    <div class="page-header mb-4" >
        <div class="row align-items-center">
            <div class="col">
                <h1><i class="fas fa-file-contract"></i> {{ $expediente->num_expediente_interno }}</h1>
                <small class="text-muted">{{ $expediente->juzgado_tribunal }}</small>
            </div>
            <div class="col-auto">
                @if(in_array(Auth::user()->rol, ['Administrador', 'Abogado']))
                    <a href="{{ route('expedientes.edit', $expediente->expediente_id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                @endif
                <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Información General -->
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Información General</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">N° Expediente Interno</label>
                            <p class="text-muted">{{ $expediente->num_expediente_interno }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">N° Judicial</label>
                            <p class="text-muted">{{ $expediente->num_judicial ?? 'No especificado' }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Juzgado/Tribunal</label>
                            <p class="text-muted">{{ $expediente->juzgado_tribunal }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Materia</label>
                            <p class="text-muted">{{ $expediente->materia }}</p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Tipo de Procedimiento</label>
                            <p class="text-muted">{{ $expediente->tipo_procedimiento }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Estado</label>
                            <p><span class="badge bg-info">{{ $expediente->estado_flujo }}</span></p>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Fecha de Inicio</label>
                            <p class="text-muted">{{ \Carbon\Carbon::parse($expediente->fecha_inicio)->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Cuantía</label>
                            <p class="text-muted">{{ $expediente->cuantia ? 'USD ' . number_format($expediente->cuantia, 2) : '-' }}</p>
                        </div>
                    </div>
                    @if($expediente->fecha_ultima_actuacion)
                        <div class="row mb-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">Última Actuación</label>
                                <p class="text-muted">{{ \Carbon\Carbon::parse($expediente->fecha_ultima_actuacion)->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    @endif
                    @if($expediente->resumen_asunto)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Resumen del Asunto</label>
                            <p class="text-muted">{{ $expediente->resumen_asunto }}</p>
                        </div>
                    @endif
                    @if($expediente->observaciones_internas)
                        <div class="mb-3">
                            <label class="form-label fw-bold">Observaciones Internas</label>
                            <p class="text-muted">{{ $expediente->observaciones_internas }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Partes Involucradas -->
            @if($expediente->partes->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-users"></i> Partes Involucradas</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>RUC/CC</th>
                                        <th>Rol</th>
                                        <th>Contacto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expediente->partes as $parte)
                                        <tr>
                                            <td><strong>{{ $parte->nombre }}</strong></td>
                                            <td>{{ $parte->ruc_cc }}</td>
                                            <td><span class="badge bg-secondary">{{ $parte->pivot->rol_en_caso }}</span></td>
                                            <td>
                                                @if($parte->email)
                                                    <i class="fas fa-envelope me-1"></i> {{ $parte->email }}<br>
                                                @endif
                                                @if($parte->telefono)
                                                    <i class="fas fa-phone me-1"></i> {{ $parte->telefono }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Plazos -->
            @if($expediente->plazosActuaciones->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-calendar-alt"></i> Plazos</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Fecha Límite</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expediente->plazosActuaciones as $plazo)
                                        @php
                                            $fechaLimite = \Carbon\Carbon::parse($plazo->fecha_limite);
                                            $hoy = \Carbon\Carbon::now();
                                            $diasRestantes = $hoy->diffInDays($fechaLimite, false);
                                            
                                            if($plazo->estado === 'Cumplido') {
                                                $badgeClass = 'bg-success';
                                            } elseif($diasRestantes < 0) {
                                                $badgeClass = 'bg-danger';
                                            } elseif($diasRestantes <= 3) {
                                                $badgeClass = 'bg-warning text-dark';
                                            } else {
                                                $badgeClass = 'bg-info';
                                            }
                                        @endphp
                                        <tr>
                                            <td>{{ $plazo->descripcion_actuacion ?? $plazo->descripcion }}</td>
                                            <td>{{ $fechaLimite->format('d/m/Y') }}</td>
                                            <td><span class="badge {{ $badgeClass }}">{{ $plazo->estado }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Documentos -->
            @if($expediente->documentos->count() > 0)
                <div class="card mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="fas fa-file-alt"></i> Documentos</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Archivo</th>
                                        <th>Tamaño</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expediente->documentos as $documento)
                                        <tr>
                                            <td>{{ $documento->nombre_original }}</td>
                                            <td><small>{{ number_format($documento->tamano_bytes / 1024, 2) }} KB</small></td>
                                            <td>
                                                <a href="{{ Storage::url($documento->ruta_archivo) }}" 
                                                   class="btn btn-sm btn-primary" 
                                                   target="_blank"
                                                   title="Descargar">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div> <!-- Cierre del col-lg-8 -->

        <div class="col-lg-4">
            <!-- Resumen -->
            <div class="card mb-4 border-info">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0"><i class="fas fa-chart-bar"></i> Resumen</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <h5 class="text-primary">{{ $expediente->partes->count() }}</h5>
                            <small class="text-muted">Partes</small>
                        </div>
                        <div class="col-6 mb-3">
                            <h5 class="text-warning">{{ $expediente->plazosActuaciones->count() }}</h5>
                            <small class="text-muted">Plazos</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-danger">{{ $expediente->documentos->count() }}</h5>
                            <small class="text-muted">Documentos</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fas fa-info-circle"></i> Información Adicional</h6>
                </div>
                <div class="card-body">
                    <p><strong>Creado el:</strong> {{ $expediente->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Actualizado el:</strong> {{ $expediente->updated_at->format('d/m/Y H:i') }}</p>
                    @if($expediente->ubicacion_archivo)
                        <p><strong>Ubicación física:</strong> {{ $expediente->ubicacion_archivo }}</p>
                    @endif
                </div>
            </div>
        </div> <!-- Cierre del col-lg-4 -->
    </div> <!-- Cierre del row -->
</div> <!-- Cierre del container -->
@endsection
