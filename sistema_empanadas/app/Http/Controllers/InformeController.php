<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformeController extends Controller
{
    public function index()
    {
        // --- Consultas para las Tarjetas de Resumen ---

        // 1. Total de ingresos
        $totalVentas = DB::table('pedidos')->sum('total');

        // 2. Número total de pedidos (ventas)
        $totalPedidos = DB::table('pedidos')->count();

        // --- Consultas para las Tablas Detalladas (las que ya tenías) ---

        // Ventas por día
        $ventasPorDia = DB::table('pedidos')
            ->select(DB::raw('DATE(fecha) as dia'), DB::raw('SUM(total) as total'))
            ->groupBy('dia')
            ->orderBy('dia', 'desc')
            ->limit(15) // Limitamos para no hacer la tabla excesivamente larga
            ->get();

        // Ventas por producto
        $ventasPorProducto = DB::table('pedido_detalles')
            ->join('productos', 'pedido_detalles.producto_id', '=', 'productos.id')
            ->select('productos.nombre', DB::raw('SUM(pedido_detalles.cantidad) as cantidad'), DB::raw('SUM(pedido_detalles.subtotal) as total'))
            ->groupBy('productos.nombre')
            ->orderByDesc('total')
            ->get();
            
        // 3. Producto más vendido (lo sacamos de la consulta anterior)
        $productoMasVendido = $ventasPorProducto->first();

        // Ventas por tipo de cliente (mostrador vs registrados)
        $ventasPorCliente = DB::table('pedidos')
            ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id')
            ->select(
                DB::raw("CASE WHEN clientes.nombre = 'Cliente de Mostrador' THEN 'Mostrador' ELSE 'Registrados' END as tipo_cliente"),
                DB::raw('COUNT(pedidos.id) as cantidad_pedidos'),
                DB::raw('SUM(pedidos.total) as total')
            )
            ->groupBy('tipo_cliente')
            ->get();

        // Ventas por ciudad
        $ventasPorCiudad = DB::table('pedidos')
            ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id')
            ->where('clientes.ciudad', '!=', 'N/A') // Excluimos al cliente de mostrador
            ->select('clientes.ciudad', DB::raw('SUM(pedidos.total) as total'))
            ->groupBy('clientes.ciudad')
            ->orderByDesc('total')
            ->get();

        // Enviamos todas las variables a la vista
        return view('informes.index', compact(
            'totalVentas',
            'totalPedidos',
            'productoMasVendido',
            'ventasPorDia',
            'ventasPorProducto',
            'ventasPorCliente',
            'ventasPorCiudad'
        ));
    }
}


