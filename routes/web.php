<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ModuloController;
Route::get('/', function () {
    return view('welcome');
});
Route::resource('cursos', CursoController::class);
Route::post('/modulos', [ModuloController::class, 'store'])->name('modulos.store');