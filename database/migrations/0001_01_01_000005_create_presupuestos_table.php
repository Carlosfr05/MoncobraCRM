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
        Schema::create('presupuestos', function (Blueprint $table) {
            $table->id();
            $table->string('documento', 50);
            $table->string('numero', 50);
            $table->date('fecha');
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('restrict');
            $table->string('titulo')->nullable();
            $table->string('ot')->nullable();
            $table->timestamps();
            
            // Índices para búsquedas comunes
            $table->index('cliente_id');
            $table->index('numero');
            $table->index('fecha');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('presupuestos');
    }
};
