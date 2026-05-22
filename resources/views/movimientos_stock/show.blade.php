@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Datos del Movimiento de Stock</h1>

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
                                    <label>Producto</label>
                                    <input type="text" class="form-control" value="{{ optional($movimiento_stock->producto)->nombre }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="text" class="form-control" value="{{ optional($movimiento_stock->fecha)->format('d/m/Y H:i') }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <input type="text" class="form-control" value="{{ $movimiento_stock->tipo }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cantidad</label>
                                    <input type="text" class="form-control" value="{{ $movimiento_stock->cantidad }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Motivo</label>
                                    <input type="text" class="form-control" value="{{ $movimiento_stock->motivo }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <hr>
                                <a href="{{ route('movimientos_stock.index') }}" class="btn btn-danger">Volver al listado</a>
                                @role('admin|carga')
                                <a href="{{ route('movimientos_stock.edit', $movimiento_stock->id) }}" class="btn btn-warning">Editar Movimiento</a>
                            @endrole
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
