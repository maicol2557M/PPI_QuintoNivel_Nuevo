<!-- Bootstrap CSS (local) -->
<link href="{{ asset('css/BootstrapCss/bootstrap.min.css') }}" rel="stylesheet">

<!-- Font Awesome (local) -->
<link href="{{ asset('css/FontAwesomeCss/all.min.css') }}" rel="stylesheet">

<!-- Asegurar que FontAwesome use las webfonts locales en /fonts/webfonts -->
<style>
    @font-face {
        font-family: "Font Awesome 7 Brands";
        font-style: normal;
        font-weight: 400;
        font-display: block;
        src: url('{{ asset('fonts/webfonts/fa-brands-400.woff2') }}') format('woff2');
    }

    @font-face {
        font-family: "Font Awesome 7 Free";
        font-style: normal;
        font-weight: 400;
        font-display: block;
        src: url('{{ asset('fonts/webfonts/fa-regular-400.woff2') }}') format('woff2');
    }

    @font-face {
        font-family: "Font Awesome 7 Free";
        font-style: normal;
        font-weight: 900;
        font-display: block;
        src: url('{{ asset('fonts/webfonts/fa-solid-900.woff2') }}') format('woff2');
    }

    @font-face {
        font-family: "FontAwesome";
        font-style: normal;
        font-display: block;
        src: url('{{ asset('fonts/webfonts/fa-v4compatibility.woff2') }}') format('woff2');
    }
</style>

<style>
    body {
        background-color: #f8f9fa;
        font-family: 'Roboto', sans-serif;
        padding-top: 70px;
    }

    .navbar {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        background-color: #fff;
        border-right: 1px solid #dee2e6;
        min-height: calc(100vh - 56px);
        position: relative;
        z-index: 1000;
    }

    .sidebar .nav-link {
        color: #495057;
        border-left: 3px solid transparent;
        padding: 0.75rem 1rem;
    }

    .sidebar .nav-link:hover {
        background-color: #f8f9fa;
        color: #667eea;
        border-left-color: #667eea;
    }

    .sidebar .nav-link.active {
        background-color: #e7f3ff;
        color: #667eea;
        border-left-color: #667eea;
        font-weight: 600;
    }

    .main-content {
        background-color: #f8f9fa;
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

<!-- Hojas de estilo del proyecto -->
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('css/estaticCSS/styles.css') }}" rel="stylesheet">
<link href="{{ asset('css/estaticCSS/styles_login.css') }}" rel="stylesheet">
<link href="{{ asset('css/estaticCSS/styles_nosotros.css') }}" rel="stylesheet">
<link href="{{ asset('css/estaticCSS/styles_nuestros.css') }}" rel="stylesheet">
<link href="{{ asset('css/estaticCSS/styless_contactanos.css') }}" rel="stylesheet">
<link href="{{ asset('css/estaticCSS/styless_blog.css') }}" rel="stylesheet">

@yield('styles')
