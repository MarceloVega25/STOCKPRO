@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Actualizar Datos del Proveedor</h1>

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
                        <form action="{{ url('/proveedores', $proveedor->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PATCH') }}

                            <div class="row">
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Nombre y Apellido</label><b>*</b>
                                                <input type="text" name="nombre_apellido" class="form-control"
                                                    value="{{ ($proveedor->nombre_apellido) }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">DNI</label><b>*</b>
                                                <input type="number" name="dni" class="form-control"
                                                    value="{{($proveedor->dni) }}" required maxlength="8">
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Fecha de Nacimiento</label><b>*</b>
                                                <input type="date" name="fecha_nacimiento" class="form-control"
                                                    value="{{ ($proveedor->fecha_nacimiento) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="genero">Género</label><b>*</b>
                                                <select name="genero" class="form-control" required>
                                                    <option value="">Seleccione...</option>
                                                    <option value="masculino" {{ trim(strtolower($proveedor->genero)) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                                    <option value="femenino" {{ trim(strtolower($proveedor->genero)) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                                    <option value="otro" {{ trim(strtolower($proveedor->genero)) == 'otro' ? 'selected' : '' }}>Otro</option>
                                                </select>
                                                @error('genero')
                                                    <small style="color: red;">*Este campo es requerido</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Email</label><b>*</b>
                                                <input type="email" name="email" class="form-control"
                                                    value="{{ ($proveedor->email) }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="">Teléfono</label><b>*</b>
                                                <input type="text" name="telefono" class="form-control"
                                                    value="{{ ($proveedor->telefono) }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="">Dirección</label><b>*</b>
                                                <input type="text" name="direccion" class="form-control"
                                                    value="{{ ($proveedor->direccion) }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Localidad/Ciudad</label><b>*</b>
                                                <input type="text" name="localidad_ciudad" class="form-control"
                                                    value="{{ ($proveedor->localidad_ciudad) }}" required>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="cv">CV</label><b>*</b>
                                                <input type="file" name="cv" class="form-control" id="cv" accept=".pdf,.doc,.docx">
                                                <small id="cv-name" class="text-muted"></small>
                                            </div>
                                            @if ($proveedor->cv)
                                                <p><a href="{{ asset('storage/' . $proveedor->cv) }}" target="_blank">Ver CV actual</a></p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="fotografia">Fotografía</label>
                                        <input type="file" name="fotografia" id="file" class="form-control" accept="image/*">
                                        <small id="file-name" class="text-muted"></small>

                                        <center>
                                            @php
                                                if (!empty($proveedor->fotografia) && file_exists(public_path('storage/' . $proveedor->fotografia))) {
                                                    $fotoPath = asset('storage/' . $proveedor->fotografia);
                                                } else {
                                                    $avatarPath = 'images/' . strtolower($proveedor->genero) . '.jpg';
                                                    $fotoPath = asset($avatarPath);
                                                }
                                            @endphp

                                            <img id="preview-image" src="{{ $fotoPath }}" class="img-thumbnail" width="150">
                                        </center>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <hr>
                                    <div class="form-group">
                                        <a href="{{ route('proveedores.index') }}" class="btn btn-danger">Cancelar</a>
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

    <script>
        document.getElementById('cv').addEventListener('change', function(event) {
            var file = event.target.files[0];
            document.getElementById('cv-name').textContent = file ? "" + file.name : "";
        });

        document.getElementById('file').addEventListener('change', function(event) {
            var file = event.target.files[0];
            if (file) {
                document.getElementById('file-name').textContent = "" + file.name;
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>

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
