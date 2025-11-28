@extends('layouts.app')

@section('content')

{{-- ====================== ESTILOS ====================== --}}
<style>
/* ======== ESTILO GENERAL TABS ========= */
.nav-tabs .nav-link {
    border: none !important;
    color: #4a4a4a;
    font-weight: 600;
    padding: 10px 18px;
    border-radius: 10px 10px 0 0;
    transition: 0.25s;
}
.nav-tabs .nav-link:not(.active) {
    background: #f3f3f3;
}
.nav-tabs .nav-link:hover {
    filter: brightness(1.05);
}

/* ======== COLORES POR TAB ACTIVA ========= */
.nav-link[href="#motivo"].active { background:#caff9c!important; color:#125c0b!important; border-bottom:3px solid #72d44a; }
.nav-link[href="#signos"].active { background:#bde3ff!important; color:#0b3e66!important; border-bottom:3px solid #4ca3ff; }
.nav-link[href="#diagnostico"].active { background:#fff3a8!important; color:#665600!important; border-bottom:3px solid #e6d000; }
.nav-link[href="#tratamiento"].active { background:#ffd1df!important; color:#7a0030!important; border-bottom:3px solid #ff4f87; }
.nav-link[href="#receta"].active { background:#ffe2c4!important; color:#7a3900!important; border-bottom:3px solid #ff8f1f; }
.nav-link[href="#incapacidad"].active { background:#e8d1ff!important; color:#4a007a!important; border-bottom:3px solid #b566ff; }
.nav-link[href="#remision"].active { background:#d4fff7!important; color:#00635c!important; border-bottom:3px solid #22c7b8; }
.nav-link[href="#examenes"].active { background:#ccffe8!important; color:#006644!important; border-bottom:3px solid #2ecc71; }
.nav-link[href="#pago"].active { background:#ffe8a8!important; color:#6d4e00!important; border-bottom:3px solid #f2b600; }
.nav-link[href="#archivos"].active { background:#e6e6e6!important; color:#333!important; border-bottom:3px solid #999; }

/* Borde dinámico */
.tab-content {
    border: 3px solid #caff9c;
    border-radius: 0 12px 12px 12px;
    transition: border-color .25s ease-in-out;
}
</style>


{{-- Tagify --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>


<div class="page-body">
<div class="container-xl">

<h2 class="page-title mb-4">
    Nueva Consulta — {{ $paciente->nombre }} 
    <span class="text-muted">(Expediente: {{ $paciente->expediente }})</span>
</h2>


    <div class="card shadow-lg" style="border-radius:18px;">
        <div class="card-body">

            <form action="{{ route('consultas.store', $paciente->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                {{-- ======================= TABS ======================= --}}
                <ul class="nav nav-tabs mb-3" id="consultaTabs">
                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#motivo">Motivo</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#signos">Signos Vitales</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#diagnostico">Diagnóstico</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tratamiento">Tratamiento</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#receta">Receta</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#incapacidad">Incapacidad</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#remision">Remisión</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#examenes">Exámenes</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#archivos">Archivos Adjuntos</a></li>
                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#pago">Pago</a></li>
                </ul>



                {{-- ======================= TAB CONTENT ======================= --}}
                <div class="tab-content p-3 shadow-sm">


                    {{-- MOTIVO --}}
                    <div class="tab-pane fade show active" id="motivo">
                        <label class="form-label">Motivo de consulta</label>
                        <textarea name="motivo" class="form-control" rows="3"></textarea>
                    </div>


                    {{-- SIGNOS --}}
                    <div class="tab-pane fade" id="signos">

                        <h5 class="mb-3">Signos Vitales</h5>

                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label>Peso</label>
                                <input type="text" name="peso" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Estatura</label>
                                <input type="text" name="estatura" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Presión</label>
                                <input type="text" name="presion_arterial" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label>Temperatura</label>
                                <input type="text" name="temperatura" class="form-control">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>FC</label>
                                <input type="text" name="frecuencia_cardiaca" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>FR</label>
                                <input type="text" name="frecuencia_respiratoria" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Saturación O₂</label>
                                <input type="text" name="saturacion_o2" class="form-control">
                            </div>
                        </div>
                    </div>


                    {{-- DIAGNOSTICO --}}
                    <div class="tab-pane fade" id="diagnostico">
                        <label class="form-label">Diagnóstico</label>
                        <textarea name="diagnostico" class="form-control" rows="3"></textarea>

                        <label class="form-label mt-3">Código CIE10</label>
                        <input type="text" name="cie10" class="form-control">
                    </div>


                    {{-- TRATAMIENTO --}}
                    <div class="tab-pane fade" id="tratamiento">
                        <label class="form-label">Tratamiento</label>
                        <textarea name="tratamiento" class="form-control" rows="4"></textarea>
                    </div>


                    {{-- RECETA --}}
                    <div class="tab-pane fade" id="receta">
                        <label class="form-label">Receta Médica</label>
                        <textarea name="receta" class="form-control" rows="6"></textarea>
                    </div>


                    {{-- INCAPACIDAD --}}
                    <div class="tab-pane fade" id="incapacidad">

                        <h5 class="mb-3">Incapacidad Médica</h5>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Días</label>
                                <input type="number" name="dias_incapacidad" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Desde</label>
                                <input type="date" name="incapacidad_inicio" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Hasta</label>
                                <input type="date" name="incapacidad_fin" class="form-control">
                            </div>
                        </div>
                    </div>


                    {{-- REMISION --}}
                    <div class="tab-pane fade" id="remision">

                        <h5 class="mb-3">Remisión</h5>

                        <label>Centro Médico</label>
                        <input type="text" name="hospital_destino" class="form-control mb-3">

                        <label>Motivo</label>
                        <textarea name="motivo_remision" class="form-control" rows="3"></textarea>
                    </div>


                    {{-- EXÁMENES (TAGIFY) --}}
                    <div class="tab-pane fade" id="examenes">
                        <h5 class="mb-3">Exámenes Solicitados</h5>

                        <label class="form-label">Escribe y presiona ENTER</label>

                        <input id="inputExamenes"
                               name="examenes"
                               class="form-control"
                               placeholder="Ej: Hemograma, Glucosa, Rayos X">
                    </div>


                    {{-- PAGO --}}
                    <div class="tab-pane fade" id="pago">
                        <h5 class="mb-3">Pago</h5>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Monto</label>
                                <input type="number" step="0.01" name="monto" class="form-control">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Tipo de Pago</label>
                                <select name="tipo_pago" class="form-select">
                                    <option>Efectivo</option>
                                    <option>Tarjeta</option>
                                    <option>Transferencia</option>
                                    <option>Sin Cobro</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Estado</label>
                                <select name="pagado" class="form-select">
                                    <option value="0">Pendiente</option>
                                    <option value="1">Pagado</option>
                                </select>
                            </div>
                        </div>
                    </div>


                    {{-- ARCHIVOS --}}
                    <div class="tab-pane fade" id="archivos">

                        <h5 class="mb-3">Archivos Adjuntos</h5>

                        <div id="contenedor-archivos">
                            <div class="row mb-3 archivo-item">
                                <div class="col-md-6">
                                    <label>Archivo</label>
                                    <input type="file" name="archivos[]" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label>Observación</label>
                                    <input type="text" name="observaciones_archivo[]" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button type="button" id="btnAgregarArchivo" class="btn btn-secondary mt-2">
                            + Agregar otro archivo
                        </button>
                    </div>

                </div>



                {{-- BOTONES --}}
                <div class="mt-4 text-end">
                    <a href="{{ route('pacientes.show', $paciente->id) }}" class="btn btn-secondary">Cancelar</a>
                    <button class="btn btn-primary">Guardar Consulta</button>
                </div>

            </form>

        </div>
    </div>

</div>
</div>


{{-- AGREGAR ARCHIVOS --}}
<script>
document.getElementById("btnAgregarArchivo").addEventListener("click", function() {
    let cont = document.getElementById("contenedor-archivos");

    let html = `
    <div class="row mb-3 archivo-item">
        <div class="col-md-6">
            <input type="file" name="archivos[]" class="form-control">
        </div>
        <div class="col-md-6">
            <input type="text" name="observaciones_archivo[]" class="form-control"
                   placeholder="Descripción del archivo">
        </div>
    </div>`;

    cont.insertAdjacentHTML("beforeend", html);
});
</script>


{{-- RECORDAR TAB ACTIVO --}}
<script>
document.addEventListener("DOMContentLoaded", function() {

    let activeTab = localStorage.getItem("consulta_tab_create");

    if (activeTab) {
        let trigger = document.querySelector(`a[href="${activeTab}"]`);
        if (trigger) new bootstrap.Tab(trigger).show();
    }

    const contentBox = document.querySelector('.tab-content');

    const colores = {
        "#motivo": "#caff9c",
        "#signos": "#bde3ff",
        "#diagnostico": "#fff3a8",
        "#tratamiento": "#ffd1df",
        "#receta": "#ffe2c4",
        "#incapacidad": "#e8d1ff",
        "#remision": "#d4fff7",
        "#examenes": "#ccffe8",
        "#pago": "#ffe8a8",
        "#archivos": "#e6e6e6",
    };

    document.querySelectorAll('#consultaTabs a').forEach(tab => {
        tab.addEventListener("shown.bs.tab", function(e) {
            let id = e.target.getAttribute("href");
            if (colores[id]) contentBox.style.borderColor = colores[id];
            localStorage.setItem("consulta_tab_create", id);
        });
    });
});
</script>


{{-- TAGIFY – AUTOCOMPLETE --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    fetch("{{ route('examenes.list') }}")
        .then(res => res.json())
        .then(lista => {

            let input = document.getElementById("inputExamenes");

            let tagify = new Tagify(input, {
                whitelist: lista,
                dropdown: {
                    enabled: 1,
                    maxItems: 15,
                    searchKeys: ["value"]
                },
                enforceWhitelist: true, // permite crear nuevos
            });
        });
});
</script>

@endsection
