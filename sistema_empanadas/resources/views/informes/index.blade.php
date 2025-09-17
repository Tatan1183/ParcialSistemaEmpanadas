@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">📊 Informe de Ventas</h1>

    {{-- Ventas por Día --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-calendar3"></i> Ventas por Día
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>Día</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventasPorDia as $venta)
                        <tr>
                            <td>{{ $venta->dia ?? $venta->fecha ?? $venta->created_at }}</td>
                            <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Ventas por Producto --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <i class="bi bi-box-seam"></i> Ventas por Producto
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-success">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventasPorProducto as $venta)
                        <tr>
                            <td>{{ $venta->nombre }}</td>
                            <td>{{ $venta->cantidad }}</td>
                            <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Ventas por Cliente --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-warning text-dark">
            <i class="bi bi-people"></i> Ventas por Tipo de Cliente
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-warning">
                    <tr>
                        <th>Tipo Cliente</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventasPorCliente as $venta)
                        <tr>
                            <td>{{ $venta->tipo_cliente }}</td>
                            <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Ventas por Ciudad --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-info text-white">
            <i class="bi bi-building"></i> Ventas por Ciudad
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-info">
                    <tr>
                        <th>Ciudad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventasPorCiudad as $venta)
                        <tr>
                            <td>{{ $venta->ciudad }}</td>
                            <td>${{ number_format($venta->total, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection



