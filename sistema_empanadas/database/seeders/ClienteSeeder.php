<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        Cliente::firstOrCreate(
            ['documento_identidad' => '0000000000'], // Clave para evitar duplicados
            [
                'nombre' => 'Cliente de Mostrador',
                'tipo_documento' => 'N/A',
                'correo' => 'mostrador@local.com',
                'telefono' => '0',
                'direccion' => 'N/A',
                'ciudad' => 'N/A',
            ]
        );
    }
}