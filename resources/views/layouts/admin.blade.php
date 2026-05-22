<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>STOCKPRO</title>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="preload" href="{{ asset('favicon.ico') }}" as="image">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Iconos de bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!--JQuery-->
    <script src="{{ asset('/plugins/jquery/jquery.js') }}"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Sweetalert2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
       <!-- Navbar -->
<nav class="main-header navbar navbar-expand bg-dark text-white">
<ul class="navbar-nav">
    <li class="nav-item d-none d-sm-inline-block">
            
                <a href="{{ url('/') }}" class="nav-link text-white">
                <strong>Sistema de Gestión de Compras, Ventas y Entregas
            </a>
            </strong>
        </li>
    </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-secondary elevation">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ url('/dist/img/icono.jpg') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-dark">STOCKPRO</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @php
                        $usuario = Auth::user();
                        $src = asset('images/otro.jpg'); // Imagen por defecto
                    
                        if ($usuario) {
                            $foto = $usuario->fotografia;
                    
                            if ($foto && file_exists(public_path('storage/' . $foto))) {
                                $src = asset('storage/' . $foto);
                            } else {
                                $genero = strtolower($usuario->genero ?? 'otro');
                                switch ($genero) {
                                    case 'femenino':
                                        $src = asset('images/femenino.jpg');
                                        break;
                                    case 'masculino':
                                        $src = asset('images/masculino.jpg');
                                        break;
                                    default:
                                        $src = asset('images/otro.jpg');
                                        break;
                                }
                            }
                        }
                    @endphp
                    
                    <img src="{{ $src }}" class="img-circle elevation-2" alt="Imagen del usuario">
</div>

<div class="info d-flex align-items-center">
   
    <a href="{{ route('usuarios.show', $usuario->id ?? 0) }}" class="text-success me-2">
        {{ $usuario->nombre_apellido ?? 'Invitado' }}
    </a>

    
