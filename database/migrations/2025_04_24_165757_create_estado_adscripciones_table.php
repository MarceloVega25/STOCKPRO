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
        Schema::create('estados_compras', function (Blueprint $table) {
            $table->id();

            // Compra asociado
            $table->foreignId('compra_id')->constrained('compras')->onDelete('cascade');

            // Estado de la compra (texto)
            $table->string('estado'); // Ej: "Inscripción abierta", "Jurado designado", etc.
            $table->text('comentario')->nullable(); // Observaciones opcionales

            // Fecha y hora del registro
            $table->timestamps(); // created_at será la fecha del estado
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados_compras');
    }
};

