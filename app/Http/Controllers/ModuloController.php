<?php

namespace App\Http\Controllers;

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

        Modulo::create($request->all());

        return back()->with('success', 'Modulo creado exitosamente.');
}}
