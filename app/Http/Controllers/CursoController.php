<?php

namespace App\Http\Controllers;
use App\Models\Curso;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      public function index(Request $request)
    {
        $cursos = Curso::with('categoria')
            ->when($request->buscar, function ($query, $buscar) {
                $query->where('titulo', 'like', "%{$buscar}%")
                      ->orWhere('descripcion', 'like', "%{$buscar}%");
            })
            ->get();

        return view('cursos.index', compact('cursos'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categorias = Categoria::all();
        return view('cursos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $curso = Curso::with('categoria', 'modulos.lecciones', 'resenas.user')->findOrFail($id);
        $inscrito = auth()->check() && auth()->user()->cursosInscritos()->where('cursos_id', $curso->id)->exists();
        return view('cursos.show', compact('curso', 'inscrito'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $curso = Curso::findOrFail($id);
        $categorias = Categoria::all();
        return view('cursos.edit', compact('curso', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
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
            if($curso->imagen) {
                Storage::disk('public')->delete($curso->imagen);
            }
            $datos['imagen'] = $request->file('imagen')->store('cursos', 'public');
        }
        $curso->update($datos);
        return redirect()->route('cursos.show', $curso->id)->with('exito', 'Curso actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $curso = Curso::findOrFail($id);
        if($curso->imagen) {
            Storage::disk('public')->delete($curso->imagen);
        }
        $curso->delete();
        return redirect()->route('cursos.index')->with('exito', 'Curso eliminado exitosamente.');
    }
}
