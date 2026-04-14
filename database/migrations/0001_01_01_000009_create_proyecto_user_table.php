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
        Schema::create('proyecto_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyecto_id')->constrained('proyectos')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['proyecto_id', 'user_id']);
        });

        $users = DB::table('users')
            ->select('id', 'proyecto_id')
            ->whereNotNull('proyecto_id')
            ->get();

        foreach ($users as $user) {
            DB::table('proyecto_user')->insert([
                'proyecto_id' => $user->proyecto_id,
                'user_id' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['proyecto_id']);
            $table->dropColumn('proyecto_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('proyecto_id')->nullable()->after('role')->constrained('proyectos')->nullOnDelete();
        });

        $rows = DB::table('proyecto_user')
            ->select('user_id', 'proyecto_id')
            ->orderBy('id')
            ->get()
            ->groupBy('user_id');

        foreach ($rows as $userId => $assignments) {
            $firstAssignment = $assignments->first();

            DB::table('users')
                ->where('id', $userId)
                ->update(['proyecto_id' => $firstAssignment->proyecto_id]);
        }

        Schema::dropIfExists('proyecto_user');
    }
};