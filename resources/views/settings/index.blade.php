@extends('layouts.app')

@section('content')

<style>
/* ----- ESTILO GENERAL TABS ----- */
.nav-tabs .nav-link {
    border: none !important;
    color: #4a4a4a;
    font-weight: 600;
    padding: 10px 18px;
    border-radius: 10px 10px 0 0;
    transition: 0.3s;
}

/* No activas */
.nav-tabs .nav-link:not(.active) {
    background: #f3f3f3;
}

/* Hover */
.nav-tabs .nav-link:hover {
    filter: brightness(1.05);
}

/* ----- COLORES POR PESTAÑA (TAB ACTIVA) ----- */

/* Clínica (verde lima) */
.nav-link[href="#clinica"].active {
    background: #caff9c !important;
    color: #125c0b !important;
    border-bottom: 3px solid #72d44a;
}

/* Doctor (azul pastel) */
.nav-link[href="#doctor"].active {
    background: #bde3ff !important;
    color: #0b3e66 !important;
    border-bottom: 3px solid #4ca3ff;
}

/* Logo (amarillo pastel) */
.nav-link[href="#logo"].active {
    background: #fff3a8 !important;
    color: #665600 !important;
    border-bottom: 3px solid #e6d000;
}

/* Recetas (rosa pastel) */
.nav-link[href="#recetas"].active {
    background: #ffd1df !important;
    color: #7a0030 !important;
    border-bottom: 3px solid #ff4f87;
}

/* Footer (naranja pastel) */
.nav-link[href="#footer"].active {
    background: #ffd9b3 !important;
    color: #7a3c00 !important;
    border-bottom: 3px solid #ff8f1f;
}

/* ----- BORDE DEL CONTENIDO DINÁMICO ----- */
.tab-content {
    border: 3px solid #caff9c;
    border-radius: 0 12px 12px 12px;
    transition: border-color .3s ease-in-out;
}

/* Vista previa de logo con estilo bonito */
#logoPreview {
    border: 2px solid #ddd;
    padding: 6px;
    border-radius: 10px;
    max-height: 120px;
}
</style>

<div class="page-body">
<div class="container-xl">

    <h2 class="page-title mb-4">Configuración del Sistema</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg" style="border-radius: 18px;">
        <div class="card-body">

            <form id="form-config" action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- NAV TABS --}}
                <ul class="nav nav-tabs mb-3" id="configTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#clinica">Datos de la Clínica</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#doctor">Datos del Médico</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#logo">Logo</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#recetas">Ajustes Recetas</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#footer">Pie de Página PDF</a>
                    </li>
                </ul>

                {{-- TAB CONTENT --}}
                <div class="tab-content p-3 shadow-sm">

                    {{-- CLINICA --}}
                    <div class="tab-pane fade show active" id="clinica">
                        <h4 class="mb-3">Datos de la Clínica</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nombre de la Clínica</label>
                                <input type="text" name="nombre_clinica" class="form-control"
                                    value="{{ old('nombre_clinica', $setting->nombre_clinica ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Teléfono</label>
                                <input type="text" name="telefono" class="form-control"
                                    value="{{ old('telefono', $setting->telefono ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>WhatsApp</label>
                                <input type="text" name="whatsapp" class="form-control"
                                    value="{{ old('whatsapp', $setting->whatsapp ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Correo</label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $setting->email ?? '') }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Dirección</label>
                                <input type="text" name="direccion" class="form-control"
                                    value="{{ old('direccion', $setting->direccion ?? '') }}">
                            </div>
                        </div>
                    </div>

                    {{-- DOCTOR --}}
                    <div class="tab-pane fade" id="doctor">
                        <h4 class="mb-3">Datos del Médico</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nombre del Médico</label>
                                <input type="text" name="doctor" class="form-control"
                                    value="{{ old('doctor', $setting->doctor ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Registro Médico</label>
                                <input type="text" name="registro_medico" class="form-control"
                                    value="{{ old('registro_medico', $setting->registro_medico ?? '') }}">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label>Especialidad</label>
                                <input type="text" name="especialidad" class="form-control"
                                    value="{{ old('especialidad', $setting->especialidad ?? '') }}">
                            </div>
                        </div>
                    </div>

                    {{-- LOGO --}}
                    <div class="tab-pane fade" id="logo">
                        <h4 class="mb-3">Logo</h4>

                        <input type="file" accept="image/*" name="logo" class="form-control mb-3">

                        @if(!empty($setting->logo))
                            <p>Logo actual:</p>
                            <img id="logoPreview" src="{{ asset('storage/'.$setting->logo) }}">
                        @else
                            <img id="logoPreview" src="" style="display:none;">
                        @endif
                    </div>

                    {{-- RECETAS --}}
                    <div class="tab-pane fade" id="recetas">
                        <h4 class="mb-3">Ajustes de Recetas</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Mostrar Logo en Receta</label>
                                <select name="mostrar_logo_recetas" class="form-select">
                                    <option value="1" {{ old('mostrar_logo_recetas', ($setting->mostrar_logo_recetas ?? 1)) == 1 ? 'selected' : '' }}>Sí</option>
                                    <option value="0" {{ old('mostrar_logo_recetas', ($setting->mostrar_logo_recetas ?? 1)) == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Mostrar Dirección en Receta</label>
                                <select name="mostrar_direccion_recetas" class="form-select">
                                    <option value="1" {{ old('mostrar_direccion_recetas', ($setting->mostrar_direccion_recetas ?? 1)) == 1 ? 'selected' : '' }}>Sí</option>
                                    <option value="0" {{ old('mostrar_direccion_recetas', ($setting->mostrar_direccion_recetas ?? 1)) == 0 ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- FOOTER --}}
                    <div class="tab-pane fade" id="footer">
                        <h4 class="mb-3">Pie de Página PDF</h4>
                        <textarea name="footer_pdf" class="form-control" rows="3">{{ old('footer_pdf', $setting->footer_pdf ?? '') }}</textarea>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-primary">Guardar Configuración</button>
                </div>

            </form>

        </div>
    </div>

</div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    // --- Recordar pestaña activa ---
    let key = 'config_tab_activa';
    let last = localStorage.getItem(key);
    if (last) {
        let trigger = document.querySelector(`#configTabs a[href="${last}"]`);
        if (trigger) new bootstrap.Tab(trigger).show();
    }
    document.querySelectorAll('#configTabs a').forEach(a=>{
        a.addEventListener('shown.bs.tab', function(e){
            localStorage.setItem(key, e.target.getAttribute('href'));
        });
    });

    // PREVISUALIZAR LOGO — 100% FUNCIONAL
    const logoInput = document.querySelector('input[name="logo"]');
    const logoPreview = document.getElementById('logoPreview');

    if (logoInput && logoPreview) {
        logoInput.addEventListener('change', function(e){
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(ev){
                logoPreview.src = ev.target.result;
                logoPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        });
    }

    // Cambiar borde según pestaña activa
    const contentBox = document.querySelector('.tab-content');

    const coloresBorde = {
        "#clinica": "#caff9c",
        "#doctor": "#bde3ff",
        "#logo": "#fff3a8",
        "#recetas": "#ffd1df",
        "#footer": "#ffd9b3"
    };

    document.querySelectorAll('#configTabs a').forEach(tab => {
        tab.addEventListener('shown.bs.tab', function(e) {
            const destino = e.target.getAttribute('href');
            if (coloresBorde[destino]) {
                contentBox.style.borderColor = coloresBorde[destino];
            }
        });
    });

    // Color inicial
    let inicio = localStorage.getItem('config_tab_activa') || "#clinica";
    if (coloresBorde[inicio]) contentBox.style.borderColor = coloresBorde[inicio];

});
</script>
@endpush

@endsection
