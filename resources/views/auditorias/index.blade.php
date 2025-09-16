@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <h1>Auditoría del Sistema</h1>

    {{-- ALERTAS --}}
    @if ($message = Session::get('mensaje'))
        <script>
            Swal.fire({
                title: "Buen Trabajo!",
                text: "{{ $message }}",
                icon: "success"
            });
        </script>
    @endif

    @if ($message = Session::get('mensaje_error'))
        <script>
            Swal.fire({
                title: "Atención",
                text: "{{ $message }}",
                icon: "warning"
            });
        </script>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title"><b>REGISTROS DE AUDITORÍA</b></h3>
                </div>

                <div class="card-body" style="display: block;">

                    {{-- FILTROS --}}
                    <form method="GET" class="row mb-4">
                        <div class="col-md-3">
                            <label><b>Tabla Afectada:</b></label>
                            <select name="tabla" class="form-control">
                                <option value="">Todas</option>
                                @foreach($tablas as $tabla)
                                    <option value="{{ $tabla }}" {{ request('tabla') == $tabla ? 'selected' : '' }}>
                                        {{ ucfirst($tabla) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label><b>Usuario:</b></label>
                            <select name="usuario_id" class="form-control">
                                <option value="">Todos</option>
                                @foreach($usuarios as $user)
                                    <option value="{{ $user->id }}" {{ request('usuario_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label><b>Desde:</b></label>
                            <input type="date" name="desde" class="form-control" value="{{ old('desde', request('desde')) }}">
                        </div>

                        <div class="col-md-2">
                            <label><b>Hasta:</b></label>
                            <input type="date" name="hasta" class="form-control" value="{{ old('hasta', request('hasta')) }}">
                        </div>

                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search"></i> Filtrar
                            </button>
                        </div>
                    </form>

                    {{-- TABLA --}}
                    <table id="example1" class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tabla</th>
                                <th>Operación</th>
                                <th>Registro</th>
                                <th>Usuario</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($auditorias as $a)
                                <tr>
                                    <td>{{ $a->id }}</td>
                                    <td>{{ ucfirst($a->tabla_afectada) }}</td>
                                    <td>
    @switch($a->operacion)
        @case('CREATED')
        @case('INSERT')
            Creación
            @break

        @case('UPDATED')
        @case('UPDATE')
            Modificación
            @break

        @case('DELETED')
        @case('DELETE')
            Eliminación
            @break

        @case('RESTORED')
            Restauración
            @break

        @case('FORCE DELETED')
            Eliminación definitiva
            @break

        @default
            {{ ucfirst($a->operacion) }}
    @endswitch
</td>

                                    <td>{{ $a->registro_id }}</td>
                                    <td>{{ $a->usuario->name ?? 'Desconocido' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($a->fecha)->format('d/m/Y H:i') }}</td>

                                    <td style="text-align: center">
                                        <a href="{{ route('auditorias.show', $a->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- SCRIPT DATATABLES --}}
                    <script>
                        $(function () {
                            $("#example1").DataTable({
                                "pageLength": 10,
                                "language": {
                                    "emptyTable": "No hay información",
                                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                                    "infoFiltered": "(Filtrado de _MAX_ registros totales)",
                                    "lengthMenu": "Mostrar _MENU_ registros",
                                    "loadingRecords": "Cargando...",
                                    "processing": "Procesando...",
                                    "search": "Buscador:",
                                    "zeroRecords": "Sin resultados encontrados",
                                    "paginate": {
                                        "first": "Primero",
                                        "last": "Último",
                                        "next": "Siguiente",
                                        "previous": "Anterior"
                                    }
                                },
                                "responsive": true,
                                "lengthChange": true,
                                "autoWidth": false,
                                buttons: [
                                    {
                                        extend: 'collection',
                                        text: 'Reportes',
                                        buttons: [
                                            { extend: 'copy', text: 'Copiar' },
                                            { extend: 'pdf', title: 'Auditoría del Sistema' },
                                            { extend: 'csv', title: 'Auditoría del Sistema' },
                                            { extend: 'excel', title: 'Auditoría del Sistema' },
                                            { extend: 'print', text: 'Imprimir', title: 'Auditoría del Sistema' }
                                        ]
                                    },
                                    {
                                        extend: 'colvis',
                                        text: 'Visor de columnas',
                                        collectionLayout: 'fixed two-column'
                                    }
                                ],
                            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                        });
                    </script>

                    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        form.addEventListener('submit', function (e) {
            const desde = document.querySelector('input[name="desde"]').value;
            const hasta = document.querySelector('input[name="hasta"]').value;

            if (!desde || !hasta) {
                e.preventDefault();

                Swal.fire({
                    title: "Atención",
                    text: "Debe completar ambos campos de fecha: Desde y Hasta para aplicar el filtro.",
                    icon: "warning"
                });
            }
        });
    });
</script>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
