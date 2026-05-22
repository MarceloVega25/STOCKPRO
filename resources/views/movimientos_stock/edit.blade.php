@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <h1>Editar Movimiento de Stock</h1>

    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            <li>{{ $error }}</li>
        </div>
    @endforeach

    <div class="row">
        <div class="col-md-11">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title"><b>MODIFIQUE LOS DATOS</b></h3>
                </div>

                <div class="card-body">
                    <form action="{{ url('/movimientos_stock/' . $movimiento_stock->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Producto</label><b>*</b>
                                    <select name="producto_id" class="form-control" required>
                                        @foreach ($productos as $p)
                                            <option value="{{ $p->id }}" {{ old('producto_id', $movimiento_stock->producto_id) == $p->id ? 'selected' : '' }}>
                                                {{ $p->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo</label><b>*</b>
                                    <select name="tipo" class="form-control" required>
                                        <option value="entrada" {{ old('tipo', $movimiento_stock->tipo) == 'entrada' ? 'selected' : '' }}>Entrada</option>
                                        <option value="salida" {{ old('tipo', $movimiento_stock->tipo) == 'salida' ? 'selected' : '' }}>Salida</option>
                                        <option value="ajuste" {{ old('tipo', $movimiento_stock->tipo) == 'ajuste' ? 'selected' : '' }}>Ajuste</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Cantidad</label><b>*</b>
                                    <input type="number" name="cantidad" class="form-control" value="{{ old('cantidad', $movimiento_stock->cantidad) }}" min="1" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="datetime-local" name="fecha" class="form-control" value="{{ old('fecha', optional($movimiento_stock->fecha)->format('Y-m-d\\TH:i')) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Motivo</label>
                                    <input type="text" name="motivo" class="form-control" value="{{ old('motivo', $movimiento_stock->motivo) }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <div class="form-group">
                                    <a href="{{ route('movimientos_stock.index') }}" class="btn btn-danger">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
