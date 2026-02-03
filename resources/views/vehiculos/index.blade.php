@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Listado de Vehículos</h1>

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
                        <h3 class="card-title"><b>VEHÍCULOS REGISTRADOS</b></h3>
                        <div class="card-tools">
                            @role('admin|carga')
                            <a href="{{ route('vehiculos.buscar') }}" class="btn btn-primary">
                                <i class="bi bi-person-add"></i>Agregar Nuevo Vehículo
                            </a>
                            @endrole
                        </div>
                    </div>

                    <div class="card-body" style="display: block;">
                        <table id="example1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nombre y Apellido</th>
                                    <th>Telefono</th>
                                    <th>Mail</th>
                                    <th>Tipo</th>
                                    <th>Agregado</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $contador = 0; ?>
                                @foreach ($vehiculos as $vehiculo)
                                    <tr>
                                        <td><?php echo $contador = $contador + 1; ?></td>
                                        <td>{{ $vehiculo->nombre_apellido }}</td>
                                        <td>{{ $vehiculo->telefono }}</td>
                                        <td>{{ $vehiculo->email }}</td>
                                        <td>{{ $vehiculo->tipo }}</td>
                                        <td>{{ \Carbon\Carbon::parse($vehiculo->created_at)->format('d/m/Y H:i') }}</td>

                                        <td style="text-align: center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ route('vehiculos.show', $vehiculo->id) }}" type="button" class="btn btn-info"><i class="bi bi-eye"></i></a>

                                                @role('admin|carga')
                                                <a href="{{ route('vehiculos.edit', $vehiculo->id) }}" type="button" class="btn btn-success"><i class="bi bi-pencil"></i></a>

                                                <form id="delete-form-{{ $vehiculo->id }}" action="{{ route('vehiculos.destroy', $vehiculo->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger" onclick="confirmarEliminacion({{ $vehiculo->id }})">
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
                            $(function() {
                                $("#example1").DataTable({
                                    "pageLength": 10,
                                    "language": {
                                        "emptyTable": "No hay información",
                                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Vehículos",
                                        "infoEmpty": "Mostrando 0 a 0 de 0 Vehículos",
                                        "infoFiltered": "(Filtrado de _MAX_ total Vehículos)",
                                        "lengthMenu": "Mostrar _MENU_ Vehículos",
                                        "loadingRecords": "Cargando...",
                                        "processing": "Procesando...",
                                        "search": "Buscador:",
                                        "zeroRecords": "Sin resultados encontrados",
                                        "paginate": {
                                            "first": "Primero",
                                            "last": "Ultimo",
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
                                                { text: 'Copiar', extend: 'copy' },
                                                { extend: 'pdf' },
                                                { extend: 'csv' },
                                                { extend: 'excel' },
                                                { text: 'Imprimir', extend: 'print' }
                                            ]
                                        },
                                        {
                                            extend: 'colvis',
                                            text: 'Visor de columnas',
                                            collectionLayout: 'fixed three-column'
                                        }
                                    ],
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
