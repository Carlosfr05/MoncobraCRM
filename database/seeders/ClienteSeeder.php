<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Proyecto;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proyectos = Proyecto::query()->whereIn('nombre', ['Cádiz', 'Albacete'])->pluck('id', 'nombre');

        $clientes = [
            ['proyecto' => 'Cádiz', 'empresa_nombre' => 'Aceros Industriales S.A.', 'cif_nif' => 'A11000001', 'direccion' => 'Av. de la Bahía 12', 'localidad' => 'Cádiz', 'codigo_postal' => '11005', 'telefono' => '956100101', 'email' => 'contacto@aceroscadiz.es', 'persona_contacto' => 'Laura Romero'],
            ['proyecto' => 'Cádiz', 'empresa_nombre' => 'Naval Sur Ingeniería', 'cif_nif' => 'A11000002', 'direccion' => 'C/ San Francisco 8', 'localidad' => 'San Fernando', 'codigo_postal' => '11100', 'telefono' => '956100102', 'email' => 'info@navalsur.es', 'persona_contacto' => 'Miguel Torres'],
            ['proyecto' => 'Cádiz', 'empresa_nombre' => 'Logística Atlántica', 'cif_nif' => 'A11000003', 'direccion' => 'Pol. Ind. Zona Franca, Nave 4', 'localidad' => 'Cádiz', 'codigo_postal' => '11011', 'telefono' => '956100103', 'email' => 'operaciones@logisticaatlantica.es', 'persona_contacto' => 'Sofía León'],
            ['proyecto' => 'Cádiz', 'empresa_nombre' => 'Electromecánica Bahía', 'cif_nif' => 'A11000004', 'direccion' => 'C/ Industria 15', 'localidad' => 'Puerto Real', 'codigo_postal' => '11510', 'telefono' => '956100104', 'email' => 'admin@electrobahia.es', 'persona_contacto' => 'Pedro Gil'],
            ['proyecto' => 'Cádiz', 'empresa_nombre' => 'Construcciones Marinas del Sur', 'cif_nif' => 'A11000005', 'direccion' => 'Av. del Puerto 31', 'localidad' => 'Cádiz', 'codigo_postal' => '11006', 'telefono' => '956100105', 'email' => 'contacto@cmsur.es', 'persona_contacto' => 'Ana Vega'],
            ['proyecto' => 'Cádiz', 'empresa_nombre' => 'Servicios Portuarios Cádiz', 'cif_nif' => 'A11000006', 'direccion' => 'Muelle Reina Victoria s/n', 'localidad' => 'Cádiz', 'codigo_postal' => '11004', 'telefono' => '956100106', 'email' => 'comercial@serviciosportuarioscadiz.es', 'persona_contacto' => 'Carlos Nieto'],
            ['proyecto' => 'Albacete', 'empresa_nombre' => 'Metalúrgica Manchega S.L.', 'cif_nif' => 'B02000001', 'direccion' => 'C/ Feria 45', 'localidad' => 'Albacete', 'codigo_postal' => '02004', 'telefono' => '967200201', 'email' => 'ventas@metalurgicamanchega.es', 'persona_contacto' => 'Elena Ruiz'],
            ['proyecto' => 'Albacete', 'empresa_nombre' => 'Transporte La Mancha', 'cif_nif' => 'B02000002', 'direccion' => 'Pol. Campollano, Calle D 7', 'localidad' => 'Albacete', 'codigo_postal' => '02007', 'telefono' => '967200202', 'email' => 'info@transportelamancha.es', 'persona_contacto' => 'Javier Mora'],
            ['proyecto' => 'Albacete', 'empresa_nombre' => 'Agroindustrial del Centro', 'cif_nif' => 'B02000003', 'direccion' => 'Av. España 88', 'localidad' => 'Hellín', 'codigo_postal' => '02400', 'telefono' => '967200203', 'email' => 'clientes@agrocentro.es', 'persona_contacto' => 'María Cano'],
            ['proyecto' => 'Albacete', 'empresa_nombre' => 'Servicios Técnicos Manchegos', 'cif_nif' => 'B02000004', 'direccion' => 'C/ Rosario 19', 'localidad' => 'Albacete', 'codigo_postal' => '02003', 'telefono' => '967200204', 'email' => 'soporte@stm.es', 'persona_contacto' => 'Raúl Blanco'],
            ['proyecto' => 'Albacete', 'empresa_nombre' => 'Energía Solar de La Mancha', 'cif_nif' => 'B02000005', 'direccion' => 'Ctra. de Valencia km 4', 'localidad' => 'Chinchilla de Montearagón', 'codigo_postal' => '02520', 'telefono' => '967200205', 'email' => 'proyectos@esmancha.es', 'persona_contacto' => 'Lucía Herrero'],
            ['proyecto' => 'Albacete', 'empresa_nombre' => 'Distribuciones Castillo', 'cif_nif' => 'B02000006', 'direccion' => 'C/ Nueva 14', 'localidad' => 'Albacete', 'codigo_postal' => '02006', 'telefono' => '967200206', 'email' => 'pedidos@distribucionescastillo.es', 'persona_contacto' => 'Óscar Díaz'],
        ];

        foreach ($clientes as $cliente) {
            Cliente::updateOrCreate(
                ['cif_nif' => $cliente['cif_nif']],
                [
                    'proyecto_id' => $proyectos->get($cliente['proyecto']),
                    'empresa_nombre' => $cliente['empresa_nombre'],
                    'direccion' => $cliente['direccion'],
                    'localidad' => $cliente['localidad'],
                    'codigo_postal' => $cliente['codigo_postal'],
                    'telefono' => $cliente['telefono'],
                    'email' => $cliente['email'],
                    'persona_contacto' => $cliente['persona_contacto'],
                ]
            );
        }
    }
}