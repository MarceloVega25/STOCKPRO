@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Seguimientos de la Compra</h1>

        <div class="row">
            <div class="col-md-11">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><b>Historial de Seguimientos</b></h3>
                    </div>

                    <div class="card-body">
                        @if ($compra->seguimientos->isEmpty())
                            <div class="alert alert-info">
                                No hay seguimientos registrados para esta Compra.
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Acción</th>
                                                <th>Detalle</th>
                                                <th>Usuario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($compra->seguimientos as $s)
                                                <tr>
                                                    <td>{{ \Carbon\Carbon::parse($s->created_at)->format('d/m/Y H:i') }}</td>
                                                    <td>{{ $s->accion }}</td>
                                                    <td>{{ $s->detalle }}</td>
                                                    <td>{{ $s->usuario }}</td>
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
                                                    "info": "Mostrando _START_ a _END_ de _TOTAL_ MOVIMIENTOS",
                                                    "infoEmpty": "Mostrando 0 a 0 de 0 Movimientos",
                                                    "infoFiltered": "(Filtrado de _MAX_ total Movimientos)",
                                                    "lengthMenu": "Mostrar _MENU_ Movimientos",
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
                        @endif

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <hr>
                                <a href="{{ route('compras.index') }}" class="btn btn-danger">Volver al listado</a>
                                @role('admin|carga')
                                    <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-warning">Editar Compra</a>
                                @endrole
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
