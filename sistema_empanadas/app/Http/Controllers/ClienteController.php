<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        // Excluir al cliente de mostrador de la lista principal
        $clientes = Cliente::where('nombre', '!=', 'Cliente de Mostrador')->get();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo_documento' => 'required|string|max:10',
            'documento_identidad' => 'required|string|max:20|unique:clientes,documento_identidad',
            'correo' => 'nullable|email|max:150|unique:clientes,correo',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
        ]);

        Cliente::create($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente creado exitosamente.');
    }
    
    // Función para crear cliente desde el POS (modal)
    public function storeFromModal(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo_documento' => 'required|string|max:10',
            'documento_identidad' => 'required|string|max:20|unique:clientes,documento_identidad',
            'correo' => 'nullable|email|max:150|unique:clientes,correo',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
        ]);

        $cliente = Cliente::create($request->all());

        // Redireccionar de vuelta al POS con el nuevo cliente seleccionado
        return redirect()->route('pos')->with('new_client_id', $cliente->id);
    }


    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'tipo_documento' => 'required|string|max:10',
            'documento_identidad' => 'required|string|max:20|unique:clientes,documento_identidad,' . $cliente->id,
            'correo' => 'nullable|email|max:150|unique:clientes,correo,' . $cliente->id,
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
        ]);

        $cliente->update($request->all());

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(Cliente $cliente)
    {
        // Restricción: No se puede eliminar cliente de mostrador
        if ($cliente->nombre === 'Cliente de Mostrador') {
            return back()->with('error', 'El "Cliente de Mostrador" no se puede eliminar.');
        }

        // Restricción: No eliminar si tiene pedidos asociados
        if ($cliente->pedidos()->exists()) {
            return back()->with('error', 'No se puede eliminar un cliente con ventas registradas.');
        }

        $cliente->delete();
        return back()->with('success', 'Cliente eliminado correctamente.');
    }
}
