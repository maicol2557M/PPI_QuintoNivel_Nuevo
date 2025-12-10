@extends('layouts.app')

@section('title', 'Carga de Casos - ASESORO')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-chart-pie"></i> Carga de Casos</h1>
    <small class="text-muted">Distribución de expedientes por abogado responsable</small>
</div>

<!-- Resumen rápido -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="text-muted">Abogados Activos</h5>
                <h2 class="text-primary">{{ $cargaCasos->count() }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="text-muted">Total de Expedientes</h5>
                <h2 class="text-success">{{ $cargaCasos->sum('expedientes_count') }}</h2>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Carga -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-users"></i> Distribución de Casos</h5>
    </div>
    <div class="table-responsive">
        @if($cargaCasos->count() > 0)
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Abogado</th>
                        <th>Rol</th>
                        <th>Email</th>
                        <th>Casos Asignados</th>
                        <th>Indicador</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cargaCasos->sortByDesc('expedientes_count') as $abogado)
                    <tr>
                        <td><strong>{{ $abogado->nombre }}</strong></td>
                        <td><span class="badge bg-secondary">{{ $abogado->rol }}</span></td>
                        <td>{{ $abogado->email }}</td>
                        <td>
                            <strong class="fs-5">{{ $abogado->expedientes_count }}</strong>
                        </td>
                        <td>
                            @php
                                $carga = $abogado->expedientes_count;
                                $max = $cargaCasos->max('expedientes_count');
                                $porcentaje = $max > 0 ? ($carga / $max) * 100 : 0;
                                $color = $carga > 8 ? 'danger' : ($carga > 5 ? 'warning' : 'success');
                            @endphp
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar bg-{{ $color }}" style="width: {{ $porcentaje }}%" role="progressbar">
                                    {{ round($porcentaje) }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('expedientes.index', ['abogado_id' => $abogado->id]) }}" class="btn btn-sm btn-info" title="Ver expedientes de {{ $abogado->nombre }}">
                                <i class="fas fa-folder"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info m-3 mb-0"><i class="fas fa-info-circle"></i> No hay datos disponibles</div>
        @endif
    </div>
</div>

@endsection
