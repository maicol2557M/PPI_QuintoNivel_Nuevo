@extends('layouts.app')

@section('title', 'Crear Usuario - ASESORO')

@section('content')
<div class="page-header">
    <h1><i class="fas fa-user-plus"></i> Crear Nuevo Usuario</h1>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('usuarios.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                               id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="id_cedula" class="form-label">Número de Cédula <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('id_cedula') is-invalid @enderror"
                                   id="id_cedula" name="id_cedula" value="{{ old('id_cedula') }}" required>
                            @error('id_cedula')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="identificacion" class="form-label">Identificación <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('identificacion') is-invalid @enderror"
                                   id="identificacion" name="identificacion" value="{{ old('identificacion') }}" required>
                            @error('identificacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required minlength="8">
                            <small class="form-text text-muted">Mínimo 8 caracteres</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control"
                                   id="password_confirmation" name="password_confirmation" required minlength="8">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="rol" class="form-label">Rol <span class="text-danger">*</span></label>
                            @if(auth()->user()->rol === 'Asistente')
                                <select class="form-select @error('rol') is-invalid @enderror"
                                        id="rol" name="rol" required disabled>
                                    <option value="Abogado" selected>Abogado</option>
                                </select>
                                <input type="hidden" name="rol" value="Abogado">
                            @else
                                <select class="form-select @error('rol') is-invalid @enderror"
                                        id="rol" name="rol" required>
                                    <option value="">-- Selecciona un rol --</option>
                                    @foreach($roles as $rol)
                                        <option value="{{ $rol }}" @if(old('rol') === $rol) selected @endif>{{ $rol }}</option>
                                    @endforeach
                                </select>
                            @endif
                            @error('rol')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Estado</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       id="activo" name="activo" value="1" @if(!old('activo', true)) @endif checked>
                                <label class="form-check-label" for="activo">
                                    Activo
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Crear Usuario
                        </button>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
