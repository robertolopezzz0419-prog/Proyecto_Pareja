<?php

namespace App\Http\Controllers;

use App\Models\Leccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LeccionController extends Controller
{
  Private function usuarioActual()
    {
        return auth()->id() ?? 1;
    }

    public function store(Request $request)
    {
     $datos = $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'nullable|string',
            'video_url' => 'nullable|url',
            'orden' => 'required|integer|min:1',
            'modulo_id' => 'required|exists:modulos,id'
        ]);

        Leccion::create($datos);

        return back()->with('exito', 'Lección creada exitosamente.');
    }
    public function show($id)
    {
        $leccion = Leccion::with('modulo.curso.modulos.lecciones')->findOrFail($id);
        $curso = $leccion->modulo->curso;
        $completadas = DB::table('leccion_usuario')
            ->where('user_id', $this->usuarioActual())
            ->where('completado', true)
            ->pluck('leccion_id')
            ->toArray();

            $estaCompletada = in_array($leccion->id, $completadas);

            $total = 0;
            $hechas = 0;
            foreach ($curso->modulos as $modulo) {
               foreach ($modulo->lecciones as $l) {
                    $total++;
                    if (in_array($l->id, $completadas)) {
                        $hechas++;
                    }
                }
            }
            $progreso = $total > 0 ? round($hechas * 100 / $total) : 0;
            return view('lecciones.show', compact('leccion', 'curso', 'completadas', 'estaCompletada', 'progreso'));
    }
    

    public function edit($id)
{
    $leccion = Leccion::with('modulo.curso')->findOrFail($id);
    return view('lecciones.edit', compact('leccion'));
}

public function update(Request $request, $id)
{
    $leccion = Leccion::findOrFail($id);

    $datos = $request->validate([
        'titulo' => 'required|string|max:255',
        'contenido' => 'nullable|string',
        'video_url' => 'nullable|url',
        'orden' => 'required|integer|min:1',
    ]);

    $leccion->update($datos);

    return redirect()->route('cursos.show', $leccion->modulo->curso_id)->with('exito', 'Leccion actualizada.');
}

public function destroy($id)
{
    $leccion = Leccion::findOrFail($id);
    $cursoId = $leccion->modulo->curso_id;

    $leccion->delete();

    return redirect()->route('cursos.show', $cursoId)->with('exito', 'Leccion eliminada.');
}
public function alternarCompletada(Request $request, $id)
{
    $leccion = Leccion::findOrFail($id);
    
    $usuarioId = $this->usuarioActual();
$registro = $leccion->usuarios()->where('user_id', $usuarioId)->first();

    $completado = $registro ? !$registro->pivot->completado : true;

   
    $leccion->usuarios()->syncWithoutDetaching([
        $usuarioId => ['completado' => $completado]
    ]);

    return back()->with('exito', $completado ? '¡Leccion marcada como completada!' : 'Leccion marcada como pendiente.');
}
}