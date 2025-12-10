@extends('layouts.app')

@section('title', 'Dashboard - ASESORO')

@section('content')
<div class="container-fluid px-4">
    <!-- Encabezado del Dashboard -->
    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <div>
            <h1 class="h3 mb-0"><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
            <small class="text-muted">Bienvenido, {{ Auth::user()->nombre }}</small>
        </div>
        <div class="text-end">
            <span class="badge bg-primary">{{ Auth::user()->rol }}</span>
            <small class="d-block text-muted">{{ now()->format('d/m/Y H:i') }}</small>
        </div>
    </div>
    <hr>
    <!-- Tarjetas de Resumen Rápido -->
    <div class="row g-3 mb-4">
        @if(Auth::user()->rol === 'Administrador' || Auth::user()->rol === 'Abogado')
            <!-- Total de Expedientes -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted mb-2">Total Expedientes</h6>
                                <h2 class="h1 text-primary mb-0">{{ $totalExpedientes ?? 0 }}</h2>
                            </div>
                            <i class="fas fa-file-contract fa-2x text-primary opacity-25"></i>
                        </div>
                        <small class="text-muted">Casos en el sistema</small>
                    </div>
                </div>
            </div>

            <!-- Expedientes Activos -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted mb-2">Expedientes Activos</h6>
                                <h2 class="h1 text-success mb-0">{{ $expedientesActivos ?? 0 }}</h2>
                            </div>
                            <i class="fas fa-check-circle fa-2x text-success opacity-25"></i>
                        </div>
                        <small class="text-muted">En progreso</small>
                    </div>
                </div>
            </div>

            <!-- Plazos Críticos (próx. 7 días) -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted mb-2">Plazos Críticos</h6>
                                <h2 class="h1 text-danger mb-0">{{ $plazosCriticos ?? 0 }}</h2>
                            </div>
                            <i class="fas fa-clock fa-2x text-danger opacity-25"></i>
                        </div>
                        <small class="text-muted">Próximos 7 días</small>
                    </div>
                </div>
            </div>

            <!-- Mi Carga de Trabajo -->
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted mb-2">Mis Expedientes</h6>
                                <h2 class="h1 text-info mb-0">{{ $misExpedientes ?? 0 }}</h2>
                            </div>
                            <i class="fas fa-user-tie fa-2x text-info opacity-25"></i>
                        </div>
                        <small class="text-muted">Asignados a mí</small>
                    </div>
                </div>
            </div>
        @endif

        @if(Auth::user()->rol === 'Asistente')
            <!-- Mi Carga de Trabajo -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted mb-2">Expedientes Activos</h6>
                                <h2 class="h1 text-info mb-0">{{ $expedientesActivos ?? 0 }}</h2>
                            </div>
                            <i class="fas fa-file-contract fa-2x text-info opacity-25"></i>
                        </div>
                        <small class="text-muted">Casos en progreso</small>
                    </div>
                </div>
            </div>

            <!-- Total de Documentos -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted mb-2">Documentos</h6>
                                <h2 class="h1 text-warning mb-0">{{ $totalDocumentos ?? 0 }}</h2>
                            </div>
                            <i class="fas fa-file-pdf fa-2x text-warning opacity-25"></i>
                        </div>
                        <small class="text-muted">Registrados en sistema</small>
                    </div>
                </div>
            </div>

            <!-- Plazos Próximos -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="text-muted mb-2">Plazos Próximos</h6>
                                <h2 class="h1 text-danger mb-0">{{ $plazosCriticos ?? 0 }}</h2>
                            </div>
                            <i class="fas fa-calendar-alt fa-2x text-danger opacity-25"></i>
                        </div>
                        <small class="text-muted">Próximos 7 días</small>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Acciones Rápidas y Gráficos -->
    <div class="row g-3">
        <!-- Panel de Acciones Rápidas -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-bolt"></i> Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if(Auth::user()->rol === 'Abogado' || Auth::user()->rol === 'Administrador')
                            <a href="{{ route('expedientes.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Nuevo Expediente
                            </a>
                            <a href="{{ route('expedientes.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-list"></i> Ver Expedientes
                            </a>
                        @endif

                        @if(Auth::user()->rol === 'Abogado' || Auth::user()->rol === 'Administrador' || Auth::user()->rol === 'Asistente')
                            <a href="{{ route('reportes.plazos') }}" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-exclamation-triangle"></i> Plazos Críticos
                            </a>
                        @endif

                        @if(Auth::user()->rol === 'Abogado' || Auth::user()->rol === 'Administrador')
                            <a href="{{ route('reportes.carga_casos') }}" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-chart-pie"></i> Carga de Casos
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de Información -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> Información de Usuario</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2"><strong>Nombre:</strong> {{ Auth::user()->nombre }}</li>
                        <li class="mb-2"><strong>Email:</strong> {{ Auth::user()->email }}</li>
                        <li class="mb-2"><strong>Rol:</strong> <span class="badge bg-primary">{{ Auth::user()->rol }}</span></li>
                        <li class="mb-2"><strong>Estado:</strong>
                            @if(Auth::user()->activo)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </li>
                        <li><strong>Último acceso:</strong> {{ Auth::user()->updated_at ? Auth::user()->updated_at->format('d/m/Y H:i') : 'Primera vez' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Sugerencias de Tareas Pendientes -->
    @if(($plazosCriticos ?? 0) > 0)
        <div class="alert alert-warning mt-4 mb-0" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <strong>Atención:</strong> Tienes <strong>{{ $plazosCriticos }}</strong> caso(s) con plazos críticos en los próximos 7 días.
            <a href="{{ route('reportes.plazos') }}" class="alert-link">Ver detalles</a>
        </div>
    @endif
</div>
@endsection
