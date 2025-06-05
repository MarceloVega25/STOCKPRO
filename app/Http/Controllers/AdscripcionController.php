<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Adscripcion;
use App\Models\Jerarquia;
use App\Models\Asignatura;
use App\Models\Departamento;
use App\Models\Carrera;
use App\Models\Adscripto;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Veedor;
use App\Models\SeguimientoAdscripcion;


class AdscripcionController extends Controller
{
    public function index()
    {
        $adscripciones = Adscripcion::with([
            'jerarquia',
            'carreras',
            'asignaturas',
            'departamentos',
            'designado',
            'estados'
        ])->orderBy('id', 'desc')->get();

        return view('adscripciones.index', compact('adscripciones'));
    }

    public function create()
    {
        return view('adscripciones.create', [
            'jerarquias' => Jerarquia::all(),
            'asignaturas' => Asignatura::all(),
            'departamentos' => Departamento::all(),
            'carreras' => Carrera::all(),
            'adscriptos' => Adscripto::all(),
            'docentes' => Docente::all(),
            'estudiantes' => Estudiante::all(),
            'veedores' => Veedor::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required',
            'anio' => 'required|numeric',
            'jerarquia_id' => 'required|exists:jerarquias,id',
            'tipo_adscripcion' => 'required',
            'modalidad_adscripcion' => 'required',
            'designado_id' => 'nullable|exists:adscriptos,id',
        ]);

        $adscripcion = Adscripcion::create($request->only([
            'numero',
            'anio',
            'jerarquia_id',
            'tipo_adscripcion',
            'modalidad_adscripcion',
            'inicio_publicidad',
            'cierre_publicidad',
            'inicio_inscripcion',
            'cierre_inscripcion',
            'fecha_adscripcion',
            'expediente',
            'observaciones',
            'estado',
            'comentario',
            'designado_id'
        ]));
        $adscripcion->asignaturas()->sync($request->input('asignaturas', []));
        $adscripcion->departamentos()->sync($request->input('departamentos', []));
        $adscripcion->carreras()->sync($request->input('carreras', []));
        $adscripcion->veedores()->sync($request->input('veedores', []));
        $adscripcion->adscriptos()->sync($request->input('adscriptos', []));


        if ($request->has('docentes_titulares')) {
            foreach ($request->docentes_titulares as $id) {
                $adscripcion->docentes()->attach($id, ['tipo' => 'titular']);
            }
        }

        if ($request->has('docentes_suplentes')) {
            foreach ($request->docentes_suplentes as $id) {
                $adscripcion->docentes()->attach($id, ['tipo' => 'suplente']);
            }
        }

        if ($request->has('estudiantes_titulares')) {
            foreach ($request->estudiantes_titulares as $id) {
                $adscripcion->estudiantes()->attach($id, ['tipo' => 'titular']);
            }
        }

        if ($request->has('estudiantes_suplentes')) {
            foreach ($request->estudiantes_suplentes as $id) {
                $adscripcion->estudiantes()->attach($id, ['tipo' => 'suplente']);
            }
        }

        $detalle = "Adscripción creada: N° {$adscripcion->numero}/{$adscripcion->anio}, Jerarquía: " . optional($adscripcion->jerarquia)->nombre .
            ", Tipo: {$adscripcion->tipo_adscripcion}, Modalidad: {$adscripcion->modalidad_adscripcion}";

        SeguimientoAdscripcion::create([
            'adscripcion_id' => $adscripcion->id,
            'accion' => 'Adscripción creada',
            'detalle' => Str::limit($detalle, 1000),
            'usuario' => Auth::check() ? Auth::user()->nombre_apellido : 'Sistema',
        ]);

        return redirect()->route('adscripciones.index')->with('mensaje', 'Adscripción creada correctamente.');
    }

    public function show(Adscripcion $adscripcion)
    {
        $adscripcion->load([
            'jerarquia',
            'asignaturas',
            'departamentos',
            'carreras',
            'adscriptos',
            'veedores',
            'docentesTitulares',
            'docentesSuplentes',
            'estudiantesTitulares',
            'estudiantesSuplentes',
            'estados',
            'designado',
            'seguimientos'
        ]);

        return view('adscripciones.show', compact('adscripcion'));
    }

