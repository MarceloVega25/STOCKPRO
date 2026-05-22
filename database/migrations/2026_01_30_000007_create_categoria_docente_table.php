<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categoria_repartidor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->foreignId('repartidor_id')->constrained('repartidores')->onDelete('cascade');
            $table->enum('tipo', ['titular', 'suplente']);
            $table->timestamps();

            $table->unique(['categoria_id', 'repartidor_id', 'tipo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categoria_repartidor');
    }
};
