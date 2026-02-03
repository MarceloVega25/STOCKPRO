@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Listado de Clientes</h1>

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
                        <h3 class="card-title"><b>CLIENTES REGISTRADOS</b></h3>
                        <div class="card-tools">
                            @role('admin|carga')
                            <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                                <i class="bi bi-person-add"></i>Agregar Nuevo Cliente
                            </a>
                            @endrole
                        </div>
                    </div>

                    <div class="card-body" style="display: block;">
                        <table id="example1" class="table table-bordered table-striped table-sm">
                            <thead>
                            <tr>
                                <th>N°</th>
                                <th>Razón Social</th>
                                <th>CUIT</th>
                                <th>Email</th>
                                <th>Agregado</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $contador = 0; ?>
                            @foreach ($clientes as $cliente)
                                <tr>
                                    <td><?php echo $contador = $contador + 1; ?></td>
                                    <td>{{ $cliente->razon_social }}</td>
                                    <td>{{ $cliente->cuit }}</td>
                                    <td>{{ $cliente->email ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($cliente->created_at)->format('d/m/Y H:i') }}</td>
                                    <td style="text-align: center">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ route('clientes.show', $cliente->id) }}" type="button" class="btn btn-info"><i class="bi bi-eye"></i></a>

                                            @role('admin|carga')
                                            <a href="{{ route('clientes.edit', $cliente->id) }}" type="button" class="btn btn-success"><i class="bi bi-pencil"></i></a>

                                            <form id="delete-form-{{ $cliente->id }}" action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger" onclick="confirmarEliminacion({{ $cliente->id }})">
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
                                    "language": {
                                        "emptyTable": "No hay información",
                                        "info": "Mostrando _START_ a _END_ de _TOTAL_ Clientes",
                                        "infoEmpty": "Mostrando 0 a 0 de 0 Clientes",
                                        "infoFiltered": "(Filtrado de _MAX_ total Clientes)",
                                        "lengthMenu": "Mostrar _MENU_ Clientes",
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
                                    "responsive": true, "lengthChange": true, "autoWidth": false,
                                });
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
