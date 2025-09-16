<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\VentaController;

// Página principal
Route::get('/', fn() => view('menu'))->name('menu');

// CRUD Productos
Route::resource('productos', ProductoController::class);

// CRUD Clientes
Route::resource('clientes', ClienteController::class);

// CRUD Ventas
Route::resource('ventas', VentaController::class);

// Pedidos (solo index, create y store)
Route::resource('pedidos', PedidoController::class)->only(['index', 'create', 'store']);
