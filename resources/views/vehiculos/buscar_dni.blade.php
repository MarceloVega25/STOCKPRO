@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Buscar Vehículo por DNI</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b>BUSCAR DNI</b></h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('vehiculos.buscarDni') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>DNI</label>
                                <input type="text" name="dni" class="form-control" placeholder="Ingrese DNI" required maxlength="8">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Buscar</button>
                                <a href="{{ route('vehiculos.index') }}" class="btn btn-danger">Volver</a>
                            </div>
                        </form>

                        @if (session('mensaje') == 'existe')
                            <script>
                                Swal.fire({
                                    icon: 'info',
                                    title: 'El vehículo ya existe',
                                    text: 'Se encontró un vehículo con ese DNI.',
                                    confirmButtonColor: '#3085d6'
                                }).then(() => {
                                    window.location.href = "{{ url('/vehiculos/' . session('docente_id')) }}";
                                });
                            </script>
                        @elseif (session('mensaje') == 'nuevo')
                            <script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'DNI no registrado',
                                    text: 'Puede crear un nuevo vehículo.',
                                    confirmButtonColor: '#3085d6'
                                }).then(() => {
                                    window.location.href = "{{ route('vehiculos.create', ['dni' => session('dni')]) }}";
                                });
                            </script>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
