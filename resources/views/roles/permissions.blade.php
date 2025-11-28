@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-3">
        Asignar Permisos al Rol: 
        <strong class="text-primary">{{ $role->label ?: $role->name }}</strong>
    </h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST" action="{{ route('roles.permissions.update', $role->id) }}">
                @csrf
                @method('PUT')

                <div class="alert alert-info">
                    Seleccione los permisos que este rol podrá realizar dentro de cada módulo del sistema.
                </div>

                @php
                    // Agrupamos permisos por módulo antes de pintar
                    $agrupados = [];

                    foreach ($permissions as $p) {
                        $partes = explode('.', $p->name);
                        $modulo = strtoupper($partes[0] ?? 'OTROS');
                        $agrupados[$modulo][] = $p;
                    }
                @endphp

                @foreach($agrupados as $modulo => $listaPermisos)
                    <div class="mb-4 border rounded p-3 bg-light">

                        <h5 class="mb-3 text-dark">
                            <strong>{{ $modulo }}</strong>
                        </h5>

                        <div class="row">
                            @foreach($listaPermisos as $p)
                                <div class="col-md-4 mb-2">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               name="permissions[]"
                                               value="{{ $p->id }}"
                                               id="p{{ $p->id }}"
                                               class="form-check-input"
                                               @if($role->permissions->contains($p->id)) checked @endif>

                                        <label class="form-check-label" for="p{{ $p->id }}">
                                            {{ $p->label ?: ucfirst($p->name) }}
                                            <br>
                                            <small class="text-muted">{{ $p->name }}</small>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                @endforeach

                <button class="btn btn-success mt-2">Guardar Cambios</button>
                <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-2">Cancelar</a>

            </form>

        </div>
    </div>

</div>
@endsection
