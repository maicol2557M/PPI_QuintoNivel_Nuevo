@extends('layouts.app')

@section('title', 'Plazos Críticos - ASESORO')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-clock"></i> Plazos Críticos</h1>
    <small class="text-muted">Actuaciones pendientes y vencidas</small>
</div>

<!-- Resumen Rápido -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card border-danger">
            <div class="card-body text-center">
                <h5 class="text-danger"><i class="fas fa-exclamation-triangle"></i> Vencidos</h5>
                <h2 class="text-danger">{{ $reporteData['vencidos']->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card border-warning">
            <div class="card-body text-center">
                <h5 class="text-warning"><i class="fas fa-hourglass-start"></i> Pendientes</h5>
                <h2 class="text-warning">{{ $reporteData['pendientes']->count() }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Plazos Vencidos -->
<div class="card mb-4">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0"><i class="fas fa-times-circle"></i> Plazos Vencidos ({{ $reporteData['vencidos']->count() }})</h5>
    </div>
    @if($reporteData['vencidos']->isEmpty())
        <div class="alert alert-success m-3 mb-0"><i class="fas fa-check-circle"></i> ¡No hay plazos vencidos!</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Expediente</th>
                        <th>Descripción</th>
                        <th>Fecha Límite</th>
                        <th>Días Vencido</th>
                        <th>Responsable</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reporteData['vencidos'] as $plazo)
                    @php
                        $fechaLimite = is_string($plazo->fecha_limite) ? \Carbon\Carbon::parse($plazo->fecha_limite) : $plazo->fecha_limite;
                        $hoy = now()->startOfDay();
                        $fechaLimiteDia = $fechaLimite->copy()->startOfDay();
                        $diasVencidos = $hoy->diffInDays($fechaLimiteDia, false);
                        $estaVencido = $diasVencidos < 0;
                        $diasVencidos = abs($diasVencidos);
                    @endphp
                    <tr class="table-danger">
                        <td><strong>{{ $plazo->expediente->num_expediente_interno }}</strong></td>
                        <td>{{ Str::limit($plazo->descripcion_actuacion, 50) }}</td>
                        <td>{{ $fechaLimite->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge bg-danger">Vencido: {{ $diasVencidos }} {{ $diasVencidos == 1 ? 'día' : 'días' }}</span>
                        </td>
                        <td>{{ $plazo->expediente->abogadoResponsable->nombre ?? '-' }}</td>
                        <td>
                            <a href="{{ route('expedientes.show', $plazo->expediente_id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Plazos Pendientes -->
<div class="card">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0"><i class="fas fa-hourglass-start"></i> Plazos Pendientes ({{ $reporteData['pendientes']->count() }})</h5>
    </div>
    @if($reporteData['pendientes']->isEmpty())
        <div class="alert alert-info m-3 mb-0"><i class="fas fa-info-circle"></i> Sin plazos pendientes</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Expediente</th>
                        <th>Descripción</th>
                        <th>Fecha Límite</th>
                        <th>Días Restantes</th>
                        <th>Responsable</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reporteData['pendientes'] as $plazo)
                    <tr>
                        <td><strong>{{ $plazo->expediente->num_expediente_interno }}</strong></td>
                        <td>{{ Str::limit($plazo->descripcion_actuacion, 50) }}</td>
                        @php
                            $fechaLimite = is_string($plazo->fecha_limite) ? \Carbon\Carbon::parse($plazo->fecha_limite) : $plazo->fecha_limite;
                        @endphp
                        <td>{{ $fechaLimite->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $hoy = now()->startOfDay();
                                $fechaLimiteDia = $fechaLimite->copy()->startOfDay();
                                $diasRestantes = $hoy->diffInDays($fechaLimiteDia, false);
                                
                                if ($diasRestantes <= 0) {
                                    $badge = 'bg-danger';
                                    $texto = 'Vencido: ' . abs($diasRestantes) . ' días';
                                } elseif ($diasRestantes <= 3) {
                                    $badge = 'bg-warning';
                                    $texto = $diasRestantes . ' días';
                                } else {
                                    $badge = 'bg-info';
                                    $texto = $diasRestantes . ' días';
                                }
                            @endphp
                            <span class="badge {{ $badge }}">{{ $texto }}</span>
                        </td>
                        <td>{{ $plazo->expediente->abogadoResponsable->nombre ?? '-' }}</td>
                        <td>
                            <a href="{{ route('expedientes.show', $plazo->expediente_id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection
