@extends('layouts.app')

@section('content')

<div class="page-body">
    <div class="container-xl">

        {{-- ENCABEZADO --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Ficha Clínica del Paciente</h2>
            <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">Volver</a>
        </div>

        {{-- TARJETA PRINCIPAL --}}
        <div class="card shadow-lg" style="border-radius: 18px;">
            <div class="card-body">

                {{-- CABECERA --}}
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3 class="fw-bold mb-1">{{ $paciente->nombre }}</h3>

                        <span class="badge bg-primary" style="font-size:14px; color:#fff; font-weight:bold;">
    Expediente: {{ $paciente->expediente }}
</span>

                    </div>

                    {{-- NUEVA CONSULTA --}}
                    <a href="{{ route('consultas.create', $paciente->id) }}" class="btn btn-success">
                        Nueva Consulta
                    </a>
                </div>

                {{-- INFORMACIÓN PACIENTE --}}
                <div class="patient-info-section p-3 mb-4">
                    <h4 class="fw-bold mb-3 text-primary">🧍 Información del Paciente</h4>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <div class="info-box">
                                <label>Identidad</label>
                                <p>{{ $paciente->identidad ?: '—' }}</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="info-box">
                                <label>Edad</label>
                                <p>{{ $paciente->edad ? $paciente->edad.' años' : '—' }}</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="info-box">
                                <label>Fecha Nacimiento</label>
                                <p>{{ $paciente->fecha_nacimiento ?: '—' }}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-box">
                                <label>Teléfono</label>
                                <p>{{ $paciente->telefono ?: '—' }}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-box">
                                <label>Email</label>
                                <p>{{ $paciente->email ?: '—' }}</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="info-box">
                                <label>Sexo</label>
                                <p>
                                    @if($paciente->sexo === 'M') Masculino
                                    @elseif($paciente->sexo === 'F') Femenino
                                    @else — @endif
                                </p>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="info-box">
                                <label>Dirección</label>
                                <p>{{ $paciente->direccion ?: '—' }}</p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        {{-- HISTORIAL DE CONSULTAS --}}
        <div class="card shadow-sm mt-4" style="border-radius: 16px;">
            <div class="card-body">
                <h3 class="mb-3">Historial de Consultas</h3>

                @php
                    $consultas = $paciente->consultas ?? collect();
                @endphp

                @if($consultas->isEmpty())

                    <div class="alert alert-info text-center">
                        Este paciente aún no tiene consultas registradas.
                    </div>

                @else

                    <div class="table-responsive">
                        <table id="consultasTable" class="table table-striped table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Motivo</th>
                                    <th>Diagnóstico</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($consultas as $c)
                                    <tr>
                                        <td>{{ $c->fecha_consulta?->format('d/m/Y') ?: '—' }}</td>
                                        <td>{{ $c->motivo ?: '—' }}</td>
                                        <td>{{ $c->diagnostico ?: '—' }}</td>

                                        <td class="text-end">

                                            {{-- VER --}}
                                            <a href="{{ route('consultas.show', $c->id) }}" class="btn btn-sm btn-info">
                                                Ver
                                            </a>

                                            {{-- EDITAR --}}
                                            <a href="{{ route('consultas.edit', $c->id) }}" class="btn btn-sm btn-primary">
                                                Editar
                                            </a>

                                            {{-- ========= RECETA ========= --}}
                                            @if(!empty($c->receta))
                                            <form method="POST"
                                                  action="{{ route('consultas.receta.pdf', $c->paciente_id) }}"
                                                  class="d-inline">
                                                @csrf
                                                <input type="hidden" name="consulta_id" value="{{ $c->id }}">
                                                <button class="btn btn-sm btn-success">
                                                    Receta PDF
                                                </button>
                                            </form>
                                            @endif

                                            {{-- ========= INCAPACIDAD ========= --}}
                                            @if(!empty($c->dias_incapacidad) && $c->incapacidad_inicio && $c->incapacidad_fin)
                                            <form method="POST"
                                                  action="{{ route('consultas.incapacidad.pdf', $c->paciente_id) }}"
                                                  class="d-inline">
                                                @csrf
                                                <input type="hidden" name="consulta_id" value="{{ $c->id }}">
                                                <button class="btn btn-sm btn-warning">
                                                    Incapacidad PDF
                                                </button>
                                            </form>
                                            @endif

                                            {{-- ========= REMISIÓN ========= --}}
                                            @if(!empty($c->hospital_destino) && !empty($c->motivo_remision))
                                            <form method="POST"
                                                  action="{{ route('consultas.remision.pdf', $c->paciente_id) }}"
                                                  class="d-inline">
                                                @csrf
                                                <input type="hidden" name="consulta_id" value="{{ $c->id }}">
                                                <button class="btn btn-sm btn-danger">
                                                    Remisión PDF
                                                </button>
                                            </form>
                                            @endif

                                            {{-- ELIMINAR --}}
                                            <form action="{{ route('consultas.destroy', $c->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button onclick="return confirm('¿Eliminar consulta?')"
                                                        class="btn btn-sm btn-outline-danger">
                                                    Eliminar
                                                </button>
                                            </form>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                @endif

            </div>
        </div>

    </div>
</div>

{{-- ESTILOS --}}
<style>
.patient-info-section {
    background: #f8faff;
    border: 1px solid #dbe2f0;
    border-radius: 14px;
}
.info-box {
    background: white;
    border: 1px solid #d9e2ef;
    padding: 12px 15px;
    border-radius: 12px;
}
</style>

@endsection
