<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    protected $redirectTo = '/dashboard';

    /**
     * Crea una nueva instancia de controlador.
     *
     * @return void
     */
    public function __construct()
    {
        // Registrar el middleware para la autenticación
        $this->middleware('guest')->except('logout');
    }

    /**
     * Muestra el formulario de login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ... el resto de los métodos (username, login, credentials, logout) ...
    // que mantendremos igual, ya que su lógica es correcta.

    public function username()
    {
        return 'identificacion';
    }

    public function login(Request $request)
    {
        // Si ya hay una sesión autenticada, cerrarla para permitir un nuevo login
        if (Auth::check()) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $this->credentials($request);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            // Evitar redirigir a rutas que el usuario no puede ver.
            $user = Auth::user();

            // Si es Cliente, redirigir a la página pública directamente
            if ($user && $user->rol === 'Cliente') {
                return redirect('/')->with('status', 'Inicio de sesión realizado.');
            }

            // Para roles distintos de Cliente, redirigir siempre al dashboard
            return redirect($this->redirectTo);
        }

        // En lugar de lanzar ValidationException, cerrar sesión (si existiera)
        // e invalidar la sesión, luego redirigir a home con mensaje de error.
        try {
            if (Auth::check()) {
                Auth::guard('web')->logout();
            }
        } catch (\Exception $e) {
            // No interrumpimos el flujo por errores al cerrar sesión
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('error', 'Las credenciales proporcionadas no son válidas.')->withInput($request->only($this->username()));
    }

    protected function credentials(Request $request)
    {
        $identificacion = $request->get($this->username());
        $field = filter_var($identificacion, FILTER_VALIDATE_EMAIL) ? 'email' : 'id_cedula';

        return [
            $field => $identificacion,
            'password' => $request->get('password'),
        ];
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', '¡Sesión cerrada exitosamente!');
    }
}
