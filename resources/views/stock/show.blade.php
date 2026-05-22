@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Datos del Stock</h1>

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
                                    <input type="text" class="form-control" value="{{ $producto->nombre }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Stock</label>
                                    <input type="text" class="form-control" value="{{ $producto->stock }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Stock Mínimo</label>
                                    <input type="text" class="form-control" value="{{ $producto->stock_minimo }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <hr>
                                <a href="{{ route('stock.index') }}" class="btn btn-danger">Volver al listado</a>
                                @role('admin|carga')
                                 <a href="{{ route('stock.edit', $producto->id) }}" class="btn btn-warning">Editar Stock</a>
                            @endrole
                                </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
