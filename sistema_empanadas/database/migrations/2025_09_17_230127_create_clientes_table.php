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
        Schema::create('clientes', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 100);
        $table->string('tipo_documento', 10)->default('CC'); // Campo nuevo y requerido
        $table->string('documento_identidad', 20)->unique(); // Documento debe ser único
        $table->string('correo', 150)->nullable()->unique(); // Puede ser nulo, pero si existe, debe ser único
        $table->string('direccion')->nullable();
        $table->string('ciudad', 100)->nullable();
        $table->string('telefono', 20)->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
