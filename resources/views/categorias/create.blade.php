@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Creación de una nueva Categoría</h1>

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
                        <form action="{{ route('categorias.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Nombre</label><b>*</b>
                                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label>Descripción</label>
                                    <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion') }}">
                                </div>
                            </div>

                            <hr>

                            <div class="form-group mt-3">
                                <a href="{{ route('categorias.index') }}" class="btn btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar Categoría</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
