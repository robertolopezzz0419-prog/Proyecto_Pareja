<?php

namespace App\Http\Controllers;

use App\Models\Leccion;
use Illuminate\Http\Request;

class LeccionController extends Controller
{
  
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'nullable|string',
            'orden' => 'required|integer|min:1',
            'modulo_id' => 'required|exists:modulos,id'
        ]);

        Leccion::create($request->all());

        return back()->with('exito', 'Lección creada exitosamente.');
    }
    
public function alternarCompletada(Request $request, $id)
{
    $leccion = Leccion::findOrFail($id);
    
    $usuarioId = auth()->id() ?? 1; 

    
    $relacion = $leccion->usuarios()->where('user_id', $usuarioId)->first();
    
    $completada = $relacion ? !$relacion->pivot->completada : true;

   
    $leccion->usuarios()->syncWithoutDetaching([
        $usuarioId => ['completada' => $completada]
    ]);

    return back()->with('exito', $completada ? '¡Leccion marcada como completada!' : 'Leccion marcada como pendiente.');
}
}