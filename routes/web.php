<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\LeccionController;
Route::get('/', function () {
    return view('welcome');
});
Route::resource('cursos', CursoController::class);
Route::post('/modulos', [ModuloController::class, 'store'])->name('modulos.store');
Route::post('/lecciones', [LeccionController::class, 'store'])->name('lecciones.store');
Route::get('/lecciones/{id}', [LeccionController::class, 'show'])-> name('lecciones.show');
Route::post('/lecciones/{id}/completar', [LeccionController::class, 'alternarCompletada'])->name('lecciones.completar');