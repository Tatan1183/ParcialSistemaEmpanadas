<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Asegúrate de incluir 'tipo_documento'
    protected $fillable = [
        'nombre',
        'tipo_documento',
        'documento_identidad',
        'correo',
        'direccion',
        'ciudad',
        'telefono',
    ];

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}

