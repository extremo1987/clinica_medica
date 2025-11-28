@extends('layouts.app')

@section('content')

<style>
    .perm-badge {
        font-size: 13px;
        border-radius: 14px;
        padding: 6px 10px;
        color: #fff !important;
        display: inline-block;
        margin-bottom: 4px;
    }

    .table thead th {
        background: #f8f9fa;
        font-weight: 600;
        border-bottom: 2px solid #dee2e6;
    }
</style>

<div class="page-body">
    <div class="container-xl">

        {{-- Encabezado --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Roles del Sistema</h2>

            <a href="{{ route('roles.create') }}" class="btn btn-primary">
                <svg class="icon me-1" xmlns="http://www.w3.org/2000/svg"
                     width="20" height="20" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentColor" fill="none"
                     stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z"/>
                    <path d="M12 5v14m-7 -7h14" />
                </svg>
                Nuevo Rol
            </a>
        </div>

        {{-- Mensaje --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- TARJETA PRINCIPAL (ELEGANTE) --}}
        <div class="card shadow-lg" style="border-radius: 16px;">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-vcenter">
                        <thead>
                            <tr>
                                <th>Nombre (slug)</th>
                                <th>Etiqueta Visible</th>
                                <th>Permisos del Rol</th>
                                <th class="text-end" width="200">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($roles as $r)
                                <tr>
                                    <td>{{ $r->name }}</td>
                                    <td>{{ $r->label ?: '—' }}</td>

                                    {{-- Permisos --}}
                                    <td>
                                        @php
                                            $perms = $r->permissions->sortBy('label');
                                        @endphp

                                        @if($perms->count())
                                            @foreach($perms as $p)

                                                @php
                                                    // Colores según tipo
                                                    $color = 'primary';

                                                    if (str_contains($p->name, 'view'))   $color = 'info';
                                                    if (str_contains($p->name, 'manage')) $color = 'warning';
                                                    if (str_contains($p->name, 'create')) $color = 'success';
                                                    if (str_contains($p->name, 'edit'))   $color = 'secondary';
                                                    if (str_contains($p->name, 'delete')) $color = 'danger';
                                                @endphp

                                                <span class="perm-badge bg-{{ $color }}"
                                                      title="{{ $p->label ?: $p->name }}">
                                                    {{ \Illuminate\Support\Str::limit($p->label ?: $p->name, 22) }}
                                                </span>

                                            @endforeach
                                        @else
                                            <span class="text-muted">Sin permisos</span>
                                        @endif
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="text-end">

                                        <a href="{{ route('roles.edit', $r->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Editar
                                        </a>

                                        <a href="{{ route('roles.permissions.edit', $r->id) }}"
                                           class="btn btn-sm btn-outline-info">
                                            Permisos
                                        </a>

                                        <button class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDeleteRole('{{ route('roles.destroy',$r->id) }}')">
                                            Eliminar
                                        </button>

                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-3">
                                        No hay roles registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <div class="mt-3">
                    {{ $roles->links() }}
                </div>

            </div>
        </div>

    </div>
</div>


{{-- MODAL ELIMINACIÓN (igual al de usuarios/pacientes) --}}
<div class="modal modal-blur fade" id="deleteRoleModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Eliminar Rol</h5>
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
            ¿Deseas eliminar este rol?
            <br><strong>Esta acción no se puede deshacer.</strong>
        </p>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

        <form id="deleteRoleForm" method="POST">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Eliminar</button>
        </form>
      </div>

    </div>
  </div>
</div>


@push('scripts')
<script>
function confirmDeleteRole(actionUrl){
    const modal = new bootstrap.Modal(document.getElementById("deleteRoleModal"));
    document.getElementById("deleteRoleForm").action = actionUrl;
    modal.show();
}
</script>
@endpush

@endsection
