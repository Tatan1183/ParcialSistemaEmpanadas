<?php

namespace App\Http\Controllers;

use App\Models\Pedido; // ¡Importante! Asegúrate de importar el modelo Pedido
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InformeController extends Controller
{
    public function index()
    {
        // --- Consultas para las Tarjetas de Resumen ---
        $totalVentas = Pedido::sum('total');
        $totalPedidos = Pedido::count();
        
        // --- Consultas para las Tablas Detalladas ---

        // Ventas por día (FORMA CORREGIDA Y ROBUSTA)
        $ventasPorDia = Pedido::where('fecha', '>=', now()->subDays(30)) // Traemos los pedidos del último mes
            ->orderBy('fecha', 'desc')
            ->get() // Obtenemos la colección completa de pedidos
            ->groupBy(function($pedido) {
                // Agrupamos por día USANDO la fecha ya convertida por el modelo.
                // $pedido->fecha ya está en la zona horaria de Colombia.
                return $pedido->fecha->format('Y-m-d');
            })
            ->map(function ($day) {
                // Mapeamos para darle el formato que la vista espera
                return (object) [ // Lo convertimos a objeto para que la vista no falle
                    'dia' => $day->first()->fecha,
                    'total' => $day->sum('total')
                ];
            });


        // Ventas por producto (Esta consulta no maneja fechas, está bien como estaba)
        $ventasPorProducto = DB::table('pedido_detalles')
            ->join('productos', 'pedido_detalles.producto_id', '=', 'productos.id')
            ->select('productos.nombre', DB::raw('SUM(pedido_detalles.cantidad) as cantidad'), DB::raw('SUM(pedido_detalles.subtotal) as total'))
            ->groupBy('productos.nombre')
            ->orderByDesc('total')
            ->get();
            
        $productoMasVendido = $ventasPorProducto->first();

        // Las demás consultas tampoco dependen de la fecha, así que se quedan igual.
        $ventasPorCliente = DB::table('pedidos')
            ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id')
            ->select(
                DB::raw("CASE WHEN clientes.nombre = 'Cliente de Mostrador' THEN 'Mostrador' ELSE 'Registrados' END as tipo_cliente"),
                DB::raw('COUNT(pedidos.id) as cantidad_pedidos'),
                DB::raw('SUM(pedidos.total) as total')
            )
            ->groupBy('tipo_cliente')
            ->get();

        $ventasPorCiudad = DB::table('pedidos')
            ->join('clientes', 'pedidos.cliente_id', '=', 'clientes.id')
            ->where('clientes.ciudad', '!=', 'N/A')
            ->select('clientes.ciudad', DB::raw('SUM(pedidos.total) as total'))
            ->groupBy('clientes.ciudad')
            ->orderByDesc('total')
            ->get();

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


