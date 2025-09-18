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
        Schema::create('productos', function (Blueprint $table) {
        $table->id(); // Columna 'id' autoincremental (bigint unsigned)
        $table->string('nombre', 100); // Columna 'nombre' (varchar 100)
        $table->text('descripcion')->nullable(); // 'descripcion' (text), puede ser nulo
        $table->integer('stock')->default(0); // 'stock' (integer), valor por defecto 0
        $table->decimal('precio', 10, 2); // 'precio' (decimal), ideal para dinero. 10 dígitos en total, 2 decimales.
        $table->timestamps(); // Crea las columnas 'created_at' y 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
