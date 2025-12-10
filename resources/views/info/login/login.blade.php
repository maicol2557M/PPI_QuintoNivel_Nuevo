<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - ASESORO</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/estaticCSS/styles_login.css') }}" rel="stylesheet">
</head>

<body>
    <div class="login-container">
        <div class="btn-back">
            <button onclick="window.location.href='{{ route('home') }}'">Volver</button>
        </div>
        <div class="logo-container">
            <img src="{{ asset('assets/img2/Logo asesoro.png') }}" alt="Logo">
        </div>
        <div class="login-header">
            <h1>Bienvenido a ASESORO</h1>
            <p>Inicia sesión para continuar</p>
        </div>
        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Mensajes de Sesión (Success/Status/Error) --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('status'))
                <div class="alert alert-info">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Errores de Validación Generales (Si Laravel no los asocia a un campo específico) --}}
            @if ($errors->any() && !$errors->has('identificacion') && !$errors->has('password'))
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            {{-- Solo mostramos errores que no se están manejando directamente debajo de un campo --}}
                            @if (!in_array($error, ['El campo identificación es obligatorio.', 'El campo contraseña es obligatorio.']))
                                <li>{{ $error }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Campo de Identificación (Cédula o Correo electrónico) --}}
            <div class="mb-3">
                <label for="identificacion" class="form-label">Cédula o Correo electrónico</label>
                <div class="input-group">
                    <input type="text" class="form-control @error('identificacion') is-invalid @enderror"
                        id="identificacion" name="identificacion" placeholder="Ingresa tu cédula o correo electrónico"
                        required value="{{ old('identificacion') }}" autocomplete="username">
                    <span class="input-group-text icon-container">
                        <i class="fa-solid fa-user-large"></i>
                    </span>

                    {{-- Mensaje de Error Específico para Identificación --}}
                    @error('identificacion')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            {{-- Campo de Contraseña --}}
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <div class="input-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Ingresa tu contraseña" required>
                    <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordVisibility()">
                        <i class="fa fa-eye" id="toggleEye"></i>
                    </button>

                    {{-- Mensaje de Error Específico para Contraseña --}}
                    @error('password')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-login">Iniciar Sesión</button>
        </form>

        <div class="login-footer">
            <p>
                ¿Olvidaste tu contraseña? <a href="#" data-bs-toggle="modal"
                    data-bs-target="#forgotPasswordModal">Recupérala aquí</a>
            </p>
            <p>
                ¿No tienes una cuenta? <a href="#" data-bs-toggle="modal"
                    data-bs-target="#registerModal">Regístrate</a>
            </p>
        </div>
    </div>

    <!-- Modal Forgot Password -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">Recuperar Contraseña</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="forgotPasswordForm" method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="correo_electronico" class="form-label">Ingresa tu correo electrónico</label>
                            <input type="email" class="form-control" id="correo_electronico" name="correo_electronico"
                                placeholder="Correo electrónico" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Enviar enlace de recuperación</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Forgot Password Success -->
    <div class="modal fade" id="forgotPasswordSuccessModal" tabindex="-1"
        aria-labelledby="forgotPasswordSuccessModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordSuccessModalLabel">Éxito</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Se ha enviado un enlace de recuperación a tu correo electrónico.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Register -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Crear una Cuenta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm" method="POST" action="{{ route('register.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                placeholder="Ingresa tu nombre completo" required>
                        </div>
                        <div class="mb-3">
                            <label for="id_cedula" class="form-label">Cédula</label>
                            <input type="text" class="form-control" id="id_cedula" name="id_cedula"
                                placeholder="Ingresa tu cédula" required pattern="[0-9]+"
                                title="Ingresa solo números">
                        </div>
                        <div class="mb-3">
                            <label for="correo_electronico" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="correo_electronico"
                                name="correo_electronico" placeholder="Ingresa tu correo electrónico" required>
                        </div>
                        <div class="mb-3">
                            <label for="numero_telefonico" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="numero_telefonico"
                                name="numero_telefonico" placeholder="Ingresa tu teléfono" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Ingresa tu contraseña" required minlength="6">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" placeholder="Confirma tu contraseña" required
                                minlength="6">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Crear Cuenta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Register Success -->
    <div class="modal fade" id="registerSuccessModal" tabindex="-1" aria-labelledby="registerSuccessModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerSuccessModalLabel">¡Registro Exitoso!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Te has registrado correctamente. ¡Bienvenido!</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleEye = document.getElementById('toggleEye');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleEye.classList.remove('fa-eye');
                toggleEye.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleEye.classList.remove('fa-eye-slash');
                toggleEye.classList.add('fa-eye');
            }
        }


        // Los formularios ahora se enviarán directamente a las rutas configuradas
        document.getElementById('forgotPasswordForm').addEventListener('submit', function() {
            // El formulario se enviará automáticamente
        });

        document.getElementById('registerForm').addEventListener('submit', function() {
            // El formulario se enviará automáticamente
        });

        // El formulario ahora envía por POST a la ruta login.submit.
        // HTML5 realizará las validaciones de los campos definidos.



        function showAlert(message, success = false) {
            const alertBox = document.getElementById('alertBox');
            const alertMessage = document.getElementById('alertMessage');


            alertMessage.textContent = message;
            alertBox.className = `alert-box ${success ? 'success' : 'error'}`;


            alertBox.classList.remove('hidden');


            setTimeout(() => {
                alertBox.classList.add('hidden');
            }, 3000);
        }



        document.getElementById('closeAlert').addEventListener('click', function() {
            document.getElementById('alertBox').classList.add('hidden');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
