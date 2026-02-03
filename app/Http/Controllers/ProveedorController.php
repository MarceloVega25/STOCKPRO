<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all()->sortByDesc('id');
        return view('proveedores.index', ['proveedores' => $proveedores]);
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_apellido' => 'required',
            'dni' => ['required', 'digits:8', 'regex:/^[0-9]{8}$/', 'unique:proveedores,dni'],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'genero' => 'required',
            'email' => 'required|unique:proveedores,email',
            'telefono' => 'required',
            'direccion' => 'required',
            'localidad_ciudad' => 'required',
            'cv' => 'required|mimes:pdf,doc,docx|max:5120',
            'fotografia' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $proveedor = new Proveedor();
        $proveedor->nombre_apellido = $request->nombre_apellido;
        $proveedor->dni = $request->dni;
        $proveedor->fecha_nacimiento = $request->fecha_nacimiento;
        $proveedor->genero = $request->genero;
        $proveedor->email = $request->email;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->localidad_ciudad = $request->localidad_ciudad;

        $proveedor->cv = $request->file('cv')->store('cv_proveedores', 'public');

        if ($request->hasFile('fotografia')) {
            $proveedor->fotografia = $request->file('fotografia')->store('fotografias_proveedores', 'public');
        }

        $proveedor->save();

        return redirect()->route('proveedores.index')->with('mensaje', 'Se Registró al Proveedor Correctamente');
    }

    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.show', ['proveedor' => $proveedor]);
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.edit', ['proveedor' => $proveedor]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_apellido' => 'required',
            'dni' => ['required', 'digits:8', 'regex:/^[0-9]{8}$/', 'unique:proveedores,dni,' . $id],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'genero' => 'required',
            'email' => 'required|unique:proveedores,email,' . $id,
            'telefono' => 'required',
            'direccion' => 'required',
            'localidad_ciudad' => 'required',
            'cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'fotografia' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $proveedor = Proveedor::findOrFail($id);

        $proveedor->nombre_apellido = $request->nombre_apellido;
        $proveedor->dni = $request->dni;
        $proveedor->fecha_nacimiento = $request->fecha_nacimiento;
        $proveedor->genero = $request->genero;
        $proveedor->email = $request->email;
        $proveedor->telefono = $request->telefono;
        $proveedor->direccion = $request->direccion;
        $proveedor->localidad_ciudad = $request->localidad_ciudad;

        if ($request->hasFile('cv')) {
            $cvPath = storage_path('app/public/' . $proveedor->cv);
            if ($proveedor->cv && File::exists($cvPath)) {
                unlink($cvPath);
            }
            $proveedor->cv = $request->file('cv')->store('cv_proveedores', 'public');
        }

        if ($request->hasFile('fotografia')) {
            $fotoPath = storage_path('app/public/' . $proveedor->fotografia);
            if ($proveedor->fotografia && File::exists($fotoPath)) {
                unlink($fotoPath);
            }
            $proveedor->fotografia = $request->file('fotografia')->store('fotografias_proveedores', 'public');
        }

        $proveedor->save();

        return redirect()->route('proveedores.index')->with('mensaje', 'Datos actualizados correctamente');
    }

    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $cvPath = storage_path('app/public/' . $proveedor->cv);
        if ($proveedor->cv && File::exists($cvPath)) {
            unlink($cvPath);
        }

        $fotoPath = storage_path('app/public/' . $proveedor->fotografia);
        if ($proveedor->fotografia && File::exists($fotoPath)) {
            unlink($fotoPath);
        }

        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('mensaje', 'Se eliminó al Proveedor correctamente');
    }

    public function mostrarBusqueda()
    {
        return view('proveedores.buscar_dni');
    }

    public function buscarDni(Request $request)
    {
        $request->validate([
            'dni' => ['required', 'digits:8'],
        ], [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos numéricos.',
        ]);

        $proveedor = Proveedor::where('dni', $request->dni)->first();

        if ($proveedor) {
            return redirect()->route('proveedores.buscar')->with([
                'mensaje' => 'existe',
                'proveedor_id' => $proveedor->id
            ]);
        }

        return redirect()->route('proveedores.buscar')->with([
            'mensaje' => 'nuevo',
            'dni' => $request->dni
        ]);
    }
}
