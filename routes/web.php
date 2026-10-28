<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\LeccionController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\ResenaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware(['auth', 'can:gestionar'])->group(function () {
    Route::resource('cursos', CursoController::class)->except(['index', 'show']);
    Route::get('/categorias/crear', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('/categorias/{categoria}/editar', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::put('/categorias/{categoria}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('/categorias/{categoria}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
    Route::post('/modulos', [ModuloController::class, 'store'])->name('modulos.store');
    Route::delete('/modulos/{id}', [ModuloController::class, 'destroy'])->name('modulos.destroy');
    Route::post('/lecciones', [LeccionController::class, 'store'])->name('lecciones.store');
    Route::get('/lecciones/{id}/editar', [LeccionController::class, 'edit'])->name('lecciones.edit');
    Route::put('/lecciones/{id}', [LeccionController::class, 'update'])->name('lecciones.update');
    Route::delete('/lecciones/{id}', [LeccionController::class, 'destroy'])->name('lecciones.destroy');
});


Route::resource('cursos', CursoController::class)->only(['index', 'show']);


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
    Route::get('/resenas/{resena}/editar', [ResenaController::class, 'edit'])->name('resenas.edit');
    Route::put('/resenas/{resena}', [ResenaController::class, 'update'])->name('resenas.update');
    Route::delete('/resenas/{resena}', [ResenaController::class, 'destroy'])->name('resenas.destroy');


    Route::get('/lecciones/{id}', [LeccionController::class, 'show'])->name('lecciones.show');
    Route::post('/lecciones/{id}/completar', [LeccionController::class, 'alternarCompletada'])->name('lecciones.completar');
});