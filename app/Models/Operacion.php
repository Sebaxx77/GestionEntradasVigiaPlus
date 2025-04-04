<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operacion extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'operaciones';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'bodega',
    ];

    /**
     * Relación: Una operación puede tener muchos usuarios asociados.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
    
    /**
     * Relación: Una operación puede tener muchos correos notificables asociados.
     */
    public function correosNotificables()
    {
        return $this->hasMany(CorreoNotificable::class);
    }

    /**
     * Relación: Muchas operaciones pueden pertenecer a un parque industrial.
     */
    public function parquesIndustriales()
    {
        return $this->belongsTo(ParqueIndustrial::class);
    }
}
