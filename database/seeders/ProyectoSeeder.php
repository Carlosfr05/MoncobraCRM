<?php

namespace Database\Seeders;

use App\Models\Proyecto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProyectoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proyectos = [
            ['nombre' => 'Cádiz', 'localizacion' => 'Cádiz, España'],
            ['nombre' => 'Albacete', 'localizacion' => 'Albacete, España'],
            ['nombre' => 'Madrid', 'localizacion' => 'Madrid, España'],
        ];

        foreach ($proyectos as $proyecto) {
            Proyecto::updateOrCreate(['nombre' => $proyecto['nombre']], $proyecto);
        }
    }
}
