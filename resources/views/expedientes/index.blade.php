@extends('layouts.app')

@section('title', 'Expedientes - ASESORO')

@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1><i class="fas fa-folder-open"></i> Expedientes</h1>
                <small class="text-muted">Gestión de casos jurídicos</small>
            </div>
            <div class="col-auto">
                <a href="{{ route('expedientes.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Expediente
                </a>
            </div>
        </div>
    </div>

    <!-- Búsqueda -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('expedientes.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="search" class="form-label">Buscar por N° Interno o Juzgado</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Ej: EXP-2025-001"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label for="sort" class="form-label">Ordenar por</label>
                    <select name="sort" id="sort" class="form-select">
                        <option value="fecha_inicio" {{ request('sort') === 'fecha_inicio' ? 'selected' : '' }}>Fecha Inicio
                        </option>
                        <option value="num_expediente_interno"
                            {{ request('sort') === 'num_expediente_interno' ? 'selected' : '' }}>N° Expediente</option>
                        <option value="estado_flujo" {{ request('sort') === 'estado_flujo' ? 'selected' : '' }}>Estado
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-info w-100"><i class="fas fa-search"></i> Buscar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla -->
    <div class="card">
        <div class="table-responsive">
            @if ($expedientes->count() > 0)
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>N° Expediente</th>
                            <th>Abogado</th>
                            <th>Juzgado</th>
                            <th>Asunto</th>
                            <th>Estado</th>
                            <th>Fecha Inicio</th>
                            <th>Cuantía</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($expedientes as $exp)
                            <tr>
                                <td><strong>{{ $exp->num_expediente_interno }}</strong></td>
                                <td>
                                    @if($exp->abogadoResponsable)
                                        {{ $exp->abogadoResponsable->nombre }}
                                    @else
                                        <span class="text-muted">Sin asignar</span>
                                    @endif
                                </td>
                                <td>{{ $exp->juzgado_tribunal }}</td>
                                <td><small>{{ Str::limit($exp->resumen_asunto, 40) }}</small></td>
                                <td><span class="badge bg-info">{{ $exp->estado_flujo }}</span></td>
                                <td>
                                    @if ($exp->fecha_inicio)
                                        {{ \Carbon\Carbon::parse($exp->fecha_inicio)->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $exp->cuantia ? 'USD ' . number_format($exp->cuantia, 2) : '-' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('expedientes.show', $exp->expediente_id) }}"
                                        class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a>
                                    @if (in_array(Auth::user()->rol, ['Administrador', 'Abogado']))
                                        <a href="{{ route('expedientes.edit', $exp->expediente_id) }}"
                                            class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                    @endif
                                    @if (Auth::user()->rol === 'Administrador')
                                        <form action="{{ route('expedientes.destroy', $exp->expediente_id) }}"
                                            method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-3 py-3 border-top">
                    {{ $expedientes->links('pagination::bootstrap-5') }}
                </div>
            @else
                <div class="alert alert-info m-3 mb-0"><i class="fas fa-info-circle"></i> No hay expedientes.</div>
            @endif
        </div>
    </div>
@endsection
