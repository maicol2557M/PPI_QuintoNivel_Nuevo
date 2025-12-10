@extends('layouts.app')

@section('title', 'Reporte Productividad - ASESORO')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-chart-bar"></i> Reporte de Productividad</h1>
            <small class="text-muted">Análisis de desempeño por abogado</small>
        </div>
        <button onclick="window.print()" class="btn btn-secondary">
            <i class="fas fa-print"></i> Imprimir
        </button>
    </div>
</div>

<!-- Resumen General -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="text-muted">Total Abogados</h5>
                <h2 class="text-primary">{{ count($productividad) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="text-muted">Total Casos</h5>
                <h2 class="text-info">{{ $productividad->sum('total_casos') }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="text-muted">Casos Cerrados</h5>
                <h2 class="text-success">{{ $productividad->sum('casos_cerrados') }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <h5 class="text-muted">Tasa Cierre Promedio</h5>
                <h2 class="text-warning">
                    {{ $productividad->count() > 0
                        ? round($productividad->avg('porcentaje_cierre'), 1)
                        : 0 }}%
                </h2>
            </div>
        </div>
    </div>
</div>

<!-- Tabla Detallada -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="fas fa-users"></i> Detalle por Abogado</h5>
    </div>
    <div class="table-responsive">
        @if($productividad->count() > 0)
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Abogado</th>
                        <th class="text-center">Total Casos</th>
                        <th class="text-center">Abiertos</th>
                        <th class="text-center">En Litigio</th>
                        <th class="text-center">Cerrados</th>
                        <th class="text-center">% Cierre</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productividad as $item)
                    <tr>
                        <td><strong>{{ $item['abogado']->nombre }}</strong></td>
                        <td class="text-center">
                            <span class="badge bg-info">{{ $item['total_casos'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary">{{ $item['casos_abiertos'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-warning">{{ $item['casos_en_litigio'] }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-success">{{ $item['casos_cerrados'] }}</span>
                        </td>
                        <td class="text-center">
                            <div class="progress" style="height: 20px;">
                                @php
                                    $color = $item['porcentaje_cierre'] >= 70 ? 'success' : ($item['porcentaje_cierre'] >= 40 ? 'warning' : 'danger');
                                @endphp
                                <div class="progress-bar bg-{{ $color }}" style="width: {{ $item['porcentaje_cierre'] }}%">
                                    {{ $item['porcentaje_cierre'] }}%
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('expedientes.index', ['abogado' => $item['abogado']->usuario_id]) }}"
                               class="btn btn-sm btn-outline-info" title="Ver expedientes">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light fw-bold">
                    <tr>
                        <td>TOTAL</td>
                        <td class="text-center">{{ $productividad->sum('total_casos') }}</td>
                        <td class="text-center">{{ $productividad->sum('casos_abiertos') }}</td>
                        <td class="text-center">{{ $productividad->sum('casos_en_litigio') }}</td>
                        <td class="text-center">{{ $productividad->sum('casos_cerrados') }}</td>
                        <td class="text-center">
                            {{ $productividad->count() > 0
                                ? round($productividad->avg('porcentaje_cierre'), 1)
                                : 0 }}%
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        @else
            <div class="alert alert-info m-3 mb-0">
                <i class="fas fa-info-circle"></i> No hay datos de productividad disponibles
            </div>
        @endif
    </div>
</div>

<!-- Nota de contexto -->
<div class="alert alert-info mt-4">
    <i class="fas fa-info-circle"></i>
    <strong>Nota:</strong> Este reporte muestra el desempeño histórico de cada abogado basado en los casos asignados
    y su estado. La tasa de cierre se calcula como el porcentaje de casos cerrados respecto al total.
</div>
@endsection
