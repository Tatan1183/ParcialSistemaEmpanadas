<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\VentaController;


// Admin: menú de administración
Route::get('/admin', fn() => view('admin.menu'))->name('admin');

// POS: crear pedido rápido
Route::get('/pos', [PedidoController::class, 'create'])->name('pos');

// CRUD Productos
Route::resource('productos', ProductoController::class);

// CRUD Clientes
Route::resource('clientes', ClienteController::class);

// CRUD Ventas
Route::resource('ventas', VentaController::class);

// Pedidos (solo index, create y store)
Route::resource('pedidos', PedidoController::class)->only(['index', 'create', 'store']);

Route::get('admin/informes', [App\Http\Controllers\InformeController::class, 'index'])->name('informes.index');




