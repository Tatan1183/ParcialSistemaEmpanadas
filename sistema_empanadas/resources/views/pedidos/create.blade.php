@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="text-center mb-4">🛒 Punto de Venta (POS)</h1>

    <form action="{{ route('pedidos.store') }}" method="POST" id="pos-form">
        @csrf
        <div class="row">
            <!-- Columna de Venta -->
            <div class="col-md-7">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Detalles de la Venta</h5>
                    </div>
                    <div class="card-body">
                        <!-- Selección de Cliente -->
                        <div class="mb-3">
                            <label for="cliente_id" class="form-label"><strong>Cliente:</strong></label>
                            <div class="input-group">
                                <select name="cliente_id" id="cliente_id" class="form-select" required>
                                    @php
                                        $newClientId = session('new_client_id');
                                    @endphp
                                    @foreach($clientes as $cliente)
                                        <option value="{{ $cliente->id }}" 
                                            {{ ($newClientId == $cliente->id) || (!$newClientId && $cliente->id == $clienteMostrador->id) ? 'selected' : '' }}>
                                            {{ $cliente->nombre }} - {{ $cliente->documento_identidad }}
                                        </option>
                                    @endforeach
                                </select>
                                <button class="btn btn-outline-success" type="button" data-bs-toggle="modal" data-bs-target="#createClientModal">
                                    <i class="bi bi-person-plus-fill"></i> Nuevo
                                </button>
                            </div>
                        </div>

                        <!-- Tabla de Productos a Vender -->
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th style="width: 120px;">Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="sale-items">
                                    <!-- Los productos se agregarán aquí con JS -->
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3 d-none" id="empty-cart-message">
                            <p class="text-muted">Agrega productos desde la lista de la derecha.</p>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <h3>Total: <span id="total-display">$0</span></h3>
                    </div>
                </div>
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-success btn-lg"><i class="bi bi-cash-coin"></i> Registrar Venta</button>
                </div>
            </div>

            <!-- Columna de Productos Disponibles -->
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Productos Disponibles</h5>
                    </div>
                    <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                        <div class="row">
                            @forelse($productos as $producto)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 product-card" role="button" onclick="addProductToSale({{ $producto->id }}, '{{ $producto->nombre }}', {{ $producto->precio }})">
                                    <div class="card-body text-center">
                                        <h6 class="card-title">{{ $producto->nombre }}</h6>
                                        <p class="card-text text-success fw-bold">${{ number_format($producto->precio, 0) }}</p>
                                        <small class="text-muted">Stock: {{ $producto->stock }}</small>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-center text-danger">No hay productos con stock disponible.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal para crear nuevo cliente -->
<div class="modal fade" id="createClientModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Nuevo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('clientes.storeFromModal') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Formulario de cliente aquí (similar a clientes/create.blade.php) -->
                     <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="tipo_documento" class="form-label">Tipo Documento</label>
                            <select name="tipo_documento" class="form-select" required>
                                <option value="CC">Cédula de Ciudadanía</option>
                                <option value="CE">Cédula de Extranjería</option>
                                <option value="NIT">NIT</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                         <div class="col-md-6">
                            <label for="documento_identidad" class="form-label">Número Documento</label>
                            <input type="text" name="documento_identidad" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" name="direccion" class="form-control">
                        </div>
                         <div class="col-md-6">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input type="text" name="ciudad" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .product-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .product-card:hover {
        transform: scale(1.05);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>

<script>
    let saleItems = [];

    function addProductToSale(id, name, price) {
        // Verificar si el producto ya está en el carrito
        const existingItem = saleItems.find(item => item.id === id);

        if (existingItem) {
            existingItem.cantidad++;
        } else {
            saleItems.push({ id, name, price, cantidad: 1 });
        }
        renderSaleItems();
    }
    
    function updateQuantity(id, newQuantity) {
        const item = saleItems.find(item => item.id === id);
        if (item) {
            item.cantidad = parseInt(newQuantity, 10);
            if (item.cantidad <= 0) {
                // Si la cantidad es 0 o menos, eliminar el item
                removeItem(id);
            } else {
                renderSaleItems();
            }
        }
    }

    function removeItem(id) {
        saleItems = saleItems.filter(item => item.id !== id);
        renderSaleItems();
    }

    function renderSaleItems() {
        const tbody = document.getElementById('sale-items');
        const totalDisplay = document.getElementById('total-display');
        const emptyCartMessage = document.getElementById('empty-cart-message');
        const form = document.getElementById('pos-form');
        
        // Limpiar inputs ocultos viejos
        form.querySelectorAll('input[name^="productos"]').forEach(input => input.remove());
        
        tbody.innerHTML = '';
        let total = 0;

        if (saleItems.length === 0) {
            emptyCartMessage.classList.remove('d-none');
        } else {
            emptyCartMessage.classList.add('d-none');
        }

        saleItems.forEach((item, index) => {
            const subtotal = item.price * item.cantidad;
            total += subtotal;

            const row = `
                <tr>
                    <td>${item.name}</td>
                    <td>
                        <input type="number" value="${item.cantidad}" class="form-control form-control-sm" min="1" 
                               onchange="updateQuantity(${item.id}, this.value)">
                    </td>
                    <td>$${item.price.toLocaleString()}</td>
                    <td>$${subtotal.toLocaleString()}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${item.id})">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </td>
                </tr>
            `;
            tbody.innerHTML += row;
            
            // Agregar inputs ocultos para el formulario
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = `productos[${index}][id]`;
            idInput.value = item.id;
            form.appendChild(idInput);

            const qtyInput = document.createElement('input');
            qtyInput.type = 'hidden';
            qtyInput.name = `productos[${index}][cantidad]`;
            qtyInput.value = item.cantidad;
            form.appendChild(qtyInput);
        });

        totalDisplay.textContent = `$${total.toLocaleString()}`;
    }
    
    // Iniciar con el mensaje de carrito vacío
    document.addEventListener('DOMContentLoaded', renderSaleItems);
</script>
@endsection