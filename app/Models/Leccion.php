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
    public function getVideoEmbedAttribute()
{
    $url = $this->video_url;

    if (preg_match('~(?:youtube\.com/(?:watch\?v=|shorts/|embed/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $url, $m)) {
        return 'https://www.youtube.com/embed/' . $m[1];
    }

    return $url;
}
}
