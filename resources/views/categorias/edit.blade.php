@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Actualizar Datos de la Categoría</h1>

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <li>{{ $error }}</li>
            </div>
        @endforeach

        <div class="row">
            <div class="col-md-11">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title"><b>ACTUALICE LOS DATOS</b></h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nombre</label><b>*</b>
                                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $categoria->nombre) }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Descripción</label>
                                    <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion', $categoria->descripcion) }}">
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <hr>
                                    <button type="submit" class="btn btn-success">Actualizar Categoría</button>
                                    <a href="{{ route('categorias.index') }}" class="btn btn-danger">Cancelar</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error en el formulario',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif

@endsection
