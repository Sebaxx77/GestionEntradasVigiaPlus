<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agendamiento extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Los atributos que se pueden asignar de manera masiva.
     *
     * @var array
     */
    protected $fillable = [
        'op',
        'fecha_entrega',
        'proveedor',
        'codigo_articulo',
        'nombre_articulo',
        'cantidades_pedidas',
        'placa',
        'conductor',
        'cedula',
        'bodega',
        'estatus',
        'autorizador',
        'fecha_programada_entrega',
        'correo_solicitante',
        'texto_respuesta_correo',
        'celular',
    ];
}
