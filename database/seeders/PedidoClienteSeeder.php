<?php

namespace Database\Seeders;

use App\Models\AlbaranCliente;
use App\Models\Cliente;
use App\Models\PedidoCliente;
use App\Models\Presupuesto;
use App\Models\Proyecto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PedidoClienteSeeder extends Seeder
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

        $presupuestosPorProyecto = Presupuesto::query()
            ->whereIn('proyecto_id', $proyectos->values())
            ->orderBy('numero')
            ->get()
            ->groupBy('proyecto_id');

        $albaranesPorProyecto = AlbaranCliente::query()
            ->whereIn('proyecto_id', $proyectos->values())
            ->orderBy('numero')
            ->get()
            ->groupBy('proyecto_id');

        $proyectosNombres = ['Cádiz', 'Albacete'];
        $estados = ['pendiente', 'facturado', 'facturado_parcial'];
        $fechaBase = Carbon::parse('2024-01-05');

        for ($indice = 1; $indice <= 50; $indice++) {
            $proyectoNombre = $proyectosNombres[($indice - 1) % count($proyectosNombres)];
            $proyectoId = $proyectos->get($proyectoNombre);

            if (!$proyectoId) {
                continue;
            }

            $clientes = $clientesPorProyecto->get($proyectoId, collect())->values();
            if ($clientes->isEmpty()) {
                continue;
            }

            $presupuestos = $presupuestosPorProyecto->get($proyectoId, collect())->values();
            $albaranes = $albaranesPorProyecto->get($proyectoId, collect())->values();
            $cliente = $clientes->get(($indice - 1) % $clientes->count());
            $presupuesto = $presupuestos->isNotEmpty()
                ? $presupuestos->get(($indice - 1) % $presupuestos->count())
                : null;

            $estado = $estados[($indice - 1) % count($estados)];
            $fecha = $fechaBase->copy()->addDays(($indice - 1) * 3)->toDateString();
            $numeroPedido = sprintf('PC-%s-%03d', Carbon::parse($fecha)->format('Y'), $indice);

            $base = 450 + ($indice * 37.5);
            $lineas = [
                [
                    'articulo' => 'MAT-' . str_pad((string) $indice, 3, '0', STR_PAD_LEFT),
                    'descripcion' => 'Suministro principal de pedido ' . $indice,
                    'cantidad' => 1,
                    'precio_unitario' => round($base, 2),
                    'margen' => 8,
                    'total' => round($base * 1.08, 2),
                ],
                [
                    'articulo' => 'SER-' . str_pad((string) ($indice + 100), 3, '0', STR_PAD_LEFT),
                    'descripcion' => 'Servicio complementario ' . $indice,
                    'cantidad' => 1,
                    'precio_unitario' => 120 + ($indice * 4),
                    'margen' => 5,
                    'total' => round((120 + ($indice * 4)) * 1.05, 2),
                ],
            ];

            $total = round(collect($lineas)->sum('total'), 2);
            $albaranId = null;

            if ($estado !== 'pendiente' && $albaranes->isNotEmpty()) {
                $albaranRelacionado = $albaranes->firstWhere('cliente_id', $cliente->id)
                    ?? $albaranes->get(($indice - 1) % $albaranes->count());

                $albaranId = $albaranRelacionado?->id;
            }

            PedidoCliente::updateOrCreate(
                [
                    'numero_pedido' => $numeroPedido,
                    'proyecto_id' => $proyectoId,
                ],
                [
                    'id_cliente' => $cliente->id,
                    'fecha_pedido' => $fecha,
                    'ot' => 'OT-' . (1200 + $indice),
                    'presupuesto_id' => $presupuesto?->id,
                    'albaran_id' => $albaranId,
                    'estado' => $estado,
                    'total' => $total,
                    'lista_articulos' => $lineas,
                ]
            );
        }
    }
}
