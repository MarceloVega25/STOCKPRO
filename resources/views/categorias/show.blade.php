@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Datos de la Categoría</h1>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><b>Información de la Categoría</b></h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Número</label>
                                <input type="text" class="form-control" value="{{ $categoria->numero }}" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Año</label>
                                <input type="text" class="form-control" value="{{ $categoria->anio }}" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Fecha</label>
                                <input type="text" class="form-control" value="{{ $categoria->fecha_concurso ? \Carbon\Carbon::parse($categoria->fecha_concurso)->format('d/m/Y') : '' }}" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Expediente</label>
                                <input type="text" class="form-control" value="{{ $categoria->expediente }}" disabled>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label>Cliente</label>
                                <input type="text" class="form-control" value="{{ $categoria->cliente->razon_social ?? '' }}" disabled>
                            </div>
                            <div class="col-md-4">
                                <label>Tipo</label>
                                <input type="text" class="form-control" value="{{ $categoria->tipo_concurso }}" disabled>
                            </div>
                            <div class="col-md-4">
                                <label>Modalidad</label>
                                <input type="text" class="form-control" value="{{ $categoria->modalidad_concurso }}" disabled>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-3">
                                <label>Inicio Publicidad</label>
                                <input type="text" class="form-control" value="{{ $categoria->inicio_publicidad ? \Carbon\Carbon::parse($categoria->inicio_publicidad)->format('d/m/Y') : '' }}" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Cierre Publicidad</label>
                                <input type="text" class="form-control" value="{{ $categoria->cierre_publicidad ? \Carbon\Carbon::parse($categoria->cierre_publicidad)->format('d/m/Y') : '' }}" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Inicio Inscripción</label>
                                <input type="text" class="form-control" value="{{ $categoria->inicio_inscripcion ? \Carbon\Carbon::parse($categoria->inicio_inscripcion)->format('d/m/Y') : '' }}" disabled>
                            </div>
                            <div class="col-md-3">
                                <label>Cierre Inscripción</label>
                                <input type="text" class="form-control" value="{{ $categoria->cierre_inscripcion ? \Carbon\Carbon::parse($categoria->cierre_inscripcion)->format('d/m/Y') : '' }}" disabled>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Observaciones</label>
                            <textarea class="form-control" disabled>{{ $categoria->observaciones }}</textarea>
                        </div>

                        <hr>

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label>Ventas</label>
                                <textarea class="form-control" disabled>{{ $categoria->asignaturas->pluck('nombre')->implode(', ') }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label>Departamentos</label>
                                <textarea class="form-control" disabled>{{ $categoria->departamentos->pluck('nombre')->implode(', ') }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label>Carreras</label>
                                <textarea class="form-control" disabled>{{ $categoria->carreras->pluck('nombre')->implode(', ') }}</textarea>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Repartos Titulares</label>
                                @forelse ($categoria->docentesTitulares as $reparto)
                                    <input type="text" class="form-control mb-2" value="{{ $reparto->nombre_apellido }}, DNI: {{ $reparto->dni }}, Institución: {{ $reparto->institucion }}" disabled>
                                @empty
                                    <input type="text" class="form-control" value="No hay repartos titulares registrados" disabled>
                                @endforelse
                            </div>

                            <div class="col-md-6">
                                <label>Repartos Suplentes</label>
                                @forelse ($categoria->docentesSuplentes as $reparto)
                                    <input type="text" class="form-control mb-2" value="{{ $reparto->nombre_apellido }}, DNI: {{ $reparto->dni }}, Institución: {{ $reparto->institucion }}" disabled>
                                @empty
                                    <input type="text" class="form-control" value="No hay repartos suplentes registrados" disabled>
                                @endforelse
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Vehículos Titulares</label>
                                @forelse ($categoria->estudiantesTitulares as $vehiculo)
                                    <input type="text" class="form-control mb-2" value="{{ $vehiculo->nombre_apellido }}, DNI: {{ $vehiculo->dni }}, Institución: {{ $vehiculo->institucion }}" disabled>
                                @empty
                                    <input type="text" class="form-control" value="No hay vehículos titulares registrados" disabled>
                                @endforelse
                            </div>

                            <div class="col-md-6">
                                <label>Vehículos Suplentes</label>
                                @forelse ($categoria->estudiantesSuplentes as $vehiculo)
                                    <input type="text" class="form-control mb-2" value="{{ $vehiculo->nombre_apellido }}, DNI: {{ $vehiculo->dni }}, Institución: {{ $vehiculo->institucion }}" disabled>
                                @empty
                                    <input type="text" class="form-control" value="No hay vehículos suplentes registrados" disabled>
                                @endforelse
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <label>Vendedores</label>
                                @forelse ($categoria->veedores as $vendedor)
                                    <input type="text" class="form-control mb-2" value="{{ $vendedor->nombre_apellido }}, DNI: {{ $vendedor->dni }}, Cargo: {{ $vendedor->cargo }}" disabled>
                                @empty
                                    <input type="text" class="form-control" value="No hay vendedores registrados" disabled>
                                @endforelse
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label>Productos</label>
                                @forelse ($categoria->productos as $producto)
                                    <input type="text" class="form-control mb-2" value="{{ $producto->nombre }}, Precio: {{ $producto->precio }}, Stock: {{ $producto->stock }}" disabled>
                                @empty
                                    <input type="text" class="form-control" value="No hay productos registrados" disabled>
                                @endforelse
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label>Designado</label>
                                <input type="text" class="form-control" value="{{ $categoria->designado ? $categoria->designado->nombre . ', Precio: ' . $categoria->designado->precio . ', Stock: ' . $categoria->designado->stock : 'Sin designar' }}" disabled>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <hr>
                                <a href="{{ route('categorias.index') }}" class="btn btn-danger">Volver al listado</a>
                                @role('admin|carga')
                                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-warning">Editar Categoría</a>
                                @endrole
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
