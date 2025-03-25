<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabla agendamientos para almacenar los datos que se reciben del formulario de agendamiento en la UI
        Schema::create('agendamientos', function (Blueprint $table) {
            $table->id(); // Identificador unico id para cada agendamiento
            $table->integer('op'); // Campo entero Orden de Producción
            $table->date('fecha_entrega'); // Fecha de entrega
            $table->string('proveedor'); // Proveedor
            $table->string('codigo_articulo')->nullable(); // Código correspondiente a el artículo a entregar
            $table->string('nombre_articulo')->nullable(); // Nombre del artículo a entregar
            $table->string('cantidades_pedidas')->nullable(); // Cantidades pedidas del artículo
            $table->string('placa')->nullable(); // Placa del vehículo
            $table->string('conductor')->nullable(); // Nombre del conductor
            $table->string('cedula')->nullable(); // Cédula del conductor
            $table->string('bodega')->nullable(); // Bodega a la que se dirige
            $table->enum('estatus', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente'); // Estatus de la solicitud
            $table->string('autorizador')->nullable(); // Nombre del autorizador
            $table->date('fecha_programada_entrega')->nullable(); // Fecha programada de entrega
            $table->string('correo_solicitante'); // Correo del solicitante
            $table->text('texto_respuesta_correo')->nullable(); // Texto de respuesta del correo
            $table->string('celular')->nullable(); // Celular del solicitante
            $table->timestamps(); // Fecha de creación y modificación
            $table->softDeletes(); // Fecha de eliminación lógica
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendamientos');
    }
};
