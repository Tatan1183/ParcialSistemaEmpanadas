@extends('layout')

@section('content')
<h2>➕ Nuevo Producto</h2>
<form action="{{ route('productos.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control"></textarea>
    </div>
    <div class="mb-3">
        <label>Stock</label>
        <input type="number" name="stock" class="form-control" min="0" required>
    </div>
    <div class="mb-3">
        <label>Precio</label>
        <input type="number" name="precio" class="form-control" step="0.01" min="0" required>
    </div>
    <button class="btn btn-success">Guardar</button>
    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection