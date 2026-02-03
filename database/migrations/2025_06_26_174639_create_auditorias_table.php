<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();
            $table->string('tabla_afectada');
            $table->string('operacion'); // INSERT, UPDATE, DELETE
            $table->unsignedBigInteger('registro_id');
            $table->longText('datos_anteriores')->nullable();
            $table->longText('datos_nuevos')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->timestamp('fecha')->useCurrent();

            $table->foreign('usuario_id')->references('id')->on('usuarios')->nullOnDelete();
        });
    }

    public function down(): void {
        Schema::dropIfExists('auditorias');
    }
};
