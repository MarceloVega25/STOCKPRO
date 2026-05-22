@extends('layouts.admin')

@section('content')
    <div class="content" style="margin-left: 20px">
        <h1>Búsqueda por DNI</h1>

        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><b>BUSCAR DNI</b></h3>
                    </div>

                    <div class="card-body">
                        <div class="alert alert-info">
                            La búsqueda por DNI corresponde al módulo de <b>Repartidores</b>.
                        </div>

                        <a href="{{ route('repartidores.buscar') }}" class="btn btn-primary">Ir a Buscar Repartidor por DNI</a>
                        <a href="{{ route('repartos.index') }}" class="btn btn-danger">Volver</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
