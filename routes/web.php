<?php



use App\Http\Controllers\Auth\LoginController;

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Artisan; // Importante para las rutas de mantenimiento

use App\Http\Controllers\ReporteController;

use App\Http\Controllers\ExpedienteController;

use App\Http\Controllers\DashboardController;

use App\Http\Controllers\UserController;

use App\Http\Controllers\DocumentoController;



// =================================================================

// RUTAS DE MANTENIMIENTO (PARA RENDER)

// =================================================================



// Visita esta ruta primero: https://lexasesoros.onrender.com/instalar-todo

Route::get('/instalar-todo', function () {

    try {

        // 1. Limpiar configuraciones viejas que puedan tener la IP 127.0.0.1

        Artisan::call('config:clear');

        Artisan::call('cache:clear');

        Artisan::call('view:clear');

        Artisan::call('route:clear');



        // 2. Ejecutar las migraciones (crear las tablas en Postgres)

        Artisan::call('migrate:fresh --seed --force');



        return "✅ Éxito: Sistema optimizado y base de datos actualizada.";

    } catch (\Exception $e) {

        return "❌ Error: " . $e->getMessage();

    }

});



// =================================================================

// RUTAS PÚBLICAS E INFORMATIVAS

// =================================================================



Route::view('/inicio', 'inicio')->name('inicio');

Route::view('/', 'info.index')->name('home');

Route::view('/servicios', 'info.nuestros_servicios.nuestros_servicios')->name('servicios');

Route::view('/sobre-nosotros', 'info.sobre_nosotros.sobre_nosotros')->name('sobre_nosotros');

Route::view('/blog', 'info.blog_informativo.blog_informativo')->name('blog');

Route::view('/contactanos', 'info.contactanos.contactanos')->name('contactanos');



// =================================================================

// RUTAS DE AUTENTICACIÓN

// =================================================================



Route::get('/login', function () {

    return view('info.login.login');

})->name('login');



Route::post('/login', [LoginController::class, 'login']);



Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])

    ->name('register.submit')

    ->middleware('guest');



Route::post('/logout', [LoginController::class, 'logout'])

    ->name('logout')

    ->middleware('auth');



// Rutas de recuperación de contraseña

Route::get('/password/reset', function () {

    return view('auth.passwords.email');

})->name('password.request')->middleware('guest');



Route::post('/password/email', function () {

    return back()->with('status', 'Recuperación de contraseña enviada (simulada).');

})->name('password.email')->middleware('guest');



Route::get('/password/reset/{token}', function () {

    return view('auth.passwords.reset');

})->name('password.reset')->middleware('guest');



Route::post('/password/reset', function () {

    return back()->with('status', 'Contraseña actualizada (simulada).');

})->name('password.update')->middleware('guest');



// =================================================================

// DASHBOARD Y GESTIÓN (Middleware auth.role)

// =================================================================



Route::get('/dashboard', [DashboardController::class, 'index'])

    ->name('dashboard')

    ->middleware('auth.role:Administrador,Abogado,Asistente');



// EXPEDIENTES

Route::middleware(['auth.role:Administrador,Abogado,Asistente'])->group(function () {

    Route::get('/expedientes', [ExpedienteController::class, 'index'])->name('expedientes.index');

    Route::get('/expedientes/{expediente}', [ExpedienteController::class, 'show'])->name('expedientes.show');

});



Route::middleware(['auth.role:Administrador,Abogado'])->group(function () {

    Route::get('/expedientes/create', [ExpedienteController::class, 'create'])->name('expedientes.create');

    Route::post('/expedientes', [ExpedienteController::class, 'store'])->name('expedientes.store');

    Route::get('/expedientes/{expediente}/edit',
