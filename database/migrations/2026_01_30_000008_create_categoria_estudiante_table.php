<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categoria_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('vehiculo_id')->constrained('vehiculos')->onDelete('cascade');
            $table->enum('tipo', ['titular', 'suplente']);
            $table->timestamps();

            $table->unique(['categoria_id', 'vehiculo_id', 'tipo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categoria_vehiculo');
    }
};
