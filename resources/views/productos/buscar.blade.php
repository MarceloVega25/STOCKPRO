@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <h1>Búsqueda de Producto por Código</h1>

    <div class="row">
        <div class="col-md-11">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title"><b>ESCRIBA EL CÓDIGO</b></h3>
                </div>

                <div class="card-body" style="display: block;">
                    <form method="POST" action="{{ route('productos.buscarDni') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="codigo">Código:</label>
                                    <input type="text" name="codigo" id="codigo" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <hr>
                                <div class="form-group">
                                    <a href="{{ route('productos.index') }}" class="btn btn-danger">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('mensaje') === 'existe')
    <script>
        Swal.fire({
            title: 'Código Encontrado',
            text: 'El código ya está Registrado. Será redirigido al formulario de Edición.',
            icon: 'info',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        }).then(() => {
            window.location.href = "{{ route('productos.edit', session('producto_id')) }}";
        });
    </script>
@endif

@if(session('mensaje') === 'nuevo')
    <script>
        Swal.fire({
            title: 'Código No Encontrado',
            text: 'El código no se encuentra Registrado. Será redirigido al formulario de Alta.',
            icon: 'warning',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        }).then(() => {
            window.location.href = "{{ route('productos.create') }}";
        });
    </script>
@endif

@endsection
