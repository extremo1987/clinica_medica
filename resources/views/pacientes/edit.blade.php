@extends('layouts.app')

@section('content')
<div class="page-body">
<div class="container-xl">

    <h2 class="page-title mb-4">Editar Paciente</h2>

    <div class="card shadow-lg" style="border-radius: 16px;">
        <div class="card-body">

            <form action="{{ route('pacientes.update', $paciente->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- ===========================================
                          FOTO DEL PACIENTE
                    ============================================ --}}
                    <div class="col-md-4 mb-4 text-center">

                        <h5 class="mb-2">Foto del Paciente</h5>

                        {{-- Vista Previa --}}
                        <img id="previewFoto"
                             src="{{ $paciente->foto ? asset('storage/'.$paciente->foto) : asset('images/default-user.png') }}"
                             class="rounded border mb-3"
                             style="width:180px;height:180px;object-fit:cover;">

                        {{-- Subir archivo --}}
                        <input type="file"
                               name="foto"
                               id="fotoInput"
                               class="form-control mb-3"
                               accept="image/*">

                        <hr>

                        {{-- Cámara --}}
                        <h6>Tomar Foto con Cámara</h6>

                        <video id="camera"
                               autoplay
                               playsinline
                               class="border rounded mb-2"
                               style="width:180px;height:180px;object-fit:cover;"></video>

                        <button type="button"
                                id="btnTomarFoto"
                                class="btn btn-sm btn-primary w-100 mb-2">
                            📷 Tomar Foto
                        </button>

                        <input type="hidden" name="foto_capturada" id="foto_capturada">
                        <canvas id="canvas" style="display:none;"></canvas>

                    </div>

                    {{-- ===========================================
                            CAMPOS DEL FORMULARIO
                    ============================================ --}}
                    <div class="col-md-8">

                        <div class="row">

                            {{-- Nombre --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre Completo *</label>
                                <input type="text"
                                       name="nombre"
                                       value="{{ $paciente->nombre }}"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Identidad --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Identidad</label>
                                <input type="text"
                                       name="identidad"
                                       value="{{ $paciente->identidad }}"
                                       class="form-control">
                            </div>

                        </div>

                        <div class="row">

                            {{-- Teléfono --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text"
                                       name="telefono"
                                       value="{{ $paciente->telefono }}"
                                       class="form-control">
                            </div>

                            {{-- Correo --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email"
                                       name="email"
                                       value="{{ $paciente->email }}"
                                       class="form-control @error('email') is-invalid @enderror">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Sexo --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sexo</label>
                                <select name="sexo" class="form-select">
                                    <option value="">-- Seleccione --</option>
                                    <option value="M" @selected($paciente->sexo=="M")>Masculino</option>
                                    <option value="F" @selected($paciente->sexo=="F")>Femenino</option>
                                </select>
                            </div>

                        </div>

                        <div class="row">

                            {{-- Fecha nacimiento --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Fecha de Nacimiento</label>
                                <input type="date"
                                       name="fecha_nacimiento"
                                       id="fecha_nacimiento"
                                       value="{{ $paciente->fecha_nacimiento }}"
                                       class="form-control">
                            </div>

                            {{-- Edad --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Edad</label>
                                <input type="text"
                                       id="edad"
                                       name="edad"
                                       value="{{ $paciente->edad }}"
                                       class="form-control"
                                       readonly>
                            </div>

                            {{-- Dirección --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Dirección</label>
                                <input type="text"
                                       name="direccion"
                                       value="{{ $paciente->direccion }}"
                                       class="form-control">
                            </div>

                        </div>

                    </div>
                </div>

                {{-- Botones --}}
                <div class="mt-3 text-end">
                    <a href="{{ route('pacientes.show', $paciente->id) }}" class="btn btn-secondary">Cancelar</a>
                    <button class="btn btn-primary">Actualizar Paciente</button>
                </div>

            </form>

        </div>
    </div>

</div>
</div>


{{-- ===================================================
     SCRIPT: Calcular Edad
=================================================== --}}
<script>
function calcularEdad() {
    let fecha = document.getElementById('fecha_nacimiento').value;
    if (!fecha) return;

    let nacimiento = new Date(fecha);
    let hoy = new Date();

    let edad = hoy.getFullYear() - nacimiento.getFullYear();
    let mes = hoy.getMonth() - nacimiento.getMonth();

    if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
        edad--;
    }

    document.getElementById('edad').value = edad;
}

document.getElementById('fecha_nacimiento').addEventListener('change', calcularEdad);
@if($paciente->fecha_nacimiento) calcularEdad(); @endif
</script>


{{-- ===================================================
     SCRIPT: Cámara y Foto Directa
=================================================== --}}
<script>
let video = document.getElementById("camera");
let canvas = document.getElementById("canvas");
let preview = document.getElementById("previewFoto");

// Activar cámara
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => video.srcObject = stream)
    .catch(err => console.log("No se pudo acceder a la cámara:", err));

// Tomar foto
document.getElementById("btnTomarFoto").addEventListener("click", function() {

    // Dibujar en canvas
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext("2d").drawImage(video, 0, 0);

    // Convertir a Base64
    let dataURL = canvas.toDataURL("image/png");

    // Poner en input y preview
    document.getElementById("foto_capturada").value = dataURL;
    preview.src = dataURL;
});

// Vista previa al subir archivo
document.getElementById("fotoInput").addEventListener("change", function() {
    if (this.files && this.files[0]) {
        preview.src = URL.createObjectURL(this.files[0]);
    }
});
</script>

@endsection
