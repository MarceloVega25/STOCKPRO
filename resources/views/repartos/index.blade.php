@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Listado de Repartos (Entregas)</h1>

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
                        <h3 class="card-title"><b>REPARTOS (ENTREGAS) REGISTRADOS</b></h3>
                        <div class="card-tools">
                            @role('admin|carga')
                            <a href="{{ route('repartos.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle"></i>Agregar Nuevo Reparto
                            </a>
                            @endrole
                        </div>
                    </div>

                    <div class="card-body" style="display: block;">
                        <table id="example1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Compra</th>
                                    <th>Repartidor</th>
                                    <th>Vehículo</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                    <th>Dirección</th>
                                    <th>Agregado</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $contador = 0; ?>
                                @foreach ($repartos as $reparto)
                                    <tr>
                                        <td><?php echo $contador = $contador + 1; ?></td>
                                        <td>{{ $reparto->compra ? ($reparto->compra->numero . '/' . $reparto->compra->anio) : '' }}</td>
                                        <td>{{ $reparto->repartidor->nombre_apellido ?? '' }}</td>
                                        <td>{{ $reparto->vehiculo->patente ?? '' }}</td>
                                        <td>{{ $reparto->fecha_reparto ? \Carbon\Carbon::parse($reparto->fecha_reparto)->format('d/m/Y') : '' }}</td>
                                        <td>{{ $reparto->estado }}</td>
                                        <td>{{ $reparto->direccion_entrega }}</td>
                                        <td>{{ \Carbon\Carbon::parse($reparto->created_at)->format('d/m/Y H:i') }}</td>

                                        <td style="text-align: center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ route('repartos.show', $reparto->id) }}" type="button" class="btn btn-info"><i class="bi bi-eye"></i></a>

                                                @role('admin|carga')
                                                <a href="{{ route('repartos.edit', $reparto->id) }}" type="button" class="btn btn-success"><i class="bi bi-pencil"></i></a>

                                                <form id="delete-form-{{ $reparto->id }}" action="{{ route('repartos.destroy', $reparto->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger" onclick="confirmarEliminacion({{ $reparto->id }})">
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
                                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Repartos (Entregas)",
                                        "infoEmpty": "Mostrando 0 a 0 de 0 Repartos (Entregas)",
                                        "infoFiltered": "(Filtrado de _MAX_ total Repartos (Entregas))",
                                        "lengthMenu": "Mostrar _MENU_ Repartos (Entregas)",
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
