@extends('layouts.app')

@section('title', 'Gestión de Usuarios - ASESORO')

@section('content')
<div class="page-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-users"></i> Gestión de Usuarios</h1>
            <small class="text-muted">Administra los usuarios del sistema</small>
        </div>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Nuevo Usuario
        </a>
    </div>
</div>

<div class="card">
    <div class="table-responsive">
        @if($usuarios->count() > 0)
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Cédula</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td>
                            <strong>{{ $usuario->nombre }}</strong>
                        </td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->id_cedula }}</td>
                        <td>
                            <span class="badge
                                @if($usuario->rol === 'Administrador') bg-danger
                                @elseif($usuario->rol === 'Abogado') bg-primary
                                @else bg-secondary @endif">
                                {{ $usuario->rol }}
                            </span>
                        </td>
                        <td>
                            @if($usuario->activo)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('usuarios.show', $usuario->usuario_id) }}" class="btn btn-sm btn-info" title="Ver">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('usuarios.edit', $usuario->usuario_id) }}" class="btn btn-sm btn-warning" title="Editar">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if($usuario->activo)
                            <form action="{{ route('usuarios.destroy', $usuario->usuario_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Desactivar este usuario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Desactivar">
                                    <i class="fas fa-ban"></i>
                                </button>
                            </form>
                            @else
                            <form action="{{ route('usuarios.reactivate', $usuario->usuario_id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success" title="Reactivar">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info m-3 mb-0">
                <i class="fas fa-info-circle"></i> No hay usuarios registrados
            </div>
        @endif
    </div>
</div>

<!-- Paginación -->
@if($usuarios->count() > 0)
<div class="d-flex justify-content-center mt-4">
    {{ $usuarios->links() }}
</div>
@endif
@endsection
