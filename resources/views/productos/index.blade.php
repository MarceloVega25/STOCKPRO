@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Listado de Productos</h1>

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
                        <h3 class="card-title"><b>PRODUCTOS REGISTRADOS</b></h3>
                        <div class="card-tools">
                            @role('admin|carga')
                            <a href="{{ route('productos.create') }}" class="btn btn-primary">
                                <i class="bi bi-person-add"></i>Agregar Nuevo Producto
                            </a>
                             @endrole                           
                        </div>
                    </div>

                    <div class="card-body" style="display: block;">

                        <table id="example1" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Nombre</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Categoría</th>
                                    <th>Agregado</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $contador = 0; ?>
                                @foreach ($productos as $producto)
                                    <tr>
                                        <td>
                                            <?php echo $contador = $contador + 1; ?></td>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>{{ $producto->precio }}</td>
                                        <td>{{ $producto->stock }}</td>
                                        <td>{{ $producto->categoria_id ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($producto->created_at)->format('d/m/Y H:i') }}</td>
                                        <td style="text-align: center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ url('/productos', $producto->id) }}" type="button"
                                                    class="btn btn-info"><i class="bi bi-eye"></i></a>

                                                    @role('admin|carga')
                                                <a href="{{ route('productos.edit', $producto->id) }}" type="button"
                                                    class="btn btn-success"><i class="bi bi-pencil"></i></a>

                                                    <form id="delete-form-{{ $producto->id }}" action="{{ url('/productos', $producto->id) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" class="btn btn-danger" onclick="confirmarEliminacion({{ $producto->id }})">
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
                                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Productos",
                                        "infoEmpty": "Mostrando 0 a 0 de 0 Productos",
                                        "infoFiltered": "(Filtrado de _MAX_ total Productos)",
                                        "infoPostFix": "",
                                        "thousands": ",",
                                        "lengthMenu": "Mostrar _MENU_ Productos", //hacer hincapie en los _MAYUSCULA_
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
                                    buttons: [{
                                            extend: 'collection',
                                            text: 'Reportes',
                                            orientation: 'landscape',
                                            buttons: [{
                                                text: 'Copiar',
                                                extend: 'copy',
                                            }, {
                                                extend: 'pdf'
                                            }, {
                                                extend: 'csv'
                                            }, {
                                                extend: 'excel'
                                            }, {
                                                text: 'Imprimir',
                                                extend: 'print'
                                            }]
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
    <!-- tus botones y tabla... -->

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
