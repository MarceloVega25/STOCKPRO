<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Informe de Vehículos</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Roboto');
        body { font-family: Roboto, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #000; padding: 5px; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h3>Informe de Vehículos</h3>

    @php use Carbon\Carbon; @endphp

    @if (isset($desde) && isset($hasta))
        <p>Desde: {{ Carbon::parse($desde)->format('d/m/Y') }} — Hasta: {{ Carbon::parse($hasta)->format('d/m/Y') }}</p>
    @elseif (isset($anio))
        <p>Año: {{ $anio }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>DNI</th>
                <th>Carrera</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datos as $vehiculo)
                <tr>
                    <td>{{ $vehiculo->nombre_apellido }}</td>
                    <td>{{ $vehiculo->dni }}</td>
                    <td>{{ $vehiculo->carrera }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 20px;"><strong>Total de estudiantes: {{ $datos->count() }}</strong></p>
</body>
</html>
