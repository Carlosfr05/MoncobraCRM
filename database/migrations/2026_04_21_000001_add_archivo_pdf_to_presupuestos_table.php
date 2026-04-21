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
        Schema::table('presupuestos', function (Blueprint $table) {
            if (!Schema::hasColumn('presupuestos', 'archivo_pdf')) {
                $table->string('archivo_pdf')->nullable()->after('ot');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('presupuestos', function (Blueprint $table) {
            if (Schema::hasColumn('presupuestos', 'archivo_pdf')) {
                $table->dropColumn('archivo_pdf');
            }
        });
    }
};
