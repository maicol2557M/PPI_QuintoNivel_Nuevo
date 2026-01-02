<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Ejemplo de endpoint API de prueba
Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

// Ejemplo de recurso API para usuarios
Route::apiResource('usuarios', App\Http\Controllers\Api\UsuarioController::class);
