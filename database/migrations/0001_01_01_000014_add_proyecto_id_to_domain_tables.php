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
        Schema::table('clientes', function (Blueprint $table) {
            $table->foreignId('proyecto_id')
                ->nullable()
                ->after('id')
                ->constrained('proyectos')
                ->nullOnDelete();
        });

        Schema::table('albaranes_clientes', function (Blueprint $table) {
            $table->foreignId('proyecto_id')
                ->nullable()
                ->after('cliente_id')
                ->constrained('proyectos')
                ->nullOnDelete();
        });

        Schema::table('presupuestos', function (Blueprint $table) {
            $table->foreignId('proyecto_id')
                ->nullable()
                ->after('cliente_id')
                ->constrained('proyectos')
                ->nullOnDelete();
        });

        Schema::table('inventario', function (Blueprint $table) {
            $table->foreignId('proyecto_id')
                ->nullable()
                ->after('id')
                ->constrained('proyectos')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventario', function (Blueprint $table) {
            $table->dropConstrainedForeignId('proyecto_id');
        });

        Schema::table('presupuestos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('proyecto_id');
        });

        Schema::table('albaranes_clientes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('proyecto_id');
        });

        Schema::table('clientes', function (Blueprint $table) {
            $table->dropConstrainedForeignId('proyecto_id');
        });
    }
};
