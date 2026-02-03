<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Venta;
use App\Models\Departamento;
use App\Models\Carrera;
use App\Models\Producto;
use App\Models\Reparto;
use App\Models\Vehiculo;
use App\Models\Vendedor;
use App\Models\SeguimientoCategoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::with([
            'cliente', 'carreras', 'asignaturas', 'departamentos',
            'designado', 'estados'
        ])->orderBy('id', 'desc')->get();

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create', [
            'clientes' => Cliente::all(),
            'asignaturas' => Venta::all(),
            'departamentos' => Departamento::all(),
            'carreras' => Carrera::all(),
            'productos' => Producto::all(),
            'docentes' => Reparto::all(),
            'estudiantes' => Vehiculo::all(),
            'veedores' => Vendedor::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required',
            'anio' => 'required|numeric',
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_concurso' => 'required',
            'modalidad_concurso' => 'required',
            'designado_id' => 'nullable|exists:productos,id',
        ]);

        $categoria = Categoria::create($request->only([
            'numero', 'anio', 'cliente_id', 'tipo_concurso', 'modalidad_concurso',
            'inicio_publicidad', 'cierre_publicidad', 'inicio_inscripcion', 'cierre_inscripcion',
            'fecha_concurso', 'expediente', 'observaciones', 'estado', 'comentario', 'designado_id'
        ]));

        $categoria->asignaturas()->sync($request->input('asignaturas', []));
        $categoria->departamentos()->sync($request->input('departamentos', []));
        $categoria->carreras()->sync($request->input('carreras', []));
        $categoria->veedores()->sync($request->input('veedores', []));
        $categoria->productos()->sync($request->input('productos', []));

        if ($request->has('docentes_titulares')) {
            foreach ($request->docentes_titulares as $id) {
                $categoria->docentes()->attach($id, ['tipo' => 'titular']);
            }
        }

        if ($request->has('docentes_suplentes')) {
            foreach ($request->docentes_suplentes as $id) {
                $categoria->docentes()->attach($id, ['tipo' => 'suplente']);
            }
        }

        if ($request->has('estudiantes_titulares')) {
            foreach ($request->estudiantes_titulares as $id) {
                $categoria->estudiantes()->attach($id, ['tipo' => 'titular']);
            }
        }

        if ($request->has('estudiantes_suplentes')) {
            foreach ($request->estudiantes_suplentes as $id) {
                $categoria->estudiantes()->attach($id, ['tipo' => 'suplente']);
            }
        }

        $detalle = "Categoría creada: N° {$categoria->numero}/{$categoria->anio}, Jerarquía: " . optional($categoria->cliente)->razon_social .
            ", Tipo: {$categoria->tipo_concurso}, Modalidad: {$categoria->modalidad_concurso}";

        SeguimientoCategoria::create([
            'categoria_id' => $categoria->id,
            'accion' => 'Categoría creada',
            'detalle' => Str::limit($detalle, 1000),
            'usuario' => Auth::check() ? Auth::user()->nombre_apellido : 'Sistema',
        ]);

        return redirect()->route('categorias.index')->with('mensaje', 'Categoría creada correctamente.');
    }

    public function show(Categoria $categoria)
    {
        $categoria->load([
            'cliente', 'asignaturas', 'departamentos',
            'carreras', 'productos', 'veedores',
            'docentesTitulares', 'docentesSuplentes',
            'estudiantesTitulares', 'estudiantesSuplentes',
            'estados', 'designado', 'seguimientos'
        ]);

        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        $categoria->load([
            'cliente', 'asignaturas', 'departamentos',
            'carreras', 'docentesTitulares', 'docentesSuplentes',
            'estudiantesTitulares', 'estudiantesSuplentes',
            'veedores', 'productos',
        ]);

        return view('categorias.edit', [
            'categoria' => $categoria,
            'clientes' => Cliente::all(),
            'asignaturas' => Venta::all(),
            'departamentos' => Departamento::all(),
            'carreras' => Carrera::all(),
            'docentes' => Reparto::all(),
            'estudiantes' => Vehiculo::all(),
            'veedores' => Vendedor::all(),
            'productos' => Producto::all(),
        ]);
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'numero' => 'required',
            'anio' => 'required|numeric',
            'cliente_id' => 'required|exists:clientes,id',
            'tipo_concurso' => 'required',
            'modalidad_concurso' => 'required',
            'designado_id' => 'nullable|exists:productos,id',
        ]);

        $original = clone $categoria;

        $categoria->update($request->only([
            'numero', 'anio', 'fecha_concurso', 'expediente',
            'cliente_id', 'tipo_concurso', 'modalidad_concurso',
            'inicio_publicidad', 'cierre_publicidad', 'inicio_inscripcion', 'cierre_inscripcion',
            'observaciones', 'estado', 'comentario', 'designado_id'
        ]));

        $detalle = 'Detalle de cambios: ';
        $cambios = [];
        $tiposDeCambio = [];

        $mapa = [
            'numero' => 'Número',
            'anio' => 'Año',
            'fecha_concurso' => 'Fecha',
            'expediente' => 'Expediente',
            'cliente_id' => 'Cliente',
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
        ];

        foreach ($mapa as $campo => $nombre) {
            $valorAnterior = $original->$campo;
            $valorNuevo = $categoria->$campo;

            if (in_array($campo, ['inicio_publicidad', 'cierre_publicidad', 'inicio_inscripcion', 'cierre_inscripcion', 'fecha_concurso'])) {
                $valorAnterior = $original->$campo ? Carbon::parse($original->$campo)->format('d/m/Y') : 'Sin fecha';
                $valorNuevo = $categoria->$campo ? Carbon::parse($categoria->$campo)->format('d/m/Y') : 'Sin fecha';
            }

            if ($campo === 'cliente_id') {
                $valorAnterior = optional($original->cliente)->razon_social;
                $valorNuevo = optional($categoria->cliente)->razon_social;
            }

            if ($campo === 'designado_id') {
                $valorAnterior = optional($original->designado)->nombre ?? 'Sin designar';
                $valorNuevo = optional($categoria->designado)->nombre ?? 'Sin designar';
            }

            if ($valorAnterior != $valorNuevo) {
                $cambios[] = "{$nombre}: {$valorAnterior} → {$valorNuevo}";
                $tiposDeCambio[] = $campo;
            }
        }

        $categoria->asignaturas()->sync($request->input('asignaturas', []));
        $categoria->departamentos()->sync($request->input('departamentos', []));
        $categoria->carreras()->sync($request->input('carreras', []));
        $categoria->veedores()->sync($request->input('veedores', []));
        $categoria->productos()->sync($request->input('productos', []));

        $categoria->docentes()->detach();
        foreach ($request->input('docentes_titulares', []) as $id) {
            $categoria->docentes()->attach($id, ['tipo' => 'titular']);
        }
        foreach ($request->input('docentes_suplentes', []) as $id) {
            $categoria->docentes()->attach($id, ['tipo' => 'suplente']);
        }

        $categoria->estudiantes()->detach();
        foreach ($request->input('estudiantes_titulares', []) as $id) {
            $categoria->estudiantes()->attach($id, ['tipo' => 'titular']);
        }
        foreach ($request->input('estudiantes_suplentes', []) as $id) {
            $categoria->estudiantes()->attach($id, ['tipo' => 'suplente']);
        }

        if (count($cambios)) {
            SeguimientoCategoria::create([
                'categoria_id' => $categoria->id,
                'accion' => 'Actualización',
                'detalle' => Str::limit($detalle . implode('; ', $cambios), 1000),
                'usuario' => Auth::check() ? Auth::user()->nombre_apellido : 'Sistema',
            ]);
        }

        return redirect()->route('categorias.index')->with('mensaje', 'Categoría actualizada correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();
        return redirect()->route('categorias.index')->with('mensaje', 'Categoría eliminada correctamente.');
    }

    public function seguimientos($id)
    {
        $categoria = Categoria::with(['seguimientos' => function ($query) {
            $query->orderByDesc('created_at')->orderByDesc('id');
        }])->findOrFail($id);

        return view('categorias.seguimientos', compact('categoria'));
    }
}
