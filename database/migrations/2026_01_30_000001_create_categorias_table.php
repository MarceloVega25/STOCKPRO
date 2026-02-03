<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('designado_id')->nullable();

            // Número y año (identificación institucional)
            $table->unsignedInteger('numero')->nullable();
            $table->unsignedInteger('anio')->nullable();

            // Fechas clave del proceso
            $table->date('inicio_publicidad')->nullable();
            $table->date('cierre_publicidad')->nullable();
            $table->date('inicio_inscripcion')->nullable();
            $table->date('cierre_inscripcion')->nullable();
            $table->date('fecha_concurso')->nullable();

            // Relación 1:1 con jerarquía
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');

            // Otros campos descriptivos
            $table->string('tipo_concurso')->nullable();
            $table->string('modalidad_concurso')->nullable();
            $table->string('expediente')->nullable();
            $table->text('observaciones')->nullable();

            $table->string('estado')->nullable();
            $table->text('comentario')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('designado_id')->references('id')->on('productos')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
