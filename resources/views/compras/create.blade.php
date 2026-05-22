@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Creación de una nueva Compra</h1>

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
                        <form action="{{ route('compras.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-3">
                                    <label>Número</label><b>*</b>
                                    <input type="number" name="numero" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Año</label><b>*</b>
                                    <input type="number" name="anio" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Fecha</label><b>*</b>
                                    <input type="date" name="fecha" class="form-control" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Comprobante</label>
                                    <input type="text" name="comprobante" class="form-control">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Proveedor</label><b>*</b>
                                    <select name="proveedor_id" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        @foreach ($proveedores as $p)
                                            <option value="{{ $p->id }}">{{ $p->nombre_apellido }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label>Observaciones</label>
                                <textarea name="observaciones" class="form-control"></textarea>
                            </div>
                            <hr>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label>Items</label><b>*</b>
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th style="width: 120px;">Cantidad</th>
                                                <th style="width: 160px;">Precio Unitario</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 0; $i < 3; $i++)
                                                <tr>
                                                    <td>
                                                        <select name="producto_id[]" class="form-control" {{ $i === 0 ? 'required' : '' }}>
                                                            <option value="">Seleccione</option>
                                                            @foreach ($productos as $prod)
                                                                <option value="{{ $prod->id }}">{{ $prod->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="cantidad[]" class="form-control" min="1" value="1" {{ $i === 0 ? 'required' : '' }}>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="precio_unitario[]" class="form-control" min="0" step="0.01" value="0" {{ $i === 0 ? 'required' : '' }}>
                                                    </td>
                                                </tr>
                                            @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group mt-3">
                                <a href="{{ route('compras.index') }}" class="btn btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar Compra</button>
                            </div>
                        </form>
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
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                placeholder: 'Seleccione una o más opciones',
                allowClear: true
            });
        });
    </script>
@endsection
