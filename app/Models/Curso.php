<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = ['titulo', 'descripcion', 'precio', 'imagen', 'categoria_id'];
    protected $table = 'cursos';

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function modulos()
    {
        return $this->hasMany(Modulo::class, 'curso_id')->orderBy('orden');
    }
}
