<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ejecutar seeders en orden
        $this->call([
            PaisSeeder::class,
            ColombiaSeeder::class,
        ]);
    }
}