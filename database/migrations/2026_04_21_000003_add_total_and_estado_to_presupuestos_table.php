<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $hasOt = Schema::hasColumn('presupuestos', 'ot');
        $hasTotal = Schema::hasColumn('presupuestos', 'total');
        $hasEstado = Schema::hasColumn('presupuestos', 'estado');

        Schema::table('presupuestos', function (Blueprint $table) use ($hasOt, $hasTotal, $hasEstado) {
            if (!$hasTotal) {
                $totalColumn = $table->decimal('total', 12, 2)->default(0);
                if ($hasOt) {
                    $totalColumn->after('ot');
                }
            }

            if (!$hasEstado) {
                $estadoColumn = $table->enum('estado', ['pendiente', 'aceptado', 'rechazado', 'pendiente pedido'])->default('pendiente');
                if ($hasTotal || Schema::hasColumn('presupuestos', 'total')) {
                    $estadoColumn->after('total');
                } elseif ($hasOt) {
                    $estadoColumn->after('ot');
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            if (Schema::hasColumn('presupuestos', 'estado')) {
                $table->dropColumn('estado');
            }

            if (Schema::hasColumn('presupuestos', 'total')) {
                $table->dropColumn('total');
            }
        });
    }
};
