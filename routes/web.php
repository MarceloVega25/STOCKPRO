<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\InformeController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\RepartoController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\MovimientoStockController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Ruta principal con middleware de autenticación
//Route::get('/', function () {return view('index');})->middleware('auth');

// Ruta para el dashboard (Home) Y con middleware de autenticacion
Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])
    ->name('home')->middleware('auth');

   // Auth::routes();
// Desactivar registro de usuarios en Auth
Auth::routes(['register' => false]);

// ----------------- Usuarios -----------------
// Administra usuarios (solo admin)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/usuarios/buscar', [UsuarioController::class, 'mostrarBusqueda'])
        ->name('usuarios.buscar');
    Route::post('/usuarios/buscar', [UsuarioController::class, 'buscarEmail'])
        ->name('usuarios.buscarEmail');

    // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('usuarios', \App\Http\Controllers\UsuarioController::class)
        ->except(['show']);
});

// Ver usuarios (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('usuarios', \App\Http\Controllers\UsuarioController::class)
        ->only(['show',]);
});

// ----------------- Productos -----------------
//Administra Productos (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () { //protege el grupo de la ruta
    // Ruta intermedia
    Route::get('/productos/buscar', [ProductoController::class, 'mostrarBusqueda'])
        ->name('productos.buscar');
    // Ruta que procesa el DNI
    Route::post('/productos/buscar', [ProductoController::class, 'buscarDni'])
        ->name('productos.buscarDni');

    // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('productos', \App\Http\Controllers\ProductoController::class)
        ->except(['show', 'index']);
});

// Ver productos (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('productos', \App\Http\Controllers\ProductoController::class)
        ->only(['show', 'index']);
});

// ----------------- Categorias -----------------
//Administra Categorias (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () { //protege el grupo de la ruta

    // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('categorias', CategoriaController::class)
        ->parameters(['categorias' => 'categoria'])
        ->except(['show', 'index']);
});

// Ver categorias (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('categorias', CategoriaController::class)
        ->parameters(['categorias' => 'categoria'])
        ->only(['show', 'index']);
});

// Ruta para ver el seguimiento de una categoria
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::get('categorias/{categoria}/seguimientos', [CategoriaController::class, 'seguimientos'])
        ->name('categorias.seguimientos');
});

// ----------------- Proveedores -----------------
//Administra Proveedores (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () { //protege el grupo de la ruta
    // Ruta intermedia
    Route::get('/proveedores/buscar', [ProveedorController::class, 'mostrarBusqueda'])
        ->name('proveedores.buscar');
    // Ruta que procesa el DNI
    Route::post('/proveedores/buscar', [ProveedorController::class, 'buscarDni'])
        ->name('proveedores.buscarDni');

    // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('proveedores', \App\Http\Controllers\ProveedorController::class)
        ->except(['show', 'index']);
});

// Ver proveedores (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('proveedores', \App\Http\Controllers\ProveedorController::class)
        ->only(['show', 'index']);
});

// ----------------- Compras -----------------
// Compras reemplaza Adscripciones
Route::middleware(['auth', 'role:admin|carga'])->group(function () {
    Route::resource('compras', CompraController::class)
        ->except(['show', 'index']);
});

Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('compras', CompraController::class)
        ->only(['show', 'index']);
});

Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::get('compras/{compra}/seguimientos', [CompraController::class, 'seguimientos'])
        ->name('compras.seguimientos');
});

// ----------------- Clientes -----------------
//Administra Clientes (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () {
    Route::resource('clientes', \App\Http\Controllers\ClienteController::class)
        ->except(['show', 'index']);
});

// Ver Clientes (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('clientes', \App\Http\Controllers\ClienteController::class)
        ->only(['show', 'index']);
});

// ----------------- Departamentos -----------------
// Legacy deshabilitado: Departamentos -> Stock
// Legacy deshabilitado: Carreras -> Movimientos de Stock

// ----------------- Stock -----------------
// Stock reemplaza Departamentos
Route::middleware(['auth', 'role:admin|carga'])->group(function () {
    Route::resource('stock', StockController::class)
        ->except(['show', 'index']);
});

Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('stock', StockController::class)
        ->only(['show', 'index']);
});

