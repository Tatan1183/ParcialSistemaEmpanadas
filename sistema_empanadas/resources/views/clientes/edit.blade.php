@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-3">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Editar Cliente</h4>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('clientes.update', $cliente->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">
                    
                    <div class="col-md-6">
                        <label for="nombre" class="form-label"><strong>Nombre Completo</strong></label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $cliente->nombre) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="tipo_documento" class="form-label"><strong>Tipo de Documento</strong></label>
                        <select name="tipo_documento" class="form-select" required>
                            @php $tipo_doc = old('tipo_documento', $cliente->tipo_documento); @endphp
                            <option value="CC" {{ $tipo_doc == 'CC' ? 'selected' : '' }}>Cédula de Ciudadanía</option>
                            <option value="CE" {{ $tipo_doc == 'CE' ? 'selected' : '' }}>Cédula de Extranjería</option>
                            <option value="NIT" {{ $tipo_doc == 'NIT' ? 'selected' : '' }}>NIT</option>
                            <option value="Otro" {{ $tipo_doc == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="documento_identidad" class="form-label"><strong>Número de Documento</strong></label>
                        <input type="text" name="documento_identidad" class="form-control" value="{{ old('documento_identidad', $cliente->documento_identidad) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono) }}">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" name="correo" class="form-control" value="{{ old('correo', $cliente->correo) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $cliente->direccion) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="ciudad" class="form-label">Ciudad</label>
                        <input type="text" class="form-control" id="ciudad" name="ciudad" value="{{ old('ciudad', $cliente->ciudad) }}">
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between">
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-save-fill"></i> Actualizar Cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


