@extends('layouts.app')

@section('content')

<style>
    .perm-badge {
        font-size: 13px;
        padding: 6px 10px;
        border-radius: 12px;
        font-weight: 600;
        color: #fff !important;
    }
</style>

<div class="page-body">
    <div class="container-xl">

        {{-- Encabezado --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Permisos del Sistema</h2>

            <a href="{{ route('permissions.create') }}" class="btn btn-primary">
                <svg class="icon me-1" xmlns="http://www.w3.org/2000/svg"
                     width="20" height="20" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z"/>
                    <path d="M12 5v14m-7 -7h14" />
                </svg>
                Nuevo Permiso
            </a>
        </div>

        {{-- Mensaje --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- TARJETA PRINCIPAL --}}
        <div class="card shadow-lg" style="border-radius: 16px;">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-vcenter">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre (slug)</th>
                                <th>Etiqueta Visible</th>
                                <th>Tipo de Permiso</th>
                                <th class="text-end" width="160">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                        @forelse($permissions as $p)
                            <tr>

                                {{-- SLUG --}}
                                <td>{{ $p->name }}</td>

                                {{-- LABEL --}}
                                <td>{{ $p->label ?: '—' }}</td>

                                {{-- TIPO --}}
                                <td>
                                    @php
                                        $tipo = 'General';
                                        $color = 'secondary';

                                        if (str_contains($p->name, 'view'))   { $tipo = 'Ver';        $color = 'info'; }
                                        if (str_contains($p->name, 'create')) { $tipo = 'Crear';      $color = 'success'; }
                                        if (str_contains($p->name, 'edit'))   { $tipo = 'Editar';     $color = 'warning'; }
                                        if (str_contains($p->name, 'delete')) { $tipo = 'Eliminar';   $color = 'danger'; }
                                        if (str_contains($p->name, 'manage')) { $tipo = 'Administrar';$color = 'primary'; }
                                    @endphp

                                    <span class="perm-badge bg-{{ $color }}">
                                        {{ $tipo }}
                                    </span>
                                </td>

                                {{-- ACCIONES --}}
                                <td class="text-end">

                                    {{-- Editar --}}
                                    <a href="{{ route('permissions.edit', $p->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Editar
                                    </a>

                                    {{-- Eliminar --}}
                                    <button class="btn btn-sm btn-outline-danger"
                                            onclick="confirmDeletePermission('{{ route('permissions.destroy', $p->id) }}')">
                                        Eliminar
                                    </button>

                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-3">
                                    No hay permisos registrados.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINACIÓN --}}
                <div class="mt-3">
                    {{ $permissions->links() }}
                </div>

            </div>
        </div>

    </div>
</div>


{{-- MODAL ELEGANTE --}}
<div class="modal modal-blur fade" id="deletePermissionModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Eliminar Permiso</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">

        <svg xmlns="http://www.w3.org/2000/svg"
             class="icon mb-3 text-danger" width="48" height="48"
             stroke-width="2" stroke="currentColor" fill="none"
             viewBox="0 0 24 24">
            <path d="M12 9v4m0 4v.01" />
            <path d="M5 19h14l-7 -14z" />
        </svg>

        <p class="text-muted">
            ¿Deseas eliminar este permiso?
            <br><strong>Esta acción no se puede deshacer.</strong>
        </p>

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

        <form id="deletePermissionForm" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Eliminar</button>
        </form>
      </div>

    </div>
  </div>
</div>


{{-- SCRIPT PARA MODAL --}}
@push('scripts')
<script>
function confirmDeletePermission(actionUrl){
    const modal = new bootstrap.Modal(document.getElementById("deletePermissionModal"));
    document.getElementById("deletePermissionForm").action = actionUrl;
    modal.show();
}
</script>
@endpush

@endsection
