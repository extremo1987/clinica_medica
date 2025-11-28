@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">Editar Permiso</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="{{ route('permissions.update', $p->id) }}">
                @csrf
                @method('PUT')

                {{-- Nombre técnico (slug) --}}
                <div class="mb-3">
                    <label class="form-label">Nombre del permiso (slug)</label>
                    <input type="text"
                           name="name"
                           value="{{ $p->name }}"
                           class="form-control @error('name') is-invalid @enderror"
                           required>
                    
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Etiqueta visible --}}
                <div class="mb-3">
                    <label class="form-label">Etiqueta (opcional)</label>
                    <input type="text"
                           name="label"
                           value="{{ $p->label }}"
                           class="form-control"
                           placeholder="Ej: Ver Usuarios, Administrar Roles">
                </div>

                <button class="btn btn-primary">Actualizar Permiso</button>
                <a href="{{ route('permissions.index') }}" class="btn btn-secondary">Cancelar</a>

            </form>

        </div>
    </div>

</div>
@endsection
