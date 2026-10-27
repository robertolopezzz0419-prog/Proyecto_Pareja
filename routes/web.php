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
Route::delete('/modulos/{id}', [ModuloController::class, 'destroy'])->name('modulos.destroy');
Route::post('/lecciones', [LeccionController::class, 'store'])->name('lecciones.store');
Route::get('/lecciones/{id}', [LeccionController::class, 'show'])-> name('lecciones.show');
Route::get('/lecciones/{id}/editar', [LeccionController::class, 'edit'])->name('lecciones.edit');
Route::put('/lecciones/{id}', [LeccionController::class, 'update'])->name('lecciones.update');
Route::delete('/lecciones/{id}', [LeccionController::class, 'destroy'])->name('lecciones.destroy');
Route::post('/lecciones/{id}/completar', [LeccionController::class, 'alternarCompletada'])->name('lecciones.completar');