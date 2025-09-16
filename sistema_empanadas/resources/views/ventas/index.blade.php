@extends('layouts.app')

@section('content')
<h2>Lista de Ventas</h2>
<a href="{{ route('ventas.create') }}" class="btn btn-primary mb-3">➕ Nueva Venta</a>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        @foreach($ventas as $venta)
        <tr>
            <td>{{ $venta->id }}</td>
            <td>{{ $venta->producto->nombre }}</td>
            <td>{{ $venta->cantidad_vendida }}</td>
            <td>${{ number_format($venta->total, 0) }}</td>
            <td>{{ $venta->fecha }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection