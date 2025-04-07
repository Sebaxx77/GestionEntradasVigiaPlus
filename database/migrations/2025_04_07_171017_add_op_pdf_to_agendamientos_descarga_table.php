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
        Schema::table('agendamientos_descarga', function (Blueprint $table) {
            $table->string('op_pdf')->nullable()->after('tipo'); // Agregar la columna op_pdf
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendamientos', function (Blueprint $table) {
            $table->dropColumn('op_pdf'); // Eliminar la columna op_pdf
        });
    }
};
