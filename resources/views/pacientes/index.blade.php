@extends('layouts.app')

@section('content')

<style>
/* FOTO MINI */
.foto-mini {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 2px solid #90caf9;
    object-fit: cover;
}

/* TARJETAS */
.badge-expediente {
    background: #1565c0 !important;
    color: #fff !important;
    padding: 5px 10px;
    border-radius: 12px;
}

/* ESTILO BUSCADOR PRINCIPAL */
.dataTables_filter {
    text-align: right !important;
}

.dataTables_filter input {
    width: 320px !important;
    height: 42px !important;
    padding-left: 40px !important;
    border-radius: 14px;
    border: 1px solid #b0bec5;
    background: #fff url('https://cdn-icons-png.flaticon.com/512/622/622669.png') no-repeat 10px center;
    background-size: 18px;
    font-size: 15px;
}

/* BOTÓN FILTRO AVANZADO */
.btn-filtros {
    border-radius: 12px;
    padding: 8px 14px;
    font-size: 15px;
    border: none;
    background: #1976d2;
    color: #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,.2);
}

/* FILTROS AVANZADOS */
.filtro-box input,
.filtro-box select {
    height: 38px;
    border-radius: 10px;
}

/* PAGINACION BONITA */
.dataTables_paginate a {
    padding: 6px 12px !important;
    border-radius: 10px !important;
}

.dataTables_paginate .paginate_button.current {
    background: #1565c0 !important;
    color: #fff !important;
}
</style>


<div class="page-body">
<div class="container-xl">

    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="page-title">Pacientes</h2>

        <div class="d-flex align-items-center gap-2">

            {{-- BOTÓN FILTRO AVANZADO --}}
            <button class="btn-filtros" id="toggleFiltros">
                🔎 Filtros Avanzados
            </button>

            <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
                + Nuevo Paciente
            </a>
        </div>
    </div>

    {{-- MENSAJE --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- FILTRO AVANZADO --}}
    <div id="filtroAvanzado" class="collapse mb-3">
        <div class="card shadow-sm" style="border-radius: 14px;">
            <div class="card-body filtro-box">

                <h5 class="mb-3">Filtros Avanzados</h5>

                <div class="row g-3">

                    <div class="col-md-3">
                        <label>Nombre</label>
                        <input type="text" id="filterNombre" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Expediente</label>
                        <input type="text" id="filterExpediente" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Identidad</label>
                        <input type="text" id="filterIdentidad" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Edad mín</label>
                        <input type="number" id="filterEdadMin" class="form-control">
                    </div>

                    <div class="col-md-2">
                        <label>Edad máx</label>
                        <input type="number" id="filterEdadMax" class="form-control">
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-secondary w-100" id="btnResetFilters">Reset</button>
                    </div>

                </div>

            </div>
        </div>
    </div>

    {{-- TABLA --}}
    <div class="card shadow-lg" style="border-radius: 16px;">
        <div class="card-body">

            <div class="table-responsive">
                <table id="pacientesTable" class="table table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Foto</th>
                            <th>Expediente</th>
                            <th>Nombre</th>
                            <th>Identidad</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Edad</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($pacientes as $p)
                        <tr>
                            <td><img src="{{ $p->foto ? asset('storage/'.$p->foto) : asset('images/default-user.png') }}"
                                     class="foto-mini"></td>
                            <td><span class="badge badge-expediente">{{ $p->expediente }}</span></td>
                            <td>{{ $p->nombre }}</td>
                            <td>{{ $p->identidad ?: '—' }}</td>
                            <td>{{ $p->telefono ?: '—' }}</td>
                            <td>{{ $p->email ?: '—' }}</td>
                            <td>{{ $p->edad ? $p->edad . ' años' : '—' }}</td>
                            <td class="text-end">

                            <a href="{{ route('pacientes.showpaciente',$p->id) }}"
                            class="btn btn-sm btn-info">Ver</a>

                            <a href="{{ route('pacientes.edit',$p->id) }}"
                            class="btn btn-sm btn-primary">Editar</a>

                            {{-- LLEVA AL HISTORIAL DE CONSULTAS --}}
                            <a href="{{ route('pacientes.show', $p->id) }}"
                            class="btn btn-sm btn-success">
                                Consultas
                            </a>

                            <button class="btn btn-sm btn-danger"
                                    onclick="confirmDeletePaciente('{{ route('pacientes.destroy',$p->id) }}')">
                                Eliminar
                            </button>

                        </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>
