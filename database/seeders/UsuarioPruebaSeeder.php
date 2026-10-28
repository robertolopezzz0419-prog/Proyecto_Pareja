<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioPruebaSeeder extends Seeder
{
    public function run(): void
    {
        $this->crearUsuario('Admin Prueba', 'admin@lms.com', 'Admin');
        $this->crearUsuario('Profesor Prueba', 'profesor@lms.com', 'Profesor');
        $this->crearUsuario('Estudiante Prueba', 'estudiante@lms.com', 'Estudiante');
        $this->crearUsuario('Nombre del Profesor', 'juan@gmail.com', 'Profesor');
    }

    private function crearUsuario($nombre, $correo, $nombreRol)
    {
        $usuario = User::firstOrCreate(
            ['email' => $correo],
            ['name' => $nombre, 'password' => Hash::make('12345678')]
        );

        $rol = Rol::where('nombre', $nombreRol)->first();
        $usuario->roles()->sync([$rol->id]);
    }
}