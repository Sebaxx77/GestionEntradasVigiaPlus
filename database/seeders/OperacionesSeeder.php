<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LogicaNegocio\Operacion;
use App\Models\LogicaNegocio\ParqueIndustrial;

class OperacionesSeeder extends Seeder
{
    public function run()
    {
        // Obtener el parque creado previamente (por nombre)
        $parque = ParqueIndustrial::where('nombre', 'Parque Industrial San Diego')->first();

        if (!$parque) {
            $this->command->error('Parque Industrial San Diego no encontrado. Ejecuta el seeder de parques primero.');
            return;
        }

        $operaciones = [
            ['nombre' => 'Vigia Plus', 'bodega' => 'Bodega 12g'],
            ['nombre' => 'Mattel', 'bodega' => 'Bodega 12g'],
            ['nombre' => 'Sony', 'bodega' => 'Bodega 12g'],
            ['nombre' => 'Fazenda', 'bodega' => 'Bodega 12g'],
            ['nombre' => 'Mary Kay', 'bodega' => 'Bodega 12g'],
        ];

        foreach ($operaciones as $data) {
            $operacion = Operacion::create($data);
            $operacion->parquesIndustriales()->attach($parque->id);
        }
    }
}