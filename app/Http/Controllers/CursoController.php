<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CursoController extends Controller
{
    /**
     * Lista de cursos con buscador.
     */
    public function index(Request $request)
    {
        $cursos = Curso::with('categoria')
            ->when($request->buscar, function ($query, $buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('titulo', 'like', "%{$buscar}%")
                      ->orWhere('descripcion', 'like', "%{$buscar}%");
                });
            })
            ->get();

        return view('cursos.index', compact('cursos'));
    }

    /**
     * Formulario para crear un curso.
     */
    public function create()
    {
          $this->soloProfesorOAdmin();
        $categorias = Categoria::all();
        return view('cursos.create', compact('categorias'));
    }

    /**
     * Guardar un curso nuevo.
     */
    public function store(Request $request)
    {
         $this->soloProfesorOAdmin();
       $datos = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => ['required', 'numeric', 'min:0', 'max:999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:10024',

        ]);

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('cursos', 'public');
        }

        Curso::create($datos);

        return redirect()->route('cursos.index')->with('exito', 'Curso creado exitosamente.');
    }

    /**
     * Detalle del curso (con reseñas e inscripción).
     */
    public function show(string $id)
    {
        $curso = Curso::with('categoria', 'modulos.lecciones', 'resenas.user')->findOrFail($id);
        $inscrito = auth()->check()
            && auth()->user()->cursosInscritos()->where('cursos.id', $curso->id)->exists();

             
        $puedeEntrar = $inscrito || (auth()->check() && auth()->user()->puedeGestionar());

        return view('cursos.show', compact('curso', 'inscrito', 'puedeEntrar'));
    }

    /**
     * Formulario para editar.
     */
    public function edit(string $id)
    {
         $this->soloProfesorOAdmin();
        $curso = Curso::findOrFail($id);
        $categorias = Categoria::all();
        return view('cursos.edit', compact('curso', 'categorias'));
    }

    /**
     * Actualizar un curso.
     */
    public function update(Request $request, string $id)
    {
         $this->soloProfesorOAdmin();
        $curso = Curso::findOrFail($id);

        $datos = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
          'precio' => ['required', 'numeric', 'min:0', 'max:999999.99', 'regex:/^\d+(\.\d{1,2})?$/'],
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:10024',
        ], [  
    'precio.regex' => 'El precio solo puede tener números y hasta 2 decimales.',
        ]);

        if ($request->hasFile('imagen')) {
            if ($curso->imagen) {
                Storage::disk('public')->delete($curso->imagen);
            }
            $datos['imagen'] = $request->file('imagen')->store('cursos', 'public');
        }

        $curso->update($datos);

        return redirect()->route('cursos.show', $curso->id)->with('exito', 'Curso actualizado exitosamente.');
    }

    /**
     * Eliminar un curso.
     */
    public function destroy(string $id)
    {
         $this->soloProfesorOAdmin();
        $curso = Curso::findOrFail($id);

        if ($curso->imagen) {
            Storage::disk('public')->delete($curso->imagen);
        }

        $curso->delete();

        return redirect()->route('cursos.index')->with('exito', 'Curso eliminado exitosamente.');
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