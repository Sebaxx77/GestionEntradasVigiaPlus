<?php

namespace App\Models\Agendamientos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AgendamientoFormatoVisita extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'agendamientos_visita';

    /**
     * Los atributos que se pueden asignar de manera masiva.
     *
     * @var array
     */
    protected $fillable = [
        'fecha_visita',
        'parque_industrial',
        'operacion',
        'vehiculo',
        'placa',
        'conductor',
        'cedula',
        'correo_solicitante',
        'tipo', // Campo para identificar el formato, por ejemplo: "formato_visita"
    ];
}