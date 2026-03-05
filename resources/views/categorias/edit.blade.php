@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Actualizar Datos de la Categoría</h1>

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
                        <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-3">
                                    <label>Número</label><b>*</b>
                                    <input type="number" name="numero" class="form-control" value="{{ $categoria->numero }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Año</label><b>*</b>
                                    <input type="number" name="anio" class="form-control" value="{{ $categoria->anio }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label>Fecha</label>
                                    <input type="date" name="fecha_concurso" class="form-control" value="{{ $categoria->fecha_concurso }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Expediente</label>
                                    <input type="text" name="expediente" class="form-control" value="{{ $categoria->expediente }}">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Cliente</label><b>*</b>
                                    <select name="cliente_id" class="form-control" required>
                                        <option value="">Seleccione un Cliente</option>
                                        @foreach ($clientes as $c)
                                            <option value="{{ $c->id }}" {{ $categoria->cliente_id == $c->id ? 'selected' : '' }}>
                                                {{ $c->razon_social }} ({{ $c->cuit }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Tipo</label><b>*</b>
                                    <select name="tipo_concurso" class="form-control" required>
                                        <option value="Abierto" {{ $categoria->tipo_concurso == 'Abierto' ? 'selected' : '' }}>Abierto</option>
                                        <option value="Cerrado" {{ $categoria->tipo_concurso == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Modalidad</label><b>*</b>
                                    <select name="modalidad_concurso" class="form-control" required>
                                        <option value="Presencial" {{ $categoria->modalidad_concurso == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                                        <option value="Virtual" {{ $categoria->modalidad_concurso == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                                        <option value="Mixta" {{ $categoria->modalidad_concurso == 'Mixta' ? 'selected' : '' }}>Mixta</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label>Inicio Publicidad</label>
                                    <input type="date" name="inicio_publicidad" class="form-control" value="{{ $categoria->inicio_publicidad }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Cierre Publicidad</label>
                                    <input type="date" name="cierre_publicidad" class="form-control" value="{{ $categoria->cierre_publicidad }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Inicio Inscripción</label>
                                    <input type="date" name="inicio_inscripcion" class="form-control" value="{{ $categoria->inicio_inscripcion }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Cierre Inscripción</label>
                                    <input type="date" name="cierre_inscripcion" class="form-control" value="{{ $categoria->cierre_inscripcion }}">
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label>Observaciones</label>
                                <textarea name="observaciones" class="form-control">{{ $categoria->observaciones }}</textarea>
                            </div>

                            <hr>

                            @php
                                function isSelected($collection, $id) {
                                    return in_array($id, $collection->pluck('id')->toArray()) ? 'selected' : '';
                                }
                            @endphp

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Ventas</label>
                                    <select name="ventas[]" class="form-control select2" multiple>
                                        @foreach ($ventas as $a)
                                            <option value="{{ $a->id }}" {{ isSelected($categoria->ventas, $a->id) }}>{{ $a->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Departamentos</label>
                                    <select name="departamentos[]" class="form-control select2" multiple>
                                        @foreach ($departamentos as $d)
                                            <option value="{{ $d->id }}" {{ isSelected($categoria->departamentos, $d->id) }}>{{ $d->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Carreras</label>
                                    <select name="carreras[]" class="form-control select2" multiple>
                                        @foreach ($carreras as $c)
                                            <option value="{{ $c->id }}" {{ isSelected($categoria->carreras, $c->id) }}>{{ $c->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Repartos Titulares</label>
                                    <select name="repartos_titulares[]" class="form-control select2" multiple>
                                        @foreach ($repartos as $d)
                                            <option value="{{ $d->id }}" {{ isSelected($categoria->repartosTitulares, $d->id) }}>{{ $d->nombre_apellido }}, DNI: {{ $d->dni }}, Institución: {{ $d->institucion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Repartos Suplentes</label>
                                    <select name="repartos_suplentes[]" class="form-control select2" multiple>
                                        @foreach ($repartos as $d)
                                            <option value="{{ $d->id }}" {{ isSelected($categoria->repartosSuplentes, $d->id) }}>{{ $d->nombre_apellido }}, DNI: {{ $d->dni }}, Institución: {{ $d->institucion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Vehículos Titulares</label>
                                    <select name="vehiculos_titulares[]" class="form-control select2" multiple>
                                        @foreach ($vehiculos as $e)
                                            <option value="{{ $e->id }}" {{ isSelected($categoria->vehiculosTitulares, $e->id) }}>{{ $e->nombre_apellido }}, DNI: {{ $e->dni }}, Institución: {{ $e->institucion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Vehículos Suplentes</label>
                                    <select name="vehiculos_suplentes[]" class="form-control select2" multiple>
                                        @foreach ($vehiculos as $e)
                                            <option value="{{ $e->id }}" {{ isSelected($categoria->vehiculosSuplentes, $e->id) }}>{{ $e->nombre_apellido }}, DNI: {{ $e->dni }}, Institución: {{ $e->institucion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Vendedores</label>
                                    <select name="vendedores[]" class="form-control select2" multiple>
                                        @foreach ($vendedores as $v)
                                            <option value="{{ $v->id }}" {{ isSelected($categoria->vendedores, $v->id) }}>{{ $v->nombre_apellido }}, DNI: {{ $v->dni }}, Cargo: {{ $v->cargo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label>Productos</label>
                                    <select name="productos[]" class="form-control select2" multiple>
                                        @foreach ($productos as $p)
                                            <option value="{{ $p->id }}" {{ isSelected($categoria->productos, $p->id) }}>{{ $p->nombre }}, Precio: {{ $p->precio }}, Stock: {{ $p->stock }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label>Designado</label>
                                    <select name="designado_id" class="form-control">
                                        <option value="">Seleccione un producto designado</option>
                                        @foreach ($categoria->productos as $p)
                                            <option value="{{ $p->id }}" {{ $categoria->designado_id == $p->id ? 'selected' : '' }}>
                                                {{ $p->nombre }}, Precio: {{ $p->precio }}, Stock: {{ $p->stock }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <hr>

                            <div class="form-group mt-4">
                                <a href="{{ route('categorias.index') }}" class="btn btn-danger">Cancelar</a>
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
