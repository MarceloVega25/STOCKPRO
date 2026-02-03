<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;
use App\Models\Compra;
use App\Models\Reparto;
use App\Models\Vehiculo;
use App\Models\Vendedor;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        Route::model('compra', Compra::class);
        Route::model('reparto', Reparto::class);
        Route::model('vehiculo', Vehiculo::class);
        Route::model('vendedor', Vendedor::class);

        // Registro de middlewares personalizados
        Route::aliasMiddleware('role', RoleMiddleware::class);
        Route::aliasMiddleware('permission', PermissionMiddleware::class);
        Route::aliasMiddleware('role_or_permission', RoleOrPermissionMiddleware::class);
    }
}
