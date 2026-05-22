@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Datos del Repartidor Registrado</h1>

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
                                            <input type="text" class="form-control" value="{{ $repartidor->nombre_apellido }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>DNI</label>
                                            <input type="number" class="form-control" value="{{ $repartidor->dni }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Fecha de Nacimiento</label>
                                            <input type="date" class="form-control" value="{{ $repartidor->fecha_nacimiento }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Género</label>
                                            <input type="text" class="form-control" value="{{ $repartidor->genero }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" value="{{ $repartidor->email }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Teléfono</label>
                                            <input type="text" class="form-control" value="{{ $repartidor->telefono }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Institución</label>
                                            <input type="text" class="form-control" value="{{ $repartidor->institucion }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tipo</label>
                                            <input type="text" class="form-control" value="{{ $repartidor->tipo }}" disabled>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>CV</label><br>
                                            @if ($repartidor->cv)
                                                <a href="{{ asset('storage/' . $repartidor->cv) }}" target="_blank" class="btn btn-primary btn-sm">Ver CV</a>
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
                                            $fotoPath = (!empty($repartidor->fotografia) && file_exists(public_path('storage/' . $repartidor->fotografia)))
                                                ? asset('storage/' . $repartidor->fotografia)
                                                : asset('images/' . strtolower($repartidor->genero) . '.jpg');
                                        @endphp
                                        <img src="{{ $fotoPath }}" class="img-thumbnail" width="150">
                                    </center>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <hr>
                                <a href="{{ route('repartidores.index') }}" class="btn btn-danger">Volver al listado</a>
                                @role('admin|carga')
                                <a href="{{ route('repartidores.edit', $repartidor->id) }}" class="btn btn-warning">Editar Repartidor</a>
                                @endrole
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
