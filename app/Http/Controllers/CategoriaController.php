<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function create()
    {
        $this->soloProfesorOAdmin();

        $categorias = Categoria::withCount('cursos')->orderBy('nombre')->get();
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

    /**
     * Formulario para editar una categoría.
     */
    public function edit(Categoria $categoria)
   {
       $this->soloProfesorOAdmin();

       return view('categorias.edit', compact('categoria'));
   }

    /**
     * Actualizar el nombre de una categoría.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $this->soloProfesorOAdmin();

        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre,' . $categoria->id,
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'nombre.unique' => 'Esa categoría ya existe.',
        ]);

        $categoria->nombre = $request->nombre;
        $categoria->save();

        return redirect()->route('categorias.create')->with('exito', 'Categoría actualizada exitosamente.');
    }

    /**
     * Eliminar una categoría.
     * Si tiene cursos no se elimina, porque la llave foránea en cascada
     * borraría también todos esos cursos con sus módulos y lecciones.
     */
    public function destroy(Categoria $categoria)
    {
        $this->soloProfesorOAdmin();

        $totalCursos = $categoria->cursos()->count();

        if ($totalCursos > 0) {
            return redirect()->route('categorias.create')->with(
                'error',
                "No se puede eliminar \"{$categoria->nombre}\" porque tiene {$totalCursos} curso(s). Cambia esos cursos a otra categoría primero."
            );
        }

        $categoria->delete();

        return redirect()->route('categorias.create')->with('exito', 'Categoría eliminada exitosamente.');
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