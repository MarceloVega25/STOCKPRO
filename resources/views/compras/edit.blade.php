@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Actualizar Datos de la Compra</h1>

        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                <li>{{ $error }}</li>
            </div>
        @endforeach

        <div class="row">
            <div class="col-md-11">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title"><b>ACTUALICE LOS DATOS</b></h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('compras.update', $compra->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-3">
                                    <label>Número</label><b>*</b>
                                    <input type="number" name="numero" class="form-control" value="{{ $compra->numero }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Año</label><b>*</b>
                                    <input type="number" name="anio" class="form-control" value="{{ $compra->anio }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Fecha</label>
                                    <input type="date" name="fecha" class="form-control" value="{{ $compra->fecha }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Expediente</label>
                                    <input type="text" name="comprobante" class="form-control" value="{{ $compra->comprobante }}">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Proveedor</label><b>*</b>
                                    <select name="proveedor_id" class="form-control" required>
                                        @foreach ($proveedores as $p)
                                            <option value="{{ $p->id }}" {{ $compra->proveedor_id == $p->id ? 'selected' : '' }}>
                                                {{ $p->nombre_apellido }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label>Observaciones</label>
                                <textarea name="observaciones" class="form-control">{{ $compra->observaciones }}</textarea>
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
                                            @foreach ($compra->items as $item)
                                                <tr>
                                                    <td>
                                                        <select name="producto_id[]" class="form-control" required>
                                                            @foreach ($productos as $prod)
                                                                <option value="{{ $prod->id }}" {{ $item->producto_id == $prod->id ? 'selected' : '' }}>
                                                                    {{ $prod->nombre }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="cantidad[]" class="form-control" min="1" value="{{ $item->cantidad }}" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="precio_unitario[]" class="form-control" min="0" step="0.01" value="{{ $item->precio_unitario }}" required>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group mt-4">
                                <a href="{{ route('compras.index') }}" class="btn btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-success">Actualizar Registro</button>
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
                title: 'Error en el formulario',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif
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
