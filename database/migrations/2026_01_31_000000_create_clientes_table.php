<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Intentionally left blank. The 'clientes' table is created by an earlier migration
        // to satisfy foreign-key constraints (e.g., adscripciones.cliente_id).
    }

    public function down(): void
    {
        // Intentionally left blank.
    }
};
