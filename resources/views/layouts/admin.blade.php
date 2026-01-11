<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SISTEMA DE GESTION DE CONCURSOS DOCENTES -FICH</title>

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
<nav class="main-header navbar navbar-expand bg-info text-white">
    <!-- Left navbar links -->
    
    <!--<ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-white" data-widget="pushmenu" href="#" role="button">
                <i class="fas fa-bars"></i>
            </a>
        </li>-->

        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/') }}" class="nav-link text-white">
                Sistema de Gestión de Concursos Docentes - FICH
            </a>
        </li>
    </ul>


            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                 <!-- <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search"
                                    aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>-->

                <!-- Messages Dropdown Menu 
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-comments"></i>
                        <span class="badge badge-danger navbar-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="#" class="dropdown-item">
                            ----Message Start---- 
                            <div class="media">
                                <img src="dist/img/user1-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 mr-3 img-circle">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Brad Diesel
                                        <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">Call me whenever you can...</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            -- Message End --
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            -- Message Start --
                            <div class="media">
                                <img src="dist/img/user8-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        John Pierce
                                        <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">I got your message bro</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            -- Message End --
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            -- Message Start --
                            <div class="media">
                                <img src="dist/img/user3-128x128.jpg" alt="User Avatar"
                                    class="img-size-50 img-circle mr-3">
                                <div class="media-body">
                                    <h3 class="dropdown-item-title">
                                        Nora Silvester
                                        <span class="float-right text-sm text-warning"><i
                                                class="fas fa-star"></i></span>
                                    </h3>
                                    <p class="text-sm">The subject goes here</p>
                                    <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                </div>
                            </div>
                            -- Message End --
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                    </div>
                </li> 
                -- Notifications Dropdown Menu --
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">15</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li> 
                <!<li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul> -->
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-secondary elevation">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <img src="{{ url('/dist/img/SISCONDOC.png') }}" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-dark">SISCONDOC</span>
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
               @role('admin')
               <li class="nav-item">
                        <a href="#" class="nav-link active bg-dark text-white">
                            <i class="nav-icon fas">
                                <i class="bi bi-person-add"></i>
                            </i>

                            <p>
                                Usuarios
                                <i class="right fas fa-angle-left"></i>
                                </i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('usuarios.buscar') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Nuevo "Usuario"</p>
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
@endrole
                    <li class="nav-item">
                        <a href="#" class="nav-link active bg-primary text-white">
                            <i class="nav-icon fas">
                                <i class="bi bi-journal-text"></i>
                            </i>
                            <p>
                                Gestión Concursos
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
                                        Inscriptos
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('inscriptos.buscar') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Aspirante"</p>
                                        </a>

                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('inscriptos.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Inscriptos</p>
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
                                        Concursos
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('concursos.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Concurso"</p>
                                        </a>

                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('concursos.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Concursos</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link active bg-primary text-white">
                            <i class="nav-icon fas">
                                <i class="bi bi-clipboard2-check"></i>
                            </i>
                            <p>
                                Gestión Adscripciones
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
                                        Adscriptos
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('adscriptos.buscar') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Adscriptos"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('adscriptos.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Adscriptos</p>
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
                                        Adscripciones
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('adscripciones.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nueva "Adscripcion"</p>
                                        </a>

                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('adscripciones.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Adscripciones</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item">
                        <a href="#" class="nav-link active bg-primary text-white">
                            <i class="nav-icon fas">
                                <i class="bi bi-buildings"></i>
                            </i>
                            <p>
                                Gestión Academica
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
                                        Jerarquia
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('jerarquias.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Jerarquia"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('jerarquias.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Jerarquias</p>
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
                                        Asignatura
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('asignaturas.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Asignatura"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('asignaturas.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Asignaturas</p>
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
                                        Departamento
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('departamentos.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Departamento"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('departamentos.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado Departamentos</p>
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
                                        Carreras
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('carreras.create') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Carrera"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('carreras.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Carreras</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link active bg-primary text-white">
                            <i class="nav-icon fas">
                                <i class="bi bi-people"></i>
                            </i>
                            <p>
                                Gestión Jurados
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
                                        Docentes
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('docentes.buscar') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Docente"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('docentes.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Docentes</p>
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
                                        Estudiantes
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('estudiantes.buscar') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Estudiante"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('estudiantes.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Estudiantes</p>
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
                                        Veedores
                                        <i class="right fas fa-angle-left"></i>
                                        </i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    @role('admin|carga')
                                    <li class="nav-item">
                                        <a href="{{ route('veedores.buscar') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Nuevo "Veedor"</p>
                                        </a>
                                    </li>
                                    @endrole
                                    <li class="nav-item">
                                        <a href="{{ route('veedores.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listado de Veedores</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                    </li>
                </ul>
                @role('admin|carga')
<li class="nav-item">
    <a href="#" class="nav-link active bg-primary text-white">
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


                    @role('admin|carga')
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

@role('admin')
<li class="nav-item">
    <a href="{{ route('auditorias.index') }}" class="nav-link active bg-primary text-white">
        <i class="nav-icon fas">
            <i class="bi bi-clipboard-data"></i>
        </i>
        <p>Auditoría
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
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
    <div class="content-wrapper">
        <br>
        <div class="content">
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
    <footer class="main-footer bg-info text-white">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            <strong>
                <a href="https://www.fich.unl.edu.ar/facultad/wp-content/uploads/sites/2/2024/02/Calendario_2025_A4-2.pdf"
                    target="_blank" class="text-dark">2026</a>
            </strong>
        </div>
        <!-- Default to the left -->
        <strong>Proyecto Final <a
                href="https://www.unl.edu.ar/carreras/licenciatura-en-tecnologias-para-la-gestion-de-las-organizaciones/"
                target="_blank" class="text-dark">LTGO - FICH</a>.</strong> Universidad Nacional del Litoral.
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
