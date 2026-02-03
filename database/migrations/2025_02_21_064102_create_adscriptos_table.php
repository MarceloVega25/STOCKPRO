<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Intentionally left blank. The legacy 'adscriptos' module has been removed.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        return;
    }
};
