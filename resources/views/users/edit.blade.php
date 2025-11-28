@extends('layouts.app')

@section('content')
<div class="page-body">
    <div class="container-xl">

        <h2 class="page-title mb-4">Editar Usuario</h2>

        <div class="card shadow-lg" style="border-radius: 16px;">
            <div class="card-body">

                <form action="{{ route('users.update', $usuario->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text" name="name" class="form-control"
                                   value="{{ $usuario->name }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control"
                                   value="{{ $usuario->email }}" required>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nueva Contraseña (opcional)</label>
                            <input type="password" name="password" class="form-control"
                                   placeholder="Dejar vacío para mantener la actual">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rol Actual</label>
                            <select name="role_id" class="form-select" required>
                                @foreach($roles as $r)
                                    <option value="{{ $r->id }}"
                                        {{ $usuario->roles->first()->id == $r->id ? 'selected' : '' }}>
                                        {{ $r->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="mt-3 text-end">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
                        <button class="btn btn-primary">Guardar Cambios</button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>
@endsection
