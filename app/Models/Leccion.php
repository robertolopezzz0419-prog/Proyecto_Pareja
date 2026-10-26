<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leccion extends Model
{
    protected $fillable = ['titulo', 'contenido', 'video_url', 'orden', 'modulo_id'];
    protected $table = 'lecciones';

    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'modulo_id');
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'leccion_usuario', 'leccion_id', 'user_id')
                    ->withPivot('completado')
                    ->withTimestamps();
    }
}
