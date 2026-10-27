<?php

namespace App\Http\Controllers;
use App\Models\Modulo;
use Illuminate\Http\Request;

class ModuloController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'orden' => 'required|integer|min:1',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        Modulo::create($datos);

        return back()->with('exito', 'Modulo creado exitosamente.');
}}
