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
                                    <input type="date" name="fecha_adscripcion" class="form-control" value="{{ $compra->fecha_adscripcion }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Expediente</label>
                                    <input type="text" name="expediente" class="form-control" value="{{ $compra->expediente }}">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Cliente</label><b>*</b>
                                    <select name="cliente_id" class="form-control" required>
                                        @foreach ($clientes as $c)
                                            <option value="{{ $c->id }}" {{ $compra->cliente_id == $c->id ? 'selected' : '' }}>
                                                {{ $c->razon_social }} ({{ $c->cuit }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Tipo</label><b>*</b>
                                    <select name="tipo_adscripcion" class="form-control" required>
                                        <option value="Abierto" {{ $compra->tipo_adscripcion == 'Abierto' ? 'selected' : '' }}>Abierto</option>
                                        <option value="Cerrado" {{ $compra->tipo_adscripcion == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Modalidad</label><b>*</b>
                                    <select name="modalidad_adscripcion" class="form-control" required>
                                        <option value="Presencial" {{ $compra->modalidad_adscripcion == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                                        <option value="Virtual" {{ $compra->modalidad_adscripcion == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                                        <option value="Mixta" {{ $compra->modalidad_adscripcion == 'Mixta' ? 'selected' : '' }}>Mixta</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label>Inicio Publicidad</label>
                                    <input type="date" name="inicio_publicidad" class="form-control" value="{{ $compra->inicio_publicidad }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Cierre Publicidad</label>
                                    <input type="date" name="cierre_publicidad" class="form-control" value="{{ $compra->cierre_publicidad }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Inicio Inscripción</label>
                                    <input type="date" name="inicio_inscripcion" class="form-control" value="{{ $compra->inicio_inscripcion }}">
                                </div>
                                <div class="col-md-3">
                                    <label>Cierre Inscripción</label>
                                    <input type="date" name="cierre_inscripcion" class="form-control" value="{{ $compra->cierre_inscripcion }}">
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label>Observaciones</label>
                                <textarea name="observaciones" class="form-control">{{ $compra->observaciones }}</textarea>
                            </div>

                            <hr>

                            @php
                                function isSelected($collection, $id) {
                                    return $collection && $collection->contains('id', $id) ? 'selected' : '';
                                }
                            @endphp

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Asignaturas</label>
                                    <select name="asignaturas[]" class="form-control select2" multiple>
                                        @foreach ($asignaturas as $a)
                                            <option value="{{ $a->id }}" {{ isSelected($compra->asignaturas, $a->id) }}>{{ $a->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Departamentos</label>
                                    <select name="departamentos[]" class="form-control select2" multiple>
                                        @foreach ($departamentos as $d)
                                            <option value="{{ $d->id }}" {{ isSelected($compra->departamentos, $d->id) }}>{{ $d->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Carreras</label>
                                    <select name="carreras[]" class="form-control select2" multiple>
                                        @foreach ($carreras as $c)
                                            <option value="{{ $c->id }}" {{ isSelected($compra->carreras, $c->id) }}>{{ $c->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Docentes Titulares</label>
                                    <select name="docentes_titulares[]" class="form-control select2" multiple>
                                        @foreach ($docentes as $d)
                                            <option value="{{ $d->id }}" {{ isSelected($compra->docentesTitulares, $d->id) }}>{{ $d->nombre_apellido }}, DNI: {{ $d->dni }}, Institución: {{ $d->institucion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Docentes Suplentes</label>
                                    <select name="docentes_suplentes[]" class="form-control select2" multiple>
                                        @foreach ($docentes as $d)
                                            <option value="{{ $d->id }}" {{ isSelected($compra->docentesSuplentes, $d->id) }}>{{ $d->nombre_apellido }}, DNI: {{ $d->dni }}, Institución: {{ $d->institucion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Estudiantes Titulares</label>
                                    <select name="estudiantes_titulares[]" class="form-control select2" multiple>
                                        @foreach ($estudiantes as $e)
                                            <option value="{{ $e->id }}" {{ isSelected($compra->estudiantesTitulares, $e->id) }}>{{ $e->nombre_apellido }}, DNI: {{ $e->dni }}, Institución: {{ $e->institucion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label>Estudiantes Suplentes</label>
                                    <select name="estudiantes_suplentes[]" class="form-control select2" multiple>
                                        @foreach ($estudiantes as $e)
                                            <option value="{{ $e->id }}" {{ isSelected($compra->estudiantesSuplentes, $e->id) }}>{{ $e->nombre_apellido }}, DNI: {{ $e->dni }}, Institución: {{ $e->institucion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Veedores</label>
                                    <select name="veedores[]" class="form-control select2" multiple>
                                        @foreach ($veedores as $v)
                                            <option value="{{ $v->id }}" {{ isSelected($compra->veedores, $v->id) }}>{{ $v->nombre_apellido }}, DNI: {{ $v->dni }}, Cargo: {{ $v->cargo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label>Proveedores</label>
                                    <select name="proveedores[]" class="form-control select2" multiple>
                                        @foreach ($proveedores as $p)
                                            <option value="{{ $p->id }}" {{ isSelected($compra->proveedores, $p->id) }}>{{ $p->nombre_apellido }}, DNI: {{ $p->dni }}, Email: {{ $p->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label>Designado</label>
                                    <select name="designado_id" class="form-control">
                                        <option value="">Seleccione un proveedor designado</option>
                                        @foreach ($compra->proveedores as $p)
                                            <option value="{{ $p->id }}" {{ $compra->designado_id == $p->id ? 'selected' : '' }}>
                                                {{ $p->nombre_apellido }}, DNI: {{ $p->dni }}, Email: {{ $p->email }}
                                            </option>
                                        @endforeach
                                    </select>
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
