@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Listado de Adscripciones</h1>

        @if ($message = Session::get('mensaje'))
            <script>
                Swal.fire({
                    title: "Buen Trabajo!",
                    text: "{{ $message }}",
                    icon: "success"
                });
            </script>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-danger">
                    <div class="card-header">
                        <h3 class="card-title"><b>ADSCRIPCIONES REGISTRADAS</b></h3>
                        <div class="card-tools">
                            @role('admin|carga')
                            <a href="{{ route('adscripciones.create') }}" class="btn btn-primary">
                                <i class="bi bi-folder-plus"></i> Agregar Nueva Adscripción
                            </a>
                            @endrole
                        </div>
                    </div>  

                    <div class="card-body" style="display: block;">
                        <table id="example1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Número/Año</th>
                                    <th>Jerarquía</th>
                                    <th>Tipo</th>
                                    <th>Modalidad</th>
                                    <th>Fecha Adscripción</th>
                                    <th>Designado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($adscripciones as $adscripcion)
                                    <tr>
                                        <td>{{ $adscripcion->id }}</td>
                                        <td>{{ $adscripcion->numero }}/{{ $adscripcion->anio }}</td>
                                        <td>{{ $adscripcion->jerarquia->siglas ?? '-' }}</td>
                                        <td>{{ $adscripcion->tipo_adscripcion }}</td>
                                        <td>{{ $adscripcion->modalidad_adscripcion }}</td>
                                        <td>{{ \Carbon\Carbon::parse($adscripcion->fecha_adscripcion)->format('d/m/Y') }}</td>
                                        <td>
                                            @if($adscripcion->designado)
                                                {{ $adscripcion->designado->nombre_apellido }}
                                            @else
                                                <em>Sin designar</em>
                                            @endif
                                        </td>
                                        
                                        <td style="text-align: center">
                                            <div class="btn-group" role="group" aria-label="Acciones">
                                                <a href="{{ route('adscripciones.seguimientos', $adscripcion->id) }}" class="btn btn-warning" title="Seguimiento">
                                                <i class="bi bi-clock-history"></i>
                                            </a>

                                                <a href="{{ route('adscripciones.show', $adscripcion->id) }}" class="btn btn-info" title="Ver">
                                                    <i class="bi bi-eye"></i></a>
                                                
                                                @role('admin|carga')
                                                <a href="{{ route('adscripciones.edit', $adscripcion->id) }}" class="btn btn-success" title="Editar">
                                                    <i class="bi bi-pencil"></i></a>
                                                <form id="delete-form-{{ $adscripcion->id }}" action="{{ route('adscripciones.destroy', $adscripcion->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger" title="Eliminar" onclick="confirmarEliminacion({{ $adscripcion->id }})">
                                                        <i class="bi bi-trash3"></i>
                                                    </button>
                                                </form>
                                                @endrole
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <script>
                            $(function () {
                                $("#example1").DataTable({
                                    "pageLength": 10,
                                    "order": [[0, "desc"]],
                                    "language": {
                                        "emptyTable": "No hay información",
                                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Adscripciones",
                                        "infoEmpty": "Mostrando 0 a 0 de 0 adscripciones",
                                        "infoFiltered": "(Filtrado de _MAX_ total Adscripciones)",
                                        "lengthMenu": "Mostrar _MENU_ Adscripciones",
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
                                            orientation: 'landscape',
                                            buttons: [
                                                { extend: 'copy', text: 'Copiar' },
                                                { extend: 'pdf', text: 'PDF' },
                                                { extend: 'csv', text: 'CSV' },
                                                { extend: 'excel', text: 'Excel' },
                                                { extend: 'print', text: 'Imprimir' }
                                            ]
                                        },
                                        {
                                            extend: 'colvis',
                                            text: 'Visor de columnas',
                                            collectionLayout: 'fixed three-column'
                                        }
                                    ]
                                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmarEliminacion(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡Esta acción no se puede deshacer!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
    </script>
@endsection
