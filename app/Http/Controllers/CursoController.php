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
        $categorias = Categoria::all();
        return view('cursos.create', compact('categorias'));
    }

    /**
     * Guardar un curso nuevo.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048',
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

        return view('cursos.show', compact('curso', 'inscrito'));
    }

    /**
     * Formulario para editar.
     */
    public function edit(string $id)
    {
        $curso = Curso::findOrFail($id);
        $categorias = Categoria::all();
        return view('cursos.edit', compact('curso', 'categorias'));
    }

    /**
     * Actualizar un curso.
     */
    public function update(Request $request, string $id)
    {
        $curso = Curso::findOrFail($id);

        $datos = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048',
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
        $curso = Curso::findOrFail($id);

        if ($curso->imagen) {
            Storage::disk('public')->delete($curso->imagen);
        }

        $curso->delete();

        return redirect()->route('cursos.index')->with('exito', 'Curso eliminado exitosamente.');
    }
}