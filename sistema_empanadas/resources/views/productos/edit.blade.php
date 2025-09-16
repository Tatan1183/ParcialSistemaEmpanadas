@extends('layout')

@section('content')
<h2>✏️ Editar Producto</h2>
<form action="{{ route('productos.update', $producto) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
    </div>
    <div class="mb-3">
        <label>Descripción</label>
        <textarea name="descripcion" class="form-control">{{ $producto->descripcion }}</textarea>
    </div>
    <div class="mb-3">
        <label>Stock</label>
        <input type="number" name="stock" class="form-control" value="{{ $producto->stock }}" min="0" required>
    </div>
    <div class="mb-3">
        <label>Precio</label>
        <input type="number" name="precio" class="form-control" value="{{ $producto->precio }}" step="0.01" min="0" required>
    </div>
    <button class="btn btn-success">Actualizar</button>
    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>
@endsection