<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
      public function puedeGestionar()
    {
        return $this->roles->whereIn('nombre', ['Admin', 'Profesor'])->count() > 0;
    }

    public function esEstudiante()
    {
        return $this->roles->where('nombre', 'Estudiante')->count() > 0;
    }

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_usuario', 'user_id', 'rol_id');
    }

    public function cursosInscritos()
    {
        return $this->belongsToMany(Curso::class, 'curso_estudiante', 'user_id', 'curso_id')->withTimestamps();
    }

    public function resenas()
    {
        return $this->hasMany(Resena::class);
    }
}