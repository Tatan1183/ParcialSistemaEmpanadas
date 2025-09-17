<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Mostrar todos los clientes.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Mostrar formulario de creación de cliente.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Guardar un nuevo cliente en la BD.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'documento_identidad' => 'required|string|unique:clientes,documento_identidad',
            'correo' => 'required|email|unique:clientes',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:20',
            'telefono' => 'required|string|max:20',
            
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Mostrar formulario para editar cliente.
     */
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualizar cliente en la BD.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'documento_identidad' => 'required|string|unique:clientes,documento_identidad,' . $cliente->id,
            'correo' => 'required|email|unique:clientes,correo,' . $cliente->id,
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:20',
            'telefono' => 'required|string|max:20',
            
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Eliminar un cliente.
     */
    public function destroy(Cliente $cliente) {
    if ($cliente->pedidos()->exists()) {
        return back()->with('error', 'No se puede eliminar un cliente con ventas registradas.');
    }
    $cliente->delete();
    return back()->with('success', 'Cliente eliminado.');
    }
}

