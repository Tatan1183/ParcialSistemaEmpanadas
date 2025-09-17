<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','documento_identidad','correo', 'direccion','ciudad','telefono',];

    // Un cliente puede tener muchos pedidos
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }
}

