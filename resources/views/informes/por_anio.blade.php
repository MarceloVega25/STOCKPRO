@extends('layouts.admin')

@section('content')
<div class="content" style="margin-left: 20px">
    <h1>Informe por Año</h1>

    {{-- ERRORES --}}
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            <li>{{ $error }}</li>
        </div>
    @endforeach

    {{-- MENSAJE FLASH --}}
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-11">
            <div class="card card-outline card-danger">
                <div class="card-header">
                    <h3 class="card-title"><b>Generar Informe por Año</b></h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('informes.generarPorAnio') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <label>Seleccione el año:</label>
                                <select name="anio" class="form-control" required>
                                    @for ($i = date('Y'); $i >= 2010; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label>Módulo</label>
                                <select name="modulo" class="form-control" required>
                                    <option value="" disabled selected>Seleccione un módulo</option>
                                    @foreach ($modulos as $modulo)
                                        @if (strtolower($modulo->nombre) === 'concursos')
                                            @continue
                                        @endif
                                        @if (strtolower($modulo->nombre) === 'usuarios')
                                            @if (Auth::user()->hasRole('admin'))
                                                <option value="usuarios">Usuarios</option>
                                            @endif
                                        @elseif (strtolower($modulo->nombre) === 'stock')
                                            <option value="stock">Stock</option>
                                        @elseif (strtolower($modulo->nombre) === 'movimientos_stock')
                                            <option value="movimientos_stock">Movimientos de Stock</option>
                                        @else
                                            <option value="{{ strtolower($modulo->nombre) }}">{{ $modulo->nombre }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-success">Generar PDF por Año</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
