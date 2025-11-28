@extends('layouts.app')
@section('title','Usuarios')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Usuarios</h1>
  <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Crear usuario</a>
</div>

<table class="table">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>Email</th>
      <th>Rol(es)</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    @foreach($users as $user)
    <tr>
      <td>{{ $user->name }}</td>
      <td>{{ $user->email }}</td>
      <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
      <td>
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Editar</a>
        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" style="display:inline">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger" onclick="return confirm('Eliminar usuario?')">Eliminar</button></form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

{{ $users->links() }}
@endsection
