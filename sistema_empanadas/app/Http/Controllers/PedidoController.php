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

    // Crear pedido vacío con total inicial en 0
    $pedido = Pedido::create([
        'cliente_id' => $request->cliente_id,
        'total' => 0,
        'fecha' => Carbon::now(),
    ]);

    $total = 0;

    foreach ($request->producto_id as $i => $producto_id) {
        $producto = Producto::find($producto_id);
        $cantidad = $request->cantidad[$i];

        // 🚨 Validar stock disponible antes de continuar
        if ($producto->stock < $cantidad) {
            // Si no hay suficiente stock, cancelar pedido creado
            $pedido->delete();
            return back()->withErrors([
                'error' => "Stock insuficiente para {$producto->nombre} (disponible: {$producto->stock}, solicitado: {$cantidad})"
            ]);
        }

        // Verificar si ya existe un detalle de este producto en el pedido
        $detalle = PedidoDetalle::where('pedido_id', $pedido->id)
                                ->where('producto_id', $producto_id)
                                ->first();

        if ($detalle) {
            // Si ya existe, sumamos cantidades y recalculamos subtotal
            $detalle->cantidad += $cantidad;
            $detalle->subtotal = $detalle->cantidad * $detalle->precio_unitario;
            $detalle->save();
        } else {
            // Si no existe, lo creamos
            PedidoDetalle::create([
                'pedido_id' => $pedido->id,
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->precio,
                'subtotal' => $producto->precio * $cantidad,
            ]);
        }

        // Restar stock
        $producto->decrement('stock', $cantidad);

        // Acumular al total
        $total += $producto->precio * $cantidad;
    }

    // Actualizar total del pedido
    $pedido->update(['total' => $total]);

    return redirect()->route('pedidos.index')->with('success', 'Pedido registrado correctamente.');
    }
}
