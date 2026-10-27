<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\LeccionController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\ResenaController;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return view('welcome');
});
Route::resource('cursos', CursoController::class);
Route::post('/modulos', [ModuloController::class, 'store'])->name('modulos.store');
Route::post('/lecciones', [LeccionController::class, 'store'])->name('lecciones.store');
Route::get('/lecciones/{id}', [LeccionController::class, 'show'])-> name('lecciones.show');
Route::post('/lecciones/{id}/completar', [LeccionController::class, 'alternarCompletada'])->name('lecciones.completar');


Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'mostrarRegistro'])->name('registro');
    Route::post('/registro', [AuthController::class, 'registrar'])->name('registro.store');
    Route::get('/login', [AuthController::class, 'mostrarLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/mis-cursos', [InscripcionController::class, 'index'])->name('inscripciones.index');
    Route::post('/cursos/{curso}/inscribirse', [InscripcionController::class, 'store'])->name('inscripciones.store');
    Route::delete('/cursos/{curso}/inscribirse', [InscripcionController::class, 'destroy'])->name('inscripciones.destroy');
    Route::post('/cursos/{curso}/resenas', [ResenaController::class, 'store'])->name('resenas.store');
});