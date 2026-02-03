<?php

namespace App\Http\Controllers;

use App\Models\Reparto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RepartoController extends Controller
{
    public function index()
    {
        $repartos = Reparto::all()->sortByDesc('id');
        return view('repartos.index', compact('repartos'));
    }

    public function create()
    {
        return view('repartos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_apellido' => 'required',
            'dni' => ['required', 'digits:8', 'regex:/^[0-9]{8}$/', 'unique:docentes,dni'],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'genero' => 'required',
            'email' => 'required|email|unique:docentes,email',
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

        $reparto = new Reparto();
        $reparto->nombre_apellido = $request->nombre_apellido;
        $reparto->dni = $request->dni;
        $reparto->fecha_nacimiento = $request->fecha_nacimiento;
        $reparto->genero = $request->genero;
        $reparto->email = $request->email;
        $reparto->telefono = $request->telefono;
        $reparto->institucion = $request->institucion;
        $reparto->tipo = $request->tipo;

        $reparto->cv = $request->file('cv')->store('cv_docentes', 'public');

        if ($request->hasFile('fotografia')) {
            $reparto->fotografia = $request->file('fotografia')->store('fotografias_docentes', 'public');
        }

        $reparto->save();

        return redirect()->route('repartos.index')->with('mensaje', 'Se registró el Reparto correctamente');
    }

    public function show($id)
    {
        $reparto = Reparto::findOrFail($id);
        return view('repartos.show', compact('reparto'));
    }

    public function edit($id)
    {
        $reparto = Reparto::findOrFail($id);
        return view('repartos.edit', compact('reparto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_apellido' => 'required',
            'dni' => ['required', 'digits:8', 'regex:/^[0-9]{8}$/', 'unique:docentes,dni,' . $id],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'genero' => 'required',
            'email' => 'required|email|unique:docentes,email,' . $id,
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

        $reparto = Reparto::findOrFail($id);

        $reparto->nombre_apellido = $request->nombre_apellido;
        $reparto->dni = $request->dni;
        $reparto->fecha_nacimiento = $request->fecha_nacimiento;
        $reparto->genero = $request->genero;
        $reparto->email = $request->email;
        $reparto->telefono = $request->telefono;
        $reparto->institucion = $request->institucion;
        $reparto->tipo = $request->tipo;

        if ($request->hasFile('cv')) {
            $cvPath = storage_path('app/public/' . $reparto->cv);
            if ($reparto->cv && File::exists($cvPath)) {
                unlink($cvPath);
            }
            $reparto->cv = $request->file('cv')->store('cv_docentes', 'public');
        }

        if ($request->hasFile('fotografia')) {
            $fotoPath = storage_path('app/public/' . $reparto->fotografia);
            if ($reparto->fotografia && File::exists($fotoPath)) {
                unlink($fotoPath);
            }
            $reparto->fotografia = $request->file('fotografia')->store('fotografias_docentes', 'public');
        }

        $reparto->save();

        return redirect()->route('repartos.index')->with('mensaje', 'Datos actualizados correctamente');
    }

    public function destroy($id)
    {
        $reparto = Reparto::findOrFail($id);

        $cvPath = storage_path('app/public/' . $reparto->cv);
        if ($reparto->cv && File::exists($cvPath)) {
            unlink($cvPath);
        }

        $fotoPath = storage_path('app/public/' . $reparto->fotografia);
        if ($reparto->fotografia && File::exists($fotoPath)) {
            unlink($fotoPath);
        }

        $reparto->delete();

        return redirect()->route('repartos.index')->with('mensaje', 'Se eliminó el Reparto correctamente');
    }

    public function mostrarBusqueda()
    {
        return view('repartos.buscar_dni');
    }

    public function buscarDni(Request $request)
    {
        $request->validate([
            'dni' => ['required', 'digits:8'],
        ], [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos numéricos.',
        ]);

        $reparto = Reparto::where('dni', $request->dni)->first();

        if ($reparto) {
            return redirect()->route('repartos.buscar')->with([
                'mensaje' => 'existe',
                'docente_id' => $reparto->id
            ]);
        }

        return redirect()->route('repartos.buscar')->with([
            'mensaje' => 'nuevo',
            'dni' => $request->dni
        ]);
    }
}
