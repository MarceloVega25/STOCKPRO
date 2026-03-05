<?php

namespace App\Http\Controllers;

use App\Models\Vendedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VendedorController extends Controller
{
    public function index()
    {
        $vendedores = Vendedor::all()->sortByDesc('id');
        return view('vendedores.index', compact('vendedores'));
    }

    public function create()
    {
        return view('vendedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_apellido' => 'required',
            'dni' => ['required', 'digits:8', 'regex:/^[0-9]{8}$/', 'unique:vendedores,dni'],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'genero' => 'required',
            'email' => 'required|email|unique:vendedores,email',
            'telefono' => 'required',
            'institucion' => 'required',
            'cargo' => 'required',
            'cv' => 'required|mimes:pdf,doc,docx|max:5120',
            'fotografia' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'dni.unique' => 'El DNI ya está registrado.',
            'email.unique' => 'El Email ya está registrado.',
            'nombre_apellido.required' => 'El nombre y apellido es obligatorio.',
            'dni.required' => 'El campo DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos.',
            'dni.regex' => 'El DNI debe contener solo números positivos sin puntos ni comas.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.before_or_equal' => 'Debe tener al menos 18 años.',
            'genero.required' => 'El campo género es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'institucion.required' => 'La institución es obligatoria.',
            'cargo.required' => 'El cargo es obligatorio.',
            'cv.required' => 'Debe adjuntar el CV.',
            'cv.mimes' => 'El CV debe estar en formato PDF, DOC o DOCX.',
            'cv.max' => 'El tamaño máximo del CV es de 5MB.',
        ]);

        $vendedor = new Vendedor();
        $vendedor->nombre_apellido = $request->nombre_apellido;
        $vendedor->dni = $request->dni;
        $vendedor->fecha_nacimiento = $request->fecha_nacimiento;
        $vendedor->genero = $request->genero;
        $vendedor->email = $request->email;
        $vendedor->telefono = $request->telefono;
        $vendedor->institucion = $request->institucion;
        $vendedor->cargo = $request->cargo;

        $vendedor->cv = $request->file('cv')->store('cv_vendedores', 'public');

        if ($request->hasFile('fotografia')) {
            $vendedor->fotografia = $request->file('fotografia')->store('fotografias_vendedores', 'public');
        }

        $vendedor->save();

        return redirect()->route('vendedores.index')->with('mensaje', 'Se registró al Vendedor correctamente');
    }

    public function show($id)
    {
        $vendedor = Vendedor::findOrFail($id);
        return view('vendedores.show', compact('vendedor'));
    }

    public function edit($id)
    {
        $vendedor = Vendedor::findOrFail($id);
        return view('vendedores.edit', compact('vendedor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_apellido' => 'required',
            'dni' => ['required', 'digits:8', 'regex:/^[0-9]{8}$/', 'unique:vendedores,dni,' . $id],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'genero' => 'required',
            'email' => 'required|email|unique:vendedores,email,' . $id,
            'telefono' => 'required',
            'institucion' => 'required',
            'cargo' => 'required',
            'cv' => 'nullable|mimes:pdf,doc,docx|max:5120',
            'fotografia' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'dni.unique' => 'El DNI ya está registrado.',
            'email.unique' => 'El Email ya está registrado.',
            'nombre_apellido.required' => 'El nombre y apellido es obligatorio.',
            'dni.required' => 'El campo DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos.',
            'dni.regex' => 'El DNI debe contener solo números positivos sin puntos ni comas.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.before_or_equal' => 'Debe tener al menos 18 años.',
            'genero.required' => 'El campo género es obligatorio.',
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'institucion.required' => 'La institución es obligatoria.',
            'cargo.required' => 'El cargo es obligatorio.',
            'cv.required' => 'Debe adjuntar el CV.',
            'cv.mimes' => 'El CV debe estar en formato PDF, DOC o DOCX.',
            'cv.max' => 'El tamaño máximo del CV es de 5MB.',
        ]);

        $vendedor = Vendedor::findOrFail($id);

        $vendedor->nombre_apellido = $request->nombre_apellido;
        $vendedor->dni = $request->dni;
        $vendedor->fecha_nacimiento = $request->fecha_nacimiento;
        $vendedor->genero = $request->genero;
        $vendedor->email = $request->email;
        $vendedor->telefono = $request->telefono;
        $vendedor->institucion = $request->institucion;
        $vendedor->cargo = $request->cargo;

        if ($request->hasFile('cv')) {
            $cvPath = storage_path('app/public/' . $vendedor->cv);
            if ($vendedor->cv && File::exists($cvPath)) {
                unlink($cvPath);
            }
            $vendedor->cv = $request->file('cv')->store('cv_vendedores', 'public');
        }

        if ($request->hasFile('fotografia')) {
            $fotoPath = storage_path('app/public/' . $vendedor->fotografia);
            if ($vendedor->fotografia && File::exists($fotoPath)) {
                unlink($fotoPath);
            }
            $vendedor->fotografia = $request->file('fotografia')->store('fotografias_vendedores', 'public');
        }

        $vendedor->save();

        return redirect()->route('vendedores.index')->with('mensaje', 'Datos actualizados correctamente');
    }

    public function destroy($id)
    {
        $vendedor = Vendedor::findOrFail($id);

        $cvPath = storage_path('app/public/' . $vendedor->cv);
        if ($vendedor->cv && File::exists($cvPath)) {
            unlink($cvPath);
        }

        $fotoPath = storage_path('app/public/' . $vendedor->fotografia);
        if ($vendedor->fotografia && File::exists($fotoPath)) {
            unlink($fotoPath);
        }

        $vendedor->delete();

        return redirect()->route('vendedores.index')->with('mensaje', 'Se eliminó al Vendedor correctamente');
    }

    public function mostrarBusqueda()
    {
        return view('vendedores.buscar_dni');
    }

    public function buscarDni(Request $request)
    {
        $request->validate([
            'dni' => ['required', 'digits:8'],
        ], [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos numéricos.',
        ]);

        $vendedor = Vendedor::where('dni', $request->dni)->first();

        if ($vendedor) {
            return redirect()->route('vendedores.buscar')->with([
                'mensaje' => 'existe',
                'vendedor_id' => $vendedor->id
            ]);
        }

        return redirect()->route('vendedores.buscar')->with([
            'mensaje' => 'nuevo',
            'dni' => $request->dni
        ]);
    }
}
