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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'admin', 'superadmin'])->default('user')->after('password');
            $table->foreignId('proyecto_id')->nullable()->constrained('proyectos')->nullOnDelete()->after('role');
            $table->text('descripcion')->nullable()->after('proyecto_id');
            $table->string('telefono', 20)->nullable()->after('descripcion');
            $table->string('avatar')->nullable()->after('telefono');
            $table->boolean('activo')->default(true)->after('avatar');
            $table->timestamp('ultimo_acceso')->nullable()->after('activo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'proyecto_id',
                'descripcion',
                'telefono',
                'avatar',
                'activo',
                'ultimo_acceso'
            ]);
        });
    }
};
