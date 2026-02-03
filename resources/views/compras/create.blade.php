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
                                    <label>Fecha</label>
                                    <input type="date" name="fecha_adscripcion" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Expediente</label>
                                    <input type="text" name="expediente" class="form-control">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Cliente</label><b>*</b>
                                    <select name="cliente_id" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        @foreach ($clientes as $c)
                                            <option value="{{ $c->id }}">{{ $c->razon_social }} , ({{ $c->cuit }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="tipo_adscripcion">Tipo</label><b>*</b>
                                    <select name="tipo_adscripcion" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        <option value="Abierto">Abierto</option>
                                        <option value="Cerrado">Cerrado</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Modalidad</label><b>*</b>
                                    <select name="modalidad_adscripcion" class="form-control" required>
                                        <option value="">Seleccione</option>
                                        <option value="Presencial">Presencial</option>
                                        <option value="Virtual">Virtual</option>
                                        <option value="Mixta">Mixta</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-3">
                                    <label>Inicio Publicidad</label>
                                    <input type="date" name="inicio_publicidad" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Cierre Publicidad</label>
                                    <input type="date" name="cierre_publicidad" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Inicio Inscripción</label>
                                    <input type="date" name="inicio_inscripcion" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <label>Cierre Inscripción</label>
                                    <input type="date" name="cierre_inscripcion" class="form-control">
                                </div>
                            </div>

                            <div class="form-group mt-3">
                                <label>Observaciones</label>
                                <textarea name="observaciones" class="form-control"></textarea>
                            </div>
                            <hr>

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <label>Asignaturas</label>
                                    <select name="asignaturas[]" class="form-control select2" multiple>
                                        @foreach ($asignaturas as $a)
                                            <option value="{{ $a->id }}">{{ $a->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Departamentos</label>
                                    <select name="departamentos[]" class="form-control select2" multiple>
                                        @foreach ($departamentos as $d)
                                            <option value="{{ $d->id }}">{{ $d->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label>Carreras</label>
                                    <select name="carreras[]" class="form-control select2" multiple>
                                        @foreach ($carreras as $c)
                                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Docentes Titulares</label>
                                    <select name="docentes_titulares[]" class="form-control select2" multiple>
                                        @foreach ($docentes as $d)
                                            <option value="{{ $d->id }}">{{ $d->nombre_apellido }}, DNI: {{ $d->dni }}, Institución: {{ $d->institucion }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>Docentes Suplentes</label>
                                    <select name="docentes_suplentes[]" class="form-control select2" multiple>
                                        @foreach ($docentes as $d)
                                            <option value="{{ $d->id }}">{{ $d->nombre_apellido }}, DNI: {{ $d->dni }}, Institución: {{ $d->institucion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Estudiantes Titulares</label>
                                    <select name="estudiantes_titulares[]" class="form-control select2" multiple>
                                        @foreach ($estudiantes as $e)
                                            <option value="{{ $e->id }}">{{ $e->nombre_apellido }}, DNI: {{ $e->dni }}, Institución: {{ $e->institucion }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label>Estudiantes Suplentes</label>
                                    <select name="estudiantes_suplentes[]" class="form-control select2" multiple>
                                        @foreach ($estudiantes as $e)
                                            <option value="{{ $e->id }}">{{ $e->nombre_apellido }}, DNI: {{ $e->dni }}, Institución: {{ $e->institucion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Veedores</label>
                                    <select name="veedores[]" class="form-control select2" multiple>
                                        @foreach ($veedores as $v)
                                            <option value="{{ $v->id }}">{{ $v->nombre_apellido }}, DNI: {{ $v->dni }}, Cargo: {{ $v->cargo }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label>Proveedores</label>
                                    <select name="proveedores[]" class="form-control select2" multiple>
                                        @foreach ($proveedores as $p)
                                            <option value="{{ $p->id }}">{{ $p->nombre_apellido }}, DNI: {{ $p->dni }}, Email: {{ $p->email }}</option>
                                        @endforeach
                                    </select>
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
