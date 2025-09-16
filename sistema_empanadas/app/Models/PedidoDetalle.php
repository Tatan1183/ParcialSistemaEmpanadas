<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model
{
    use HasFactory;

    protected $fillable = ['pedido_id', 'producto_id', 'cantidad', 'precio_unitario', 'subtotal'];

    // Un detalle pertenece a un pedido
    public function pedido()
    {
        return $this->belongsTo(Pedido::class);
    }

    // Un detalle pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}