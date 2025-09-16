<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VentaController extends Controller
{
    // Mostrar todas las ventas
    public function index()
    {
        $ventas = Venta::with('producto')->get();
        return view('ventas.index', compact('ventas'));
    }

    // Mostrar formulario para nueva venta
    public function create()
    {
        $productos = Producto::all();
        return view('ventas.create', compact('productos'));
    }

    // Guardar nueva venta
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad_vendida' => 'required|integer|min:1',
        ]);

        $producto = Producto::find($request->producto_id);

        // Crear venta
        $venta = Venta::create([
            'producto_id' => $producto->id,
            'cantidad_vendida' => $request->cantidad_vendida,
            'total' => $producto->precio * $request->cantidad_vendida,
            'fecha' => Carbon::now(),
        ]);

        // Actualizar stock del producto
        $producto->decrement('stock', $request->cantidad_vendida);

        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
    }

    public function show(Venta $venta)
    {
        return view('ventas.show', compact('venta'));
    }

    public function edit(Venta $venta)
    {
        $productos = Producto::all();
        return view('ventas.edit', compact('venta', 'productos'));
    }

    public function update(Request $request, Venta $venta)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad_vendida' => 'required|integer|min:1',
        ]);

        $producto = Producto::find($request->producto_id);

        $venta->update([
            'producto_id' => $producto->id,
            'cantidad_vendida' => $request->cantidad_vendida,
            'total' => $producto->precio * $request->cantidad_vendida,
            'fecha' => Carbon::now(),
        ]);

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }

    public function destroy(Venta $venta)
    {
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada.');
    }
}

