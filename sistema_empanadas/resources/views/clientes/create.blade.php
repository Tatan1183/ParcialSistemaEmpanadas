@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card shadow-lg rounded-3">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">➕ Registrar Nuevo Cliente</h4>
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

            <form action="{{ route('clientes.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" name="correo" class="form-control" value="{{ old('correo') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}" required>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('clientes.index') }}" class="btn btn-secondary">⬅️ Volver</a>
                    <button type="submit" class="btn btn-success">💾 Guardar Cliente</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


