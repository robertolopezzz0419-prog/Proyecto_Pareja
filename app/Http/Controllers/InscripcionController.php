<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscripcionController extends Controller
{
   
    public function index()
    {
        $cursos = Auth::user()->cursosInscritos()->with('categoria')->get();
        return view('inscripciones.index', compact('cursos'));
    }


    public function store(Curso $curso)
    {
        Auth::user()->cursosInscritos()->syncWithoutDetaching([$curso->id]);
        return back()->with('success', 'Te inscribiste al curso.');
    }


    public function destroy(Curso $curso)
    {
        Auth::user()->cursosInscritos()->detach($curso->id);
        return back()->with('success', 'Te saliste del curso.');
    }
}