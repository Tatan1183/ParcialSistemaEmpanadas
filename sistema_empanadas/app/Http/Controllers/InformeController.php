<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformeController extends Controller
{
    public function index()
    {
        // Ventas totales por día
        $ventasPorDia = DB::table('pedidos')
            ->select(DB::raw('DATE(fecha) as dia'), DB::raw('SUM(total) as total'))
            ->groupBy('dia')
            ->orderBy('dia', 'desc')
            ->get();

        // Ventas por producto
        $ventasPorProducto = DB::table('pedido_detalles')
            ->join('productos', 'pedido_detalles.producto_id', '=', 'productos.id')
            ->select('productos.nombre', DB::raw('SUM(pedido_detalles.cantidad) as cantidad'), DB::raw('SUM(pedido_detalles.subtotal) as total'))
            ->groupBy('productos.nombre')
            ->orderByDesc('total')
            ->get();

        // Ventas por tipo de cliente (mostrador vs registrados)
        $ventasPorCliente = DB::table('pedidos')
            ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id')
            ->select(DB::raw("CASE 
                WHEN clientes.nombre = 'Mostrador' THEN 'Mostrador' 
                ELSE 'Registrados' END as tipo_cliente"), 
                DB::raw('COUNT(*) as cantidad'), 
                DB::raw('SUM(pedidos.total) as total'))
            ->groupBy('tipo_cliente')
            ->get();

        // Ventas por ciudad
        $ventasPorCiudad = DB::table('pedidos')
            ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id')
            ->select('clientes.ciudad', DB::raw('SUM(pedidos.total) as total'))
            ->groupBy('clientes.ciudad')
            ->orderByDesc('total')
            ->get();

        return view('informes.index', compact('ventasPorDia', 'ventasPorProducto', 'ventasPorCliente', 'ventasPorCiudad'));
    }
}


