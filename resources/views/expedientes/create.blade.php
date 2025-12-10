@extends('layouts.app')

@section('content')
<div class="container" style="padding-top: 83rem;">
    <h2 class="mb-4">📝 Nuevo Expediente Jurídico</h2>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Error al guardar el expediente</h5>
            <p class="mb-1"><strong>Posible causa del error:</strong></p>
            <p class="mb-0">{{ session('error') }}</p>
            <hr>
            <p class="mb-0 small">Por favor, verifica los datos e intenta nuevamente.</p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h5 class="alert-heading"><i class="fas fa-exclamation-circle me-2"></i>Se encontraron los siguientes errores:</h5>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <form action="{{ route('expedientes.store') }}" method="POST" enctype="multipart/form-data" id="expedienteForm" onsubmit="return validateForm()">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <h5>Por favor corrige los siguientes errores:</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Datos Principales -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Datos Principales</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="num_expediente_interno" class="form-label">N° Expediente Interno <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('num_expediente_interno') is-invalid @enderror" 
                               id="num_expediente_interno" name="num_expediente_interno" 
                               value="{{ old('num_expediente_interno') }}" required>
                        @error('num_expediente_interno')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="num_judicial" class="form-label">N° Expediente Judicial</label>
                        <input type="text" class="form-control" id="num_judicial" 
                               name="num_judicial" value="{{ old('num_judicial') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="juzgado_tribunal" class="form-label">Juzgado / Tribunal <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('juzgado_tribunal') is-invalid @enderror" 
                               id="juzgado_tribunal" name="juzgado_tribunal" 
                               value="{{ old('juzgado_tribunal') }}" required>
                        @error('juzgado_tribunal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="materia" class="form-label">Materia <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('materia') is-invalid @enderror" 
                               id="materia" name="materia" 
                               value="{{ old('materia') }}" required>
                        @error('materia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tipo_procedimiento" class="form-label">Tipo de Procedimiento <span class="text-danger">*</span></label>
                        <select class="form-select @error('tipo_procedimiento') is-invalid @enderror" 
                                id="tipo_procedimiento" name="tipo_procedimiento" required>
                            <option value="">Seleccione...</option>
                            <option value="Ordinario" {{ old('tipo_procedimiento') == 'Ordinario' ? 'selected' : '' }}>Ordinario</option>
                            <option value="Verbal" {{ old('tipo_procedimiento') == 'Verbal' ? 'selected' : '' }}>Verbal</option>
                            <option value="Ejecutivo" {{ old('tipo_procedimiento') == 'Ejecutivo' ? 'selected' : '' }}>Ejecutivo</option>
                            <option value="Especial" {{ old('tipo_procedimiento') == 'Especial' ? 'selected' : '' }}>Especial</option>
                        </select>
                        @error('tipo_procedimiento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="fecha_inicio" class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" 
                               id="fecha_inicio" name="fecha_inicio" 
                               value="{{ old('fecha_inicio', date('Y-m-d')) }}" required>
                        @error('fecha_inicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="estado_flujo" class="form-label">Estado del Flujo <span class="text-danger">*</span></label>
                        <select class="form-select @error('estado_flujo') is-invalid @enderror" 
                                id="estado_flujo" name="estado_flujo" required>
                            <option value="">Seleccione...</option>
                            <option value="Abierto" {{ old('estado_flujo') == 'Abierto' ? 'selected' : '' }}>Abierto</option>
                            <option value="En Litigio" {{ old('estado_flujo') == 'En Litigio' ? 'selected' : '' }}>En Litigio</option>
                            <option value="Suspendido" {{ old('estado_flujo') == 'Suspendido' ? 'selected' : '' }}>Suspendido</option>
                            <option value="Cerrado" {{ old('estado_flujo') == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                            <option value="Archivado" {{ old('estado_flujo') == 'Archivado' ? 'selected' : '' }}>Archivado</option>
                        </select>
                        @error('estado_flujo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cuantia" class="form-label">Cuantía</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control @error('cuantia') is-invalid @enderror" 
                                   id="cuantia" name="cuantia" step="0.01" min="0"
                                   value="{{ old('cuantia') }}">
                            @error('cuantia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="resumen_asunto" class="form-label">Resumen del Asunto</label>
                    <textarea class="form-control @error('resumen_asunto') is-invalid @enderror" 
                              id="resumen_asunto" name="resumen_asunto" 
                              rows="3">{{ old('resumen_asunto') }}</textarea>
                    @error('resumen_asunto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fecha_ultima_actuacion" class="form-label">Fecha Última Actuación</label>
                        <input type="date" class="form-control @error('fecha_ultima_actuacion') is-invalid @enderror" 
                               id="fecha_ultima_actuacion" name="fecha_ultima_actuacion" 
                               value="{{ old('fecha_ultima_actuacion') }}">
                        @error('fecha_ultima_actuacion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="ubicacion_archivo" class="form-label">Ubicación del Archivo Físico</label>
                        <input type="text" class="form-control @error('ubicacion_archivo') is-invalid @enderror" 
                               id="ubicacion_archivo" name="ubicacion_archivo" 
                               value="{{ old('ubicacion_archivo') }}">
                        @error('ubicacion_archivo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="observaciones_internas" class="form-label">Observaciones Internas</label>
                    <textarea class="form-control @error('observaciones_internas') is-invalid @enderror" 
                              id="observaciones_internas" name="observaciones_internas" 
                              rows="2">{{ old('observaciones_internas') }}</textarea>
                    @error('observaciones_internas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Sección de Partes -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">👥 Partes en el Caso</h5>
            </div>
            <div class="card-body">
                <div id="partes-container">
                    <!-- Las partes se agregarán aquí dinámicamente -->
                    <div class="parte-item mb-3 p-3 border rounded">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="parte_0_ruc_cc" class="form-label">RUC/CC <span class="text-danger">*</span></label>
                                <input type="text" name="partes[0][ruc_cc]" id="parte_0_ruc_cc" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label for="parte_0_nombre" class="form-label">Nombre/Razón Social <span class="text-danger">*</span></label>
                                <input type="text" name="partes[0][nombre_razonsocial]" id="parte_0_nombre" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label for="parte_0_tipo" class="form-label">Tipo de Persona <span class="text-danger">*</span></label>
                                <select name="partes[0][tipo_persona]" id="parte_0_tipo" class="form-select" required>
                                    <option value="Física">Física</option>
                                    <option value="Jurídica">Jurídica</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="parte_0_rol" class="form-label">Rol en el caso <span class="text-danger">*</span></label>
                                <input type="text" name="partes[0][rol_en_caso]" id="parte_0_rol" class="form-control" 
                                    placeholder="Ej: Demandante, Demandado" required>
                            </div>
                            <div class="col-md-2">
                                <label for="parte_0_posicion" class="form-label">Posición Procesal <span class="text-danger">*</span></label>
                                <input type="text" name="partes[0][posicion_procesal]" id="parte_0_posicion" class="form-control" 
                                    placeholder="Ej: Actor, Demandado" required>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label for="parte_0_domicilio" class="form-label">Domicilio Completo</label>
                                <input type="text" name="partes[0][domicilio_completo]" id="parte_0_domicilio" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="parte_0_telefono" class="form-label">Teléfono</label>
                                <input type="tel" name="partes[0][telefono]" id="parte_0_telefono" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label for="parte_0_email" class="form-label">Correo Electrónico</label>
                                <input type="email" name="partes[0][email]" id="parte_0_email" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-parte">
                                    <i class="fas fa-times"></i> Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary mt-3" id="agregar-parte">
                    <i class="fas fa-plus"></i> Agregar Parte
                </button>
            </div>
        </div>

        <!-- Sección de Plazos y Actuaciones -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">⏰ Plazos y Actuaciones</h5>
            </div>
            <div class="card-body">
                <div id="plazos-container">
                    <!-- Los plazos se agregarán aquí dinámicamente -->
                    <div class="plazo-item mb-3 p-3 border rounded">
                        <div class="row">
                            <div class="col-md-5">
                                <label for="plazo_0_descripcion" class="form-label">Descripción <span class="text-danger">*</span></label>
                                <input type="text" name="plazos[0][descripcion_actuacion]" 
                                       id="plazo_0_descripcion" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label for="plazo_0_fecha" class="form-label">Fecha Límite <span class="text-danger">*</span></label>
                                <input type="date" name="plazos[0][fecha_limite]" 
                                       id="plazo_0_fecha" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label for="plazo_0_responsable" class="form-label">Responsable <span class="text-danger">*</span></label>
                                <input type="text" name="plazos[0][responsable]" 
                                       id="plazo_0_responsable" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <label for="plazo_0_estado" class="form-label">Estado <span class="text-danger">*</span></label>
                                <select name="plazos[0][estado]" id="plazo_0_estado" class="form-select" required>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Completado">Completado</option>
                                    <option value="Vencido">Vencido</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-10">
                                <label for="plazo_0_notas" class="form-label">Notas</label>
                                <input type="text" name="plazos[0][notas]" 
                                       id="plazo_0_notas" class="form-control">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-danger btn-sm remove-plazo">
                                    <i class="fas fa-times"></i> Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary mt-3" id="agregar-plazo">
                    <i class="fas fa-plus"></i> Agregar Plazo
                </button>
            </div>
        </div>

        <!-- Sección de Documentos -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">📄 Documentos Digitales</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="documentos" class="form-label">Subir Documentos (Máx. 5 archivos)</label>
                    <input type="file" class="form-control" id="documentos" name="documentos[]" multiple>
                    <div class="form-text">Formatos permitidos: PDF, DOC, DOCX, JPG, JPEG, PNG (Máx. 10MB por archivo)</div>
                </div>
                <div class="mb-3">
                    <label for="descripcion_documentos" class="form-label">Descripción General (Opcional)</label>
                    <textarea class="form-control" id="descripcion_documentos" name="descripcion_documentos" rows="2"></textarea>
                </div>
            </div>
        </div>

        <!-- Botones de Acción -->
        <div class="d-flex justify-content-between">
            <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar Expediente
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Contadores para índices dinámicos
    let parteIndex = 1;
    let plazoIndex = 1;

    // Agregar nueva parte
    document.getElementById('agregar-parte').addEventListener('click', function() {
        const container = document.getElementById('partes-container');
        const newParte = document.createElement('div');
        newParte.className = 'parte-item mb-3 p-3 border rounded';
        newParte.innerHTML = `
            <div class="row">
                <div class="col-md-3">
                    <label class="form-label">RUC/CC <span class="text-danger">*</span></label>
                    <input type="text" name="partes[${parteIndex}][ruc_cc]" 
                           class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nombre/Razón Social <span class="text-danger">*</span></label>
                    <input type="text" name="partes[${parteIndex}][nombre_razonsocial]" 
                           class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Tipo de Persona <span class="text-danger">*</span></label>
                    <select name="partes[${parteIndex}][tipo_persona]" class="form-select" required>
                        <option value="Física">Física</option>
                        <option value="Jurídica">Jurídica</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Rol <span class="text-danger">*</span></label>
                    <input type="text" name="partes[${parteIndex}][rol_en_caso]" 
                           class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Posición Procesal <span class="text-danger">*</span></label>
                    <input type="text" name="partes[${parteIndex}][posicion_procesal]" 
                           class="form-control" required>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label class="form-label">Domicilio</label>
                    <input type="text" name="partes[${parteIndex}][domicilio_completo]" 
                           class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Teléfono</label>
                    <input type="text" name="partes[${parteIndex}][telefono]" 
                           class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="partes[${parteIndex}][email]" 
                           class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-parte">
                        <i class="fas fa-times"></i> Eliminar
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newParte);
        parteIndex++;
    });

    // Agregar nuevo plazo
    document.getElementById('agregar-plazo').addEventListener('click', function() {
        const container = document.getElementById('plazos-container');
        const newPlazo = document.createElement('div');
        newPlazo.className = 'plazo-item mb-3 p-3 border rounded';
        newPlazo.innerHTML = `
            <div class="row">
                <div class="col-md-5">
                    <label class="form-label">Descripción <span class="text-danger">*</span></label>
                    <input type="text" name="plazos[${plazoIndex}][descripcion_actuacion]" 
                           class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Fecha Límite <span class="text-danger">*</span></label>
                    <input type="date" name="plazos[${plazoIndex}][fecha_limite]" 
                           class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Responsable <span class="text-danger">*</span></label>
                    <input type="text" name="plazos[${plazoIndex}][responsable]" 
                           class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Estado <span class="text-danger">*</span></label>
                    <select name="plazos[${plazoIndex}][estado]" class="form-select" required>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Completado">Completado</option>
                        <option value="Vencido">Vencido</option>
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-10">
                    <label class="form-label">Notas</label>
                    <input type="text" name="plazos[${plazoIndex}][notas]" 
                           class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-plazo">
                        <i class="fas fa-times"></i> Eliminar
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newPlazo);
        plazoIndex++;
    });

    // Eliminar parte
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-parte')) {
            const parteItem = e.target.closest('.parte-item');
            if (document.querySelectorAll('.parte-item').length > 1) {
                parteItem.remove();
            } else {
                alert('Debe haber al menos una parte en el expediente.');
            }
        }

        // Eliminar plazo
        if (e.target.closest('.remove-plazo')) {
            const plazoItem = e.target.closest('.plazo-item');
            if (document.querySelectorAll('.plazo-item').length > 1) {
                plazoItem.remove();
            } else {
                // No eliminamos el último plazo, solo lo limpiamos
                const inputs = plazoItem.querySelectorAll('input, select');
                inputs.forEach(input => {
                    if (input.type !== 'button') {
                        input.value = '';
                    }
                });
            }
        }
    });

    // Validación de formulario
    document.getElementById('expedienteForm').addEventListener('submit', function(e) {
        // Validar que al menos haya una parte
        const partes = document.querySelectorAll('.parte-item');
        if (partes.length === 0) {
            e.preventDefault();
            alert('Debe agregar al menos una parte al expediente.');
            return false;
        }

        // Validar fechas
        const fechaInicio = new Date(document.getElementById('fecha_inicio').value);
        const fechaUltimaActuacion = document.getElementById('fecha_ultima_actuacion').value;
        
        if (fechaUltimaActuacion) {
            const fechaUltimaAct = new Date(fechaUltimaActuacion);
            if (fechaUltimaAct < fechaInicio) {
                e.preventDefault();
                alert('La fecha de última actuación no puede ser anterior a la fecha de inicio.');
                return false;
            }
        }

        // Validar archivos
        const archivos = document.getElementById('documentos').files;
        if (archivos.length > 5) {
            e.preventDefault();
            alert('No se pueden subir más de 5 archivos a la vez.');
            return false;
        }

        for (let i = 0; i < archivos.length; i++) {
            const archivo = archivos[i];
            const extensionesPermitidas = /(\.pdf|\.doc|\.docx|\.jpg|\.jpeg|\.png)$/i;
            const tamanoMaximo = 10 * 1024 * 1024; // 10MB

            if (!extensionesPermitidas.exec(archivo.name)) {
                e.preventDefault();
                alert(`El archivo ${archivo.name} tiene una extensión no permitida.`);
                return false;
            }

            if (archivo.size > tamanoMaximo) {
                e.preventDefault();
                alert(`El archivo ${archivo.name} excede el tamaño máximo de 10MB.`);
                return false;
            }
        }

        return true;
    });
</script>
@endpush

@endsection