<?php

namespace Database\Seeders;

use App\Models\AlbaranCliente;
use App\Models\Cliente;
use App\Models\Proyecto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class AlbaranClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proyectos = Proyecto::query()
            ->whereIn('nombre', ['Cádiz', 'Albacete'])
            ->pluck('id', 'nombre');

        $clientesPorProyecto = Cliente::query()
            ->whereIn('proyecto_id', $proyectos->values())
            ->orderBy('empresa_nombre')
            ->get()
            ->groupBy('proyecto_id');

        $proyectosNombres = ['Cádiz', 'Albacete'];
        $estados = ['pendiente', 'recibido', 'entregado'];

        for ($indice = 1; $indice <= 40; $indice++) {
            $proyectoNombre = $proyectosNombres[($indice - 1) % count($proyectosNombres)];
            $proyectoId = $proyectos->get($proyectoNombre);

            if (!$proyectoId) {
                continue;
            }

            $clientes = $clientesPorProyecto->get($proyectoId, collect())->values();

            if ($clientes->isEmpty()) {
                continue;
            }

            $cliente = $clientes->get(($indice - 1) % $clientes->count());
            $codigo = str_pad((string) $indice, 3, '0', STR_PAD_LEFT);
            $prefijo = $proyectoNombre === 'Cádiz' ? 'CAD' : 'ALB';
            $documento = "ALB-{$prefijo}-{$codigo}";
            $estado = $estados[($indice - 1) % count($estados)];
            $fecha = Carbon::parse('2024-01-08')->addDays(($indice - 1) * 2)->toDateString();
            $total = round(180 + ($indice * 12.75), 2);

            AlbaranCliente::updateOrCreate(
                [
                    'numero' => $documento,
                    'proyecto_id' => $proyectoId,
                ],
                [
                    'documento' => $documento,
                    'fecha' => $fecha,
                    'cliente_id' => $cliente->id,
                    'ot' => 'OT-' . (900 + $indice),
                    'pedido_cliente' => 'PED-' . (1500 + $indice),
                    'titulo' => "Albarán de ejemplo {$codigo}",
                    'lista_articulos' => [
                        [
                            'descripcion' => "Servicio técnico {$codigo}",
                            'cantidad' => 1,
                            'precio' => $total,
                            'total' => $total,
                        ],
                    ],
                    'total' => $total,
                    'estado' => $estado,
                    'archivo_pdf' => null,
                ]
            );
        }
    }
}