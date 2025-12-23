<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DocumentoController;

// =================================================================
// RUTAS DE MANTENIMIENTO (PARA RENDER)
// =================================================================

Route::get('/instalar-todo', function () {
    try {
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
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
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.submit')->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// =================================================================
// DASHBOARD Y GESTIÓN
// =================================================================

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware('auth.role:Administrador,Abogado,Asistente');

// --- SECCIÓN DE EXPEDIENTES (ORDEN CORREGIDO) ---
Route::middleware(['auth.role:Administrador,Abogado,Asistente'])->group(function () {
    
    // 1. Rutas específicas (DEBEN IR PRIMERO)
    Route::get('/expedientes/create', [ExpedienteController::class, 'create'])->name('expedientes.create');
    Route::get('/expedientes', [ExpedienteController::class, 'index'])->name('expedientes.index');
    
    // 2. Rutas con parámetros variables (DEBEN IR DESPUÉS)
    Route::get('/expedientes/{expediente}', [ExpedienteController::class, 'show'])->name('expedientes.show');
});

Route::middleware(['auth.role:Administrador,Abogado'])->group(function () {
    Route::post('/expedientes', [ExpedienteController::class, 'store'])->name('expedientes.store');
    Route::get('/expedientes/{expediente}/edit', [ExpedienteController::class, 'edit'])->name('expedientes.edit');
    Route::put('/expedientes/{expediente}', [ExpedienteController::class, 'update'])->name('expedientes.update');
});

Route::delete('/expedientes/{expediente}', [ExpedienteController::class, 'destroy'])
    ->name('expedientes.destroy')
    ->middleware('auth.role:Administrador');

// --- RESTO DE RUTAS (REPORTES, USUARIOS, DOCUMENTOS) ---
// (Mantén el resto igual que lo tenías)
