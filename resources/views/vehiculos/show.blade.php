@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Datos del Vehículo Registrado</h1>

        <div class="row">
            <div class="col-md-11">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><b>Datos Registrados</b></h3>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nombre y Apellido</label>
                                            <input type="text" class="form-control" value="{{ $vehiculo->nombre_apellido }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>DNI</label>
                                            <input type="number" class="form-control" value="{{ $vehiculo->dni }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Fecha de Nacimiento</label>
                                            <input type="date" class="form-control" value="{{ $vehiculo->fecha_nacimiento }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Género</label>
                                            <input type="text" class="form-control" value="{{ $vehiculo->genero }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" value="{{ $vehiculo->email }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Teléfono</label>
                                            <input type="text" class="form-control" value="{{ $vehiculo->telefono }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Institución</label>
                                            <input type="text" class="form-control" value="{{ $vehiculo->institucion }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tipo</label>
                                            <input type="text" class="form-control" value="{{ $vehiculo->tipo }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>CV</label><br>
                                            @if ($vehiculo->cv)
                                                <a href="{{ asset('storage/' . $vehiculo->cv) }}" target="_blank" class="btn btn-primary btn-sm">Ver CV</a>
                                            @else
                                                <p class="text-muted">No disponible</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fotografía</label>
                                    <center>
                                        @php
                                            $fotoPath = (!empty($vehiculo->fotografia) && file_exists(public_path('storage/' . $vehiculo->fotografia)))
                                                ? asset('storage/' . $vehiculo->fotografia)
                                                : asset('images/' . strtolower($vehiculo->genero) . '.jpg');
                                        @endphp
                                        <img src="{{ $fotoPath }}" class="img-thumbnail" width="150">
                                    </center>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <hr>
                                <a href="{{ route('vehiculos.index') }}" class="btn btn-danger">Volver al listado</a>
                                @role('admin|carga')
                                <a href="{{ route('vehiculos.edit', $vehiculo->id) }}" class="btn btn-warning">Editar Vehículo</a>
                                @endrole
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
