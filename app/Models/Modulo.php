<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $fillable = ['titulo', 'orden', 'curso_id'];
    protected $table = 'modulos';

    public function curso()
    {
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function lecciones()
    {
        return $this->hasMany(Leccion::class, 'modulo_id')->orderBy('orden');
    }
}
