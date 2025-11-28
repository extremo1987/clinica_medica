@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">Crear Permiso</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="{{ route('permissions.store') }}">
                @csrf

                {{-- Nombre técnico (slug) --}}
                <div class="mb-3">
                    <label class="form-label">Nombre del permiso (slug)</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Ej: users.view, roles.manage"
                           required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nombre visible --}}
                <div class="mb-3">
                    <label class="form-label">Etiqueta (opcional)</label>
                    <input type="text"
                           name="label"
                           class="form-control"
                           placeholder="Ej: Ver Usuarios, Administrar Roles">
                </div>

                <button class="btn btn-success">Guardar Permiso</button>
                <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancelar</a>

            </form>

        </div>
    </div>

</div>
@endsection
