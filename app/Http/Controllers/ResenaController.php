<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Resena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResenaController extends Controller
{
    public function store(Request $request, Curso $curso)
    {
        $datos = $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'nullable|string|max:1000',
        ]);

        if (!Auth::user()->cursosInscritos()->where('curso_id', $curso->id)->exists()) {
            return back()->with('error', 'Debes estar inscrito para dejar una resena.');
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

        return back()->with('success', 'Gracias por tu resena.');
    }
}