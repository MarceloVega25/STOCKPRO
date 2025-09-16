<?php

use App\Http\Controllers\InscriptoController;
use App\Http\Controllers\AdscriptoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\VeedorController;
use App\Http\Controllers\AsignaturaController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\JerarquiaController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ConcursoController;
use App\Http\Controllers\AdscripcionController;
use App\Http\Controllers\AuditoriaController;
use App\Http\Controllers\InformeController;

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

// ----------------- Inscriptos -----------------
//Administra Inscriptos (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () { //protege el grupo de la ruta
    // Ruta intermedia
    Route::get('/inscriptos/buscar', [InscriptoController::class, 'mostrarBusqueda'])
        ->name('inscriptos.buscar');
    // Ruta que procesa el DNI
    Route::post('/inscriptos/buscar', [InscriptoController::class, 'buscarDni'])
        ->name('inscriptos.buscarDni');

    // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('inscriptos', \App\Http\Controllers\InscriptoController::class)
        ->except(['show', 'index']);
});

// Ver inscriptos (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('inscriptos', \App\Http\Controllers\InscriptoController::class)
        ->only(['show', 'index']);
});

// ----------------- Concursos -----------------
//Administra Concursos (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () { //protege el grupo de la ruta

    // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('concursos', \App\Http\Controllers\ConcursoController::class)
        ->except(['show', 'index']);
});

// Ver concursos (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('concursos', \App\Http\Controllers\ConcursoController::class)
        ->only(['show', 'index']);
});

// Ruta para ver el seguimiento de un concurso
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::get('concursos/{concurso}/seguimientos', [\App\Http\Controllers\ConcursoController::class, 'seguimientos'])
        ->name('concursos.seguimientos');
});

// ----------------- Adscriptos -----------------
//Administra Adscriptos (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () { //protege el grupo de la ruta
    // Ruta intermedia
    Route::get('/adscriptos/buscar', [AdscriptoController::class, 'mostrarBusqueda'])
        ->name('adscriptos.buscar');
    // Ruta que procesa el DNI
    Route::post('/adscriptos/buscar', [AdscriptoController::class, 'buscarDni'])
        ->name('adscriptos.buscarDni');

    // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('adscriptos', \App\Http\Controllers\AdscriptoController::class)
        ->except(['show', 'index']);
});

// Ver adscriptos (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('adscriptos', \App\Http\Controllers\AdscriptoController::class)
        ->only(['show', 'index']);
});

// ----------------- Adscripciones -----------------
//Administra Adscripciones (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () {

    // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('adscripciones', \App\Http\Controllers\AdscripcionController::class)
        ->parameters(['adscripciones' => 'adscripcion'])
        ->except(['show', 'index']);
});

// Ver Adscripciones (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('adscripciones', \App\Http\Controllers\AdscripcionController::class)
        ->parameters(['adscripciones' => 'adscripcion'])
        ->only(['show', 'index']);
});

// Ruta para ver el seguimiento de un concurso
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::get('adscripciones/{adscripcion}/seguimientos', [\App\Http\Controllers\AdscripcionController::class, 'seguimientos'])
        ->name('adscripciones.seguimientos');
});

// ----------------- Jerarquias -----------------
//Administra Jerarquias (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () { //protege el grupo de la ruta

     // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('jerarquias', \App\Http\Controllers\JerarquiaController::class)
    ->except(['show', 'index']);
});

Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    // Ver Jerarquias (admin, carga y consulta)
    Route::resource('jerarquias', \App\Http\Controllers\JerarquiaController::class)
    ->only(['show', 'index']);
});

// ----------------- Departamentos -----------------
//Administra Departamentos (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () { //protege el grupo de la ruta

    // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('departamentos', \App\Http\Controllers\DepartamentoController::class)
    ->except(['show', 'index']);
});

// Ver Departamentos (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('departamentos', \App\Http\Controllers\DepartamentoController::class)
        ->only(['show', 'index']);
});

// ----------------- Carreras -----------------
//Administra Carreras (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () { //protege el grupo de la ruta

    // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('carreras', \App\Http\Controllers\CarreraController::class)
    ->except(['show', 'index']);
});

// Ver Carreras (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
Route::resource('carreras', \App\Http\Controllers\CarreraController::class)
    ->only(['show', 'index']);
});

// ----------------- Asignaturas -----------------
//Administra Asignaturas (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () { //protege el grupo de la ruta

    // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('asignaturas', \App\Http\Controllers\AsignaturaController::class)
    ->except(['show', 'index']);
});

// Ver Asignaturas (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
Route::resource('asignaturas', \App\Http\Controllers\AsignaturaController::class)
->only(['show', 'index']);
});

// ----------------- Docentes -----------------
//Administra Docentes (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () { //protege el grupo de la ruta
    // Ruta intermedia
    Route::get('/docentes/buscar', [DocenteController::class, 'mostrarBusqueda'])->name('docentes.buscar');

    // Ruta que procesa el DNI
    Route::post('/docentes/buscar', [DocenteController::class, 'buscarDni'])->name('docentes.buscarDni');
    
    // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('docentes', \App\Http\Controllers\DocenteController::class)
    ->except(['show', 'index']);
});
// Ver Docentes (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('docentes', \App\Http\Controllers\DocenteController::class)
    ->only(['show', 'index']);
});

// ----------------- Estudiantes -----------------
//Administra Estudiantes (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () { //protege el grupo de la ruta
    // Ruta intermedia
    Route::get('/estudiantes/buscar', [EstudianteController::class, 'mostrarBusqueda'])->name('estudiantes.buscar');

    // Ruta que procesa el DNI
    Route::post('/estudiantes/buscar', [EstudianteController::class, 'buscarDni'])->name('estudiantes.buscarDni');
    
    // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('estudiantes', \App\Http\Controllers\EstudianteController::class)
    ->except(['show', 'index']);
});
// Ver Estudiantes (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
Route::resource('estudiantes', \App\Http\Controllers\EstudianteController::class)
    ->only(['show', 'index']);
});

// ----------------- Veedores -----------------
//Administra Veedores (admin, carga)
Route::middleware(['auth', 'role:admin|carga'])->group(function () { //protege el grupo de la ruta
    // Ruta intermedia
    Route::get('/veedores/buscar', [VeedorController::class, 'mostrarBusqueda'])->name('veedores.buscar');

    // Ruta que procesa el DNI
    Route::post('/veedores/buscar', [VeedorController::class, 'buscarDni'])->name('veedores.buscarDni');
    
    // EXCEPCION (para que no se contrapongan los roles)
    Route::resource('veedores', \App\Http\Controllers\VeedorController::class)
    ->except(['show', 'index']);
});

// Ver Veedores (admin, carga y consulta)
Route::middleware(['auth', 'role:admin|carga|consulta'])->group(function () {
    Route::resource('veedores', \App\Http\Controllers\VeedorController::class)
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
