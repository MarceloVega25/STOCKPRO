<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seguimientos_compras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('compra_id')->constrained('compras')->onDelete('cascade');
             $table->string('accion'); // Ej: "Se agregó reparto titular"
            $table->text('detalle')->nullable(); // Info extra
            $table->string('usuario')->nullable(); // Quién hizo la acción
            $table->timestamp('fecha')->useCurrent(); // Cuándo se hizo
            $table->timestamps();
         });
    }

    public function down(): void
    {
        Schema::dropIfExists('seguimientos_compras');
    }
};
