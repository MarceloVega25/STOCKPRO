<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class VehiculoController extends Controller
{
    public function index()
    {
        $vehiculos = Vehiculo::all()->sortByDesc('id');
        return view('vehiculos.index', compact('vehiculos'));
    }

    public function create()
    {
        return view('vehiculos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_apellido' => 'required',
            'dni' => ['required', 'digits:8', 'regex:/^[0-9]{8}$/', 'unique:estudiantes,dni'],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'genero' => 'required',
            'email' => 'required|email|unique:estudiantes,email',
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

        $vehiculo = new Vehiculo();
        $vehiculo->nombre_apellido = $request->nombre_apellido;
        $vehiculo->dni = $request->dni;
        $vehiculo->fecha_nacimiento = $request->fecha_nacimiento;
        $vehiculo->genero = $request->genero;
        $vehiculo->email = $request->email;
        $vehiculo->telefono = $request->telefono;
        $vehiculo->institucion = $request->institucion;
        $vehiculo->tipo = $request->tipo;

        $vehiculo->cv = $request->file('cv')->store('cv_estudiantes', 'public');

        if ($request->hasFile('fotografia')) {
            $vehiculo->fotografia = $request->file('fotografia')->store('fotografias_estudiantes', 'public');
        }

        $vehiculo->save();

        return redirect()->route('vehiculos.index')->with('mensaje', 'Se registró el Vehículo correctamente');
    }

    public function show($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        return view('vehiculos.show', compact('vehiculo'));
    }

    public function edit($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        return view('vehiculos.edit', compact('vehiculo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_apellido' => 'required',
            'dni' => ['required', 'digits:8', 'regex:/^[0-9]{8}$/', 'unique:estudiantes,dni,' . $id],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'genero' => 'required',
            'email' => 'required|email|unique:estudiantes,email,' . $id,
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

        $vehiculo = Vehiculo::findOrFail($id);

        $vehiculo->nombre_apellido = $request->nombre_apellido;
        $vehiculo->dni = $request->dni;
        $vehiculo->fecha_nacimiento = $request->fecha_nacimiento;
        $vehiculo->genero = $request->genero;
        $vehiculo->email = $request->email;
        $vehiculo->telefono = $request->telefono;
        $vehiculo->institucion = $request->institucion;
        $vehiculo->tipo = $request->tipo;

        if ($request->hasFile('cv')) {
            $cvPath = storage_path('app/public/' . $vehiculo->cv);
            if ($vehiculo->cv && File::exists($cvPath)) {
                unlink($cvPath);
            }
            $vehiculo->cv = $request->file('cv')->store('cv_estudiantes', 'public');
        }

        if ($request->hasFile('fotografia')) {
            $fotoPath = storage_path('app/public/' . $vehiculo->fotografia);
            if ($vehiculo->fotografia && File::exists($fotoPath)) {
                unlink($fotoPath);
            }
            $vehiculo->fotografia = $request->file('fotografia')->store('fotografias_estudiantes', 'public');
        }

        $vehiculo->save();

        return redirect()->route('vehiculos.index')->with('mensaje', 'Datos actualizados correctamente');
    }

    public function destroy($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);

        $cvPath = storage_path('app/public/' . $vehiculo->cv);
        if ($vehiculo->cv && File::exists($cvPath)) {
            unlink($cvPath);
        }

        $fotoPath = storage_path('app/public/' . $vehiculo->fotografia);
        if ($vehiculo->fotografia && File::exists($fotoPath)) {
            unlink($fotoPath);
        }

        $vehiculo->delete();

        return redirect()->route('vehiculos.index')->with('mensaje', 'Se eliminó el Vehículo correctamente');
    }

    public function mostrarBusqueda()
    {
        return view('vehiculos.buscar_dni');
    }

    public function buscarDni(Request $request)
    {
        $request->validate([
            'dni' => ['required', 'digits:8'],
        ], [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos numéricos.',
        ]);

        $vehiculo = Vehiculo::where('dni', $request->dni)->first();

        if ($vehiculo) {
            return redirect()->route('vehiculos.buscar')->with([
                'mensaje' => 'existe',
                'docente_id' => $vehiculo->id
            ]);
        }

        return redirect()->route('vehiculos.buscar')->with([
            'mensaje' => 'nuevo',
            'dni' => $request->dni
        ]);
    }
}
