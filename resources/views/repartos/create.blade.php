@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <h1>Creación de un nuevo Reparto (Entrega)</h1>

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
                    <form action="{{ route('repartos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Compra</label><b>*</b>
                                            <select name="compra_id" class="form-control" required>
                                                <option value="">Seleccione...</option>
                                                @foreach ($compras as $compra)
                                                    <option value="{{ $compra->id }}" {{ old('compra_id') == $compra->id ? 'selected' : '' }}>
                                                        {{ $compra->numero }}/{{ $compra->anio }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('compra_id')
                                                <small style="color: red;">*Este campo es requerido</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Repartidor</label><b>*</b>
                                            <select name="repartidor_id" class="form-control" required>
                                                <option value="">Seleccione...</option>
                                                @foreach ($repartidores as $repartidor)
                                                    <option value="{{ $repartidor->id }}" {{ old('repartidor_id') == $repartidor->id ? 'selected' : '' }}>
                                                        {{ $repartidor->nombre_apellido }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('repartidor_id')
                                                <small style="color: red;">*Este campo es requerido</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vehículo</label>
                                            <select name="vehiculo_id" class="form-control">
                                                <option value="">Sin vehículo</option>
                                                @foreach ($vehiculos as $vehiculo)
                                                    <option value="{{ $vehiculo->id }}" {{ old('vehiculo_id') == $vehiculo->id ? 'selected' : '' }}>
                                                        {{ $vehiculo->patente ?? ('ID: ' . $vehiculo->id) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('vehiculo_id')
                                                <small style="color: red;">*Selección inválida</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fecha de Reparto</label><b>*</b>
                                            <input type="date" name="fecha_reparto" class="form-control" value="{{ old('fecha_reparto') }}" required>
                                            @error('fecha_reparto')
                                                <small style="color: red;">*Este campo es requerido</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Estado</label><b>*</b>
                                            <input type="text" name="estado" class="form-control" value="{{ old('estado') }}" required maxlength="50">
                                            @error('estado')
                                                <small style="color: red;">*Este campo es requerido</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Dirección de Entrega</label><b>*</b>
                                            <input type="text" name="direccion_entrega" class="form-control" value="{{ old('direccion_entrega') }}" required maxlength="255">
                                            @error('direccion_entrega')
                                                <small style="color: red;">*Este campo es requerido</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Observaciones</label>
                                            <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones') }}</textarea>
                                            @error('observaciones')
                                                <small style="color: red;">*Dato inválido</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <div class="form-group">
                                    <a href="{{ route('repartos.index') }}" class="btn btn-danger">Cancelar</a>
                                    <button type="submit" class="btn btn-primary">Guardar Registro</button>
                                </div>
                            </div>
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
        title: 'Error en el Formulario',
        html: '{!! implode("<br>", $errors->all()) !!}',
        confirmButtonColor: '#3085d6'
    });
</script>
@endif
@endsection
