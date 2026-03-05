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
                            <input type="text" class="form-control" value="{{ $compra->fecha_compra ? \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y') : '' }}" disabled>
                        </div>
                        <div class="col-md-3">
                            <label>Expediente</label>
                            <input type="text" class="form-control" value="{{ $compra->expediente }}" disabled>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label>Cliente</label>
                            <input type="text" class="form-control" value="{{ $compra->cliente->razon_social ?? '' }}" disabled>
                        </div>
                        <div class="col-md-4">
                            <label>Tipo</label>
                            <input type="text" class="form-control" value="{{ $compra->tipo_compra }}" disabled>
                        </div>
                        <div class="col-md-4">
                            <label>Modalidad</label>
                            <input type="text" class="form-control" value="{{ $compra->modalidad_compra }}" disabled>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label>Inicio Publicidad</label>
                            <input type="text" class="form-control" value="{{ $compra->inicio_publicidad ? \Carbon\Carbon::parse($compra->inicio_publicidad)->format('d/m/Y') : '' }}" disabled>
                        </div>
                        <div class="col-md-3">
                            <label>Cierre Publicidad</label>
                            <input type="text" class="form-control" value="{{ $compra->cierre_publicidad ? \Carbon\Carbon::parse($compra->cierre_publicidad)->format('d/m/Y') : '' }}" disabled>
                        </div>
                        <div class="col-md-3">
                            <label>Inicio Inscripción</label>
                            <input type="text" class="form-control" value="{{ $compra->inicio_inscripcion ? \Carbon\Carbon::parse($compra->inicio_inscripcion)->format('d/m/Y') : '' }}" disabled>
                        </div>
                        <div class="col-md-3">
                            <label>Cierre Inscripción</label>
                            <input type="text" class="form-control" value="{{ $compra->cierre_inscripcion ? \Carbon\Carbon::parse($compra->cierre_inscripcion)->format('d/m/Y') : '' }}" disabled>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label>Observaciones</label>
                        <textarea class="form-control" disabled>{{ $compra->observaciones }}</textarea>
                    </div>

                    <hr>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label>Ventas</label>
                            <select class="form-control select2" multiple disabled>
                                @foreach ($compra->ventas as $a)
                                    <option selected>{{ $a->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Departamentos</label>
                            <select class="form-control select2" multiple disabled>
                                @foreach ($compra->departamentos as $d)
                                    <option selected>{{ $d->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Carreras</label>
                            <select class="form-control select2" multiple disabled>
                                @foreach ($compra->carreras as $c)
                                    <option selected>{{ $c->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>Repartos Titulares</label>
                            @foreach ($compra->repartosTitulares as $reparto)
                                <input type="text" class="form-control mb-2" value="{{ $reparto->nombre_apellido }}, DNI: {{ $reparto->dni }}, Institución: {{ $reparto->institucion }}" disabled>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <label>Repartos Suplentes</label>
                            @foreach ($compra->repartosSuplentes as $reparto)
                                <input type="text" class="form-control mb-2" value="{{ $reparto->nombre_apellido }}, DNI: {{ $reparto->dni }}, Institución: {{ $reparto->institucion }}" disabled>
                            @endforeach
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>Vehículos Titulares</label>
                            @foreach ($compra->vehiculosTitulares as $vehiculo)
                                <input type="text" class="form-control mb-2" value="{{ $vehiculo->nombre_apellido }}, DNI: {{ $vehiculo->dni }}, Institución: {{ $vehiculo->institucion }}" disabled>
                            @endforeach
                        </div>
                        <div class="col-md-6">
                            <label>Vehículos Suplentes</label>
                            @foreach ($compra->vehiculosSuplentes as $vehiculo)
                                <input type="text" class="form-control mb-2" value="{{ $vehiculo->nombre_apellido }}, DNI: {{ $vehiculo->dni }}, Institución: {{ $vehiculo->institucion }}" disabled>
                            @endforeach
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label>Vendedores</label>
                            @foreach ($compra->vendedores as $vendedor)
                                <input type="text" class="form-control mb-2" value="{{ $vendedor->nombre_apellido }}, DNI: {{ $vendedor->dni }}, Cargo: {{ $vendedor->cargo }}" disabled>
                            @endforeach
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label>Proveedores</label>
                            @foreach ($compra->proveedores as $proveedor)
                                <input type="text" class="form-control mb-2" value="{{ $proveedor->nombre_apellido }}, DNI: {{ $proveedor->dni }}, Email: {{ $proveedor->email }}" disabled>
                            @endforeach
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label>Designado</label>
                            <input type="text" class="form-control"
                                   value="{{ $compra->designado ? $compra->designado->nombre_apellido . ', DNI: ' . $compra->designado->dni . ', Email: ' . $compra->designado->email : 'Sin designar' }}" disabled>
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
