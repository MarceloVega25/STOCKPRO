@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Detalle de Auditoría</h1>

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
                                    <label>Tabla Afectada</label>
                                    <input type="text" class="form-control"
                                        value="{{ ucfirst($auditoria->tabla_afectada) }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Operación</label>
                                    <input type="text" class="form-control"
                                        value="{{ strtoupper($auditoria->operacion) }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>ID del Registro</label>
                                    <input type="text" class="form-control"
                                        value="{{ $auditoria->registro_id }}" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Usuario</label>
                                    <input type="text" class="form-control"
                                        value="{{ $auditoria->usuario->name ?? 'Desconocido' }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Fecha</label>
                                    <input type="text" class="form-control" value="{{ $auditoria->fecha }}" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Datos Anteriores</label>
                            <textarea class="form-control" rows="6" disabled>{{ json_encode(json_decode($auditoria->datos_anteriores), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Datos Nuevos</label>
                            <textarea class="form-control" rows="6" disabled>{{ json_encode(json_decode($auditoria->datos_nuevos), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</textarea>
                        </div>

                        <!-- Botones -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <hr>
                                <a href="{{ route('auditorias.index') }}" class="btn btn-danger">Volver al listado</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
