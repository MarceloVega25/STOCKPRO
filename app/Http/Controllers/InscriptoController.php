<?php

namespace App\Http\Controllers;

use App\Models\Inscripto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class InscriptoController extends Controller
{
    public function index()
    {
        $inscriptos = Inscripto::all()->sortByDesc('id');
        return view('productos.index', ['inscriptos' => $inscriptos]);
    }

    public function create()
    {
        return view('productos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_apellido' => 'required',
            'dni' => ['required', 'digits:8', 'regex:/^[0-9]{8}$/', 'unique:inscriptos,dni'],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'genero' => 'required',
            'email' => 'required|email|unique:inscriptos,email',
            'telefono' => 'required',
            'direccion' => 'required',
            'localidad_ciudad' => 'required',
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
            'direccion.required' => 'La dirección es obligatoria.',
            'localidad_ciudad.required' => 'La localidad o ciudad es obligatoria.',
            'cv.required' => 'Debe adjuntar el CV.',
            'cv.mimes' => 'El CV debe estar en formato PDF, DOC o DOCX.',
            'cv.max' => 'El tamaño máximo del CV es de 5MB.',
        ]);

        $inscripto = new Inscripto();
        $inscripto->nombre_apellido = $request->nombre_apellido;
        $inscripto->dni = $request->dni;
        $inscripto->fecha_nacimiento = $request->fecha_nacimiento;
        $inscripto->genero = $request->genero;
        $inscripto->email = $request->email;
        $inscripto->telefono = $request->telefono;
        $inscripto->direccion = $request->direccion;
        $inscripto->localidad_ciudad = $request->localidad_ciudad;

        $inscripto->cv = $request->file('cv')->store('cv_inscriptos', 'public');

        if ($request->hasFile('fotografia')) {
            $inscripto->fotografia = $request->file('fotografia')->store('fotografias_inscriptos', 'public');
        }

        $inscripto->save();

        return redirect()->route('inscriptos.index')->with('mensaje', 'Se registró al Inscripto correctamente');
    }

    public function show($id)
    {
        $inscripto = Inscripto::findOrFail($id);
        return view('productos.show', ['inscripto' => $inscripto]);
    }

    public function edit($id)
    {
        $inscripto = Inscripto::findOrFail($id);
        return view('productos.edit', ['inscripto' => $inscripto]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_apellido' => 'required',
            'dni' => ['required', 'digits:8', 'regex:/^[0-9]{8}$/', 'unique:inscriptos,dni,' . $id],
            'fecha_nacimiento' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'genero' => 'required',
            'email' => 'required|email|unique:inscriptos,email,' . $id,
            'telefono' => 'required',
            'direccion' => 'required',
            'localidad_ciudad' => 'required',
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
            'direccion.required' => 'La dirección es obligatoria.',
            'localidad_ciudad.required' => 'La localidad o ciudad es obligatoria.',
            'cv.mimes' => 'El CV debe estar en formato PDF, DOC o DOCX.',
            'cv.max' => 'El tamaño máximo del CV es de 5MB.',
        ]);

        $inscripto = Inscripto::findOrFail($id);

        $inscripto->nombre_apellido = $request->nombre_apellido;
        $inscripto->dni = $request->dni;
        $inscripto->fecha_nacimiento = $request->fecha_nacimiento;
        $inscripto->genero = $request->genero;
        $inscripto->email = $request->email;
        $inscripto->telefono = $request->telefono;
        $inscripto->direccion = $request->direccion;
        $inscripto->localidad_ciudad = $request->localidad_ciudad;

        if ($request->hasFile('cv')) {
            $cvPath = storage_path('app/public/' . $inscripto->cv);
            if ($inscripto->cv && File::exists($cvPath)) {
                unlink($cvPath);
            }
            $inscripto->cv = $request->file('cv')->store('cv_inscriptos', 'public');
        }

        if ($request->hasFile('fotografia')) {
            $fotoPath = storage_path('app/public/' . $inscripto->fotografia);
            if ($inscripto->fotografia && File::exists($fotoPath)) {
                unlink($fotoPath);
            }
            $inscripto->fotografia = $request->file('fotografia')->store('fotografias_inscriptos', 'public');
        }

        $inscripto->save();

        return redirect()->route('inscriptos.index')->with('mensaje', 'Datos actualizados correctamente');
    }

    public function destroy($id)
    {
        $inscripto = Inscripto::findOrFail($id);

        $cvPath = storage_path('app/public/' . $inscripto->cv);
        if ($inscripto->cv && File::exists($cvPath)) {
            unlink($cvPath);
        }

        $fotoPath = storage_path('app/public/' . $inscripto->fotografia);
        if ($inscripto->fotografia && File::exists($fotoPath)) {
            unlink($fotoPath);
        }

        $inscripto->delete();

        return redirect()->route('inscriptos.index')->with('mensaje', 'Se eliminó al Inscripto correctamente');
    }

    public function mostrarBusqueda()
    {
        return view('productos.buscar_dni');
    }

    public function buscarDni(Request $request)
    {
        $request->validate([
            'dni' => ['required', 'digits:8'],
        ], [
            'dni.required' => 'El DNI es obligatorio.',
            'dni.digits' => 'El DNI debe tener exactamente 8 dígitos numéricos.',
        ]);

        $inscripto = Inscripto::where('dni', $request->dni)->first();

        if ($inscripto) {
            return redirect()->route('inscriptos.buscar')->with([
                'mensaje' => 'existe',
                'inscripto_id' => $inscripto->id,
            ]);
        }

        return redirect()->route('inscriptos.buscar')->with([
            'mensaje' => 'nuevo',
            'dni' => $request->dni,
        ]);
    }
}
