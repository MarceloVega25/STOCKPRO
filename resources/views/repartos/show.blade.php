@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Datos del Reparto (Entrega)</h1>

        <div class="row">
            <div class="col-md-11">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><b>Datos Registrados</b></h3>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Compra</label>
                                            <input type="text" class="form-control" value="{{ $reparto->compra ? ($reparto->compra->numero . '/' . $reparto->compra->anio) : '' }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Repartidor</label>
                                            <input type="text" class="form-control" value="{{ $reparto->repartidor->nombre_apellido ?? '' }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehículo</label>
                                            <input type="text" class="form-control" value="{{ $reparto->vehiculo->patente ?? '' }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fecha de Reparto</label>
                                            <input type="text" class="form-control" value="{{ $reparto->fecha_reparto ? \Carbon\Carbon::parse($reparto->fecha_reparto)->format('d/m/Y') : '' }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <input type="text" class="form-control" value="{{ $reparto->estado }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Dirección de Entrega</label>
                                            <input type="text" class="form-control" value="{{ $reparto->direccion_entrega }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Observaciones</label>
                                            <textarea class="form-control" rows="3" disabled>{{ $reparto->observaciones }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <hr>
                                <a href="{{ route('repartos.index') }}" class="btn btn-danger">Volver al listado</a>
                                @role('admin|carga')
                                <a href="{{ route('repartos.edit', $reparto->id) }}" class="btn btn-warning">Editar Reparto (Entrega)</a>
                                @endrole
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
