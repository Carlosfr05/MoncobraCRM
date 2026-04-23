<?php

namespace Database\Seeders;

use App\Models\Inventario;
use App\Models\Proyecto;
use Illuminate\Database\Seeder;

class InventarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proyectos = Proyecto::query()
            ->whereIn('nombre', ['Cádiz', 'Albacete', 'Madrid'])
            ->pluck('id', 'nombre');

        $items = [
            ['proyecto' => 'Cádiz', 'codigo' => 'CAD-INS-001', 'descripcion' => 'Inspección visual industrial', 'referencia_proveedor' => 'PROV-AV-1001', 'clase' => 'SERVICIOS', 'ubicacion' => 'Muelles', 'almacen' => 'Central', 'stock_actual' => 120, 'stock_minimo' => 30, 'nivel_critico' => 15],
            ['proyecto' => 'Cádiz', 'codigo' => 'CAD-REP-002', 'descripcion' => 'Repuestos hidráulicos kit A', 'referencia_proveedor' => 'HID-KIT-A', 'clase' => 'REPUESTOS', 'ubicacion' => 'Estantería B1', 'almacen' => 'Central', 'stock_actual' => 18, 'stock_minimo' => 25, 'nivel_critico' => 10],
            ['proyecto' => 'Cádiz', 'codigo' => 'CAD-LUB-003', 'descripcion' => 'Lubricante técnico 5W40', 'referencia_proveedor' => 'LUB-540', 'clase' => 'LUBRICANTES', 'ubicacion' => 'Zona química', 'almacen' => 'Norte', 'stock_actual' => 45, 'stock_minimo' => 20, 'nivel_critico' => 8],
            ['proyecto' => 'Cádiz', 'codigo' => 'CAD-EXT-004', 'descripcion' => 'Extintor CO2 5kg', 'referencia_proveedor' => 'SEG-EXT-CO2', 'clase' => 'SEGURIDAD', 'ubicacion' => 'Entrada principal', 'almacen' => 'Central', 'stock_actual' => 6, 'stock_minimo' => 10, 'nivel_critico' => 4],
            ['proyecto' => 'Cádiz', 'codigo' => 'CAD-ALT-005', 'descripcion' => 'Alambre TIG inoxidable', 'referencia_proveedor' => 'TIG-INOX-1.6', 'clase' => 'CONSUMIBLES', 'ubicacion' => 'Soldadura', 'almacen' => 'Sur', 'stock_actual' => 80, 'stock_minimo' => 30, 'nivel_critico' => 12],
            ['proyecto' => 'Cádiz', 'codigo' => 'CAD-PLT-006', 'descripcion' => 'Placa aluminio 3mm', 'referencia_proveedor' => 'AL-3MM', 'clase' => 'MATERIA PRIMA', 'ubicacion' => 'Patio', 'almacen' => 'Central', 'stock_actual' => 22, 'stock_minimo' => 18, 'nivel_critico' => 9],
            ['proyecto' => 'Cádiz', 'codigo' => 'CAD-BRN-007', 'descripcion' => 'Bridas nylon 200mm', 'referencia_proveedor' => 'BRD-200', 'clase' => 'CONSUMIBLES', 'ubicacion' => 'Pequeño material', 'almacen' => 'Norte', 'stock_actual' => 350, 'stock_minimo' => 200, 'nivel_critico' => 80],
            ['proyecto' => 'Cádiz', 'codigo' => 'CAD-FUS-008', 'descripcion' => 'Fusible industrial 16A', 'referencia_proveedor' => 'FUS-16', 'clase' => 'ELÉCTRICO', 'ubicacion' => 'Armario eléctrico', 'almacen' => 'Central', 'stock_actual' => 14, 'stock_minimo' => 40, 'nivel_critico' => 10],
            ['proyecto' => 'Cádiz', 'codigo' => 'CAD-TUB-009', 'descripcion' => 'Tubo acero 40x40', 'referencia_proveedor' => 'TUB-4040', 'clase' => 'ESTRUCTURA', 'ubicacion' => 'Zona corte', 'almacen' => 'Sur', 'stock_actual' => 62, 'stock_minimo' => 25, 'nivel_critico' => 12],
            ['proyecto' => 'Cádiz', 'codigo' => 'CAD-PIN-010', 'descripcion' => 'Pintura anticorrosiva azul', 'referencia_proveedor' => 'PINT-ANT-01', 'clase' => 'PINTURAS', 'ubicacion' => 'Cabina', 'almacen' => 'Central', 'stock_actual' => 9, 'stock_minimo' => 15, 'nivel_critico' => 5],
            ['proyecto' => 'Cádiz', 'codigo' => 'CAD-ROL-011', 'descripcion' => 'Rodamiento 6204', 'referencia_proveedor' => 'ROL-6204', 'clase' => 'REPUESTOS', 'ubicacion' => 'Estantería C2', 'almacen' => 'Norte', 'stock_actual' => 27, 'stock_minimo' => 20, 'nivel_critico' => 8],
            ['proyecto' => 'Cádiz', 'codigo' => 'CAD-COR-012', 'descripcion' => 'Cortadora de disco 230mm', 'referencia_proveedor' => 'HERR-230', 'clase' => 'HERRAMIENTAS', 'ubicacion' => 'Herramientas', 'almacen' => 'Central', 'stock_actual' => 11, 'stock_minimo' => 10, 'nivel_critico' => 4],
            ['proyecto' => 'Albacete', 'codigo' => 'ALB-INS-013', 'descripcion' => 'Inspección eléctrica anual', 'referencia_proveedor' => 'ELEC-INS-13', 'clase' => 'SERVICIOS', 'ubicacion' => 'Línea A', 'almacen' => 'Central', 'stock_actual' => 95, 'stock_minimo' => 20, 'nivel_critico' => 10],
            ['proyecto' => 'Albacete', 'codigo' => 'ALB-MOT-014', 'descripcion' => 'Motor trifásico 2.2kW', 'referencia_proveedor' => 'MOT-22', 'clase' => 'REPUESTOS', 'ubicacion' => 'Taller', 'almacen' => 'Norte', 'stock_actual' => 5, 'stock_minimo' => 8, 'nivel_critico' => 3],
            ['proyecto' => 'Albacete', 'codigo' => 'ALB-CAB-015', 'descripcion' => 'Cable 4mm rojo', 'referencia_proveedor' => 'CAB-4R', 'clase' => 'ELÉCTRICO', 'ubicacion' => 'Bobinas', 'almacen' => 'Central', 'stock_actual' => 260, 'stock_minimo' => 120, 'nivel_critico' => 50],
            ['proyecto' => 'Albacete', 'codigo' => 'ALB-ACE-016', 'descripcion' => 'Aceite sintético industrial', 'referencia_proveedor' => 'ACE-SYN-01', 'clase' => 'LUBRICANTES', 'ubicacion' => 'Zona química', 'almacen' => 'Sur', 'stock_actual' => 34, 'stock_minimo' => 15, 'nivel_critico' => 8],
            ['proyecto' => 'Albacete', 'codigo' => 'ALB-CLA-017', 'descripcion' => 'Clavija schuko reforzada', 'referencia_proveedor' => 'CLI-SCH-01', 'clase' => 'ELÉCTRICO', 'ubicacion' => 'Armario 2', 'almacen' => 'Central', 'stock_actual' => 42, 'stock_minimo' => 25, 'nivel_critico' => 10],
            ['proyecto' => 'Albacete', 'codigo' => 'ALB-BRO-018', 'descripcion' => 'Broca metal 12mm', 'referencia_proveedor' => 'BRO-12', 'clase' => 'HERRAMIENTAS', 'ubicacion' => 'Herramientas', 'almacen' => 'Norte', 'stock_actual' => 7, 'stock_minimo' => 12, 'nivel_critico' => 5],
            ['proyecto' => 'Albacete', 'codigo' => 'ALB-PAL-019', 'descripcion' => 'Palet europeo', 'referencia_proveedor' => 'PAL-EUR', 'clase' => 'LOGÍSTICA', 'ubicacion' => 'Muelles', 'almacen' => 'Central', 'stock_actual' => 140, 'stock_minimo' => 60, 'nivel_critico' => 25],
            ['proyecto' => 'Albacete', 'codigo' => 'ALB-SOP-020', 'descripcion' => 'Soporte metálico angular', 'referencia_proveedor' => 'SOP-ANG-02', 'clase' => 'ESTRUCTURA', 'ubicacion' => 'Zona montaje', 'almacen' => 'Sur', 'stock_actual' => 16, 'stock_minimo' => 18, 'nivel_critico' => 6],
            ['proyecto' => 'Albacete', 'codigo' => 'ALB-LLA-021', 'descripcion' => 'Llana de albañil inox', 'referencia_proveedor' => 'LLA-IN-01', 'clase' => 'HERRAMIENTAS', 'ubicacion' => 'Taller', 'almacen' => 'Norte', 'stock_actual' => 19, 'stock_minimo' => 10, 'nivel_critico' => 4],
            ['proyecto' => 'Albacete', 'codigo' => 'ALB-TOR-022', 'descripcion' => 'Tornillería surtida M8', 'referencia_proveedor' => 'TOR-M8', 'clase' => 'CONSUMIBLES', 'ubicacion' => 'Pequeño material', 'almacen' => 'Central', 'stock_actual' => 520, 'stock_minimo' => 250, 'nivel_critico' => 90],
            ['proyecto' => 'Albacete', 'codigo' => 'ALB-SEG-023', 'descripcion' => 'Señal de seguridad salida', 'referencia_proveedor' => 'SEG-SAL-01', 'clase' => 'SEGURIDAD', 'ubicacion' => 'Pasillos', 'almacen' => 'Central', 'stock_actual' => 12, 'stock_minimo' => 15, 'nivel_critico' => 6],
            ['proyecto' => 'Albacete', 'codigo' => 'ALB-SIL-024', 'descripcion' => 'Silicona industrial transparente', 'referencia_proveedor' => 'SIL-TR-01', 'clase' => 'CONSUMIBLES', 'ubicacion' => 'Química', 'almacen' => 'Sur', 'stock_actual' => 58, 'stock_minimo' => 30, 'nivel_critico' => 12],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-PLA-025', 'descripcion' => 'Placa electrónica base', 'referencia_proveedor' => 'ELEC-BASE-25', 'clase' => 'ELECTRÓNICA', 'ubicacion' => 'Rack 1', 'almacen' => 'Centro', 'stock_actual' => 21, 'stock_minimo' => 14, 'nivel_critico' => 7],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-UPS-026', 'descripcion' => 'UPS 1500VA', 'referencia_proveedor' => 'UPS-1500', 'clase' => 'ELECTRÓNICA', 'ubicacion' => 'Rack 3', 'almacen' => 'Centro', 'stock_actual' => 4, 'stock_minimo' => 6, 'nivel_critico' => 2],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-MOD-027', 'descripcion' => 'Módulo relé industrial', 'referencia_proveedor' => 'REL-IND-01', 'clase' => 'ELÉCTRICO', 'ubicacion' => 'Armario A', 'almacen' => 'Norte', 'stock_actual' => 33, 'stock_minimo' => 20, 'nivel_critico' => 8],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-SEN-028', 'descripcion' => 'Sensor de proximidad', 'referencia_proveedor' => 'SEN-PROX', 'clase' => 'ELECTRÓNICA', 'ubicacion' => 'Armario B', 'almacen' => 'Centro', 'stock_actual' => 15, 'stock_minimo' => 18, 'nivel_critico' => 6],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-FAN-029', 'descripcion' => 'Ventilador industrial 24V', 'referencia_proveedor' => 'FAN-24V', 'clase' => 'CLIMATIZACIÓN', 'ubicacion' => 'Zona técnica', 'almacen' => 'Sur', 'stock_actual' => 10, 'stock_minimo' => 8, 'nivel_critico' => 4],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-FIL-030', 'descripcion' => 'Filtro de aire HEPA', 'referencia_proveedor' => 'HEPA-01', 'clase' => 'CONSUMIBLES', 'ubicacion' => 'Limpieza', 'almacen' => 'Centro', 'stock_actual' => 26, 'stock_minimo' => 12, 'nivel_critico' => 5],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-DIS-031', 'descripcion' => 'Disco de corte 125mm', 'referencia_proveedor' => 'DIS-125', 'clase' => 'HERRAMIENTAS', 'ubicacion' => 'Taller', 'almacen' => 'Norte', 'stock_actual' => 90, 'stock_minimo' => 40, 'nivel_critico' => 18],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-CAJ-032', 'descripcion' => 'Caja de conexiones IP65', 'referencia_proveedor' => 'IP65-CAJ', 'clase' => 'ELÉCTRICO', 'ubicacion' => 'Armario C', 'almacen' => 'Centro', 'stock_actual' => 13, 'stock_minimo' => 16, 'nivel_critico' => 6],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-RAC-033', 'descripcion' => 'Rack metálico 42U', 'referencia_proveedor' => 'RACK-42U', 'clase' => 'INFRAESTRUCTURA', 'ubicacion' => 'Sala técnica', 'almacen' => 'Centro', 'stock_actual' => 3, 'stock_minimo' => 5, 'nivel_critico' => 2],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-MAN-034', 'descripcion' => 'Manguera de alta presión', 'referencia_proveedor' => 'MAN-HP', 'clase' => 'LÍNEA', 'ubicacion' => 'Patio', 'almacen' => 'Sur', 'stock_actual' => 17, 'stock_minimo' => 14, 'nivel_critico' => 6],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-PIL-035', 'descripcion' => 'Piloto luminoso verde', 'referencia_proveedor' => 'PIL-VER', 'clase' => 'ELÉCTRICO', 'ubicacion' => 'Armario A', 'almacen' => 'Norte', 'stock_actual' => 74, 'stock_minimo' => 30, 'nivel_critico' => 12],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-TRA-036', 'descripcion' => 'Transformador 220/24V', 'referencia_proveedor' => 'TRA-220-24', 'clase' => 'ELECTRÓNICA', 'ubicacion' => 'Zona técnica', 'almacen' => 'Centro', 'stock_actual' => 8, 'stock_minimo' => 10, 'nivel_critico' => 4],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-ACE-037', 'descripcion' => 'Aceite dieléctrico', 'referencia_proveedor' => 'DIEL-01', 'clase' => 'LUBRICANTES', 'ubicacion' => 'Química', 'almacen' => 'Sur', 'stock_actual' => 29, 'stock_minimo' => 18, 'nivel_critico' => 7],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-LLA-038', 'descripcion' => 'Lámpara LED industrial', 'referencia_proveedor' => 'LED-IND', 'clase' => 'ILUMINACIÓN', 'ubicacion' => 'Estantería D2', 'almacen' => 'Centro', 'stock_actual' => 41, 'stock_minimo' => 20, 'nivel_critico' => 9],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-CON-039', 'descripcion' => 'Conector rápido neumático', 'referencia_proveedor' => 'NEU-CON', 'clase' => 'NEUMÁTICA', 'ubicacion' => 'Taller', 'almacen' => 'Norte', 'stock_actual' => 50, 'stock_minimo' => 24, 'nivel_critico' => 10],
            ['proyecto' => 'Madrid', 'codigo' => 'MAD-ETQ-040', 'descripcion' => 'Etiquetas industriales resistentes', 'referencia_proveedor' => 'ETQ-RES', 'clase' => 'CONSUMIBLES', 'ubicacion' => 'Impresión', 'almacen' => 'Centro', 'stock_actual' => 180, 'stock_minimo' => 70, 'nivel_critico' => 25],
        ];

        foreach ($items as $item) {
            $proyectoId = $proyectos->get($item['proyecto']);

            if (!$proyectoId) {
                continue;
            }

            Inventario::updateOrCreate(
                [
                    'codigo' => $item['codigo'],
                ],
                [
                    'proyecto_id' => $proyectoId,
                    'descripcion' => $item['descripcion'],
                    'referencia_proveedor' => $item['referencia_proveedor'],
                    'clase' => $item['clase'],
                    'ubicacion' => $item['ubicacion'],
                    'almacen' => $item['almacen'],
                    'stock_actual' => $item['stock_actual'],
                    'stock_minimo' => $item['stock_minimo'],
                    'nivel_critico' => $item['nivel_critico'],
                ]
            );
        }
    }
}