// ----------------- Movimientos de Stock -----------------
// Movimientos de Stock reemplaza Carreras
Route::middleware(['auth', 'role:admin|carga'])->group(function () {
    Route::resource('movimientos_stock', MovimientoStockController::class)
        ->except(['show', 'index']);
});

Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('movimientos_stock', MovimientoStockController::class)
        ->only(['show', 'index']);
});

// ----------------- Ventas -----------------
// Ventas reemplaza Asignaturas
Route::middleware(['auth', 'role:admin|carga'])->group(function () {
    Route::resource('ventas', VentaController::class)
        ->except(['show', 'index']);
});

Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('ventas', VentaController::class)
        ->only(['show', 'index']);
});

// ----------------- Repartos -----------------
// Repartos reemplaza Docentes
Route::middleware(['auth', 'role:admin|carga'])->group(function () {
    Route::get('/repartos/buscar', [RepartoController::class, 'mostrarBusqueda'])
        ->name('repartos.buscar');
    Route::post('/repartos/buscar', [RepartoController::class, 'buscarDni'])
        ->name('repartos.buscarDni');

    Route::resource('repartos', RepartoController::class)
        ->except(['show', 'index']);
});

Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('repartos', RepartoController::class)
        ->only(['show', 'index']);
});

// ----------------- Vehículos -----------------
// Vehículos reemplaza Estudiantes
Route::middleware(['auth', 'role:admin|carga'])->group(function () {
    Route::get('/vehiculos/buscar', [VehiculoController::class, 'mostrarBusqueda'])
        ->name('vehiculos.buscar');
    Route::post('/vehiculos/buscar', [VehiculoController::class, 'buscarDni'])
        ->name('vehiculos.buscarDni');

    Route::resource('vehiculos', VehiculoController::class)
        ->except(['show', 'index']);
});

Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('vehiculos', VehiculoController::class)
        ->only(['show', 'index']);
});

// ----------------- Vendedores -----------------
// Vendedores reemplaza Veedores
Route::middleware(['auth', 'role:admin|carga'])->group(function () {
    Route::get('/vendedores/buscar', [VendedorController::class, 'mostrarBusqueda'])
        ->name('vendedores.buscar');

    Route::post('/vendedores/buscar', [VendedorController::class, 'buscarDni'])
        ->name('vendedores.buscarDni');

    Route::resource('vendedores', VendedorController::class)
        ->except(['show', 'index']);
});

Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('vendedores', VendedorController::class)
        ->only(['show', 'index']);
});

// ----------------- Informes -----------------
Route::middleware(['auth'])->group(function () {

    // Vista unificada (opcional)
    Route::get('/informes', [App\Http\Controllers\InformeController::class, 'index'])->name('informes.index');

    // Vistas separadas
    Route::get('/informes/fecha', [App\Http\Controllers\InformeController::class, 'porFecha'])->name('informes.porFecha');
    Route::get('/informes/anio', [App\Http\Controllers\InformeController::class, 'porAnio'])->name('informes.porAnio');

    // Historial de informes generados
    Route::get('/informes/historico', [App\Http\Controllers\InformeController::class, 'historico'])->name('informes.historico');

    // Acciones POST para generar PDF
    Route::post('/informes/generar', [App\Http\Controllers\InformeController::class, 'generar'])->name('informes.generar');
    Route::post('/informes/por-anio', [App\Http\Controllers\InformeController::class, 'generarPorAnio'])->name('informes.generarPorAnio');

    Route::delete('/informes/{id}', [App\Http\Controllers\InformeController::class, 'destroy'])->name('informes.destroy');

});




// ----------------- Notificaciones -----------------
//Administra Notificaciones (admin, carga)
Route::get('/notificacion', function () {
    return view('mail.notificacion');
})->middleware('auth', 'role:admin|carga')->name('notificacion');

// ----------------- enviar correos -----------------
Route::post('/mail/send', [MailController::class, 'sendMail'])->name('mail.send');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('auditorias', AuditoriaController::class)->only(['index', 'show']);
