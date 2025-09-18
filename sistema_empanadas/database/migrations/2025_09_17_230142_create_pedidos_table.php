<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
        $table->id();
        
        // Relación con la tabla 'clientes'
        $table->foreignId('cliente_id')
              ->constrained('clientes') // Se enlaza con la tabla 'clientes'
              ->onDelete('restrict'); // Impide que se borre un cliente si tiene pedidos

        $table->decimal('total', 10, 2);
        $table->dateTime('fecha'); // Usamos dateTime para guardar fecha y hora
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
