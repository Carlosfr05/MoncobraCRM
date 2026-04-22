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
        Schema::table('albaranes_clientes', function (Blueprint $table) {
            if (!Schema::hasColumn('albaranes_clientes', 'estado')) {
                $table->string('estado', 20)->default('pendiente')->after('titulo');
            }

            if (!Schema::hasColumn('albaranes_clientes', 'archivo_pdf')) {
                $table->string('archivo_pdf')->nullable()->after('estado');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('albaranes_clientes', function (Blueprint $table) {
            if (Schema::hasColumn('albaranes_clientes', 'archivo_pdf')) {
                $table->dropColumn('archivo_pdf');
            }

            if (Schema::hasColumn('albaranes_clientes', 'estado')) {
                $table->dropColumn('estado');
            }
        });
    }
};
