@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">✏️ Editar Cliente</h4>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>⚠️ Atención!</strong> Revisa los campos obligatorios.<br><br>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                <!-- Documento de Identidad -->
                <div class="col-md-6 mb-3">
                    <label for="documento_identidad" class="form-label">Documento de Identidad</label>
                    <input type="text" class="form-control" id="documento_identidad" name="documento_identidad" 
                           value="{{ old('documento_identidad', $cliente->documento_identidad) }}" required>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $cliente->nombre) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" name="correo" class="form-control" value="{{ old('correo', $cliente->correo) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $cliente->direccion) }}" required>
                    </div>
                    <div class="form-group">
                         <label for="ciudad">Ciudad</label>
                         <input type="text" class="form-control" id="ciudad" name="ciudad"
                         value="{{ old('ciudad', $cliente->ciudad ?? '') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono) }}" required>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">⬅️ Volver</a>
                    <button type="submit" class="btn btn-warning">💾 Actualizar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


