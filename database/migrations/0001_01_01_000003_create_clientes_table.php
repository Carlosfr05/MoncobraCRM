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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('empresa_nombre');
            $table->string('cif_nif')->unique();
            $table->string('direccion');
            $table->string('localidad');
            $table->string('codigo_postal', 10);
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('persona_contacto')->nullable();
            $table->timestamps();
            
            // Índices para búsquedas comunes
            $table->index('email');
            $table->index('cif_nif');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
