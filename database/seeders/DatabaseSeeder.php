<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear proyectos primero
        $this->call(ProyectoSeeder::class);

        // Crear usuarios con diferentes roles
        $this->call(UserSeeder::class);
    }
}
