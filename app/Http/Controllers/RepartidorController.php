<?php

namespace App\Http\Controllers;

use App\Models\Repartidor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RepartidorController extends Controller
{
    public function index()
    {
        $repartidores = Repartidor::all()->sortByDesc('id');
        return view('repartidores.index', compact('repartidores'));
    }

    public function create()
    {
        return view('repartidores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_apellido' => 'required',
            'dni' => ['required', 'digits:8', 'regex:/^[0-9]{8}$/', 'unique:repartidores,dni'],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'genero' => 'required',
            'email' => 'required|email|unique:repartidores,email',
            'telefono' => 'required',
            'institucion' => 'required',
            'tipo' => 'required',
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
            'tipo.required' => 'El tipo es obligatorio.',
            'cv.required' => 'Debe adjuntar el CV.',
            'cv.mimes' => 'El CV debe estar en formato PDF, DOC o DOCX.',
            'cv.max' => 'El tamaño máximo del CV es de 5MB.',
        ]);

        $repartidor = new Repartidor();
        $repartidor->nombre_apellido = $request->nombre_apellido;
        $repartidor->dni = $request->dni;
        $repartidor->fecha_nacimiento = $request->fecha_nacimiento;
        $repartidor->genero = $request->genero;
        $repartidor->email = $request->email;
        $repartidor->telefono = $request->telefono;
        $repartidor->institucion = $request->institucion;
        $repartidor->tipo = $request->tipo;

        $repartidor->cv = $request->file('cv')->store('cv_repartidores', 'public');

        if ($request->hasFile('fotografia')) {
            $repartidor->fotografia = $request->file('fotografia')->store('fotografias_repartidores', 'public');
        }

        $repartidor->save();

        return redirect()->route('repartidores.index')->with('mensaje', 'Se registró el Repartidor correctamente');
    }

    public function show($id)
    {
        $repartidor = Repartidor::findOrFail($id);
        return view('repartidores.show', compact('repartidor'));
    }

    public function edit($id)
    {
        $repartidor = Repartidor::findOrFail($id);
        return view('repartidores.edit', compact('repartidor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_apellido' => 'required',
            'dni' => ['required', 'digits:8', 'regex:/^[0-9]{8}$/', 'unique:repartidores,dni,' . $id],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'genero' => 'required',
            'email' => 'required|email|unique:repartidores,email,' . $id,
            'telefono' => 'required',
            'institucion' => 'required',
            'tipo' => 'required',
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
            'tipo.required' => 'El tipo es obligatorio.',
            'cv.required' => 'Debe adjuntar el CV.',
            'cv.mimes' => 'El CV debe estar en formato PDF, DOC o DOCX.',
            'cv.max' => 'El tamaño máximo del CV es de 5MB.',
        ]);

        $repartidor = Repartidor::findOrFail($id);

        $repartidor->nombre_apellido = $request->nombre_apellido;
        $repartidor->dni = $request->dni;
        $repartidor->fecha_nacimiento = $request->fecha_nacimiento;
        $repartidor->genero = $request->genero;
        $repartidor->email = $request->email;
        $repartidor->telefono = $request->telefono;
        $repartidor->institucion = $request->institucion;
        $repartidor->tipo = $request->tipo;

        if ($request->hasFile('cv')) {
            $cvPath = storage_path('app/public/' . $repartidor->cv);
            if ($repartidor->cv && File::exists($cvPath)) {
                unlink($cvPath);
            }
            $repartidor->cv = $request->file('cv')->store('cv_repartidores', 'public');
        }

        if ($request->hasFile('fotografia')) {
            $fotoPath = storage_path('app/public/' . $repartidor->fotografia);
            if ($repartidor->fotografia && File::exists($fotoPath)) {
                unlink($fotoPath);
            }
            $repartidor->fotografia = $request->file('fotografia')->store('fotografias_repartidores', 'public');
        }

        $repartidor->save();

        return redirect()->route('repartidores.index')->with('mensaje', 'Datos actualizados correctamente');
    }

    public function destroy($id)
    {
        $repartidor = Repartidor::findOrFail($id);

        $cvPath = storage_path('app/public/' . $repartidor->cv);
        if ($repartidor->cv && File::exists($cvPath)) {
            unlink($cvPath);
        }

        $fotoPath = storage_path('app/public/' . $repartidor->fotografia);
        if ($repartidor->fotografia && File::exists($fotoPath)) {
            unlink($fotoPath);
        }

        $repartidor->delete();

        return redirect()->route('repartidores.index')->with('mensaje', 'Se eliminó el Repartidor correctamente');
    }

    public function mostrarBusqueda()
    {
        return view('repartidores.buscar_dni');
    }

    public function buscarDni(Request $request)
    {
        $request->validate([
            'dni' => ['required', 'digits:8'],
        ], [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos numéricos.',
        ]);

        $repartidor = Repartidor::where('dni', $request->dni)->first();

        if ($repartidor) {
            return redirect()->route('repartidores.buscar')->with([
                'mensaje' => 'existe',
                'repartidor_id' => $repartidor->id
            ]);
        }

        return redirect()->route('repartidores.buscar')->with([
            'mensaje' => 'nuevo',
            'dni' => $request->dni
        ]);
    }
}
