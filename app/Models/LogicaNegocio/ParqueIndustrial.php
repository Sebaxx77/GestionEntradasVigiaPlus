<?php

namespace App\Models\LogicaNegocio;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParqueIndustrial extends Model
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
        'direccion',
    ];

    /**
     * Relación: Muchos industrial puede tener muchas operaciones.
     */
    public function operaciones()
    {
        return $this->belongsToMany(Operacion::class);
    }
}
