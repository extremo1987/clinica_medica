@extends('layouts.app')

@section('content')

<style>
    .card-paciente {
        border-radius: 18px;
        background: #f8fbff;
        border: 1px solid #dce6f3;
    }

    .foto-paciente {
        width: 150px;
        height: 150px;
        border-radius: 14px;
        object-fit: cover;
        border: 3px solid #90caf9;
    }

    .info-box {
        background: #ffffff;
        border: 1px solid #d8e3ef;
        border-radius: 12px;
        padding: 12px 15px;
        margin-bottom: 12px;
    }

    .badge-expediente {
        background:#1565c0;
        color:white;
        padding:6px 12px;
        border-radius:12px;
        font-size:15px;
    }
</style>


<div class="page-body">
<div class="container-xl">

    <div class="d-flex justify-content-between mb-4">
        <h2 class="page-title">
            Paciente — {{ $paciente->nombre }}
        </h2>

        <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">
            Volver
        </a>
    </div>


    <div class="card card-paciente shadow-lg p-4">

        <div class="row">

            {{-- FOTO --}}
            <div class="col-md-3 text-center">

                <img src="{{ $paciente->foto ? asset('storage/'.$paciente->foto) : asset('images/default-user.png') }}" 
                     class="foto-paciente mb-3">

                <h5 class="badge-expediente">
                    Expediente: {{ $paciente->expediente }}
                </h5>

            </div>

            {{-- INFORMACIÓN --}}
            <div class="col-md-9">

                <h3 class="mb-3 text-primary">Información General</h3>

                <div class="row">

                    <div class="col-md-6">
                        <div class="info-box">
                            <strong>Nombre:</strong><br>
                            {{ $paciente->nombre }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <strong>Identidad:</strong><br>
                            {{ $paciente->identidad ?: '—' }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <strong>Sexo:</strong><br>
                            @if($paciente->sexo === 'M') Masculino
                            @elseif($paciente->sexo === 'F') Femenino
                            @else — @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <strong>Edad:</strong><br>
                            {{ $paciente->edad ?: '—' }} años
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="info-box">
                            <strong>Fecha de nacimiento:</strong><br>
                            {{ $paciente->fecha_nacimiento ?: '—' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <strong>Teléfono:</strong><br>
                            {{ $paciente->telefono ?: '—' }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <strong>Correo:</strong><br>
                            {{ $paciente->email ?: '—' }}
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="info-box">
                            <strong>Dirección:</strong><br>
                            {{ $paciente->direccion ?: '—' }}
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
</div>

@endsection
