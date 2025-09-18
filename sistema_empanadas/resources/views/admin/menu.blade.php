@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center p-5 bg-white rounded-3 shadow-sm">
        <h1 class="display-4">Menú de Administración</h1>
        <p class="lead">Selecciona una opción para gestionar el sistema.</p>
        <hr class="my-4">
        <div class="d-grid gap-3 d-md-flex justify-content-md-center">
            <a href="{{ route('productos.index') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-box-seam-fill"></i> Gestión de Productos
            </a>
            <a href="{{ route('clientes.index') }}" class="btn btn-success btn-lg">
                <i class="bi bi-people-fill"></i> Gestión de Clientes
            </a>
            <a href="{{ route('informes.index') }}" class="btn btn-info btn-lg">
                <i class="bi bi-bar-chart-line-fill"></i> Informe de Ventas
            </a>
            <a href="{{ route('pedidos.index') }}" class="btn btn-secondary btn-lg">
                <i class="bi bi-receipt"></i> Historial de Ventas
            </a>
        </div>
    </div>
</div>
@endsection