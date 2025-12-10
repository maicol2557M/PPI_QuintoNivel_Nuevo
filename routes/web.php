<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentoController;

// =================================================================
// RUTAS PÚBLICAS E INFORMATIVAS
// =================================================================

// Vista de inicio (archivo resources/views/inicio.blade.php o info.index)
Route::view('/inicio', 'inicio')->name('inicio');
// La raíz muestra el index principal
Route::view('/', 'info.index')->name('home');

Route::view('/servicios', 'info.nuestros_servicios.nuestros_servicios')->name('servicios');
Route::view('/sobre-nosotros', 'info.sobre_nosotros.sobre_nosotros')->name('sobre_nosotros');
Route::view('/blog', 'info.blog_informativo.blog_informativo')->name('blog');
Route::view('/contactanos', 'info.contactanos.contactanos')->name('contactanos');

// =================================================================
// RUTAS DE AUTENTICACIÓN (LOGIN)
// =================================================================

// RUTA GET: Muestra el formulario de login
Route::get('/login', function () {
    return view('info.login.login');
})->name('login');

// RUTA POST: Procesa el envío del formulario
Route::post('/login', [LoginController::class, 'login']);

// Ruta pública para registro desde modal en la pantalla de login
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])
    ->name('register.submit')
    ->middleware('guest');

// Nota: Faltan las rutas de LOGOUT, REGISTRO, y RESETEADO de contraseña si no usas Auth::routes()
// Por ejemplo, para el Logout:
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Rutas de recuperación de contraseña (stub para evitar errores)
// En producción, implementa Password Reset completo con PasswordResetController
Route::get('/password/reset', function () {
    return view('auth.passwords.email');
})->name('password.request')->middleware('guest');

Route::post('/password/email', function () {
    return back()->with('status', 'Recuperación de contraseña no implementada aún.');
})->name('password.email')->middleware('guest');

Route::get('/password/reset/{token}', function () {
    return view('auth.passwords.reset');
})->name('password.reset')->middleware('guest');

Route::post('/password/reset', function () {
    return back()->with('status', 'Reset de contraseña no implementado aún.');
})->name('password.update')->middleware('guest');

// =================================================================
// DASHBOARD Y RUTAS AUTENTICADAS GENERALES (Solo Personal Administrativo)
// =================================================================

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth.role:Administrador,Abogado,Asistente');

// =================================================================
// RUTAS AUTENTICADAS (EXPEDIENTES Y REPORTES)
// =================================================================

// RUTA GET PARA CREAR EXPEDIENTE (mostrar formulario)
Route::get('/expedientes/create', [ExpedienteController::class, 'create'])
    ->name('expedientes.create')
    ->middleware('auth.role:Administrador,Abogado');

// RUTA POST PARA CREAR EXPEDIENTE
Route::post('/expedientes', [ExpedienteController::class, 'store'])
    ->name('expedientes.store')
    ->middleware('auth.role:Administrador,Abogado');

// RUTA GET PARA EDITAR EXPEDIENTE (mostrar formulario)
Route::get('/expedientes/{expediente}/edit', [ExpedienteController::class, 'edit'])
    ->name('expedientes.edit')
    ->middleware('auth.role:Administrador,Abogado');

// RUTA PUT/PATCH PARA ACTUALIZAR EXPEDIENTE
Route::put('/expedientes/{expediente}', [ExpedienteController::class, 'update'])
    ->name('expedientes.update')
    ->middleware('auth.role:Administrador,Abogado');

// RUTA DELETE PARA ELIMINAR EXPEDIENTE
Route::delete('/expedientes/{expediente}', [ExpedienteController::class, 'destroy'])
    ->name('expedientes.destroy')
    ->middleware('auth.role:Administrador');

// RUTA DE REPORTE CRÍTICO (Permisos: Todos los roles deben ver esto)
Route::get('/reportes/plazos-criticos', [ReporteController::class, 'plazosCriticos'])
    ->name('reportes.plazos')
    ->middleware('auth.role:Administrador,Abogado,Asistente');

// RUTA DE REPORTE DE CARGA (Permisos: Administrador y Abogado)
Route::get('/reportes/carga-casos', [ReporteController::class, 'cargaCasosPorAbogado'])
    ->name('reportes.carga_casos')
    ->middleware('auth.role:Administrador,Abogado');

// RUTA DE REPORTE DE PRODUCTIVIDAD (Permisos: Administrador)
Route::get('/reportes/productividad', [\App\Http\Controllers\ProductividadController::class, 'index'])
    ->name('reportes.productividad')
    ->middleware('auth.role:Administrador');

// RUTA DE DETALLE (SHOW)
Route::get('/expedientes/{expediente}', [ExpedienteController::class, 'show'])
    ->name('expedientes.show')
    ->middleware('auth.role:Administrador,Abogado,Asistente');

// RUTA DE LISTADO (INDEX)
Route::get('/expedientes', [ExpedienteController::class, 'index'])
    ->name('expedientes.index')
    ->middleware('auth.role:Administrador,Abogado,Asistente');

// RUTA PARA VER DETALLES DE EXPEDIENTE (Permitir a asistentes)
Route::get('/expedientes/{expediente}', [ExpedienteController::class, 'show'])
    ->name('expedientes.show')
    ->middleware('auth.role:Administrador,Abogado,Asistente');

// =================================================================
// RUTAS DE GESTIÓN DE USUARIOS
// =================================================================

// Rutas accesibles para administradores y asistentes (con restricciones en el controlador)
Route::middleware(['auth.role:Administrador,Asistente'])->group(function () {
    // Rutas de listado y creación
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
    
    // Rutas de visualización y edición
    Route::get('/usuarios/{usuario}', [UserController::class, 'show'])->name('usuarios.show');
    Route::get('/usuarios/{usuario}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
    
    // Ruta para desactivar usuarios (solo abogados para asistentes)
    Route::delete('/usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    
    // Solo administradores pueden reactivar usuarios
    Route::middleware(['auth.role:Administrador'])->group(function () {
        Route::post('/usuarios/{usuario}/reactivate', [UserController::class, 'reactivate'])->name('usuarios.reactivate');
    });
});

// =================================================================
// RUTAS DE GESTIÓN DE DOCUMENTOS
// =================================================================

Route::get('/documentos/{documento}/download', [DocumentoController::class, 'download'])
    ->name('documentos.download')
    ->middleware('auth.role:Administrador,Abogado,Asistente');

Route::delete('/documentos/{documento}', [DocumentoController::class, 'destroy'])
    ->name('documentos.destroy')
    ->middleware('auth.role:Administrador,Abogado');
