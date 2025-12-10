<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Handle public registration from modal form.
     */
    public function register(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'id_cedula' => 'required|string|max:50|unique:usuarios,id_cedula',
            'correo_electronico' => 'required|email|unique:usuarios,email',
            'numero_telefonico' => 'nullable|string|max:50',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $user = User::create([
                'nombre' => $data['nombre'],
                'email' => $data['correo_electronico'],
                'id_cedula' => $data['id_cedula'],
                'identificacion' => $data['id_cedula'],
                'password' => Hash::make($data['password']),
                'rol' => 'Cliente',
                'activo' => true,
            ]);

            Auth::login($user);

            Log::info("Registro público: usuario creado ID={$user->usuario_id} email={$user->email} rol=Cliente");

            return redirect()->route('home')->with('success', 'Registro exitoso. Bienvenido a ASESORO.');
        } catch (\Exception $e) {
            Log::error('Error al registrar usuario público: ' . $e->getMessage());
            return back()->withInput()->withErrors(['registro' => 'No se pudo completar el registro.']);
        }
    }
}
