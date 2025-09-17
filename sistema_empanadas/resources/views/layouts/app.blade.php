<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Empanadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin') }}">🥟 Empanadas</a>
            <div>
                <a class="btn btn-outline-light btn-sm" href="{{ route('productos.index') }}">Productos</a>
                <a class="btn btn-outline-light btn-sm" href="{{ route('clientes.index') }}">Clientes</a>
                <a class="btn btn-outline-light btn-sm" href="{{ route('pedidos.index') }}">Pedidos</a>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>