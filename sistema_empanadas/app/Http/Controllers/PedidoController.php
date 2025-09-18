<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\PedidoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('cliente', 'detalles.producto')->orderBy('fecha', 'desc')->get();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $productos = Producto::where('stock', '>', 0)->orderBy('nombre')->get(); // Solo productos con stock
        $clienteMostrador = Cliente::where('nombre', 'Cliente de Mostrador')->first();

        return view('pedidos.create', compact('clientes', 'productos', 'clienteMostrador'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        // Usamos una transacción para garantizar la integridad de los datos
        DB::beginTransaction();
        try {
            // 1. Crear el pedido
            $pedido = Pedido::create([
                'cliente_id' => $request->cliente_id,
                'total' => 0, // El total se calculará después
                'fecha' => Carbon::now(),
            ]);

            $totalPedido = 0;

            // 2. Procesar cada producto del pedido
            foreach ($request->productos as $productoData) {
                $producto = Producto::find($productoData['id']);
                $cantidad = $productoData['cantidad'];

                // 2.1. Validar si hay stock suficiente
                if ($producto->stock < $cantidad) {
                    // Si no hay stock, revertimos todo y mandamos error
                    DB::rollBack();
                    return redirect()->route('pos')->with('error', "Stock insuficiente para {$producto->nombre}. Disponible: {$producto->stock}.");
                }

                // 2.2. Crear el detalle del pedido
                $subtotal = $producto->precio * $cantidad;
                PedidoDetalle::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $producto->precio,
                    'subtotal' => $subtotal,
                ]);

                // 2.3. Actualizar el stock del producto
                $producto->decrement('stock', $cantidad);

                // 2.4. Acumular el total
                $totalPedido += $subtotal;
            }

            // 3. Actualizar el total del pedido
            $pedido->total = $totalPedido;
            $pedido->save();

            // Si todo salió bien, confirmamos la transacción
            DB::commit();

            return redirect()->route('pos')->with('success', 'Venta registrada correctamente. Total: $' . number_format($totalPedido));

        } catch (\Exception $e) {
            // Si algo falla, revertimos todo
            DB::rollBack();
            return redirect()->route('pos')->with('error', 'Ocurrió un error al registrar la venta: ' . $e->getMessage());
        }
    }
}