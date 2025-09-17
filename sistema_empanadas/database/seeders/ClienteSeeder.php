<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente; // Asegúrate de importar el modelo

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cliente::firstOrCreate([
            'nombre' => 'Cliente de Mostrador',
            'correo' => 'mostrador@local',
            'direccion' => 'N/A',
            'telefono' => '0000000000',
        ]);
    }
}