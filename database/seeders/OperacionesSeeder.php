<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperacionesSeeder extends Seeder
{
    public function run()
    {
        DB::table('operaciones')->insert([
            ['nombre' => 'Vigia Plus', 'bodega' => 'Bodega 12g', 'parque_industrial_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Mattel ', 'bodega' => 'Bodega 12g', 'parque_industrial_id' => 1,'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Sony ', 'bodega' => 'Bodega 12g', 'parque_industrial_id' => 1,'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Fazenda ', 'bodega' => 'Bodega 12g', 'parque_industrial_id' => 1,'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Mary Kay ', 'bodega' => 'Bodega 12g', 'parque_industrial_id' => 1,'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

