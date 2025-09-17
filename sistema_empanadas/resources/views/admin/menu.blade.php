@extends('layouts.app')

@section('content')
<div class="text-center">
    <h1 class="mb-4">Menú de Administración</h1>
    <a href="{{ route('productos.index') }}" class="btn btn-primary btn-lg me-3">Gestión de Productos</a>
    <a href="{{ route('clientes.index') }}" class="btn btn-success btn-lg me-3">Gestión de Clientes</a>
    <a href="{{ route('informes.index') }}" class="btn btn-warning btn-lg">Informe de Ventas</a>
</div>
@endsection
