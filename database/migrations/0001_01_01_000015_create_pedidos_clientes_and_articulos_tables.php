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
        if (!Schema::hasTable('pedidos_clientes')) {
            Schema::create('pedidos_clientes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('id_cliente')->constrained('clientes')->restrictOnDelete();
                $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->nullOnDelete();
                $table->string('numero_pedido', 80);
                $table->date('fecha_pedido');
                $table->string('ot', 100)->nullable();
                $table->json('lista_articulos')->nullable();
                $table->timestamps();

                $table->index('numero_pedido');
                $table->index('fecha_pedido');
            });
        }

        if (!Schema::hasTable('articulos')) {
            Schema::create('articulos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->nullOnDelete();
                $table->string('numero_referencia', 120);
                $table->text('descripcion');
                $table->decimal('cantidad', 12, 2)->default(0);
                $table->decimal('precio_unitario', 12, 2)->default(0);
                $table->decimal('margen', 8, 2)->default(0);
                $table->decimal('total', 12, 2)->default(0);
                $table->timestamps();

                $table->index('numero_referencia');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articulos');
        Schema::dropIfExists('pedidos_clientes');
    }
};
