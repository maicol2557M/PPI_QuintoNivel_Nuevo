<!DOCTYPE html>
<html>
<head>
    <title>Acceso denegado - ASESORO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .error-container {
            text-align: center;
            padding: 2rem;
            border-radius: 0.5rem;
            background-color: white;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            max-width: 500px;
            width: 100%;
        }
        .error-icon {
            font-size: 4rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h2 class="mb-4">Acceso denegado</h2>
        <p class="mb-4">{{ $message ?? 'No tiene permiso para acceder a este recurso.' }}</p>
        <a href="{{ url()->previous() }}" class="btn btn-primary">
            <i class="fas fa-arrow-left"></i> Volver atrás
        </a>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.all.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Acceso denegado',
                html: '{{ $message ?? "No tiene permiso para acceder a este recurso." }}',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#0d6efd',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        });
    </script>
</body>
</html>
