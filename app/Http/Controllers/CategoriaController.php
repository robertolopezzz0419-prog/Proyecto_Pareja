<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function create()
    {
        $this->soloProfesorOAdmin();

        $categorias = Categoria::all();
        return view('categorias.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $this->soloProfesorOAdmin();

        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre',
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'nombre.unique' => 'Esa categoría ya existe.',
        ]);

        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->save();

        return redirect()->route('categorias.create')->with('exito', 'Categoría creada exitosamente.');
    }

    private function soloProfesorOAdmin()
    {
        if (!auth()->check()) {
            abort(403, 'Debes iniciar sesión.');
        }

        $tienePermiso = auth()->user()->roles->whereIn('nombre', ['Admin', 'Profesor'])->count() > 0;

        if (!$tienePermiso) {
            abort(403, 'No tienes permiso para hacer esto.');
        }
    }
}