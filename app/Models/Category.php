<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['nombre'];
    protected $table = 'categories';
    public function cursos()
    {
        return $this->hasMany(Curso::class, 'category_id');
    }
}
