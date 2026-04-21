<?php

namespace Database\Seeders;

use App\Models\Cliente;
use App\Models\Presupuesto;
use App\Models\Proyecto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PresupuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proyectos = Proyecto::query()->whereIn('nombre', ['Cádiz', 'Albacete'])->pluck('id', 'nombre');
        $clientesPorProyecto = Cliente::query()
            ->whereIn('proyecto_id', $proyectos->values())
            ->orderBy('empresa_nombre')
            ->get()
            ->groupBy('proyecto_id');

        $presupuestos = [
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2023-001', 'numero' => 'PPT-2023-001', 'fecha' => '2023-10-12', 'cliente' => 'Aceros Industriales S.A.', 'titulo' => 'Suministro de perfiles laminados', 'ot' => 'OT-882'],
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2023-002', 'numero' => 'PPT-2023-002', 'fecha' => '2023-10-14', 'cliente' => 'Naval Sur Ingeniería', 'titulo' => 'Fabricación de estructura auxiliar', 'ot' => 'OT-885'],
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2023-003', 'numero' => 'PPT-2023-003', 'fecha' => '2023-10-15', 'cliente' => 'Logística Atlántica', 'titulo' => 'Adecuación de muelle operativo', 'ot' => 'OT-890'],
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2023-004', 'numero' => 'PPT-2023-004', 'fecha' => '2023-10-16', 'cliente' => 'Construcciones Marinas del Sur', 'titulo' => 'Instalación de cerramiento técnico', 'ot' => 'OT-892'],
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2023-005', 'numero' => 'PPT-2023-005', 'fecha' => '2023-10-18', 'cliente' => 'Electromecánica Bahía', 'titulo' => 'Cuadro de control industrial', 'ot' => 'OT-894'],
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2023-006', 'numero' => 'PPT-2023-006', 'fecha' => '2023-10-19', 'cliente' => 'Servicios Portuarios Cádiz', 'titulo' => 'Mantenimiento de equipos portuarios', 'ot' => 'OT-897'],
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2023-007', 'numero' => 'PPT-2023-007', 'fecha' => '2023-11-02', 'cliente' => 'Aceros Industriales S.A.', 'titulo' => 'Corte y plegado de chapa', 'ot' => 'OT-901'],
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2023-008', 'numero' => 'PPT-2023-008', 'fecha' => '2023-11-04', 'cliente' => 'Naval Sur Ingeniería', 'titulo' => 'Montaje de bancada técnica', 'ot' => 'OT-903'],
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2023-009', 'numero' => 'PPT-2023-009', 'fecha' => '2023-11-06', 'cliente' => 'Logística Atlántica', 'titulo' => 'Optimización de almacén', 'ot' => 'OT-907'],
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2023-010', 'numero' => 'PPT-2023-010', 'fecha' => '2023-11-08', 'cliente' => 'Construcciones Marinas del Sur', 'titulo' => 'Refuerzo estructural de nave', 'ot' => 'OT-912'],
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2023-011', 'numero' => 'PPT-2023-011', 'fecha' => '2023-11-10', 'cliente' => 'Electromecánica Bahía', 'titulo' => 'Sustitución de motor principal', 'ot' => 'OT-916'],
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2023-012', 'numero' => 'PPT-2023-012', 'fecha' => '2023-11-14', 'cliente' => 'Servicios Portuarios Cádiz', 'titulo' => 'Ampliación de red auxiliar', 'ot' => 'OT-919'],
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2024-013', 'numero' => 'PPT-2024-013', 'fecha' => '2024-01-09', 'cliente' => 'Aceros Industriales S.A.', 'titulo' => 'Revisión de suministro anual', 'ot' => 'OT-924'],
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2024-014', 'numero' => 'PPT-2024-014', 'fecha' => '2024-01-12', 'cliente' => 'Naval Sur Ingeniería', 'titulo' => 'Estructura de soporte modular', 'ot' => 'OT-928'],
            ['proyecto' => 'Cádiz', 'documento' => 'OF-2024-015', 'numero' => 'PPT-2024-015', 'fecha' => '2024-01-15', 'cliente' => 'Logística Atlántica', 'titulo' => 'Cerramiento de zona de carga', 'ot' => 'OT-931'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2023-016', 'numero' => 'PPT-2023-016', 'fecha' => '2023-10-13', 'cliente' => 'Metalúrgica Manchega S.L.', 'titulo' => 'Bastidor industrial reforzado', 'ot' => 'OT-884'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2023-017', 'numero' => 'PPT-2023-017', 'fecha' => '2023-10-17', 'cliente' => 'Transporte La Mancha', 'titulo' => 'Adecuación de plataforma logística', 'ot' => 'OT-888'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2023-018', 'numero' => 'PPT-2023-018', 'fecha' => '2023-10-20', 'cliente' => 'Agroindustrial del Centro', 'titulo' => 'Mantenimiento de línea de producción', 'ot' => 'OT-891'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2023-019', 'numero' => 'PPT-2023-019', 'fecha' => '2023-10-23', 'cliente' => 'Servicios Técnicos Manchegos', 'titulo' => 'Instalación de soporte técnico', 'ot' => 'OT-895'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2023-020', 'numero' => 'PPT-2023-020', 'fecha' => '2023-10-25', 'cliente' => 'Energía Solar de La Mancha', 'titulo' => 'Estructura para placas fotovoltaicas', 'ot' => 'OT-899'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2023-021', 'numero' => 'PPT-2023-021', 'fecha' => '2023-10-27', 'cliente' => 'Distribuciones Castillo', 'titulo' => 'Reorganización de almacén central', 'ot' => 'OT-902'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2023-022', 'numero' => 'PPT-2023-022', 'fecha' => '2023-11-03', 'cliente' => 'Metalúrgica Manchega S.L.', 'titulo' => 'Fabricación de piezas seriadas', 'ot' => 'OT-906'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2023-023', 'numero' => 'PPT-2023-023', 'fecha' => '2023-11-07', 'cliente' => 'Transporte La Mancha', 'titulo' => 'Sistema de carga rápida', 'ot' => 'OT-910'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2023-024', 'numero' => 'PPT-2023-024', 'fecha' => '2023-11-11', 'cliente' => 'Agroindustrial del Centro', 'titulo' => 'Cierre técnico de nave auxiliar', 'ot' => 'OT-914'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2024-025', 'numero' => 'PPT-2024-025', 'fecha' => '2024-01-10', 'cliente' => 'Servicios Técnicos Manchegos', 'titulo' => 'Renovación de equipamiento', 'ot' => 'OT-925'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2024-026', 'numero' => 'PPT-2024-026', 'fecha' => '2024-01-13', 'cliente' => 'Energía Solar de La Mancha', 'titulo' => 'Ampliación de planta solar', 'ot' => 'OT-929'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2024-027', 'numero' => 'PPT-2024-027', 'fecha' => '2024-01-17', 'cliente' => 'Distribuciones Castillo', 'titulo' => 'Nuevo puesto de control', 'ot' => 'OT-933'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2024-028', 'numero' => 'PPT-2024-028', 'fecha' => '2024-02-02', 'cliente' => 'Metalúrgica Manchega S.L.', 'titulo' => 'Optimización de consumibles', 'ot' => 'OT-937'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2024-029', 'numero' => 'PPT-2024-029', 'fecha' => '2024-02-08', 'cliente' => 'Transporte La Mancha', 'titulo' => 'Plataforma de expedición', 'ot' => 'OT-941'],
            ['proyecto' => 'Albacete', 'documento' => 'OF-2024-030', 'numero' => 'PPT-2024-030', 'fecha' => '2024-02-14', 'cliente' => 'Agroindustrial del Centro', 'titulo' => 'Proyecto de automatización parcial', 'ot' => 'OT-945'],
        ];

        foreach ($presupuestos as $presupuesto) {
            $proyectoId = $proyectos->get($presupuesto['proyecto']);

            $cliente = $clientesPorProyecto->get($proyectoId, collect())
                ->firstWhere('empresa_nombre', $presupuesto['cliente']);

            if (!$cliente) {
                continue;
            }

            Presupuesto::updateOrCreate(
                [
                    'numero' => $presupuesto['numero'],
                    'proyecto_id' => $proyectoId,
                ],
                [
                    'documento' => $presupuesto['documento'],
                    'fecha' => Carbon::parse($presupuesto['fecha'])->toDateString(),
                    'cliente_id' => $cliente->id,
                    'titulo' => $presupuesto['titulo'],
                    'ot' => $presupuesto['ot'],
                ]
            );
        }
    }
}