@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <h1>Datos del Cliente</h1>

    <div class="row">
        <div class="col-md-11">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><b>Datos Registrados</b></h3>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Razón Social</label>
                                <input type="text" class="form-control" value="{{ $cliente->razon_social }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CUIT</label>
                                <input type="text" class="form-control" value="{{ $cliente->cuit }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" value="{{ $cliente->email ?? '-' }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" class="form-control" value="{{ $cliente->telefono ?? '-' }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Condición IVA</label>
                                <input type="text" class="form-control" value="{{ $cliente->condicion_iva ?? '-' }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Localidad/Ciudad</label>
                                <input type="text" class="form-control" value="{{ $cliente->localidad_ciudad ?? '-' }}" disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Dirección</label>
                                <input type="text" class="form-control" value="{{ $cliente->direccion ?? '-' }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <hr>
                            <a href="{{ route('clientes.index') }}" class="btn btn-danger">Volver al listado</a>
                            @role('admin|carga')
                                <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning">Editar Cliente</a>
                            @endrole
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
