<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Reparto;
use App\Models\Vehiculo;
use App\Models\Vendedor;
use App\Models\Usuario;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\InformeGenerado;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
public function index(){
    $productos = Producto::all();
    $proveedores = Proveedor::all();
    $repartos = Reparto::all();
    $vehiculos = Vehiculo::all();
    $vendedores = Vendedor::all();
    $usuarios = Usuario::all();
    $categorias = Categoria::all();
    $compras = Compra::all();
    $informes = InformeGenerado::all();

    return view('index',['productos' => $productos,
    'proveedores' => $proveedores, 
    'repartos' => $repartos, 
    'vehiculos' => $vehiculos,
    'vendedores'=>$vendedores,
    'usuarios'=>$usuarios,
    'categorias'=>$categorias,
    'compras'=>$compras,
    'informes'=>$informes]);
}
}
