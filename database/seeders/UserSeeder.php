<?php

namespace Database\Seeders;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener un proyecto para el usuario normal
        $proyectoCadiz = Proyecto::where('nombre', 'Cádiz')->first();

        // Usuario normal (user)

        User::create([
            'name' => 'AlfonsoUser',
            'email' => 'alfonso.user@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'user',
            'proyecto_id' => $proyectoCadiz?->id,
            'descripcion' => 'Usuario operativo de la sucursal Cádiz',
            'telefono' => '633117324',
            'avatar' => null,
            'activo' => true,
        ]);

        // Usuario administrador (admin)
        
        User::create([
            'name' => 'AlfonsoAdmin',
            'email' => 'alfonso.admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'proyecto_id' => null, // Los admins no tienen proyecto asignado
            'descripcion' => 'Administradora del sistema',
            'telefono' => '633117324',
            'avatar' => null,
            'activo' => true,
        ]);

        // Usuario superadmin (superadmin)
       
        User::create([
            'name' => 'AlfonsoSuperAdmin',
            'email' => 'alfonso.superadmin@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'superadmin',
            'proyecto_id' => null, // Los superadmins no tienen proyecto asignado
            'descripcion' => 'Superadministrador con acceso total',
            'telefono' => '633117324',
            'avatar' => null,
            'activo' => true,
        ]);
    }
}
