<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParquesIndustrialesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('parques_industriales')->insert([
            ['nombre' => 'Parque Industrial San Diego', 'direccion' => 'CALLE #123', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
