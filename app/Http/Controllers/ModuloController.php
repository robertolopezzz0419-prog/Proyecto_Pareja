<?php

namespace App\Http\Controllers;
use App\Models\Modulo;
use Illuminate\Http\Request;

class ModuloController extends Controller
{
    public function store(Request $request)
    {
        $datos = $request->validate([
            'titulo' => 'required|string|max:255',
            'orden' => 'required|integer|min:1',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        Modulo::create($datos);

        return back()->with('exito', 'Modulo creado exitosamente.');
}
public function destroy($id)
{
    $modulo = Modulo::findOrFail($id);
    $modulo->delete();

    return back()->with('exito', 'Modulo eliminado.');
}}
