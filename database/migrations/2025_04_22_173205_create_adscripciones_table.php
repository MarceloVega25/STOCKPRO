<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id();

            // Número y año (identificación institucional)
            $table->unsignedInteger('numero')->nullable();
            $table->unsignedInteger('anio')->nullable();

            // Fechas clave del proceso
            $table->date('inicio_publicidad')->nullable();
            $table->date('cierre_publicidad')->nullable();
            $table->date('inicio_inscripcion')->nullable();
            $table->date('cierre_inscripcion')->nullable();
            $table->date('fecha_compra')->nullable();

            // Relación 1:1 con jerarquía (cargo concursado)
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');

            // Otros campos descriptivos
            $table->string('tipo_compra')->nullable();       // Ej: Ordinario, Reválida
            $table->string('modalidad_compra')->nullable();  // Ej: Presencial, Virtual, Mixta
            $table->string('expediente')->nullable();
            $table->text('observaciones')->nullable();

            $table->string('estado')->nullable();
            $table->text('comentario')->nullable();

            $table->foreignId('designado_id')->nullable()->constrained('proveedores')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compras');
    }
};
