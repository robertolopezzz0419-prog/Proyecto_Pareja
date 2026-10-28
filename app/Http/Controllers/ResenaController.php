<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Resena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResenaController extends Controller
{
    private function reglas(): array
    {
        return [
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ];
    }

    private function mensajes(): array
    {
        return [
            'calificacion.required' => 'La calificación es obligatoria.',
            'calificacion.integer' => 'La calificación debe ser un número.',
            'calificacion.min' => 'La calificación mínima es 1.',
            'calificacion.max' => 'La calificación máxima es 5.',
            'comentario.max' => 'El comentario no puede tener más de 1000 caracteres.',
        ];
    }

    /**
     * Crear reseña: solo alumnos inscritos al curso.
     */
    public function store(Request $request, Curso $curso)
    {
        if (!Auth::user()->esEstudiante()) {
            abort(403, 'Solo los alumnos pueden dejar reseñas.');
        }

        $datos = $request->validate($this->reglas(), $this->mensajes());

        if (!Auth::user()->cursosInscritos()->where('curso_id', $curso->id)->exists()) {
            return back()->with('error', 'Debes estar inscrito para dejar una reseña.');
        }

        if (Auth::user()->resenas()->where('curso_id', $curso->id)->exists()) {
            return back()->with('error', 'Ya dejaste una reseña en este curso.');
        }

        Resena::create([
            'user_id' => Auth::id(),
            'curso_id' => $curso->id,
            'calificacion' => $datos['calificacion'],
            'comentario' => $datos['comentario'] ?? null,
        ]);

        return back()->with('success', 'Gracias por tu reseña.');
    }

    /**
     * Formulario para editar: solo el alumno autor de la reseña.
     */
    public function edit(Resena $resena)
    {
        $this->soloAutorEstudiante($resena);

        return view('resenas.edit', compact('resena'));
    }

    /**
     * Actualizar reseña: solo el alumno autor de la reseña.
     */
    public function update(Request $request, Resena $resena)
    {
        $this->soloAutorEstudiante($resena);

        $datos = $request->validate($this->reglas(), $this->mensajes());

        $resena->update([
            'calificacion' => $datos['calificacion'],
            'comentario' => $datos['comentario'] ?? null,
        ]);

        return redirect()->route('cursos.show', $resena->curso_id)->with('success', 'Reseña actualizada.');
    }

    /**
     * Eliminar reseña: el alumno autor, o Admin/Profesor para moderar.
     */
    public function destroy(Resena $resena)
    {
        $usuario = Auth::user();
        $esAutor = $usuario->esEstudiante() && $resena->user_id === $usuario->id;

        if (!$esAutor && !$usuario->puedeGestionar()) {
            abort(403, 'No puedes eliminar esta reseña.');
        }

        $cursoId = $resena->curso_id;
        $resena->delete();

        return redirect()->route('cursos.show', $cursoId)->with('success', 'Reseña eliminada.');
    }

    private function soloAutorEstudiante(Resena $resena): void
    {
        $usuario = Auth::user();

        if (!$usuario->esEstudiante() || $resena->user_id !== $usuario->id) {
            abort(403, 'Solo el alumno que escribió la reseña puede modificarla.');
        }
    }
}