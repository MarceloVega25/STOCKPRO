@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Creación de un nuevo Producto</h1>

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <li>{{ $error }}</li>
            </div>
        @endforeach

        <div class="row">
            <div class="col-md-11">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b>COMPLETE LOS DATOS</b></h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('productos.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nombre</label><b>*</b>
                                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Precio</label><b>*</b>
                                        <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Stock</label><b>*</b>
                                        <input type="number" name="stock" class="form-control" value="{{ old('stock') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Categoría (ID)</label>
                                        <input type="number" name="categoria_id" class="form-control" value="{{ old('categoria_id') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Botones dentro del formulario -->
                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <div class="form-group">
                                        <a href="{{ route('productos.index') }}" class="btn btn-danger">Cancelar</a>
                                        <button type="submit" class="btn btn-primary">Guardar Registro</button>
                                    </div>
                                </div>
                            </div>
                        </form> <!-- ✅ cierre correcto -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error en el Formulario',
                html: '{!! implode("<br>", $errors->all()) !!}',
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif
@endsection
