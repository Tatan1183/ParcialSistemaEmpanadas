<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0', // No negativo
            'stock' => 'required|integer|min:0',  // No negativo
            'descripcion' => 'nullable|string',
        ]);

        Producto::create($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto agregado correctamente.');
    }

    public function edit(Producto $producto)
    {
        return view('productos.edit', compact('producto'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0', // No negativo
            'stock' => 'required|integer|min:0',  // No negativo
            'descripcion' => 'nullable|string',
        ]);

        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        // Restricción: No eliminar si el producto tiene ventas asociadas
        if ($producto->detalles()->exists()) {
            return back()->with('error', 'No se puede eliminar un producto con ventas registradas.');
        }
        $producto->delete();
        return back()->with('success', 'Producto eliminado.');
    }
}