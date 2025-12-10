@extends('layouts.app')

@section('title', 'Detalle de Usuario - ASESORO')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-user"></i> {{ $usuario->nombre }}</h1>
        <div>
            <a href="{{ route('usuarios.edit', $usuario->usuario_id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Información Personal</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Nombre:</dt>
                    <dd class="col-sm-9"><strong>{{ $usuario->nombre }}</strong></dd>

                    <dt class="col-sm-3">Email:</dt>
                    <dd class="col-sm-9"><a href="mailto:{{ $usuario->email }}">{{ $usuario->email }}</a></dd>

                    <dt class="col-sm-3">Cédula:</dt>
                    <dd class="col-sm-9">{{ $usuario->id_cedula }}</dd>

                    <dt class="col-sm-3">Identificación:</dt>
                    <dd class="col-sm-9">{{ $usuario->identificacion }}</dd>

                    <dt class="col-sm-3">Rol:</dt>
                    <dd class="col-sm-9">
                        <span class="badge
                            @if($usuario->rol === 'Administrador') bg-danger
                            @elseif($usuario->rol === 'Abogado') bg-primary
                            @else bg-secondary @endif">
                            {{ $usuario->rol }}
                        </span>
                    </dd>

                    <dt class="col-sm-3">Estado:</dt>
                    <dd class="col-sm-9">
                        @if($usuario->activo)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </dd>

                    <dt class="col-sm-3">Creado:</dt>
                    <dd class="col-sm-9">{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : 'N/A' }}</dd>

                    <dt class="col-sm-3">Actualizado:</dt>
                    <dd class="col-sm-9">{{ $usuario->updated_at ? $usuario->updated_at->format('d/m/Y H:i') : 'N/A' }}</dd>
                </dl>
            </div>
        </div>

        <!-- Expedientes asignados (si es Abogado) -->
        @if($usuario->rol === 'Abogado')
        <div class="card mt-3">
            <div class="card-header bg-light">
                <h5 class="mb-0">Expedientes Asignados</h5>
            </div>
            <div class="card-body">
                @if($usuario->expedientes && $usuario->expedientes->count() > 0)
                    <ul class="list-unstyled">
                        @foreach($usuario->expedientes as $expediente)
                            <li class="mb-2">
                                <a href="{{ route('expedientes.show', $expediente->expediente_id) }}">
                                    {{ $expediente->numero_expediente }}
                                </a>
                                <span class="badge bg-secondary">{{ $expediente->estado }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">Sin expedientes asignados</p>
                @endif
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Acciones</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('usuarios.edit', $usuario->usuario_id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Editar Usuario
                    </a>
                    @if($usuario->activo)
                    <form action="{{ route('usuarios.destroy', $usuario->usuario_id) }}" method="POST" onsubmit="return confirm('¿Desactivar este usuario?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-ban"></i> Desactivar
                        </button>
                    </form>
                    @else
                    <form action="{{ route('usuarios.reactivate', $usuario->usuario_id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check"></i> Reactivar
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
