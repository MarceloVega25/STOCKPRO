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
        if (!Schema::hasTable('compras')) {
            return;
        }

        if (Schema::hasColumn('compras', 'designado_id')) {
            return;
        }

        Schema::table('compras', function (Blueprint $table) {
            $table->unsignedBigInteger('designado_id')->nullable()->after('comentario');
            $table->foreign('designado_id')->references('id')->on('proveedores')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('compras') || !Schema::hasColumn('compras', 'designado_id')) {
            return;
        }

        Schema::table('compras', function (Blueprint $table) {
            $table->dropForeign(['designado_id']);
            $table->dropColumn('designado_id');
        });
    }
};
