@extends('layout')

@section('content')
<h2>🧾 Pedidos</h2>
<a href="{{ route('pedidos.create') }}" class="btn btn-primary mb-3">+ Nuevo Pedido</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Detalles</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedidos as $pedido)
        <tr>
            <td>{{ $pedido->id }}</td>
            <td>{{ $pedido->cliente->nombre }}</td>
            <td>${{ $pedido->total }}</td>
            <td>{{ $pedido->fecha }}</td>
            <td>
                <ul>
                    @foreach($pedido->detalles as $detalle)
                        <li>{{ $detalle->cantidad }} x {{ $detalle->producto->nombre }} ( ${{ $detalle->subtotal }} )</li>
                    @endforeach
                </ul>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection