<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = ['cliente_id', 'total', 'fecha'];

    // Un pedido pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    // Un pedido tiene muchos detalles
    public function detalles()
    {
        return $this->hasMany(PedidoDetalle::class);
    }
}