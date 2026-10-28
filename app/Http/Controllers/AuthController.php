<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function mostrarRegistro()
    {
        return view('auth.registro');
    }

    public function registrar(Request $request)
    {
        // Normaliza el correo para que A@x.com y a@x.com cuenten como el mismo.
        $request->merge(['email' => mb_strtolower(trim((string) $request->input('email')))]);

        $datos = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Escribe un correo válido.',
            'email.unique' => 'Ese correo ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $user = User::create($datos);

        // El registro público siempre crea alumnos.
        // Los profesores se dan de alta desde el seeder (UsuarioPruebaSeeder).
        $rolEstudiante = Rol::firstOrCreate(['nombre' => 'Estudiante']);
        $user->roles()->attach($rolEstudiante->id);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('cursos.index')->with('exito', 'Cuenta creada. ¡Bienvenido!');
    }

    public function mostrarLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credenciales = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'El correo es obligatorio.',
            'email.email' => 'Escribe un correo válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);
        if (Auth::attempt($credenciales, $request->boolean('recordar'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('cursos.index'));
        }

        return back()->withErrors(['email' => 'Correo o contraseña incorrectos.'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('cursos.index');
    }
}