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
        Schema::create('operacion_parque_industrial', function (Blueprint $table) {
            $table->id();
            $table->foreignId('operacion_id')->constrained('operaciones')->onDelete('cascade');
            $table->foreignId('parque_industrial_id')->constrained('parques_industriales')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operacion_parque_industrial');
    }
};
