<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CorreoNotificable extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'parques_industriales';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'correo',
    ];

    /**
     * Relación: Muchas correos notificables pueden pertenecer a una operación.
     */
    public function operacion()
    {
        return $this->belongsTo(Operacion::class);
    }
}
