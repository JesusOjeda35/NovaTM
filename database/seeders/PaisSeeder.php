<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pais;

class PaisSeeder extends Seeder
{
    public function run(): void
    {
        $paises = [
            ['nombre' => 'Colombia', 'codigo' => 'CO'],
            ['nombre' => 'Argentina', 'codigo' => 'AR'],
            ['nombre' => 'Brasil', 'codigo' => 'BR'],
            ['nombre' => 'Chile', 'codigo' => 'CL'],
            ['nombre' => 'Ecuador', 'codigo' => 'EC'],
            ['nombre' => 'Perú', 'codigo' => 'PE'],
            ['nombre' => 'Uruguay', 'codigo' => 'UY'],
            ['nombre' => 'Paraguay', 'codigo' => 'PY'],
            ['nombre' => 'Venezuela', 'codigo' => 'VE'],
            ['nombre' => 'Bolivia', 'codigo' => 'BO'],
            ['nombre' => 'Guyana', 'codigo' => 'GY'],
            ['nombre' => 'Surinam', 'codigo' => 'SR'],
            ['nombre' => 'Panamá', 'codigo' => 'PA'],
            ['nombre' => 'Costa Rica', 'codigo' => 'CR'],
            ['nombre' => 'Nicaragua', 'codigo' => 'NI'],
            ['nombre' => 'Honduras', 'codigo' => 'HN'],
            ['nombre' => 'El Salvador', 'codigo' => 'SV'],
            ['nombre' => 'Guatemala', 'codigo' => 'GT'],
            ['nombre' => 'Belice', 'codigo' => 'BZ'],
            ['nombre' => 'México', 'codigo' => 'MX'],
            ['nombre' => 'Estados Unidos', 'codigo' => 'US'],
            ['nombre' => 'Canadá', 'codigo' => 'CA'],
            ['nombre' => 'España', 'codigo' => 'ES'],
            ['nombre' => 'Portugal', 'codigo' => 'PT'],
            ['nombre' => 'Francia', 'codigo' => 'FR'],
            ['nombre' => 'Italia', 'codigo' => 'IT'],
            ['nombre' => 'Alemania', 'codigo' => 'DE'],
            ['nombre' => 'Reino Unido', 'codigo' => 'GB'],
            ['nombre' => 'Otros países', 'codigo' => 'OT'],
        ];

        foreach ($paises as $pais) {
            Pais::firstOrCreate(
                ['codigo' => $pais['codigo']],
                ['nombre' => $pais['nombre']]
            );
        }
    }
}