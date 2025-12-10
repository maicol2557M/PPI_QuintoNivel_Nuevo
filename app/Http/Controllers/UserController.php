<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Constructor del controlador.
     */
    public function __construct()
    {
        // Aplicar el middleware de autenticación a todos los métodos
        $this->middleware('auth');
        
        // Verificación de permisos para cada método
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            $currentAction = $request->route()->getActionMethod();
            
            // Métodos permitidos para asistentes
            $allowedForAsistente = ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'];
            
            // Si es asistente y no está en los métodos permitidos, denegar acceso
            if ($user->rol === 'Asistente' && !in_array($currentAction, $allowedForAsistente)) {
                abort(403, 'Acceso denegado. No tienes permiso para realizar esta acción.');
            }
            
            return $next($request);
        });
    }
    /**
     * Mostrar listado de usuarios (solo Administrador).
     */
    public function index()
    {
        $user = auth()->user();
        
        // Solo administradores y asistentes pueden ver la lista de usuarios
        if (!in_array($user->rol, ['Administrador', 'Asistente'])) {
            abort(403, 'Acceso denegado. No tienes permiso para ver la lista de usuarios.');
        }

        // Si es asistente, solo puede ver abogados
        if ($user->rol === 'Asistente') {
            $usuarios = User::where('rol', 'Abogado')->paginate(15);
        } else {
            $usuarios = User::paginate(15);
        }
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Mostrar formulario para crear nuevo usuario.
     */
    public function create()
    {
        $user = auth()->user();
        
        // Solo administradores pueden crear cualquier tipo de usuario
        // Asistentes solo pueden crear abogados
        if ($user->rol === 'Asistente') {
            $roles = ['Abogado'];
        } else if ($user->rol === 'Administrador') {
            $roles = ['Administrador', 'Abogado', 'Asistente'];
        } else {
            abort(403, 'Acceso denegado. No tienes permiso para crear usuarios.');
        }
        
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Guardar nuevo usuario en base de datos.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        
        // Verificar permisos
        if (!in_array($user->rol, ['Administrador', 'Asistente'])) {
            abort(403, 'Acceso denegado. No tienes permiso para crear usuarios.');
        }
        
        // Si es asistente, solo puede crear abogados
        if ($user->rol === 'Asistente' && $request->rol !== 'Abogado') {
            abort(403, 'Los asistentes solo pueden registrar abogados.');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'id_cedula' => 'required|string|unique:usuarios,id_cedula',
            'identificacion' => 'required|string|unique:usuarios,identificacion',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:Administrador,Abogado,Asistente',
            'activo' => 'boolean',
        ]);

        try {
            $usuario = User::create([
                'nombre' => $validated['nombre'],
                'email' => $validated['email'],
                'id_cedula' => $validated['id_cedula'],
                'identificacion' => $validated['identificacion'],
                'password' => Hash::make($validated['password']),
                'rol' => $validated['rol'],
                'activo' => $request->boolean('activo', true),
            ]);

            Log::info("Usuario creado: {$usuario->nombre} ({$usuario->email}) - Rol: {$usuario->rol}");

            return redirect()->route('usuarios.show', $usuario->usuario_id)
                ->with('success', "Usuario '{$usuario->nombre}' creado exitosamente.");
        } catch (\Exception $e) {
            Log::error("Error al crear usuario: {$e->getMessage()}");
            return back()->with('error', 'Error al crear el usuario.')->withInput();
        }
    }

    /**
     * Mostrar detalle de un usuario.
     */
    public function show($id)
    {
        $user = auth()->user();
        
        // Solo administradores y asistentes pueden ver detalles de usuarios
        if (!in_array($user->rol, ['Administrador', 'Asistente'])) {
            abort(403, 'Acceso denegado. No tienes permiso para ver los detalles de usuarios.');
        }
        
        $usuario = User::findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Mostrar formulario para editar usuario.
     */
    public function edit($id)
    {
        $user = auth()->user();
        $usuario = User::findOrFail($id);
        
        // Si es asistente, solo puede editar abogados
        if ($user->rol === 'Asistente') {
            if ($usuario->rol !== 'Abogado') {
                abort(403, 'Solo puedes editar usuarios con rol de Abogado.');
            }
            $roles = ['Abogado'];
        } else if ($user->rol === 'Administrador') {
            $roles = ['Administrador', 'Abogado', 'Asistente'];
        } else {
            abort(403, 'Acceso denegado. No tienes permiso para editar usuarios.');
        }
        
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Actualizar usuario en base de datos.
     */
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $usuario = User::findOrFail($id);
        
        // Si es asistente, solo puede actualizar abogados
        if ($user->rol === 'Asistente') {
            if ($usuario->rol !== 'Abogado') {
                abort(403, 'Solo puedes actualizar usuarios con rol de Abogado.');
            }
            // Forzar el rol a Abogado para asistentes
            $request->merge(['rol' => 'Abogado']);
        }
        
        // Si no es administrador ni asistente, denegar acceso
        if (!in_array($user->rol, ['Administrador', 'Asistente'])) {
            abort(403, 'Acceso denegado. No tienes permiso para actualizar usuarios.');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $usuario->usuario_id . ',usuario_id',
            'id_cedula' => 'required|string|unique:usuarios,id_cedula,' . $usuario->usuario_id . ',usuario_id',
            'identificacion' => 'required|string|unique:usuarios,identificacion,' . $usuario->usuario_id . ',usuario_id',
            'rol' => 'required|in:Administrador,Abogado,Asistente',
            'activo' => 'boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        try {
            $usuario->nombre = $validated['nombre'];
            $usuario->email = $validated['email'];
            $usuario->id_cedula = $validated['id_cedula'];
            $usuario->identificacion = $validated['identificacion'];
            $usuario->rol = $validated['rol'];
            $usuario->activo = $request->boolean('activo', true);

            if ($validated['password'] ?? null) {
                $usuario->password = Hash::make($validated['password']);
            }

            $usuario->save();

            Log::info("Usuario actualizado: {$usuario->nombre} ({$usuario->email}) - Rol: {$usuario->rol}");

            return redirect()->route('usuarios.show', $usuario->usuario_id)
                ->with('success', "Usuario '{$usuario->nombre}' actualizado exitosamente.");
        } catch (\Exception $e) {
            Log::error("Error al actualizar usuario: {$e->getMessage()}");
            return back()->with('error', 'Error al actualizar el usuario.')->withInput();
        }
    }

    /**
     * Desactivar usuario.
     */
    public function destroy($id)
    {
        $user = auth()->user();
        $usuario = User::findOrFail($id);
        
        // Si es asistente, solo puede desactivar abogados
        if ($user->rol === 'Asistente') {
            if ($usuario->rol !== 'Abogado') {
                abort(403, 'Solo puedes desactivar usuarios con rol de Abogado.');
            }
        } 
        // Si no es administrador ni asistente, denegar acceso
        elseif ($user->rol !== 'Administrador') {
            abort(403, 'Acceso denegado. No tienes permiso para desactivar usuarios.');
        }

        try {
            $usuario->activo = false;
            $usuario->save();

            Log::info("Usuario desactivado: {$usuario->nombre} ({$usuario->email})");

            return redirect()->route('usuarios.index')
                ->with('success', "Usuario '{$usuario->nombre}' desactivado exitosamente.");
        } catch (\Exception $e) {
            Log::error("Error al desactivar usuario: {$e->getMessage()}");
            return back()->with('error', 'Error al desactivar el usuario.');
        }
    }

    /**
     * Reactivar usuario inactivo.
     */
    public function reactivate($id)
    {
        if (!auth()->check() || !in_array(auth()->user()->rol, ['Administrador', 'Asistente'])) {
            abort(403, 'Acceso denegado. Se requieren privilegios de administrador para reactivar usuarios.');
        }

        try {
            $usuario = User::findOrFail($id);
            $usuario->activo = true;
            $usuario->save();

            Log::info("Usuario reactivado: {$usuario->nombre} ({$usuario->email})");

            return back()->with('success', "Usuario '{$usuario->nombre}' reactivado exitosamente.");
        } catch (\Exception $e) {
            Log::error("Error al reactivar usuario: {$e->getMessage()}");
            return back()->with('error', 'Error al reactivar el usuario.');
        }
    }
}
