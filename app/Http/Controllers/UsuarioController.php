<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function __construct()
    {
        // Solo admin puede gestionar usuarios
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || Auth::user()->cargo !== 'admin') {
                abort(403, 'Acceso denegado');
            }
            return $next($request);
        })->except(['loginForm', 'login', 'logout']);
    }

    // Mostrar formulario de registro
    public function registerForm()
    {
        return view('admin.register-user');
    }

    // Registrar usuario
    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuario,correo',
            'password' => 'required|string|min:6|confirmed',
            'ci' => 'nullable|string|unique:usuario,ci',
        ]);

        $data = $request->all();
        $data['password'] = bcrypt($data['password']); // 🔐 hashear contraseña

        Usuario::create($data);

        return redirect()->route('admin.usuarios')->with('success', 'Usuario registrado correctamente.');
    }

    // Mostrar todos los usuarios
    public function index()
    {
        $usuarios = Usuario::all();
        return view('admin.usuarios', compact('usuarios'));
    }

    // Mostrar formulario de edición
    public function edit(Usuario $usuario)
    {
        return view('admin.edit-usuario', compact('usuario'));
    }

    // Actualizar usuario
    public function update(Request $request, Usuario $usuario)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'correo' => 'required|email|unique:usuario,correo,' . $usuario->id,
            'ci' => 'nullable|string|unique:usuario,ci,' . $usuario->id,
        ]);

        $data = $request->all();

        // Solo actualizar contraseña si se envía
        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios')->with('success', 'Usuario actualizado correctamente.');
    }

    // Inhabilitar / habilitar usuario
    public function toggleInhabilitado(Usuario $usuario)
    {
        $usuario->inhabilitado = !$usuario->inhabilitado;
        $usuario->save();

        return redirect()->route('admin.usuarios')->with('success', 'Estado actualizado.');
    }

    // Login
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'correo' => 'required|email',
            'password' => 'required|string',
        ]);


        if (Auth::attempt(['correo' => $credentials['correo'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/usuarios');
        }

        return back()->withErrors(['correo' => 'Credenciales incorrectas o usuario inhabilitado.']);
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
