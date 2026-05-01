<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pais;
use App\Models\Departamento;
use App\Models\Municipio;

class ColombiaSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener o crear Colombia
        $colombia = Pais::firstOrCreate(
            ['codigo' => 'CO'],
            ['nombre' => 'Colombia']
        );

        // Array con departamentos y municipios de Colombia
        $departamentosData = [
            'Amazonas' => ['Leticia', 'Puerto Nariño', 'La Chorrera', 'Tarapacá'],
            'Antioquia' => ['Medellín', 'Aburrá Sur', 'Bello', 'Envigado', 'Itagüí', 'La Ceja', 'Rionegro'],
            'Arauca' => ['Arauca', 'Arauquita', 'Cravo Norte', 'Fortul', 'Puerto Rondón'],
            'Atlántico' => ['Barranquilla', 'Soledad', 'Malambo', 'Galapa', 'Sabanalarga'],
            'Bolívar' => ['Cartagena', 'Turbaco', 'Magangué', 'Santa Cartagena', 'Arjona'],
            'Boyacá' => ['Tunja', 'Duitama', 'Sogamoso', 'Paipa', 'Uptá', 'Ráquira'],
            'Caldas' => ['Manizales', 'Villamaría', 'Neira', 'Palestina', 'Chinchiná'],
            'Caquetá' => ['Florencia', 'La Montañita', 'Cartagena del Chairá', 'Solano', 'Valparaíso'],
            'Cauca' => ['Popayán', 'Santander de Quilichao', 'Puerto Tejada', 'Timbío', 'Piendamó'],
            'Cesar' => ['Valledupar', 'La Paz', 'Bosconia', 'Aguachica', 'Codazzi'],
            'Chocó' => ['Quibdó', 'Istmina', 'Tadó', 'Condoto', 'Atrato'],
            'Córdoba' => ['Montería', 'Cereté', 'Lorica', 'Sahagún', 'Tierralta'],
            'Cundinamarca' => ['Bogotá', 'Soacha', 'Zipaquirá', 'Facatativá', 'Girardot', 'Ubaté'],
            'Guainía' => ['Inírida', 'Puerto Colombia', 'San Felipe'],
            'Guaviare' => ['San José del Guaviare', 'Calamar', 'El Retorno'],
            'Huila' => ['Neiva', 'Pitalito', 'La Plata', 'Garzón', 'Campoalegre'],
            'La Guajira' => ['Riohacha', 'Maicao', 'Fonseca', 'Baranoa', 'Distracción'],
            'Magdalena' => ['Santa Marta', 'Ciénaga', 'Aracataca', 'Fundación', 'El Retén'],
            'Meta' => ['Villavicencio', 'Acacías', 'San Juan de Arama', 'Restrepo', 'Castilla la Nueva'],
            'Nariño' => ['Pasto', 'Ipiales', 'Tumaco', 'Sibundoy', 'San Juan de Pasto'],
            'Norte de Santander' => ['Cúcuta', 'Los Patios', 'Villa del Rosario', 'Pamplona', 'Oca­ña'],
            'Putumayo' => ['Mocoa', 'Puerto Asís', 'Puerto Caicedo', 'Leguízamo', 'Sibundoy'],
            'Quindío' => ['Armenia', 'Pereira', 'Dosquebradas', 'La Tebaida', 'Buenavista'],
            'Risaralda' => ['Pereira', 'Dosquebradas', 'Santa Rosa de Cabal', 'La Virginia', 'Cartago'],
            'Santander' => ['Bucaramanga', 'Girón', 'Floridablanca', 'Piedecuesta', 'San Gil'],
            'Sucre' => ['Sincelejo', 'Corozal', 'San Marcos', 'Palmito', 'Tolú'],
            'Tolima' => ['Ibagué', 'Espinal', 'Melgar', 'Saldaña', 'Chaparral'],
            'Valle del Cauca' => ['Cali', 'Yumbo', 'Candelaria', 'Cartago', 'Buenaventura'],
            'Vaupés' => ['Mitú', 'Caruru', 'Taraira', 'Papúnaua'],
            'Vichada' => ['Puerto Carreño', 'La Primavera', 'Santa Rosalía de Vichada'],
        ];

        foreach ($departamentosData as $nombreDept => $municipios) {
            // Crear departamento
            $departamento = Departamento::firstOrCreate(
                ['nombre' => $nombreDept, 'pais_id' => $colombia->id],
                ['pais_id' => $colombia->id, 'nombre' => $nombreDept]
            );

            // Crear municipios
            foreach ($municipios as $nombreMuni) {
                Municipio::firstOrCreate(
                    ['nombre' => $nombreMuni, 'departamento_id' => $departamento->id],
                    ['departamento_id' => $departamento->id, 'nombre' => $nombreMuni]
                );
            }
        }

        echo "\n✅ Colombia con todos sus departamentos y municipios cargados exitosamente!\n";
    }
}