<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\{
    Categoria,
    Proveedor,
    Cliente,
    Carrera,
    Departamento,
    Compra,
    Reparto,
    Vehiculo,
    Vendedor,
    Venta,
    Producto,
    Usuario,
    Modulo,
    InformeGenerado
};

class InformeController extends Controller
{
    public function index()
    {
        $modulos = Modulo::orderBy('nombre')->get();
        return view('informes.por_fecha', compact('modulos'));
    }

    public function porFecha()
    {
        $modulos = Modulo::orderBy('nombre')->get();
        return view('informes.por_fecha', compact('modulos'));
    }

    public function porAnio()
    {
        $modulos = Modulo::orderBy('nombre')->get();
        return view('informes.por_anio', compact('modulos'));
    }

    public function generar(Request $request)
    {
        $modulo = $request->modulo;
        $desde = $request->fecha_inicio;
        $hasta = $request->fecha_fin;

        $modelos = [
            'categorias' => Categoria::class,
            'proveedores' => Proveedor::class,
            'clientes' => Cliente::class,
            'carreras' => Carrera::class,
            'departamentos' => Departamento::class,
            'stock' => Departamento::class,
            'movimientos_stock' => Carrera::class,
            'productos' => Producto::class,
            'usuarios' => Usuario::class,
            'compras' => Compra::class,
            'ventas' => Venta::class,
            'repartos' => Reparto::class,
            'vehiculos' => Vehiculo::class,
            'vendedores' => Vendedor::class,
        ];

        if (!array_key_exists($modulo, $modelos)) {
            return back()->with('error', 'Módulo no reconocido.');
        }

        $modelo = $modelos[$modulo];
        $datos = $modelo::whereBetween('created_at', [$desde, $hasta])->get();

        if ($datos->isEmpty()) {
            return back()->with('error', 'No hay datos para ese rango de fechas.');
        }

        $vistasPdfMap = [
            'compras' => 'informes.pdf_compras',
            'ventas' => 'informes.pdf_ventas',
            'repartos' => 'informes.pdf_repartos',
            'vehiculos' => 'informes.pdf_vehiculos',
            'vendedores' => 'informes.pdf_vendedores',
        ];

        $vistaPdf = 'informes.pdf_' . $modulo;
        if (array_key_exists($modulo, $vistasPdfMap)) {
            $vistaPdf = $vistasPdfMap[$modulo];
        }
        if (!view()->exists($vistaPdf)) {
            return back()->with('error', 'La vista PDF para este módulo no existe: ' . $vistaPdf);
        }

        $filename = "informe_{$modulo}_{$desde}_{$hasta}.pdf";
        $pdf = Pdf::loadView($vistaPdf, compact('datos', 'desde', 'hasta'));

        // Guardar PDF en storage/app/public/informes
        Storage::disk('public')->put("informes/{$filename}", $pdf->output());

        InformeGenerado::create([
            'modulo' => $modulo,
            'fecha_desde' => $desde,
            'fecha_hasta' => $hasta,
            'usuario' => Auth::user()->nombre_apellido,
            'archivo_pdf' => $filename,
        ]);

        return redirect()->route('informes.historico')->with('success', 'Informe generado y guardado correctamente.');
    }

    public function generarPorAnio(Request $request)
    {
        $anio = $request->anio;
        $modulo = $request->modulo;

        $modelos = [
            'categorias' => Categoria::class,
            'proveedores' => Proveedor::class,
            'clientes' => Cliente::class,
            'carreras' => Carrera::class,
            'departamentos' => Departamento::class,
            'stock' => Departamento::class,
            'movimientos_stock' => Carrera::class,
            'productos' => Producto::class,
            'usuarios' => Usuario::class,
            'compras' => Compra::class,
            'ventas' => Venta::class,
            'repartos' => Reparto::class,
            'vehiculos' => Vehiculo::class,
            'vendedores' => Vendedor::class,
        ];

        if (!array_key_exists($modulo, $modelos)) {
            return back()->with('error', 'Módulo no reconocido.');
        }

        $modelo = $modelos[$modulo];
        $datos = $modelo::whereYear('created_at', $anio)->get();

        if ($datos->isEmpty()) {
            return back()->with('error', 'No hay datos para el año seleccionado.');
        }

        $vistasPdfMap = [
            'compras' => 'informes.pdf_compras',
            'ventas' => 'informes.pdf_ventas',
            'repartos' => 'informes.pdf_repartos',
            'vehiculos' => 'informes.pdf_vehiculos',
            'vendedores' => 'informes.pdf_vendedores',
        ];

        $vistaPdf = 'informes.pdf_' . $modulo;
        if (array_key_exists($modulo, $vistasPdfMap)) {
            $vistaPdf = $vistasPdfMap[$modulo];
        }
        if (!view()->exists($vistaPdf)) {
            return back()->with('error', 'La vista PDF para este módulo no existe: ' . $vistaPdf);
        }

        $filename = "informe_{$modulo}_{$anio}.pdf";
        $pdf = Pdf::loadView($vistaPdf, compact('datos', 'anio'));

        Storage::disk('public')->put("informes/{$filename}", $pdf->output());

        InformeGenerado::create([
            'modulo' => $modulo,
            'anio' => $anio,
            'usuario' => Auth::user()->nombre_apellido,
            'archivo_pdf' => $filename,
        ]);

        return redirect()->route('informes.historico')->with('success', 'Informe generado y guardado correctamente.');
    }

    public function historico()
    {
        $historial = InformeGenerado::orderBy('created_at', 'desc')->paginate(20);
        return view('informes.historico', compact('historial'));
    }

    public function destroy($id)
    {
        $registro = InformeGenerado::findOrFail($id);

        // Eliminar archivo PDF si existe
        if ($registro->archivo_pdf && Storage::disk('public')->exists("informes/{$registro->archivo_pdf}")) {
            Storage::disk('public')->delete("informes/{$registro->archivo_pdf}");
        }

        $registro->delete();

        return redirect()->route('informes.historico')->with('success', 'Se eliminó el Informe del historial.');
    }
}
