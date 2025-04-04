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
        Schema::create('agendamientos_visita', function (Blueprint $table) {
            $table->id(); // Identificador unico id para cada agendamiento de visita
            $table->date('fecha_visita'); // Fecha de visita
            $table->string('parque_industrial'); // Parque industrial donde se dirige
            $table->string('operacion'); // Operacion a la que se dirige
            $table->integer('vehiculo'); // Carro, Moto
            $table->string('placa'); // Placa del vehículo
            $table->string('conductor'); // Nombre del conductor
            $table->string('cedula'); // Cédula del conductor
            $table->string('correo_solicitante'); // Correo de la persona que solicita la visita
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendamientos_visita');
    }
};
