<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nombres = ['Programación', 'Diseño', 'Marketing', 'Idiomas', 'matematicas'];
        foreach ($nombres as $nombre) {
            Categoria::firstOrCreate(['nombre' => $nombre]);
        }
    }
}