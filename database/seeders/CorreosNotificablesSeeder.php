<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CorreosNotificablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('correos_notificables')->insert([
            ['nombre' => 'Pruebas', 'correo' => 'juanpiamba23@gmail.com', 'operacion_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
