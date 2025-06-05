<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Concurso;
use App\Models\Jerarquia;
use App\Models\Asignatura;
use App\Models\Departamento;
use App\Models\Carrera;
use App\Models\Inscripto;
use App\Models\Docente;
use App\Models\Estudiante;
use App\Models\Veedor;
use App\Models\SeguimientoConcurso;


class ConcursoController extends Controller
{
    public function index()
    {
        $concursos = Concurso::with([
            'jerarquia', 'carreras', 'asignaturas', 'departamentos',
            'designado', 'estados'
        ])->orderBy('id', 'desc')->get();

        return view('concursos.index', compact('concursos'));
    }

    public function create()
    {
        return view('concursos.create', [
            'jerarquias' => Jerarquia::all(),
            'asignaturas' => Asignatura::all(),
            'departamentos' => Departamento::all(),
            'carreras' => Carrera::all(),
            'inscriptos' => Inscripto::all(),
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
            'tipo_concurso' => 'required',
            'modalidad_concurso' => 'required',
            'designado_id' => 'nullable|exists:inscriptos,id',
        ]);

        $concurso = Concurso::create($request->only([
            'numero', 'anio', 'jerarquia_id', 'tipo_concurso', 'modalidad_concurso',
            'inicio_publicidad', 'cierre_publicidad', 'inicio_inscripcion', 'cierre_inscripcion',
            'fecha_concurso', 'expediente', 'observaciones', 'estado', 'comentario', 'designado_id'
        ]));
        $concurso->asignaturas()->sync($request->input('asignaturas', []));
        $concurso->departamentos()->sync($request->input('departamentos', []));
        $concurso->carreras()->sync($request->input('carreras', []));
        $concurso->veedores()->sync($request->input('veedores', []));
        $concurso->inscriptos()->sync($request->input('inscriptos', []));
        

        if ($request->has('docentes_titulares')) {
            foreach ($request->docentes_titulares as $id) {
                $concurso->docentes()->attach($id, ['tipo' => 'titular']);
            }
        }

        if ($request->has('docentes_suplentes')) {
            foreach ($request->docentes_suplentes as $id) {
                $concurso->docentes()->attach($id, ['tipo' => 'suplente']);
            }
        }

        if ($request->has('estudiantes_titulares')) {
            foreach ($request->estudiantes_titulares as $id) {
                $concurso->estudiantes()->attach($id, ['tipo' => 'titular']);
            }
        }

        if ($request->has('estudiantes_suplentes')) {
            foreach ($request->estudiantes_suplentes as $id) {
                $concurso->estudiantes()->attach($id, ['tipo' => 'suplente']);
            }
        }

        $detalle = "Concurso creado: N° {$concurso->numero}/{$concurso->anio}, Jerarquía: " . optional($concurso->jerarquia)->nombre .
            ", Tipo: {$concurso->tipo_concurso}, Modalidad: {$concurso->modalidad_concurso}";

        SeguimientoConcurso::create([
            'concurso_id' => $concurso->id,
            'accion' => 'Concurso creado',
            'detalle' => Str::limit($detalle, 1000),
            'usuario' => Auth::check() ? Auth::user()->nombre_apellido : 'Sistema',
        ]);

        return redirect()->route('concursos.index')->with('mensaje', 'Concurso creado correctamente.');
    }

    public function show(Concurso $concurso)
    {
        $concurso->load([
            'jerarquia', 'asignaturas', 'departamentos',
            'carreras', 'inscriptos', 'veedores',
            'docentesTitulares', 'docentesSuplentes',
            'estudiantesTitulares', 'estudiantesSuplentes',
            'estados', 'designado', 'seguimientos'
        ]);

        return view('concursos.show', compact('concurso'));
    }

