@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <h1>Creación de un nuevo Departamento</h1>

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
                    <form action="{{ url('/stock') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nombre</label><b>*</b>
                                    <input type="text" name="nombre" class="form-control"
                                        placeholder="Ingrese Nombre del Departamento" value="{{ old('nombre') }}" required>
                                    @error('nombre')
                                        <small style="color: red;">*Este campo es requerido</small>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Siglas</label><b>*</b>
                                    <input type="text" name="siglas" class="form-control"
                                        placeholder="Ingrese Siglas del Departamento" value="{{ old('siglas') }}" required>
                                    @error('siglas')
                                        <small style="color: red;">*Este campo es requerido</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <div class="form-group">
                                    <a href="{{ route('stock.index') }}" class="btn btn-danger">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Guardar Registro</button>
                                </div>
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
        title: 'Error en el Formulario',
        html: '{!! implode("<br>", $errors->all()) !!}',
        confirmButtonColor: '#3085d6'
    });
</script>
@endif
@endsection
