@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <h1 class="display-5"><i class="bi bi-bar-chart-line-fill text-primary"></i> Informe de Ventas</h1>
    </div>

    <!-- Fila de Tarjetas de Resumen -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Ventas Totales</h5>
                        <p class="card-text fs-4 fw-bold">${{ number_format($totalVentas, 0, ',', '.') }}</p>
                    </div>
                    <i class="bi bi-cash-coin" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">N° de Ventas</h5>
                        <p class="card-text fs-4 fw-bold">{{ $totalPedidos }}</p>
                    </div>
                    <i class="bi bi-receipt" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-dark bg-warning shadow">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Producto Estrella</h5>
                        <p class="card-text fs-4 fw-bold">
                            {{ $productoMasVendido->nombre ?? 'N/A' }}
                        </p>
                    </div>
                    <i class="bi bi-star-fill" style="font-size: 3rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Fila de Tablas de Informes -->
    <div class="row">
        <!-- Columna Principal -->
        <div class="col-lg-8">
            <!-- Ventas por Producto -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-box-seam"></i> Ventas por Producto</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad Vendida</th>
                                    <th>Total Generado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ventasPorProducto as $venta)
                                    <tr>
                                        <td>{{ $venta->nombre }}</td>
                                        <td>{{ $venta->cantidad }}</td>
                                        <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center">No hay datos para mostrar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Ventas por Día -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar-day"></i> Ventas Recientes (Últimos 15 días)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Día</th>
                                    <th>Total del Día</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ventasPorDia as $venta)
                                    <tr>
                                        <td>{{ $venta->dia->format('d \d\e F, Y') }}</td>
                                        <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-center">No hay datos para mostrar.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna Secundaria -->
        <div class="col-lg-4">
            <!-- Ventas por Tipo de Cliente -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-people"></i> Ventas por Tipo de Cliente</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            @forelse($ventasPorCliente as $venta)
                                <tr>
                                    <td><strong>{{ $venta->tipo_cliente }}</strong></td>
                                    <td class="text-end">${{ number_format($venta->total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td class="text-center">No hay datos.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Ventas por Ciudad -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-geo-alt"></i> Ventas por Ciudad (Clientes Registrados)</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                         <tbody>
                            @forelse($ventasPorCiudad as $venta)
                                <tr>
                                    <td><strong>{{ $venta->ciudad }}</strong></td>
                                    <td class="text-end">${{ number_format($venta->total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr><td class="text-center">No hay datos.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


