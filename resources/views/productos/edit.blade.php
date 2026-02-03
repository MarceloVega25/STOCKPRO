@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Actualizar Datos del Producto</h1>

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
                        <form action="{{ url('/productos', $producto->id) }}" method="POST">
                            @csrf
                            {{ method_field('PATCH') }} 

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nombre</label><b>*</b>
                                        <input type="text" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Precio</label><b>*</b>
                                        <input type="number" step="0.01" name="precio" class="form-control" value="{{ $producto->precio }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Stock</label><b>*</b>
                                        <input type="number" name="stock" class="form-control" value="{{ $producto->stock }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <textarea name="descripcion" class="form-control" rows="3">{{ $producto->descripcion }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Categoría (ID)</label>
                                        <input type="number" name="categoria_id" class="form-control" value="{{ $producto->categoria_id }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <div class="form-group">
                                        <a href="{{ route('productos.index') }}" class="btn btn-danger">Cancelar</a>
                                        <button type="submit" class="btn btn-success">Actualizar Registro</button>
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
