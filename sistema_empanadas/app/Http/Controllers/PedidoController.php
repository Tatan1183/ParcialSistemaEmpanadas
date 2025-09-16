<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\PedidoDetalle;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('cliente', 'detalles.producto')->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('pedidos.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'producto_id' => 'required|array',
            'producto_id.*' => 'exists:productos,id',
            'cantidad' => 'required|array',
            'cantidad.*' => 'integer|min:1',
        ]);

        $pedido = Pedido::create([
            'cliente_id' => $request->cliente_id,
            'total' => 0,
            'fecha' => Carbon::now(),
        ]);

        $total = 0;

        foreach ($request->producto_id as $i => $producto_id) {
            $producto = Producto::find($producto_id);
            $cantidad = $request->cantidad[$i];
            $subtotal = $producto->precio * $cantidad;

            PedidoDetalle::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->precio,
                'subtotal' => $subtotal,
            ]);

            // Actualizar stock
            $producto->decrement('stock', $cantidad);

            $total += $subtotal;
        }

        $pedido->update(['total' => $total]);

        return redirect()->route('pedidos.index')->with('success', 'Pedido registrado correctamente.');
    }
}
