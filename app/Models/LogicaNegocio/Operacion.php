<?php

namespace App\Models\LogicaNegocio;

use App\Models\User;
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
     * Relación: Muchas operaciones pueden pertenecer a Muchos parques industriales.
     */
    public function parquesIndustriales()
    {
        return $this->belongsToMany(ParqueIndustrial::class);
    }
}