    public function edit(Adscripcion $adscripcion)
    {
        $adscripcion->load([
            'jerarquia',
            'asignaturas',
            'departamentos',
            'carreras',
            'docentesTitulares',
            'docentesSuplentes',
            'estudiantesTitulares',
            'estudiantesSuplentes',
            'veedores',
            'adscriptos',
        ]);

        return view('adscripciones.edit', [
            'adscripcion' => $adscripcion,
            'jerarquias' => Jerarquia::all(),
            'asignaturas' => Asignatura::all(),
            'departamentos' => Departamento::all(),
            'carreras' => Carrera::all(),
            'docentes' => Docente::all(),
            'estudiantes' => Estudiante::all(),
            'veedores' => Veedor::all(),
            'adscriptos' => Adscripto::all(),
        ]);
    }

    public function update(Request $request, Adscripcion $adscripcion)
    {
        $request->validate([
            'numero' => 'required',
            'anio' => 'required|numeric',
            'jerarquia_id' => 'required|exists:jerarquias,id',
            'tipo_adscripcion' => 'required',
            'modalidad_adscripcion' => 'required',
            'designado_id' => 'nullable|exists:adscriptos,id',
        ]);

        $original = clone $adscripcion;

        $adscripcion->update($request->only([
            'numero',
            'anio',
            'fecha_adscripcion',
            'expediente',
            'jerarquia_id',
            'tipo_adscripcion',
            'modalidad_adscripcion',
            'inicio_publicidad',
            'cierre_publicidad',
            'inicio_inscripcion',
            'cierre_inscripcion',
            'observaciones',
            'estado',
            'comentario',
            'designado_id'
        ]));

        $detalle = "Detalle de cambios: ";
        $cambios = [];
        $tiposDeCambio = [];

        $mapa = [
            //campos simples
            'numero' => 'Número',
            'anio' => 'Año',
            'fecha_adscripcion' => 'Fecha de adscripción',
            'expediente' => 'Expediente',
            'jerarquia_id' => 'Jerarquía',
            'tipo_adscripcion' => 'Tipo',
            'modalidad_adscripcion' => 'Modalidad',
            'inicio_publicidad' => 'Inicio de publicidad',
            'cierre_publicidad' => 'Cierre de publicidad',
            'inicio_inscripcion' => 'Inicio de inscripción',
            'cierre_inscripcion' => 'Cierre de inscripción',
            'observaciones' => 'Observaciones',
            'comentario' => 'Comentario',
            'estado' => 'Estado',
            'designado_id' => 'Designado',

            // Relaciones (carga múltiple)
            'asignaturas' => 'Asignaturas',
            'departamentos' => 'Departamentos',
            'carreras' => 'Carreras',
            'docentes_titulares' => 'Docentes Titulares',
            'docentes_suplentes' => 'Docentes Suplentes',
            'estudiantes_titulares' => 'Estudiantes Titulares',
            'estudiantes_suplentes' => 'Estudiantes Suplentes',
            'veedores' => 'Veedores',
            'adscriptos' => 'Adscriptos',
        ];


        foreach ($mapa as $campo => $nombre) {
            $valorAnterior = $original->$campo;
            $valorNuevo = $adscripcion->$campo;

            if ($campo === 'numero') {
                $valorAnterior = $original->numero ?: 'Sin número';
                $valorNuevo = $adscripcion->numero ?: 'Sin número';
            }

            if ($campo === 'anio') {
                $valorAnterior = $original->anio ?: 'Sin año';
                $valorNuevo = $adscripcion->anio ?: 'Sin año';
            }

            if ($campo === 'fecha_adscripcion') {
                $valorAnterior = $original->fecha_adscripcion ? Carbon::parse($original->fecha_adscripcion)->format('d/m/Y') : 'Sin fecha';
                $valorNuevo = $adscripcion->fecha_adscripcion ? Carbon::parse($adscripcion->fecha_adscripcion)->format('d/m/Y') : 'Sin fecha';
            }


            if ($campo === 'expediente') {
                $valorAnterior = $original->expediente ?? 'Sin expediente';
                $valorNuevo = $adscripcion->expediente ?? 'Sin expediente';
            }

            if ($campo === 'jerarquia_id') {
                $valorAnterior = optional($original->jerarquia)->nombre;
                $valorNuevo = optional($adscripcion->jerarquia)->nombre;
            }

            if ($campo === 'tipo_adscripcion') {
                $valorAnterior = $original->tipo_adscripcion ?: 'Sin tipo';
                $valorNuevo = $adscripcion->tipo_adscripcion ?: 'Sin tipo';
            }


            if ($campo === 'modalidad_adscripcion') {
                $valorAnterior = $original->modalidad_adscripcion ?: 'Sin modalidad';
                $valorNuevo = $adscripcion->modalidad_adscripcion ?: 'Sin modalidad';
            }

            if (in_array($campo, ['inicio_publicidad', 'cierre_publicidad', 'inicio_inscripcion', 'cierre_inscripcion'])) {
                $valorAnterior = $original->$campo ? Carbon::parse($original->$campo)->format('d/m/Y') : 'Sin fecha';
                $valorNuevo = $adscripcion->$campo ? Carbon::parse($adscripcion->$campo)->format('d/m/Y') : 'Sin fecha';
            }

            if ($campo === 'observaciones') {
                $valorAnterior = $original->observaciones ?: 'Sin observaciones';
                $valorNuevo = $adscripcion->observaciones ?: 'Sin observaciones';
            }

            if ($campo === 'comentario') {
                $valorAnterior = $original->comentario ?: 'Sin comentario';
                $valorNuevo = $adscripcion->comentario ?: 'Sin comentario';
            }

            if ($campo === 'asignaturas') {
                $valorAnterior = $original->asignaturas->pluck('nombre')->implode(', ') ?: 'Sin asignaturas';
                $valorNuevo = $adscripcion->asignaturas->pluck('nombre')->implode(', ') ?: 'Sin asignaturas';
            }

            if ($campo === 'departamentos') {
                $valorAnterior = $original->departamentos->pluck('nombre')->implode(', ') ?: 'Sin departamentos';
                $valorNuevo = $adscripcion->departamentos->pluck('nombre')->implode(', ') ?: 'Sin departamentos';
            }

            if ($campo === 'carreras') {
                $valorAnterior = $original->carreras->pluck('nombre')->implode(', ') ?: 'Sin carreras';
                $valorNuevo = $adscripcion->carreras->pluck('nombre')->implode(', ') ?: 'Sin carreras';
            }

            if ($campo === 'docentes_titulares') {
                $valorAnterior = $original->docentesTitulares->pluck('nombre_apellido')->implode(', ') ?: 'Sin docentes';
                $valorNuevo = $adscripcion->docentesTitulares->pluck('nombre_apellido')->implode(', ') ?: 'Sin docentes';
            }

            if ($campo === 'docentes_suplentes') {
                $valorAnterior = $original->docentesSuplentes->pluck('nombre_apellido')->implode(', ') ?: 'Sin docentes';
                $valorNuevo = $adscripcion->docentesSuplentes->pluck('nombre_apellido')->implode(', ') ?: 'Sin docentes';
            }

            if ($campo === 'estudiantes_titulares') {
                $valorAnterior = $original->estudiantesTitulares->pluck('nombre_apellido')->implode(', ') ?: 'Sin estudiantes';
                $valorNuevo = $adscripcion->estudiantesTitulares->pluck('nombre_apellido')->implode(', ') ?: 'Sin estudiantes';
            }

            if ($campo === 'estudiantes_suplentes') {
                $valorAnterior = $original->estudiantesSuplentes->pluck('nombre_apellido')->implode(', ') ?: 'Sin estudiantes';
                $valorNuevo = $adscripcion->estudiantesSuplentes->pluck('nombre_apellido')->implode(', ') ?: 'Sin estudiantes';
            }

            if ($campo === 'veedores') {
                $valorAnterior = $original->veedores->pluck('nombre_apellido')->implode(', ') ?: 'Sin veedores';
                $valorNuevo = $adscripcion->veedores->pluck('nombre_apellido')->implode(', ') ?: 'Sin veedores';
            }

            if ($campo === 'adscriptos') {
                $valorAnterior = $original->adscriptos->pluck('nombre_apellido')->implode(', ') ?: 'Sin inscriptos';
                $valorNuevo = $adscripcion->adscriptos->pluck('nombre_apellido')->implode(', ') ?: 'Sin inscriptos';
            }

            if ($campo === 'designado_id') {
                $valorAnterior = optional($original->designado)->nombre_apellido ?? 'Sin designar';
                $valorNuevo = optional($adscripcion->designado)->nombre_apellido ?? 'Sin designar';
            }

            if ($valorAnterior != $valorNuevo) {
                $cambios[] = "$nombre: $valorAnterior → $valorNuevo";
                $tiposDeCambio[] = $campo;
            }
        }

        // Definir relaciones a comparar y sus etiquetas
        $relaciones = [
            'asignaturas' => ['label' => 'Asignaturas', 'modelo' => Asignatura::class, 'campo' => 'nombre'],
            'carreras' => ['label' => 'Carreras', 'modelo' => Carrera::class, 'campo' => 'nombre'],
            'departamentos' => ['label' => 'Departamentos', 'modelo' => Departamento::class, 'campo' => 'nombre'],
            'adscriptos' => ['label' => 'Adscriptos', 'modelo' => Adscripto::class, 'campo' => 'nombre_apellido'],
            'veedores' => ['label' => 'Veedores', 'modelo' => Veedor::class, 'campo' => 'nombre_apellido'],

            // 👇 Agregados
            'docentes_titulares' => ['label' => 'Docentes Titulares', 'modelo' => Docente::class, 'campo' => 'nombre_apellido'],
            'docentes_suplentes' => ['label' => 'Docentes Suplentes', 'modelo' => Docente::class, 'campo' => 'nombre_apellido'],
            'estudiantes_titulares' => ['label' => 'Estudiantes Titulares', 'modelo' => Estudiante::class, 'campo' => 'nombre_apellido'],
            'estudiantes_suplentes' => ['label' => 'Estudiantes Suplentes', 'modelo' => Estudiante::class, 'campo' => 'nombre_apellido'],
        ];

        // Obtener valores anteriores para relaciones con pivot "tipo"
        $docentesTitularesIds = $original->docentes()->wherePivot('tipo', 'titular')->pluck('docente_id')->toArray();
        $docentesSuplentesIds = $original->docentes()->wherePivot('tipo', 'suplente')->pluck('docente_id')->toArray();
        $estudiantesTitularesIds = $original->estudiantes()->wherePivot('tipo', 'titular')->pluck('estudiante_id')->toArray();
        $estudiantesSuplentesIds = $original->estudiantes()->wherePivot('tipo', 'suplente')->pluck('estudiante_id')->toArray();

        // Cargar relaciones en el clon original
        $original->load([
            'asignaturas',
            'departamentos',
            'carreras',
            'veedores',
            'adscriptos'
        ]);

        // Comparar relaciones y registrar cambios
        foreach ($relaciones as $rel => $conf) {
            // Obtener IDs originales y nuevos según el tipo de relación
            if ($rel === 'docentes_titulares') {
                $originalIds = $docentesTitularesIds;
                $nuevosIds = $request->input('docentes_titulares', []);
            } elseif ($rel === 'docentes_suplentes') {
                $originalIds = $docentesSuplentesIds;
                $nuevosIds = $request->input('docentes_suplentes', []);
            } elseif ($rel === 'estudiantes_titulares') {
                $originalIds = $estudiantesTitularesIds;
                $nuevosIds = $request->input('estudiantes_titulares', []);
            } elseif ($rel === 'estudiantes_suplentes') {
                $originalIds = $estudiantesSuplentesIds;
                $nuevosIds = $request->input('estudiantes_suplentes', []);
            } else {
                $originalIds = $original->$rel()->pluck("{$conf['modelo']::getModel()->getTable()}.id")->toArray();
                $nuevosIds = $request->input($rel, []);
            }

            sort($originalIds);
            sort($nuevosIds);

            if ($originalIds != $nuevosIds) {
                $tiposDeCambio[] = $rel;

                $etiqueta = $conf['label'];

                // Mostrar mensaje si antes estaba vacío
                if (empty($originalIds)) {
                    $cambios[] = "{$etiqueta}: Sin " . strtolower($etiqueta);
                }

                // Mostrar mensaje si ahora quedó vacío
                if (empty($nuevosIds)) {
                    $cambios[] = "{$etiqueta}: Sin " . strtolower($etiqueta);
                }

                // Agregados
                $agregados = array_diff($nuevosIds, $originalIds);
                if (!empty($agregados)) {
                    $nombres = $conf['modelo']::whereIn('id', $agregados)->pluck($conf['campo'])->toArray();
                    $cambios[] = "{$etiqueta} agregados: " . implode(', ', $nombres);
                }

                // Eliminados
                $eliminados = array_diff($originalIds, $nuevosIds);
                if (!empty($eliminados)) {
                    $nombres = $conf['modelo']::whereIn('id', $eliminados)->pluck($conf['campo'])->toArray();
                    $cambios[] = "{$etiqueta} eliminados: " . implode(', ', $nombres);
                }
            }
        }


        // Actualiza relaciones

        $adscripcion->asignaturas()->sync($request->input('asignaturas', []));
        $adscripcion->departamentos()->sync($request->input('departamentos', []));
        $adscripcion->carreras()->sync($request->input('carreras', []));
        $adscripcion->veedores()->sync($request->input('veedores', []));
        $adscripcion->adscriptos()->sync($request->input('adscriptos', []));

        $adscripcion->docentes()->detach();
        foreach ($request->input('docentes_titulares', []) as $id) {
            $adscripcion->docentes()->attach($id, ['tipo' => 'titular']);
        }
        foreach ($request->input('docentes_suplentes', []) as $id) {
            $adscripcion->docentes()->attach($id, ['tipo' => 'suplente']);
        }

        $adscripcion->estudiantes()->detach();
        foreach ($request->input('estudiantes_titulares', []) as $id) {
            $adscripcion->estudiantes()->attach($id, ['tipo' => 'titular']);
        }
        foreach ($request->input('estudiantes_suplentes', []) as $id) {
            $adscripcion->estudiantes()->attach($id, ['tipo' => 'suplente']);
        }

        // Definir acción dinámica
        $accion = 'Actualización general de la adscripcion';

        if (in_array('numero', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifica número de la adscripcion';
        } elseif (in_array('anio', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifica año de la adscripcion';
        } elseif (in_array('fecha_adscripcion', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifica fecha de adscripcion';
        } elseif (in_array('expediente', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifica expediente';
        } elseif (in_array('jerarquia_id', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifica jerarquía de la adscripcion';
        } elseif (in_array('tipo_adscripcion', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifica tipo de la adscripcion';
        } elseif (in_array('modalidad_adscripcion', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifica modalidad de la adscripcion';
        } elseif (in_array('inicio_publicidad', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifica inicio de publicidad';
        } elseif (in_array('cierre_publicidad', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifica cierre de publicidad';
        } elseif (in_array('inicio_inscripcion', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifica inicio de inscripción';
        } elseif (in_array('cierre_inscripcion', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifica cierre de inscripción';
        } elseif (in_array('comentario', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifica comentario de la adscripcion';
        } elseif (in_array('observaciones', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifican observaciones de la adscripcion';
        } elseif (in_array('estado', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifica estado de la adscripcion';
        } elseif (in_array('asignaturas', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifican asignaturas';
        } elseif (in_array('departamentos', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifican departamentos';
        } elseif (in_array('carreras', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifican carreras';
        } elseif (in_array('docentes_titulares', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifican docentes titulares';
        } elseif (in_array('docentes_suplentes', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifican docentes suplentes';
        } elseif (in_array('estudiantes_titulares', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifican estudiantes titulares';
        } elseif (in_array('estudiantes_suplentes', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifican estudiantes suplentes';
        } elseif (in_array('veedores', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifican veedores';
        } elseif (in_array('adscriptos', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se modifican adscriptos';
        } elseif (in_array('designado_id', $tiposDeCambio) && count($tiposDeCambio) === 1) {
            $accion = 'Se asigna designado';
        }


        if (count($cambios)) {
            SeguimientoAdscripcion::create([
                'adscripcion_id' => $adscripcion->id,
                'accion' => $accion,
                'detalle' => Str::limit($detalle . implode('; ', $cambios), 1000),
                'usuario' => Auth::check() ? Auth::user()->nombre_apellido : 'Sistema',
            ]);
        }

        return redirect()->route('adscripciones.index')->with('mensaje', 'Adscripción actualizada correctamente.');
    }
    public function destroy(Adscripcion $adscripcion)
    {
        $adscripcion->delete();
        return redirect()->route('adscripciones.index')->with('mensaje', 'Adscripción eliminada correctamente.');
    }

    public function seguimientos($id)
{
    $adscripcion = Adscripcion::with(['seguimientos' => function ($query) {
        $query->orderBy('created_at', 'desc');
    }])->findOrFail($id);

    return view('adscripciones.seguimientos', compact('adscripcion'));
}

}