</div>


{{-- MODAL ELIMINACIÓN --}}
<div class="modal fade" id="confirmDeleteModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">
                ¿Deseas eliminar este paciente?<br>
                <strong>Esta acción no se puede deshacer.</strong>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deletePacienteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Eliminar</button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection



{{-- ===================== SCRIPTS ===================== --}}
@push('scripts')

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>


<script>
$(document).ready(function(){

    // ===============================================
    //   TOGGLE FILTRO AVANZADO (FUNCIONANDO)
    // ===============================================
    const collapseEl = document.getElementById('filtroAvanzado');
    const bsCollapse = new bootstrap.Collapse(collapseEl, { toggle: false });

    $('#toggleFiltros').on('click', function(){
        bsCollapse.toggle();
    });


    // ===============================================
    //   DATATABLES
    // ===============================================
    var tabla = $('#pacientesTable').DataTable({
        pageLength: 10,
        ordering: true,
        dom: '<"d-flex justify-content-between mb-3"Bf>rt<"d-flex justify-content-between mt-3"ip>',
        buttons: [

            { extend:'excelHtml5', text:'Excel', className:'btn btn-success btn-sm' },

            // EXPORTACIÓN FOTO FUNCIONANDO
            { extend:'pdfHtml5', text:'PDF', className:'btn btn-danger btn-sm', exportOptions:{ columns:':visible' } },

            // IMPRESIÓN CON FOTOS OK
            {
    extend: 'print',
    text: 'Imprimir',
    className: 'btn btn-dark btn-sm',

    exportOptions: { columns: ':visible' },

    customize: function (win) {

        let images = win.document.querySelectorAll('img');

        images.forEach(function(img) {

            let src = img.getAttribute('src');

            // Crear un objeto imagen temporal
            let tempImg = new Image();
            tempImg.crossOrigin = 'Anonymous';

            tempImg.onload = function () {
                let canvas = document.createElement('canvas');
                canvas.width = tempImg.width;
                canvas.height = tempImg.height;

                let ctx = canvas.getContext('2d');
                ctx.drawImage(tempImg, 0, 0);

                let dataURL = canvas.toDataURL('image/png');

                // Cambiar la imagen en el documento de impresión
                img.setAttribute('src', dataURL);
            };

            tempImg.src = src;
        });

    }
}

        ],
        language: {
            search: "",
            searchPlaceholder: "Buscar paciente...",
            paginate: {
                next: "Siguiente →",
                previous: "← Anterior"
            }
        }
    });


    // ===============================================
    //   FILTROS AVANZADOS
    // ===============================================

    $("#filterNombre").on('input', function(){ tabla.column(2).search(this.value).draw(); });
    $("#filterExpediente").on('input', function(){ tabla.column(1).search(this.value).draw(); });
    $("#filterIdentidad").on('input', function(){ tabla.column(3).search(this.value).draw(); });

    $.fn.dataTable.ext.search.push(function(settings, data){
        const edadTxt = data[6] || '';
        const edad = parseInt(edadTxt.replace(/\D/g,'')) || 0;

        const min = parseInt($('#filterEdadMin').val()) || 0;
        const max = parseInt($('#filterEdadMax').val()) || 200;

        return edad >= min && edad <= max;
    });

    $("#filterEdadMin, #filterEdadMax").on('input', function(){ tabla.draw(); });

    $("#btnResetFilters").click(function(){
        $("#filterNombre, #filterExpediente, #filterIdentidad, #filterEdadMin, #filterEdadMax").val('');
        tabla.search('').columns().search('').draw();
    });

});


// ===============================================
// CONFIRMAR ELIMINAR
// ===============================================
window.confirmDeletePaciente = function(url){
    let modal = new bootstrap.Modal(document.getElementById("confirmDeleteModal"));
    document.getElementById("deletePacienteForm").action = url;
    modal.show();
};
</script>

@endpush
