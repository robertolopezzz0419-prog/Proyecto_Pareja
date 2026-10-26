<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $fillable = ['titulo', 'descripcion', 'precio', 'category_id'];
    protected $table = 'cursos';

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function modulos()
    {
        return $this->hasMany(Modulo::class, 'curso_id');
    }
}
