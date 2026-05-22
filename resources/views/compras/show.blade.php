@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <h1>Datos de la Compra</h1>

    <div class="row">
        <div class="col-md-11">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title"><b>Información de la Compra</b></h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label>Número</label>
                            <input type="text" class="form-control" value="{{ $compra->numero }}" disabled>
                        </div>
                        <div class="col-md-3">
                            <label>Año</label>
                            <input type="text" class="form-control" value="{{ $compra->anio }}" disabled>
                        </div>
                        <div class="col-md-3">
                            <label>Fecha</label>
                            <input type="text" class="form-control" value="{{ $compra->fecha ? \Carbon\Carbon::parse($compra->fecha)->format('d/m/Y') : '' }}" disabled>
                        </div>
                        <div class="col-md-3">
                            <label>Comprobante</label>
                            <input type="text" class="form-control" value="{{ $compra->comprobante }}" disabled>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label>Proveedor</label>
                            <input type="text" class="form-control" value="{{ $compra->proveedor->nombre_apellido ?? '' }}" disabled>
                        </div>
                        <div class="col-md-4">
                            <label>Total</label>
                            <input type="text" class="form-control" value="{{ number_format((float) $compra->total, 2, ',', '.') }}" disabled>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label>Observaciones</label>
                        <textarea class="form-control" disabled>{{ $compra->observaciones }}</textarea>
                    </div>

                    <hr>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label>Items</label>
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($compra->items as $item)
                                        <tr>
                                            <td>{{ $item->producto->nombre ?? '-' }}</td>
                                            <td>{{ $item->cantidad }}</td>
                                            <td>{{ number_format((float) $item->precio_unitario, 2, ',', '.') }}</td>
                                            <td>{{ number_format((float) $item->subtotal, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <hr>
                            <a href="{{ route('compras.index') }}" class="btn btn-danger">Volver al listado</a>
                            @role('admin|carga')
                                <a href="{{ route('compras.edit', $compra->id) }}" class="btn btn-warning">Editar Compra</a>
                            @endrole
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2({
            width: '100%',
            placeholder: 'Seleccione una o más opciones',
            allowClear: true
        });
    });
</script>
@endsection
