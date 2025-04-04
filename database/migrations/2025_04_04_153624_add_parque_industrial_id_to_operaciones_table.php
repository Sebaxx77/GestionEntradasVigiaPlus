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
        Schema::table('operaciones', function (Blueprint $table) {
            // Agregar la clave foránea a operaciones
            $table->foreignId('parque_industrial_id')->constrained('parques_industriales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('operaciones', function (Blueprint $table) {
            // Eliminar la clave foránea primero
            $table->dropForeign(['parque_industrial_id']);
            // Luego eliminar la columna
            $table->dropColumn('parque_industrial_id');
        });
    }
};
