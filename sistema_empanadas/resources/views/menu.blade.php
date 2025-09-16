@extends('layouts.app')

@section('content')
<div class="text-center">
    <h1 class="mb-4">Bienvenido al Sistema de Empanadas 🥟</h1>
    <a href="{{ route('productos.index') }}" class="btn btn-primary btn-lg me-3">Ver Productos</a>
    <a href="{{ route('ventas.index') }}" class="btn btn-success btn-lg">Ver Ventas</a>
</div>
@endsection