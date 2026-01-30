@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <h1>Búsqueda por DNI</h1>

    <div class="row">
        <div class="col-md-11">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title"><b>ESCRIBA EL DNI</b></h3>
                </div>

                <div class="card-body" style="display: block;">
                    <form method="POST" action="{{ route('inscriptos.buscarDni') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dni">DNI:</label>
                                    <input type="text" name="dni" id="dni" class="form-control" required maxlength="8" pattern="\d{8}" title="Debe ingresar exactamente 8 números">
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <hr>
                                <div class="form-group">
                                    <a href="{{ route('inscriptos.index') }}" class="btn btn-danger">Cancelar</a>
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
@if(session('mensaje') === 'existe')
    <script>
        Swal.fire({
            title: 'DNI Encontrado',
            text: 'El DNI ya está Registrado. Será redirigido al formulario de Edición.',
            icon: 'info',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        }).then(() => {
            window.location.href = "{{ route('inscriptos.edit', session('inscripto_id')) }}";
        });
    </script>
@endif

@if(session('mensaje') === 'nuevo')
    <script>
        Swal.fire({
            title: 'DNI No Encontrado',
            text: 'El DNI no se encuentra Registrado. Será redirigido al formulario de Alta.',
            icon: 'warning',
            confirmButtonText: 'OK',
            allowOutsideClick: false
        }).then(() => {
            window.location.href = "{{ route('inscriptos.create', ['dni' => session('dni')]) }}";
        });
    </script>
@endif
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dniInput = document.getElementById('dni');

        // Evita escribir letras o símbolos
        dniInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, ''); // solo deja números
        });

        // Evita pegar letras o símbolos
        dniInput.addEventListener('paste', function (e) {
            const pasted = e.clipboardData.getData('text');
            if (/\D/.test(pasted)) {
                e.preventDefault(); // cancela el pegado si hay algo que no sea número
            }
        });

        // Previene que se escriban más de 8 números
        dniInput.addEventListener('keypress', function (e) {
            if (this.value.length >= 8) {
                e.preventDefault();
            }
        });
    });
</script>

@endsection

