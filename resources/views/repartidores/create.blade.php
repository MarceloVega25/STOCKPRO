@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <h1>Creación de un nuevo Repartidor</h1>

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
                    <form action="{{ route('repartidores.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nombre y Apellido</label><b>*</b>
                                            <input type="text" name="nombre_apellido" class="form-control"
                                                value="{{ old('nombre_apellido') }}" placeholder="Ingrese su Nombre y Apellido" required>
                                            @error('nombre_apellido')
                                                <small style="color: red;">*Este campo es requerido</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>DNI</label><b>*</b>
                                            <input type="number" name="dni" class="form-control"
                                                value="{{ request('dni') ?? old('dni') }}" placeholder="Ingrese su DNI" required maxlength="8">
                                            @error('dni')
                                                <small style="color: red;">*Este campo es requerido</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Fecha de Nacimiento</label><b>*</b>
                                            <input type="date" name="fecha_nacimiento" class="form-control"
                                                value="{{ old('fecha_nacimiento') }}" required>
                                            @error('fecha_nacimiento')
                                                <small style="color: red;">*Este campo es requerido</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Género</label><b>*</b>
                                            <select name="genero" class="form-control" required>
                                                <option value="">Seleccione...</option>
                                                <option value="masculino">Masculino</option>
                                                <option value="femenino">Femenino</option>
                                                <option value="otro">Otro</option>
                                            </select>
                                            @error('genero')
                                                <small style="color: red;">*Este campo es requerido</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Email</label><b>*</b>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email') }}" placeholder="Ingrese su Email" required>
                                            @error('email')
                                                <small style="color: red;">*Este campo es requerido</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Teléfono</label><b>*</b>
                                            <input type="number" name="telefono" class="form-control"
                                                value="{{ old('telefono') }}" placeholder="Ingrese su Teléfono" required maxlength="10">
                                            @error('telefono')
                                                <small style="color: red;">*Este campo es requerido</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Institución</label><b>*</b>
                                            <input type="text" name="institucion" class="form-control"
                                                value="{{ old('institucion') }}" placeholder="Ingrese su Institución" required>
                                            @error('institucion')
                                                <small style="color: red;">*Este campo es requerido</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tipo</label><b>*</b>
                                            <select name="tipo" class="form-control" required>
                                                <option value="">Seleccione...</option>
                                                <option value="titular">Titular</option>
                                                <option value="suplente">Suplente</option>
                                            </select>
                                            @error('tipo')
                                                <small style="color: red;">*Este campo es requerido</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="cv">CV</label><b>*</b>
                                            <input type="file" name="cv" class="form-control" id="cv" accept=".pdf,.doc,.docx" required>
                                            <small id="cv-name" class="text-muted"></small>
                                            @error('cv')
                                                <small style="color: red;">*Este campo es requerido</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="file">Fotografía</label>
                                    <input type="file" name="fotografia" id="file" class="form-control" accept="image/*">
                                    <small id="file-name" class="text-muted"></small>
                                    <div id="preview-container">
                                        <center><output id="list"></output></center>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <div class="form-group">
                                    <a href="{{ route('repartidores.index') }}" class="btn btn-danger">Cancelar</a>
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

<script>
    document.getElementById('cv').addEventListener('change', function(event) {
        var file = event.target.files[0];
        document.getElementById('cv-name').textContent = file ? file.name : "";
    });

    document.getElementById('file').addEventListener('change', function(evt) {
        var files = evt.target.files;
        var previewContainer = document.getElementById("list");
        var fileNameDisplay = document.getElementById("file-name");

        previewContainer.innerHTML = "";

        if (files.length > 0) {
            var file = files[0];
            fileNameDisplay.textContent = file.name;

            if (file.type.match('image.*')) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement("img");
                    img.src = e.target.result;
                    img.classList.add("thumb");
                    img.style.maxWidth = "50%";
                    img.style.height = "auto";
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.innerHTML = "<p style='color: red;'>Seleccione un archivo de imagen válido.</p>";
            }
        } else {
            fileNameDisplay.textContent = "";
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
