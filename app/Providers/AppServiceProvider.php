<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Usuario;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\Carrera;
use App\Models\Compra;
use App\Models\Venta;
use App\Models\Reparto;
use App\Models\Vehiculo;
use App\Models\Vendedor;

use App\Observers\UsuarioObserver;
use App\Observers\ProductoObserver;
use App\Observers\CategoriaObserver;
use App\Observers\ProveedorObserver;
use App\Observers\ClienteObserver;
use App\Observers\DepartamentoObserver;
use App\Observers\CarreraObserver;
use App\Observers\CompraObserver;
use App\Observers\VentaObserver;
use App\Observers\RepartoObserver;
use App\Observers\VehiculoObserver;
use App\Observers\VendedorObserver;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    Usuario::observe(UsuarioObserver::class);
    Producto::observe(ProductoObserver::class);
    Categoria::observe(CategoriaObserver::class);
    Proveedor::observe(ProveedorObserver::class);
    Cliente::observe(ClienteObserver::class);
    Departamento::observe(DepartamentoObserver::class);
    Carrera::observe(CarreraObserver::class);
    Compra::observe(CompraObserver::class);
    Venta::observe(VentaObserver::class);
    Reparto::observe(RepartoObserver::class);
    Vehiculo::observe(VehiculoObserver::class);
    Vendedor::observe(VendedorObserver::class);
}

}
