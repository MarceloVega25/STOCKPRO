<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Usuario;
use App\Models\Inscripto;
use App\Models\Concurso;
use App\Models\Adscripto;
use App\Models\Adscripcion;
use App\Models\Jerarquia;
use App\Models\Asignatura;
use App\Models\Departamento;
use App\Models\Carrera;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Veedor;

use App\Observers\UsuarioObserver;
use App\Observers\InscriptoObserver;
use App\Observers\ConcursoObserver;
use App\Observers\AdscriptoObserver;
use App\Observers\AdscripcionObserver;
use App\Observers\JerarquiaObserver;
use App\Observers\AsignaturaObserver;
use App\Observers\DepartamentoObserver;
use App\Observers\CarreraObserver;
use App\Observers\DocenteObserver;
use App\Observers\EstudianteObserver;
use App\Observers\VeedorObserver;


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
    Inscripto::observe(InscriptoObserver::class);
    Concurso::observe(ConcursoObserver::class);
    Adscripto::observe(AdscriptoObserver::class);
    Adscripcion::observe(AdscripcionObserver::class);
    Jerarquia::observe(JerarquiaObserver::class);
    Asignatura::observe(AsignaturaObserver::class);
    Departamento::observe(DepartamentoObserver::class);
    Carrera::observe(CarreraObserver::class);
    Docente::observe(DocenteObserver::class);
    Estudiante::observe(EstudianteObserver::class);
    Veedor::observe(VeedorObserver::class);
}

}
