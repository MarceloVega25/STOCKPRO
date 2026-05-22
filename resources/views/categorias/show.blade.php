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
                            <div class="col-md-6">
                                <label>Nombre</label>
                                <input type="text" class="form-control" value="{{ $categoria->nombre }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label>Descripción</label>
                                <input type="text" class="form-control" value="{{ $categoria->descripcion ?? '' }}" disabled>
                            </div>
                        </div>

                        <hr>

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
