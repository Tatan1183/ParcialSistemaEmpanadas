@extends('layouts.app')

@section('content')
<h2>Registrar Nueva Venta</h2>

<form action="{{ route('ventas.store') }}" method="POST" class="card p-4">
    @csrf
    <div class="mb-3">
        <label class="form-label">Producto</label>
        <select name="producto_id" class="form-control" required>
            @foreach($productos as $producto)
            <option value="{{ $producto->codigo }}">{{ $producto->nombre }} (Stock: {{ $producto->cantidad }})</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Cantidad Vendida</label>
        <input type="number" name="cantidad_vendida" class="form-control" required>
    </div>
    <button class="btn btn-success">Registrar Venta</button>
</form>
@endsection