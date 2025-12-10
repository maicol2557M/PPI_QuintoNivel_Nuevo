<!-- Sidebar -->
<nav class="col-md-2 d-md-block sidebar">
    <div class="position-sticky" style="top: 56px;">

        <div class=" accordion-flush" id="menuAcordeon">

            <ul class="nav flex-column mb-0">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
            </ul>

            <hr class="dropdown-divider">

            <div class="accordion-item" style="padding: 7px">
                <h2 class="accordion-header" id="headingExpedientes">
                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseExpedientes" aria-expanded="false" aria-controls="collapseExpedientes"
                        style="color: #e4b04e; font-weight: 600;">
                        <i class="fas fa-folder me-2"></i> Expedientes
                    </button>
                </h2>
                <div id="collapseExpedientes" class="accordion-collapse collapse" aria-labelledby="headingExpedientes"
                    data-bs-parent="#menuAcordeon">
                    <div class="accordion-body p-0">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() === 'expedientes.index' ? 'active' : '' }}"
                                    href="{{ route('expedientes.index') }}">
                                    <i class="fas fa-list"></i> Ver Expedientes
                                </a>
                            </li>
                            @if (in_array(Auth::user()->rol, ['Administrador', 'Abogado']))
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() === 'expedientes.create' ? 'active' : '' }}"
                                        href="{{ route('expedientes.create') }}">
                                        <i class="fas fa-plus-circle"></i> Nuevo Expediente
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <hr class="dropdown-divider">

            <div class="accordion-item" style="padding: 7px">
                <h2 class="accordion-header" id="headingReportes">
                    <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseReportes" aria-expanded="false" aria-controls="collapseReportes"
                        style="color: #e4b04e; font-weight: 600;">
                        <i class="fas fa-chart-bar me-2"></i> Reportes
                    </button>
                </h2>
                <div id="collapseReportes" class="accordion-collapse collapse" aria-labelledby="headingReportes"
                    data-bs-parent="#menuAcordeon">
                    <div class="accordion-body p-0">
                        <ul class="nav flex-column">
                            @if (in_array(Auth::user()->rol, ['Administrador', 'Abogado', 'Asistente']))
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() === 'reportes.plazos' ? 'active' : '' }}"
                                        href="{{ route('reportes.plazos') }}">
                                        <i class="fas fa-exclamation-triangle"></i> Plazos Críticos
                                    </a>
                                </li>
                            @endif
                            @if (in_array(Auth::user()->rol, ['Administrador', 'Abogado']))
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() === 'reportes.carga_casos' ? 'active' : '' }}"
                                        href="{{ route('reportes.carga_casos') }}">
                                        <i class="fas fa-pie-chart"></i> Carga de Casos
                                    </a>
                                </li>
                            @endif
                            @if (Auth::user()->rol === 'Administrador')
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::currentRouteName() === 'reportes.productividad' ? 'active' : '' }}"
                                        href="{{ route('reportes.productividad') }}">
                                        <i class="fas fa-chart-line"></i> Productividad
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <hr class="dropdown-divider">

            @auth
                @if (in_array(auth()->user()->rol, ['Administrador', 'Asistente']))
                    <div class="accordion-item" style="padding: 7px">
                        <h2 class="accordion-header" id="headingAdmin">
                            <button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseAdmin" aria-expanded="false" aria-controls="collapseAdmin"
                                style="color: #e4b04e; font-weight: 600;">
                                <i class="fas fa-cog me-2"></i> 
                                {{ auth()->user()->rol === 'Asistente' ? 'Usuarios' : 'Administración' }}
                            </button>
                        </h2>
                        <div id="collapseAdmin" class="accordion-collapse collapse" aria-labelledby="headingAdmin"
                            data-bs-parent="#menuAcordeon">
                            <div class="accordion-body p-0">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link {{ Route::currentRouteName() === 'usuarios.index' ? 'active' : '' }}"
                                            href="{{ route('usuarios.index') }}">
                                            <i class="fas fa-users"></i> 
                                            {{ auth()->user()->rol === 'Asistente' ? 'Ver Usuarios' : 'Gestión de Usuarios' }}
                                        </a>
                                    </li>
                                    @if (auth()->user()->rol === 'Administrador')
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::currentRouteName() === 'usuarios.create' ? 'active' : '' }}"
                                                href="{{ route('usuarios.create') }}">
                                                <i class="fas fa-user-plus"></i> Nuevo Usuario
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr class="dropdown-divider">
                @endif
            @endauth

        </div>
    </div>
</nav>
