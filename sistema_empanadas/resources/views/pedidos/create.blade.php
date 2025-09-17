@extends('layouts.app')

@section('content')
<h2>➕ Nuevo Pedido</h2>
<form action="{{ route('pedidos.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label>Cliente</label>
        <select name="cliente_id" class="form-control" required>
            @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
            @endforeach
        </select>
    </div>

    <div id="productos-container">
        <div class="row mb-2 producto-item">
            <div class="col">
                <label>Producto</label>
                <select name="producto_id[]" class="form-control" required>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre }} - ${{ $producto->precio }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label>Cantidad</label>
                <input type="number" name="cantidad[]" class="form-control" min="1" required>
            </div>
        </div>
    </div>

    <button type="button" class="btn btn-secondary mb-3" onclick="agregarProducto()">+ Agregar otro producto</button>
    <br>
    <button class="btn btn-success">Registrar Pedido</button>
    <a href="{{ route('pedidos.index') }}" class="btn btn-secondary">Cancelar</a>
</form>

<select name="cliente_id" class="form-control" required>
    @foreach($clientes as $cliente)
        <option value="{{ $cliente->id }}" {{ $cliente->nombre == 'Cliente de Mostrador' ? 'selected' : '' }}>
            {{ $cliente->nombre }}
        </option>
    @endforeach
</select>


<script>
function agregarProducto() {
    let container = document.getElementById('productos-container');
    let productos = document.querySelectorAll('select[name="producto_id[]"]');
    let cantidades = document.querySelectorAll('input[name="cantidad[]"]');

    // Tomar el producto seleccionado en la última fila
    let ultimaFila = container.querySelector('.producto-item:last-child');
    let selectProducto = ultimaFila.querySelector('select[name="producto_id[]"]');
    let inputCantidad = ultimaFila.querySelector('input[name="cantidad[]"]');

    let productoId = selectProducto.value;
    let cantidadNueva = parseInt(inputCantidad.value) || 0;

    // Buscar si ya existe otra fila con el mismo producto
    let encontrado = false;
    productos.forEach((select, index) => {
        if (index < productos.length - 1 && select.value === productoId) {
            cantidades[index].value = parseInt(cantidades[index].value) + cantidadNueva;
            ultimaFila.remove(); // Eliminamos la fila repetida
            encontrado = true;
        }
    });

    if (!encontrado) {
        // Si no estaba repetido, clonamos una nueva fila limpia
        let item = ultimaFila.cloneNode(true);
        item.querySelectorAll('input').forEach(input => input.value = '');
        container.appendChild(item);
    }
}
</script>

@endsection