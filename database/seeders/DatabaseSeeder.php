<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llamar a los seeders en el orden correcto
        $this->call([
            RoleAndPermissionSeeder::class,
            ParquesIndustrialesSeeder::class,
            OperacionesSeeder::class,
            CorreosNotificablesSeeder::class,
            UserSeeder::class,
        ]);

        $this->command->info("Seeders ejecutados en el orden correcto.");
    }
}
