<?php

namespace App\Models\Agendamientos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgendamientoFormatoDescarga extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'agendamientos_descarga'; // Se modifca el nombre de la tabla a plural para que concuerde con la migración

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
        'tipo', // Campo para identificar el formato, por ejemplo: "formato_descarga"
    ];
}
