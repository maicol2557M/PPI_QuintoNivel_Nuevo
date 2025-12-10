<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ASESORO - Sistema de Gestión Jurídica')</title>

    @include('layouts.head')
    
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #1f1f1f;
            font-family: 'Roboto', sans-serif;
            padding-top: 70px;
        }

        .navbar {
            background: linear-gradient(135deg, #1f1f1f 0%, #1f1f1f 100%);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 0.5rem 1rem;
            position: sticky;
            top: 0;
            z-index: 3000;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 56px;
            z-index: 3000;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: #fff !important;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Links dentro del navbar */
        .navbar .nav-link {
            color: rgba(255, 255, 255, 0.95);
            padding: 0.5rem 0.75rem;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            color: #e6eefc;
            text-decoration: none;
        }

        /* Toggle icon (mejor contraste en teléfonos) */
        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.15);
        }

        .navbar-toggler-icon {
            filter: invert(1) brightness(2) contrast(.8);
        }

        /* Dropdown dentro del navbar: mantener menú claro sobre fondo oscuro */
        .navbar .dropdown-menu {
            min-width: 12rem;
            border-radius: 0.35rem;
            padding: 0.25rem 0;
        }

        .navbar .dropdown-item {
            color: #333;
        }

        .navbar .dropdown-item:hover {
            background-color: #f1f5fb;
        }

        /* Usuario (nombre) en el dropdown: más compacto */
        .navbar .dropdown-item-text.small {
            color: #6c757d;
            padding-left: 1rem;
            padding-right: 1rem;
        }

        /* Asegurar visibilidad cuando el sidebar esté presente */
        @media (min-width: 992px) {
            .navbar {
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }
        }

        .sidebar {
            background-color: #1f1f1f;
            border-right: 1px solid #dee2e6;
            min-height: calc(100vh - 56px);
            position: relative;
            z-index: 1000;
        }

        .sidebar .nav-link {
            color: #b8860b;
            border-left: 3px solid transparent;
            padding: 0.75rem 1rem;
        }

        .sidebar .nav-link:hover {
            background-color: #1f1f1f;
            color: #b8860b;
            border-left-color: #dda236;
        }

        .sidebar .nav-link.active {
            background-color: #1f1f1f;
            color: #e4b04e;
            border-left-color: #dda236;
            font-weight: 600;
        }

        .main-content {
            background-color: #e9e9e9;
            min-height: calc(100vh - 56px);
            padding: 2rem;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 2rem;
        }

        .badge-vencido {
            background-color: #dc3545;
        }

        .badge-pendiente {
            background-color: #ffc107;
            color: #000;
        }

        .badge-abierto {
            background-color: #28a745;
        }

        .badge-cerrado {
            background-color: #6c757d;
        }

        .table-striped tbody tr:hover {
            background-color: #f5f5f5;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
        }

        .alert {
            border-radius: 0.5rem;
        }

        .page-header {
            background-color: #fff;
            padding: 2rem;
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 2rem;
            border-radius: 0.5rem;
        }

        .page-header h1 {
            color: #333;
            font-weight: 700;
            margin-bottom: 0;
        }

        .page-header small {
            color: #6c757d;
        }
    </style>

    @yield('styles')
</head>

<body>
    @include('layouts.nav')
    @auth
        <div class="container-fluid">
            <div class="row">
                @include('layouts.sidebar')
                <!-- Main Content -->
                <main class="col-md-10 ms-sm-auto px-md-4 main-content">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h5 class="alert-heading">
                                <i class="fas fa-exclamation-circle"></i> Errores de validación
                            </h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-times-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <main class="main-content">
            @yield('content')
        </main>
    @endauth

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery (si lo necesitas) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @yield('scripts')
</body>

</html>
 