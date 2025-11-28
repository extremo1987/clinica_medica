<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Consulta {{ $consulta->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 13px; }
        h2 { margin-bottom: 0; }
        .seccion { margin: 18px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 6px; border: 1px solid #ccc; }
        .titulo { font-size: 18px; margin-bottom: 10px; font-weight: bold; }
    </style>
</head>
<body>

    <h2>Consulta #{{ $consulta->id }}</h2>
    <p>Fecha: {{ $consulta->fecha_consulta?->format('d/m/Y H:i') }}</p>
    <hr>

    <div class="seccion">
        <div class="titulo">Datos del Paciente</div>
        <p><strong>Nombre:</strong> {{ $consulta->paciente->nombre }}</p>
        <p><strong>Identidad:</strong> {{ $consulta->paciente->identidad }}</p>
        <p><strong>Edad:</strong> {{ $consulta->paciente->edad }} años</p>
    </div>

    <div class="seccion">
        <div class="titulo">Motivo de Consulta</div>
        <p>{!! nl2br(e($consulta->motivo)) !!}</p>
    </div>

    <div class="seccion">
        <div class="titulo">Diagnóstico</div>
        <p>{!! nl2br(e($consulta->diagnostico)) !!}</p>
        @if($consulta->cie10)
            <p><strong>CIE10:</strong> {{ $consulta->cie10 }}</p>
        @endif
    </div>

    <div class="seccion">
        <div class="titulo">Signos Vitales</div>
        <table>
            <tr><th>Peso</th><td>{{ $consulta->peso }}</td></tr>
            <tr><th>Estatura</th><td>{{ $consulta->estatura }}</td></tr>
            <tr><th>Presión Arterial</th><td>{{ $consulta->presion_arterial }}</td></tr>
            <tr><th>FC</th><td>{{ $consulta->frecuencia_cardiaca }}</td></tr>
            <tr><th>FR</th><td>{{ $consulta->frecuencia_respiratoria }}</td></tr>
            <tr><th>Temperatura</th><td>{{ $consulta->temperatura }}</td></tr>
            <tr><th>Saturación O₂</th><td>{{ $consulta->saturacion_o2 }}</td></tr>
        </table>
    </div>

    <div class="seccion">
        <div class="titulo">Tratamiento</div>
        <p>{!! nl2br(e($consulta->tratamiento)) !!}</p>
    </div>

    <div class="seccion">
        <div class="titulo">Exámenes Solicitados</div>
        @if($consulta->examenes)
            <ul>
                @foreach($consulta->examenes as $ex)
                    <li>{{ $ex }}</li>
                @endforeach
            </ul>
        @else
            <p>No se solicitaron exámenes.</p>
        @endif
    </div>

    <div class="seccion">
        <div class="titulo">Incapacidad</div>
        @if($consulta->dias_incapacidad)
            <p><strong>Días:</strong> {{ $consulta->dias_incapacidad }}</p>
            <p><strong>Inicio:</strong> {{ $consulta->incapacidad_inicio }}</p>
            <p><strong>Fin:</strong> {{ $consulta->incapacidad_fin }}</p>
        @else
            <p>No hubo incapacidad.</p>
        @endif
    </div>

    <div class="seccion">
        <div class="titulo">Remisión</div>
        @if($consulta->hospital_destino)
            <p><strong>Centro:</strong> {{ $consulta->hospital_destino }}</p>
            <p><strong>Motivo:</strong> {!! nl2br(e($consulta->motivo_remision)) !!}</p>
        @else
            <p>No hubo remisión.</p>
        @endif
    </div>

    <div class="seccion">
        <div class="titulo">Archivos Adjuntos</div>
        @if($consulta->archivos->count())
            <ul>
                @foreach($consulta->archivos as $archivo)
                    <li>
                        {{ $archivo->nombre_archivo }}
                        ({{ $archivo->created_at->format('d/m/Y H:i') }})
                    </li>
                @endforeach
            </ul>
        @else
            <p>No hay archivos adjuntos.</p>
        @endif
    </div>

</body>
</html>
