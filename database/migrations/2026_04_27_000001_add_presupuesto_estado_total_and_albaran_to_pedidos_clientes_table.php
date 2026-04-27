<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pedidos_clientes', function (Blueprint $table) {
            if (!Schema::hasColumn('pedidos_clientes', 'presupuesto_id')) {
                $table->foreignId('presupuesto_id')
                    ->nullable()
                    ->after('ot')
                    ->constrained('presupuestos')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('pedidos_clientes', 'albaran_id')) {
                $table->foreignId('albaran_id')
                    ->nullable()
                    ->after('presupuesto_id')
                    ->constrained('albaranes_clientes')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('pedidos_clientes', 'estado')) {
                $table->string('estado', 30)->default('pendiente')->after('albaran_id');
            }

            if (!Schema::hasColumn('pedidos_clientes', 'total')) {
                $table->decimal('total', 12, 2)->default(0)->after('lista_articulos');
            }

            $table->index('estado');
            $table->index('presupuesto_id');
            $table->index('albaran_id');
        });

        $pedidos = DB::table('pedidos_clientes')->orderBy('id')->get();

        foreach ($pedidos as $pedido) {
            $updates = [];

            $lineas = json_decode((string) ($pedido->lista_articulos ?? '[]'), true);
            if ((float) ($pedido->total ?? 0) <= 0 && is_array($lineas) && $lineas !== []) {
                $total = collect($lineas)->sum(function ($linea) {
                    return (float) ($linea['total'] ?? 0);
                });

                if ($total > 0) {
                    $updates['total'] = round((float) $total, 2);
                }
            }

            if (empty($pedido->estado)) {
                $updates['estado'] = 'pendiente';
            }

            $albaran = DB::table('albaranes_clientes')
                ->where('pedido_cliente', $pedido->numero_pedido)
                ->orderByDesc('fecha')
                ->orderByDesc('id')
                ->first();

            if ($albaran) {
                if (empty($pedido->albaran_id)) {
                    $updates['albaran_id'] = $albaran->id;
                }

                if (empty($pedido->presupuesto_id) && !empty($albaran->documento)) {
                    $presupuesto = DB::table('presupuestos')
                        ->where('proyecto_id', $pedido->proyecto_id)
                        ->where('numero', $albaran->documento)
                        ->first();

                    if ($presupuesto) {
                        $updates['presupuesto_id'] = $presupuesto->id;
                    }
                }
            }

            if ($updates !== []) {
                DB::table('pedidos_clientes')->where('id', $pedido->id)->update($updates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedidos_clientes', function (Blueprint $table) {
            if (Schema::hasColumn('pedidos_clientes', 'albaran_id')) {
                $table->dropForeign(['albaran_id']);
                $table->dropColumn('albaran_id');
            }

            if (Schema::hasColumn('pedidos_clientes', 'presupuesto_id')) {
                $table->dropForeign(['presupuesto_id']);
                $table->dropColumn('presupuesto_id');
            }

            if (Schema::hasColumn('pedidos_clientes', 'estado')) {
                $table->dropColumn('estado');
            }

            if (Schema::hasColumn('pedidos_clientes', 'total')) {
                $table->dropColumn('total');
            }
        });
    }
};