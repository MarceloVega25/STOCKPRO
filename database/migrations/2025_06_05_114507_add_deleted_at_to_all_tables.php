<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tablas = [
            'repartos',
            'repartidores',
            'vehiculos',
            'vendedores',
            'compras',
            'usuarios',
            'ventas',
            'departamentos',
            'carreras',
        ];

        foreach ($tablas as $tabla) {
            if (!Schema::hasTable($tabla)) {
                continue;
            }

            Schema::table($tabla, function (Blueprint $table) use ($tabla) {
                if (!Schema::hasColumn($tabla, 'deleted_at')) {
                    $table->softDeletes();
                }
            });
        }
    }

    public function down(): void
    {
        $tablas = [
            'repartos',
            'repartidores',
            'vehiculos',
            'vendedores',
            'compras',
            'usuarios',
            'ventas',
            'departamentos',
            'carreras',
        ];

        foreach ($tablas as $tabla) {
            if (!Schema::hasTable($tabla)) {
                continue;
            }

            Schema::table($tabla, function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
