<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            if (!Schema::hasColumn('compras', 'proveedor_id')) {
                $table->foreignId('proveedor_id')->nullable()->after('cliente_id')->constrained('proveedores')->nullOnDelete();
            }
            if (!Schema::hasColumn('compras', 'fecha')) {
                $table->date('fecha')->nullable()->after('anio');
            }
            if (!Schema::hasColumn('compras', 'comprobante')) {
                $table->string('comprobante')->nullable()->after('fecha');
            }
            if (!Schema::hasColumn('compras', 'observaciones')) {
                $table->text('observaciones')->nullable();
            }
            if (!Schema::hasColumn('compras', 'total')) {
                $table->decimal('total', 12, 2)->default(0)->after('observaciones');
            }
        });

        Schema::table('compras', function (Blueprint $table) {
            if (Schema::hasColumn('compras', 'cliente_id')) {
                $table->dropConstrainedForeignId('cliente_id');
            }
        });

        Schema::table('compras', function (Blueprint $table) {
            if (!Schema::hasColumn('compras', 'cliente_id')) {
                $table->foreignId('cliente_id')->nullable()->constrained('clientes')->nullOnDelete();
            }
        });

        Schema::table('compras', function (Blueprint $table) {
            $columns = [
                'inicio_publicidad',
                'cierre_publicidad',
                'inicio_inscripcion',
                'cierre_inscripcion',
                'fecha_compra',
                'tipo_compra',
                'modalidad_compra',
                'expediente',
                'estado',
                'comentario',
            ];

            foreach ($columns as $col) {
                if (Schema::hasColumn('compras', $col)) {
                    $table->dropColumn($col);
                }
            }
        });

        Schema::table('compras', function (Blueprint $table) {
            if (Schema::hasColumn('compras', 'designado_id')) {
                $table->dropConstrainedForeignId('designado_id');
            }
        });

        $pivotTables = [
            'compra_venta',
            'compra_departamento',
            'compra_carrera',
            'compra_vendedor',
            'compra_proveedor',
            'compra_repartidor',
            'compra_vehiculo',
        ];

        foreach ($pivotTables as $tableName) {
            Schema::dropIfExists($tableName);
        }
    }

    public function down(): void
    {
        Schema::table('compras', function (Blueprint $table) {
            if (Schema::hasColumn('compras', 'total')) {
                $table->dropColumn('total');
            }
            if (Schema::hasColumn('compras', 'comprobante')) {
                $table->dropColumn('comprobante');
            }
            if (Schema::hasColumn('compras', 'fecha')) {
                $table->dropColumn('fecha');
            }
            if (Schema::hasColumn('compras', 'proveedor_id')) {
                $table->dropConstrainedForeignId('proveedor_id');
            }
        });
    }
};
