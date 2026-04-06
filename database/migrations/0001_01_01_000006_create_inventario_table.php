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
        Schema::create('inventario', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('descripcion');
            $table->string('referencia_proveedor')->nullable();
            $table->string('clase')->nullable();
            $table->string('ubicacion')->nullable();
            $table->string('almacen')->nullable();
            $table->integer('stock_actual')->default(0);
            $table->integer('stock_minimo')->default(0);
            $table->integer('nivel_critico')->default(0);
            $table->timestamps();
            
            // Índices para búsquedas comunes
            $table->index('codigo');
            $table->index('almacen');
            $table->index('clase');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario');
    }
};
