@extends('layouts.app')

@section('content')

<style>
@media print {

    /* Ocultar botones y elementos no imprimibles */
    .no-print, .navbar, .btn, a.btn {
        display: none !important;
    }

    /* Reset del body para impresión */
    body, html {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        background: white !important;
    }

    /* Contenedor a todo lo ancho (página carta o A4) */
    .container-xl, .page-body, .card {
        width: 100% !important;  
        max-width: 100% !important;
        margin: 0 !important;
        padding: 20px !important; /* agrega márgenes internos para que no quede tan pegado */
        box-shadow: none !important;
        border: none !important;
    }

    /* Quitar bordes y estilos gráficos si deseas */
    .card {
        border: none !important;
    }

    /* Ajustar tablas para que usen todo el ancho */
    table {
        width: 100% !important;
    }
}
</style>



<div class="page-body">
<div class="container-xl">

    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="page-title">Consulta #{{ $consulta->id }}</h2>

        <a href="{{ route('pacientes.show', $consulta->paciente_id) }}" class="btn btn-secondary no-print">
            Volver a Ficha Clínica
        </a>
    </div>

    {{-- BOTONES SUPERIORES --}}
    <div class="d-flex gap-2 mb-3 no-print">
        <a href="javascript:window.print();" class="btn btn-dark">
            🖨️ Imprimir
        </a>

        <a href="{{ route('consultas.pdf.completa', $consulta->id) }}" class="btn btn-primary">
            📄 Exportar PDF
        </a>
    </div>

    {{-- TARJETA PRINCIPAL --}}
    <div class="card shadow-lg" style="border-radius: 18px;">
        <div class="card-body">

            {{-- ========================
                 DATOS DEL PACIENTE
            ========================= --}}
            <h3 class="mb-3">Datos del Paciente</h3>

            <p><strong>Nombre:</strong> {{ $consulta->paciente->nombre }}</p>
            <p><strong>Identidad:</strong> {{ $consulta->paciente->identidad }}</p>
            <p><strong>Edad:</strong> {{ $consulta->paciente->edad }} años</p>
            <hr>

            {{-- ========================
                 DATOS DE CONSULTA
            ========================= --}}
            <h3 class="mb-3">Detalles de la Consulta</h3>

            <p><strong>Fecha:</strong> {{ $consulta->fecha_consulta?->format('d/m/Y H:i') }}</p>

            <p><strong>Motivo de Consulta:</strong><br>
                {!! nl2br(e($consulta->motivo)) !!}
            </p>

            <p><strong>Diagnóstico:</strong><br>
                {!! nl2br(e($consulta->diagnostico)) !!}
            </p>

            @if($consulta->cie10)
                <p><strong>Código CIE10:</strong> {{ $consulta->cie10 }}</p>
            @endif

            <hr>

            {{-- ========================
                 SIGNOS VITALES
            ========================= --}}
            <h3 class="mb-3">Signos Vitales</h3>

            <table class="table table-bordered">
                <tr><th>Peso</th><td>{{ $consulta->peso }} kg</td></tr>
                <tr><th>Estatura</th><td>{{ $consulta->estatura }} cm</td></tr>
                <tr><th>Presión Arterial</th><td>{{ $consulta->presion_arterial }}</td></tr>
                <tr><th>Frecuencia Cardiaca</th><td>{{ $consulta->frecuencia_cardiaca }} lpm</td></tr>
                <tr><th>Frecuencia Respiratoria</th><td>{{ $consulta->frecuencia_respiratoria }}</td></tr>
                <tr><th>Temperatura</th><td>{{ $consulta->temperatura }} °C</td></tr>
                <tr><th>Saturación O₂</th><td>{{ $consulta->saturacion_o2 }} %</td></tr>
            </table>

            <hr>

            {{-- ========================
                 TRATAMIENTO
            ========================= --}}
            <h3 class="mb-3">Tratamiento / Receta</h3>

            <p>{!! nl2br(e($consulta->tratamiento)) !!}</p>

            <hr>

            {{-- ========================
                 EXÁMENES
            ========================= --}}
            <h3 class="mb-3">Exámenes Solicitados</h3>

            @if($consulta->examenes)
                <ul>
                @foreach($consulta->examenes as $ex)
                    <li>{{ $ex }}</li>
                @endforeach
                </ul>
            @else
                <p class="text-muted">No se solicitaron exámenes.</p>
            @endif

            <hr>

            {{-- ========================
                 INCAPACIDAD
            ========================= --}}
            <h3 class="mb-3">Incapacidad</h3>

            @if($consulta->dias_incapacidad)
                <p><strong>Días:</strong> {{ $consulta->dias_incapacidad }}</p>
                <p><strong>Desde:</strong> {{ $consulta->incapacidad_inicio }}</p>
                <p><strong>Hasta:</strong> {{ $consulta->incapacidad_fin }}</p>
            @else
                <p class="text-muted">No se generó incapacidad.</p>
            @endif

            <hr>

            {{-- ========================
                 REMISIÓN
            ========================= --}}
            <h3 class="mb-3">Remisión</h3>

            @if($consulta->hospital_destino)
                <p><strong>Centro Médico:</strong> {{ $consulta->hospital_destino }}</p>
                <p><strong>Motivo:</strong><br>
                    {!! nl2br(e($consulta->motivo_remision)) !!}
                </p>
            @else
                <p class="text-muted">No hubo remisión.</p>
            @endif

            <hr>

            {{-- ========================
                 ARCHIVOS ADJUNTOS
            ========================= --}}
            <h3 class="mb-3">Archivos Adjuntos</h3>

            @if($consulta->archivos->count())
                <ul>
                    @foreach($consulta->archivos as $archivo)
                        <li class="mb-2">
                            📄 <strong>{{ ucfirst($archivo->tipo_archivo) }}</strong><br>

                            <a href="{{ asset('storage/'.$archivo->ruta_archivo) }}" 
                               class="btn btn-sm btn-primary mt-1 no-print"
                               target="_blank">
                                Descargar PDF
                            </a>

                            <small class="d-block text-muted mt-1">
                                {{ $archivo->observacion ?: 'Sin observación' }}  
                                — {{ $archivo->created_at->format('d/m/Y H:i') }}
                            </small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No hay archivos adjuntos.</p>
            @endif

        </div>
    </div>

</div>
</div>

@endsection