</div>

                
                
                
                </div>
            </div>


            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <!-- Inicio -->
               <li class="nav-item">
                <a href="{{  url('/')  }}" class="nav-link active bg-dark text-white">
                <i class="nav-icon bi bi-house-door-fill"></i>
                <p>Inicio</p>
                </a>
                </li>
                <!-- Deposito -->
                <li class="nav-item">
                        <a href="#" class="nav-link active bg-dark text-white">
                            <i class="nav-icon fas">
                                <i class="bi bi-boxes"></i>
                            </i>
                            <p>
                                Deposito
                                <i class="right fas fa-angle-left"></i>
                                </i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas">
                                        <i class="bi bi-file-earmark-person-fill"></i>
                                    </i>
                                    <p>
                                        Productos
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('productos.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Producto"</p>
                                        </a>

                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('productos.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Productos</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas">
                                        <i class="bi bi-clipboard2-check-fill"></i>
                                    </i>
                                    <p>
                                        Categorías
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('categorias.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nueva "Categoría"</p>
                                        </a>

                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('categorias.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Categorías</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas">
                                        <i class="bi bi-collection-fill"></i>
                                    </i>
                                    <p>
                                        Stock
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ \Illuminate\Support\Facades\Route::has('stock.index') ? route('stock.index') : '#' }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Stock</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas">
                                        <i class="bi bi-mortarboard-fill"></i>
                                    </i>
                                    <p>
                                        Movimientos de Stock
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ \Illuminate\Support\Facades\Route::has('movimientos_stock.create') ? route('movimientos_stock.create') : '#' }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Movimiento"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ \Illuminate\Support\Facades\Route::has('movimientos_stock.index') ? route('movimientos_stock.index') : '#' }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Movimientos</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            
                        </ul>
                    </li>
<!-- Compras -->
                    <li class="nav-item">
                        <a href="#" class="nav-link active bg-dark text-white">
                            <i class="nav-icon fas">
                                <i class="bi bi-cart-check"></i>
                            </i>
                            <p>
                                Gestión de Compras
                                <i class="right fas fa-angle-left"></i>
                                </i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas">
                                        <i class="bi bi-file-earmark-person-fill"></i>
                                    </i>
                                    <p>
                                        Proveedores
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('proveedores.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Proveedor"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('proveedores.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Proveedores</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link active ">
                                    <i class="nav-icon fas">
                                        <i class="bi bi-clipboard2-check-fill"></i>
                                    </i>
                                    <p>
                                        Compras
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ \Illuminate\Support\Facades\Route::has('compras.create') ? route('compras.create') : '#' }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nueva "Compra"</p>
                                        </a>

                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ \Illuminate\Support\Facades\Route::has('compras.index') ? route('compras.index') : '#' }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Compras</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

<!-- Ventas -->
                    <li class="nav-item">
                        <a href="#" class="nav-link active bg-dark text-white">
                            <i class="nav-icon fas">
                                <i class="bi bi-receipt"></i>
                            </i>
                            <p>
                                Gestión Ventas
                                <i class="right fas fa-angle-left"></i>
                                </i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas">
                                        <i class="bi bi-diagram-3-fill"></i>
                                    </i>
                                    <p>
                                        Clientes
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('clientes.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Cliente"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('clientes.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Clientes</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas">
                                        <i class="bi bi-book-fill"></i>
                                    </i>
                                    <p>
                                        Ventas
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('ventas.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Venta"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('ventas.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Ventas</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link active bg-dark text-white">
                            <i class="nav-icon fas">
                                <i class="bi bi-truck"></i>
                            </i>
                            <p>
                                Gestión de Entregas y Repartidores
                                <i class="right fas fa-angle-left"></i>
                                </i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas">
                                        <i class="bi bi-microsoft-teams"></i>
                                    </i>
                                    <p>
                                        Repartos (Entregas)
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('repartos.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Reparto"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('repartos.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Repartos (Entregas)</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas">
                                        <i class="bi bi-people"></i>
                                    </i>
                                    <p>
                                        Repartidores
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('repartidores.buscar') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Buscar por DNI</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('repartidores.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Repartidor"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('repartidores.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Repartidores</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas">
                                        <i class="bi bi-person-rolodex"></i>
                                    </i>
                                    <p>
                                        Vehículos
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ \Illuminate\Support\Facades\Route::has('vehiculos.create') ? route('vehiculos.create') : '#' }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Vehículo"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ \Illuminate\Support\Facades\Route::has('vehiculos.index') ? route('vehiculos.index') : '#' }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Vehículos</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link active">
                                    <i class="nav-icon fas">
                                        <i class="bi bi-person-fill-check"></i>
                                    </i>
                                    <p>
                                        Vendedores
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ \Illuminate\Support\Facades\Route::has('vendedores.create') ? route('vendedores.create') : '#' }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Vendedor"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ \Illuminate\Support\Facades\Route::has('vendedores.index') ? route('vendedores.index') : '#' }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Vendedores</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    </li>
                </ul>
                @role('admin|carga')
<li class="nav-item">
    <a href="#" class="nav-link active bg-dark text-white">
        <i class="nav-icon fas">
            <i class="bi bi-info-square"></i>
        </i>
        <p>
            Gestión de Informes
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('informes.porFecha') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Por Fechas</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('informes.porAnio') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Por Año</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('informes.historico') }}" class="nav-link">
                <i class="far fa-clock nav-icon"></i>
                <p>Historial</p>
            </a>
        </li>
    </ul>
</li>
@endrole


                <!---    @role('admin|carga')
                <li class="nav-item">
                    <a href="{{ route('notificacion') }}" class="nav-link active bg-primary text-white">
                        <i class="nav-icon fas">
                            <i class="bi bi-envelope"></i>
                        </i>
                        <p>
                            Notificaciones
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                @endrole
            -->
@role('admin')

<li class="nav-item">
    <a href="#" class="nav-link active bg-dark text-white">
        <i class="nav-icon bi bi-buildings"></i>
        <p>
            Administración
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>

    <ul class="nav nav-treeview">

        {{-- Usuarios --}}
        <li class="nav-item">
            <a href="#" class="nav-link active">
                <i class="nav-icon bi bi-person-add"></i>
                <p>
                    Usuarios
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('usuarios.create') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Nuevo Usuario</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('usuarios.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Listado de Usuarios</p>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Auditorías --}}
        <li class="nav-item">
            <a href="#" class="nav-link active">
                <i class="nav-icon bi bi-clipboard2-check-fill"></i>
                <p>
                    Auditorías
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>

            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('auditorias.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Auditoría</p>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</li>

@endrole

                                    



                <li class="nav-item">

                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"
                        style="background-color: #f7483f; color:white;">
                        <i class="nav-icon fas">
                            <i class="bi bi-person-walking"></i>
                        </i>
                        <p>
                        Cerrar Sesión
                        <i class="right fas fa-angle-left"></i>
                            </i>
                        </p>
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf

                    </form>

                </li>

                </ul>


            </nav>

            <!-- /.sidebar-menu -->
    </div>

    <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper flex-grow-1">
    <div class="content pt-2">
        @yield('content')
    </div>
</div>

    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer bg-dark text-white d-flex justify-content-center">
        <strong><a href="" class="text-white">©  {{ date('Y') }} – STOCKPRO</a></strong>
    </footer>

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- CSS de Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- JS de Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</body>

</html>

<script>
    $(document).ready(function() {
        // Solo ejecutar DataTables si la vista hija define initDataTable
        if (typeof initDataTable !== "undefined" && $.isFunction(initDataTable)) {
            initDataTable();
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            placeholder: 'Seleccione una o más opciones',
            allowClear: true
        });
    });
</script>


@yield('scripts') <!-- Esto permitirá que las vistas hijas agreguen scripts adicionales -->