    public function edit(Concurso $concurso)
    {
        $concurso->load([
            'jerarquia', 'asignaturas', 'departamentos',
            'carreras', 'docentesTitulares', 'docentesSuplentes',
            'estudiantesTitulares', 'estudiantesSuplentes',
            'veedores','inscriptos', 
        ]);

        return view('concursos.edit', [
            'concurso' => $concurso,
            'jerarquias' => Jerarquia::all(),
            'asignaturas' => Asignatura::all(),
            'departamentos' => Departamento::all(),
            'carreras' => Carrera::all(),
            'docentes' => Docente::all(),
            'estudiantes' => Estudiante::all(),
            'veedores' => Veedor::all(),
            'inscriptos' => Inscripto::all(),
        ]);
    }

    public function update(Request $request, Concurso $concurso)
{
    $request->validate([
        'numero' => 'required',
        'anio' => 'required|numeric',
        'jerarquia_id' => 'required|exists:jerarquias,id',
        'tipo_concurso' => 'required',
        'modalidad_concurso' => 'required',
        'designado_id' => 'nullable|exists:inscriptos,id',
    ]);

    $original = clone $concurso;

    $concurso->update($request->only([
        'numero', 'anio','fecha_concurso', 'expediente',
        'jerarquia_id', 'tipo_concurso', 'modalidad_concurso',
        'inicio_publicidad', 'cierre_publicidad', 'inicio_inscripcion', 'cierre_inscripcion',
         'observaciones', 
         'estado', 'comentario', 'designado_id'
    ]));

    $detalle = "Detalle de cambios: ";
    $cambios = [];
    $tiposDeCambio = [];

    $mapa = [
    // Campos simples
    'numero' => 'Número',
    'anio' => 'Año',
    'fecha_concurso' => 'Fecha del concurso',
    'expediente' => 'Expediente',
    'jerarquia_id' => 'Jerarquía',
    'tipo_concurso' => 'Tipo',
    'modalidad_concurso' => 'Modalidad',
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
    'inscriptos' => 'Inscriptos',
];


    foreach ($mapa as $campo => $nombre) {
        $valorAnterior = $original->$campo;
        $valorNuevo = $concurso->$campo;

        if ($campo === 'numero') {
            $valorAnterior = $original->numero ?: 'Sin número';
            $valorNuevo = $concurso->numero ?: 'Sin número';
        }

        if ($campo === 'anio') {
            $valorAnterior = $original->anio ?: 'Sin año';
            $valorNuevo = $concurso->anio ?: 'Sin año';
        }

        if ($campo === 'fecha_concurso') {
            $valorAnterior = $original->fecha_concurso ? Carbon::parse($original->fecha_concurso)->format('d/m/Y') : 'Sin fecha';
            $valorNuevo = $concurso->fecha_concurso ? Carbon::parse($concurso->fecha_concurso)->format('d/m/Y') : 'Sin fecha';
        }

        if ($campo === 'expediente') {
            $valorAnterior = $original->expediente ?? 'Sin expediente';
            $valorNuevo = $concurso->expediente ?? 'Sin expediente';
        }

        if ($campo === 'jerarquia_id') {
            $valorAnterior = optional($original->jerarquia)->nombre;
            $valorNuevo = optional($concurso->jerarquia)->nombre;
        }

        if ($campo === 'tipo_concurso') {
            $valorAnterior = $original->tipo_concurso ?: 'Sin tipo';
            $valorNuevo = $concurso->tipo_concurso ?: 'Sin tipo';
        }

        if ($campo === 'modalidad_concurso') {
            $valorAnterior = $original->modalidad_concurso ?: 'Sin modalidad';
            $valorNuevo = $concurso->modalidad_concurso ?: 'Sin modalidad';
        }

        if (in_array($campo, ['inicio_publicidad', 'cierre_publicidad', 'inicio_inscripcion', 'cierre_inscripcion'])) {
            $valorAnterior = $original->$campo ? Carbon::parse($original->$campo)->format('d/m/Y') : 'Sin fecha';
            $valorNuevo = $concurso->$campo ? Carbon::parse($concurso->$campo)->format('d/m/Y') : 'Sin fecha';
        }

        if ($campo === 'observaciones') {
            $valorAnterior = $original->observaciones ?: 'Sin observaciones';
            $valorNuevo = $concurso->observaciones ?: 'Sin observaciones';
        }

        if ($campo === 'comentario') {
            $valorAnterior = $original->comentario ?: 'Sin comentario';
            $valorNuevo = $concurso->comentario ?: 'Sin comentario';
        }

        if ($campo === 'asignaturas') {
            $valorAnterior = $original->asignaturas->pluck('nombre')->implode(', ') ?: 'Sin asignaturas';
            $valorNuevo = $concurso->asignaturas->pluck('nombre')->implode(', ') ?: 'Sin asignaturas';
        }

        if ($campo === 'departamentos') {
            $valorAnterior = $original->departamentos->pluck('nombre')->implode(', ') ?: 'Sin departamentos';
            $valorNuevo = $concurso->departamentos->pluck('nombre')->implode(', ') ?: 'Sin departamentos';
        }

        if ($campo === 'carreras') {
            $valorAnterior = $original->carreras->pluck('nombre')->implode(', ') ?: 'Sin carreras';
            $valorNuevo = $concurso->carreras->pluck('nombre')->implode(', ') ?: 'Sin carreras';
        }

        if ($campo === 'docentes_titulares') {
            $valorAnterior = $original->docentesTitulares->pluck('nombre_apellido')->implode(', ') ?: 'Sin docentes';
            $valorNuevo = $concurso->docentesTitulares->pluck('nombre_apellido')->implode(', ') ?: 'Sin docentes';
        }

        if ($campo === 'docentes_suplentes') {
            $valorAnterior = $original->docentesSuplentes->pluck('nombre_apellido')->implode(', ') ?: 'Sin docentes';
            $valorNuevo = $concurso->docentesSuplentes->pluck('nombre_apellido')->implode(', ') ?: 'Sin docentes';
        }

        if ($campo === 'estudiantes_titulares') {
            $valorAnterior = $original->estudiantesTitulares->pluck('nombre_apellido')->implode(', ') ?: 'Sin estudiantes';
            $valorNuevo = $concurso->estudiantesTitulares->pluck('nombre_apellido')->implode(', ') ?: 'Sin estudiantes';
        }

        if ($campo === 'estudiantes_suplentes') {
            $valorAnterior = $original->estudiantesSuplentes->pluck('nombre_apellido')->implode(', ') ?: 'Sin estudiantes';
            $valorNuevo = $concurso->estudiantesSuplentes->pluck('nombre_apellido')->implode(', ') ?: 'Sin estudiantes';
        }

        if ($campo === 'veedores') {
            $valorAnterior = $original->veedores->pluck('nombre_apellido')->implode(', ') ?: 'Sin veedores';
            $valorNuevo = $concurso->veedores->pluck('nombre_apellido')->implode(', ') ?: 'Sin veedores';
        }

        if ($campo === 'inscriptos') {
            $valorAnterior = $original->inscriptos->pluck('nombre_apellido')->implode(', ') ?: 'Sin inscriptos';
            $valorNuevo = $concurso->inscriptos->pluck('nombre_apellido')->implode(', ') ?: 'Sin inscriptos';
        }

        if ($campo === 'designado_id') {
            $valorAnterior = optional($original->designado)->nombre_apellido ?? 'Sin designar';
            $valorNuevo = optional($concurso->designado)->nombre_apellido ?? 'Sin designar';
        }        

        if ($valorAnterior != $valorNuevo) {
            $cambios[] = "{$nombre}: {$valorAnterior} → {$valorNuevo}";
            $tiposDeCambio[] = $campo;
        }
    }

    // Definir relaciones a comparar y sus etiquetas
$relaciones = [
    'asignaturas' => ['label' => 'Asignaturas', 'modelo' => Asignatura::class, 'campo' => 'nombre'],
    'carreras' => ['label' => 'Carreras', 'modelo' => Carrera::class, 'campo' => 'nombre'],
    'departamentos' => ['label' => 'Departamentos', 'modelo' => Departamento::class, 'campo' => 'nombre'],
    'inscriptos' => ['label' => 'Inscriptos', 'modelo' => Inscripto::class, 'campo' => 'nombre_apellido'],
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
    'inscriptos'
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
    
    $concurso->asignaturas()->sync($request->input('asignaturas', []));
    $concurso->departamentos()->sync($request->input('departamentos', []));
    $concurso->carreras()->sync($request->input('carreras', []));
    $concurso->veedores()->sync($request->input('veedores', []));
    $concurso->inscriptos()->sync($request->input('inscriptos', []));

    $concurso->docentes()->detach();
    foreach ($request->input('docentes_titulares', []) as $id) {
        $concurso->docentes()->attach($id, ['tipo' => 'titular']);
    }
    foreach ($request->input('docentes_suplentes', []) as $id) {
        $concurso->docentes()->attach($id, ['tipo' => 'suplente']);
    }

    $concurso->estudiantes()->detach();
    foreach ($request->input('estudiantes_titulares', []) as $id) {
        $concurso->estudiantes()->attach($id, ['tipo' => 'titular']);
    }
    foreach ($request->input('estudiantes_suplentes', []) as $id) {
        $concurso->estudiantes()->attach($id, ['tipo' => 'suplente']);
    }

    // Definir acción dinámica
    $accion = 'Actualización general del concurso';

    if (in_array('numero', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifica número del concurso';
    }
    elseif (in_array('anio', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifica año del concurso';
    }
    elseif (in_array('fecha_concurso', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifica fecha de concurso';
    }
    elseif (in_array('expediente', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifica expediente';
    }
    elseif (in_array('jerarquia_id', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifica jerarquía del concurso';
    }
    elseif (in_array('tipo_concurso', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifica tipo de concurso';
    }
    elseif (in_array('modalidad_concurso', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifica modalidad del concurso';
    }
    elseif (in_array('inicio_publicidad', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifica inicio de publicidad';
    }
    elseif (in_array('cierre_publicidad', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifica cierre de publicidad';
    }
    elseif (in_array('inicio_inscripcion', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifica inicio de inscripción';
    }
    elseif (in_array('cierre_inscripcion', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifica cierre de inscripción';
    }
    elseif (in_array('comentario', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifica comentario del concurso';
    }
    elseif (in_array('observaciones', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifican observaciones del concurso';
    }
    elseif (in_array('estado', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifica estado del concurso';
    }
    elseif (in_array('asignaturas', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifican asignaturas';
    }
    elseif (in_array('departamentos', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifican departamentos';
    }
    elseif (in_array('carreras', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifican carreras';
    }
    elseif (in_array('docentes_titulares', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifican docentes titulares';
    }
    elseif (in_array('docentes_suplentes', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifican docentes suplentes';
    }
    elseif (in_array('estudiantes_titulares', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifican estudiantes titulares';
    }
    elseif (in_array('estudiantes_suplentes', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifican estudiantes suplentes';
    }
    elseif (in_array('veedores', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifican veedores';
    }
    elseif (in_array('inscriptos', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se modifican inscriptos';
    } 
    elseif (in_array('designado_id', $tiposDeCambio) && count($tiposDeCambio) === 1) {
        $accion = 'Se asigna designado';
    }   
    

    if (count($cambios)) {
        SeguimientoConcurso::create([
            'concurso_id' => $concurso->id,
            'accion' => $accion,
            'detalle' => Str::limit($detalle . implode('; ', $cambios), 1000),
            'usuario' => Auth::check() ? Auth::user()->nombre_apellido : 'Sistema',
        ]);
    }

    return redirect()->route('concursos.index')->with('mensaje', 'Concurso actualizado correctamente.');


}
    public function destroy(Concurso $concurso)
    {
        $concurso->delete();
        return redirect()->route('concursos.index')->with('mensaje', 'Concurso eliminado correctamente.');
    }

    public function seguimientos($id)
{
    $concurso = Concurso::with(['seguimientos' => function ($query) {
        $query->orderByDesc('created_at')->orderByDesc('id');
    }])->findOrFail($id);

    return view('concursos.seguimientos', compact('concurso'));
}

}

