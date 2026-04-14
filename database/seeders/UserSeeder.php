<?php

namespace Database\Seeders;

use App\Models\Proyecto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proyectos = Proyecto::query()->pluck('id', 'nombre');

        // Usuario normal (1 proyecto)
        $usuario = User::updateOrCreate([
            'email' => 'alfonso.user@gmail.com',
        ], [
            'name' => 'AlfonsoUser',
            'password' => Hash::make('12345678'),
            'role' => 'user',
            'descripcion' => 'Usuario operativo de la sucursal Cádiz',
            'telefono' => '633117324',
            'avatar' => null,
            'activo' => true,
        ]);
        $usuario->proyectos()->sync(array_filter([
            $proyectos->get('Cádiz'),
        ]));

        // Usuario administrador (2 proyectos)
        $admin = User::updateOrCreate([
            'email' => 'alfonso.admin@gmail.com',
        ], [
            'name' => 'AlfonsoAdmin',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'descripcion' => 'Administradora del sistema',
            'telefono' => '633117324',
            'avatar' => null,
            'activo' => true,
        ]);
        $admin->proyectos()->sync(array_filter([
            $proyectos->get('Cádiz'),
            $proyectos->get('Madrid'),
        ]));

        // Usuario superadmin (todos los proyectos)
        $superadmin = User::updateOrCreate([
            'email' => 'alfonso.superadmin@gmail.com',
        ], [
            'name' => 'AlfonsoSuperAdmin',
            'password' => Hash::make('12345678'),
            'role' => 'superadmin',
            'descripcion' => 'Superadministrador con acceso total',
            'telefono' => '633117324',
            'avatar' => null,
            'activo' => true,
        ]);
        $superadmin->proyectos()->sync($proyectos->values()->all());
    }
}
