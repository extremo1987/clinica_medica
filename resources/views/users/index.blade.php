@extends('layouts.app')

@section('content')
@stack('scripts')

<style>
    .role-badge {
        padding: 6px 10px;
        border-radius: 14px;
        font-size: 13px;
        font-weight: 600;
        color: #fff !important;
    }
</style>

<div class="page-body">
    <div class="container-xl">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">Usuarios del Sistema</h2>

            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <svg class="icon me-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                     fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z"/>
                    <path d="M12 5v14m-7 -7h14" />
                </svg>
                Nuevo Usuario
            </a>
        </div>

        <div class="card shadow-lg" style="border-radius:16px;">
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-vcenter">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>

                                    <td>
                                        @foreach($user->roles as $role)

                                            @php
                                                $color = 'secondary'; // default

                                                if ($role->name === 'admin')         $color = 'danger';
                                                if ($role->name === 'doctor')        $color = 'success';
                                                if ($role->name === 'recepcion')     $color = 'primary';
                                                if ($role->name === 'enfermeria')    $color = 'info';
                                                if ($role->name === 'laboratorio')   $color = 'indigo';
                                            @endphp

                                            <span class="role-badge bg-{{ $color }}">
                                                {{ $role->label }}
                                            </span>

                                        @endforeach
                                    </td>

                                    <td class="text-end">

                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="btn btn-sm btn-outline-primary">
                                            Editar
                                        </a>

                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete('{{ route('users.destroy', $user->id) }}')">
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
@endsection


{{-- MODAL --}}
<div class="modal modal-blur fade" id="confirmDeleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Confirmar Eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">

        <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-3 text-danger"
             width="48" height="48" stroke-width="2" stroke="currentColor" fill="none">
            <path d="M12 9v4m0 4v.01" />
            <path d="M5 19h14l-7 -14z" />
        </svg>

        <p class="text-muted">
            ¿Deseas eliminar este usuario?
            <br><strong>Esta acción no se puede deshacer.</strong>
        </p>

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>

        <form id="deleteUserForm" method="POST">
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
document.addEventListener("DOMContentLoaded", function () {

    window.confirmDelete = function(actionUrl) {
        const modal = new bootstrap.Modal(document.getElementById("confirmDeleteModal"));
        document.getElementById("deleteUserForm").action = actionUrl;
        modal.show();
    };

});
</script>
@endpush
