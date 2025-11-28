@extends('layouts.app')

@section('content')

<div class="page-body">
<div class="container-xl">

    <h2 class="page-title mb-4">Registrar Nuevo Paciente</h2>

    <div class="card shadow-lg" style="border-radius: 16px;">
        <div class="card-body">

            <form action="{{ route('pacientes.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- ============================
                         FOTO DEL PACIENTE
                    ============================ --}}
                    <div class="col-md-4 mb-4 text-center">

                        <h5 class="mb-2">Foto del Paciente</h5>

                        {{-- Vista Previa --}}
                        <img id="previewFoto" 
                             src="{{ asset('images/default-user.png') }}" 
                             class="rounded border mb-3"
                             style="width:180px;height:180px;object-fit:cover;">

                        {{-- Subir archivo --}}
                        <input type="file" name="foto" id="fotoInput"
                               class="form-control mb-2"
                               accept="image/*">

                        <hr>

                        {{-- Cámara --}}
                        <h6>Tomar Foto con Cámara</h6>

                        <video id="camera" autoplay playsinline 
                               class="border rounded mb-2"
                               style="width:180px;height:180px;object-fit:cover;"></video>

                        <button type="button" id="btnTomarFoto" 
                                class="btn btn-sm btn-primary w-100 mb-2">
                            📷 Tomar Foto
                        </button>

                        {{-- Campo oculto donde se guarda la foto capturada --}}
                        <input type="hidden" name="foto_capturada" id="foto_capturada">

                        <canvas id="canvas" style="display:none;"></canvas>

                    </div>

                    {{-- =====================================================
                          CAMPOS DE FORMULARIO
                    ===================================================== --}}
                    <div class="col-md-8">

                        <div class="row">

                            {{-- Nombre --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre Completo *</label>
                                <input type="text" name="nombre"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Identidad --}}
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Identidad</label>
                                <input type="text" name="identidad" class="form-control">
                            </div>

                        </div>

                        <div class="row">

                            {{-- Teléfono --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="telefono" class="form-control">
                            </div>

                            {{-- Correo --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email" name="email"
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
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>

                        </div>

                        <div class="row">

                            {{-- Fecha nacimiento --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                                       class="form-control">
                            </div>

                            {{-- Edad --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Edad</label>
                                <input type="text" id="edad" name="edad" class="form-control" readonly>
                            </div>

                            {{-- Dirección --}}
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Dirección</label>
                                <input type="text" name="direccion" class="form-control">
                            </div>

                        </div>

                    </div>
                </div>

                {{-- Botones --}}
                <div class="mt-3 text-end">
                    <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button class="btn btn-primary">Guardar Paciente</button>
                </div>

            </form>

        </div>
    </div>

</div>
</div>



{{-- ===================================================
     SCRIPT: Calcular EDAD
=================================================== --}}
<script>
function calcularEdad() {
    let fecha = document.getElementById('fecha_nacimiento').value;
    if (!fecha) {
        document.getElementById('edad').value = '';
        return;
    }

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
</script>


{{-- ===================================================
     SCRIPT: Cámara y foto capturada
=================================================== --}}
<script>
let video = document.getElementById("camera");
let canvas = document.getElementById("canvas");
let preview = document.getElementById("previewFoto");
let modalPreview = document.getElementById("modalPreviewFoto");

// Activar cámara
navigator.mediaDevices.getUserMedia({ video: true })
    .then(stream => { video.srcObject = stream; })
    .catch(err => { console.log("No se pudo acceder a la cámara:", err); });

document.getElementById("btnTomarFoto").addEventListener("click", function() {

    // Dibujar foto en canvas
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    canvas.getContext("2d").drawImage(video, 0, 0);

    // Convertir a base64
    let dataURL = canvas.toDataURL("image/png");

    // Guardar en input oculto
    document.getElementById("foto_capturada").value = dataURL;

    // Vista previa principal
    preview.src = dataURL;

    // Vista previa en modal
    modalPreview.src = dataURL;

    // Mostrar modal elegante
    let modal = new bootstrap.Modal(document.getElementById("fotoModal"));
    modal.show();
});

// Vista previa al subir archivo
document.getElementById("fotoInput").addEventListener("change", function() {
    if (this.files && this.files[0]) {
        preview.src = URL.createObjectURL(this.files[0]);
    }
});
</script>

{{-- ===========================
     MODAL FOTO CAPTURADA
=========================== --}}
<div class="modal fade" id="fotoModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content" style="border-radius: 14px;">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">📸 Foto Capturada</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                <p class="mb-2">La fotografía del paciente fue tomada exitosamente.</p>
                <img id="modalPreviewFoto" 
                     src="" 
                     class="rounded border"
                     style="width:220px;height:220px;object-fit:cover;">
            </div>

            <div class="modal-footer">
                <button class="btn btn-success" data-bs-dismiss="modal">
                    Perfecto
                </button>
            </div>
        </div>

    </div>
</div>

@endsection
