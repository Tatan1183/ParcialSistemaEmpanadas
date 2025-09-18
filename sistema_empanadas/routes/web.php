<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\InformeController;

// Ruta principal que redirige al admin
Route::get('/', function () {
    return redirect()->route('admin');
});

// Admin: menú de administración
Route::get('/admin', fn() => view('admin.menu'))->name('admin');

// POS: Vista principal del punto de venta
Route::get('/pos', [PedidoController::class, 'create'])->name('pos');

// CRUD Productos
Route::resource('productos', ProductoController::class);

// CRUD Clientes
Route::resource('clientes', ClienteController::class);
// Ruta para guardar un cliente desde el modal del POS
Route::post('/clientes/modal', [ClienteController::class, 'storeFromModal'])->name('clientes.storeFromModal');


// Pedidos (Punto de Venta)
Route::resource('pedidos', PedidoController::class)->only(['index', 'create', 'store']);

// Informes
Route::get('admin/informes', [InformeController::class, 'index'])->name('informes.index');




