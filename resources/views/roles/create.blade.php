@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">Crear Rol</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="{{ route('roles.store') }}">
                @csrf

                {{-- Nombre técnico --}}
                <div class="mb-3">
                    <label class="form-label">Nombre del Rol (slug)</label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Ej: admin, secretaria, medico"
                           required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Etiqueta visible --}}
                <div class="mb-3">
                    <label class="form-label">Etiqueta Visible (opcional)</label>
                    <input type="text"
                           name="label"
                           class="form-control"
                           placeholder="Ej: Administrador del sistema">
                </div>

                {{-- Permisos --}}
                <div class="mb-3">
                    <label class="form-label">Permisos para este Rol</label>

                    @foreach($permissions as $p)
                        <div class="form-check">
                            <input type="checkbox"
                                   name="permissions[]"
                                   value="{{ $p->id }}"
                                   id="perm{{ $p->id }}"
                                   class="form-check-input">

                            <label class="form-check-label" for="perm{{ $p->id }}">
                                {{ $p->label ?: $p->name }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <button class="btn btn-success">Guardar Rol</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>

            </form>

        </div>
    </div>

</div>
@endsection
