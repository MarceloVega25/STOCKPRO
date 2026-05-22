<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Categoria;
use App\Models\SeguimientoCategoria;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withCount('productos')->orderBy('id', 'desc')->get();

        return view('categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $categoria = Categoria::create($request->only(['nombre', 'descripcion']));

        $detalle = "Categoría creada: {$categoria->nombre}";

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
        $categoria->load(['productos', 'seguimientos']);

        return view('categorias.show', compact('categoria'));
    }

    public function edit(Categoria $categoria)
    {
        return view('categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $original = clone $categoria;

        $categoria->update($request->only(['nombre', 'descripcion']));

        $cambios = [];
        if ($original->nombre !== $categoria->nombre) {
            $cambios[] = "Nombre: {$original->nombre} → {$categoria->nombre}";
        }
        if ($original->descripcion !== $categoria->descripcion) {
            $cambios[] = "Descripción actualizada";
        }
        if (count($cambios)) {
            SeguimientoCategoria::create([
                'categoria_id' => $categoria->id,
                'accion' => 'Actualización',
                'detalle' => Str::limit('Detalle de cambios: ' . implode('; ', $cambios), 1000),
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
