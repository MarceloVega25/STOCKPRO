@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Búsqueda por EMAIL</h1>

        <div class="row">
            <div class="col-md-11">
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><b>ESCRIBA EL EMAIL</b></h3>
                    </div>

                    <div class="card-body" style="display: block;">
                        <form method="POST" action="{{ route('usuarios.buscarEmail') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="dni">EMAIL:</label>
                                        <input type="text" name="email" id="email" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <hr>
                                    <div class="form-group">
                                        <a href="{{ route('usuarios.index') }}" class="btn btn-danger">Cancelar</a>
                                        <button type="submit" class="btn btn-primary">Buscar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->
            </div> <!-- /.col-md-11 -->
        </div> <!-- /.row -->
    </div> <!-- /.content -->

    {{-- SweetAlert2 para redirecciones --}}
    @if (session('mensaje') === 'existe')
        <script>
            Swal.fire({
                title: 'Email Encontrado',
                text: 'El EMAIL ya está Registrado. Será redirigido al formulario de Edición.',
                icon: 'info',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = "{{ route('usuarios.edit', session('usuario_id')) }}";
            });
        </script>
    @endif

    @if (session('mensaje') === 'nuevo')
        <script>
            Swal.fire({
                title: 'EMAIL No Encontrado',
                text: 'El EMAIL no se encuentra Registrado. Será redirigido al formulario de Alta.',
                icon: 'warning',
                confirmButtonText: 'OK',
                allowOutsideClick: false
            }).then(() => {
                window.location.href = "{{ route('usuarios.create', ['email' => session('email')]) }}";
            });
        </script>
    @endif
    
@endsection
