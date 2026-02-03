@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <h1>Creación de un nuevo Cliente</h1>

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
                    <form action="{{ route('clientes.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Razón Social</label><b>*</b>
                                    <input type="text" name="razon_social" class="form-control" value="{{ old('razon_social') }}" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>CUIT</label><b>*</b>
                                    <input type="text" name="cuit" class="form-control" value="{{ old('cuit') }}" required>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Condición IVA</label>
                                    <input type="text" name="condicion_iva" class="form-control" value="{{ old('condicion_iva') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Teléfono</label>
                                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Localidad/Ciudad</label>
                                    <input type="text" name="localidad_ciudad" class="form-control" value="{{ old('localidad_ciudad') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Dirección</label>
                                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <div class="form-group">
                                    <a href="{{ route('clientes.index') }}" class="btn btn-danger">Cancelar</a>
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
