<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'descripcion', 'stock', 'precio'];

    // Un producto puede estar en muchos detalles de pedido
    public function detalles()
    {
        return $this->hasMany(PedidoDetalle::class);
    }
}