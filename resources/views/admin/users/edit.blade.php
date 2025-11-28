@extends('layouts.app')
@section('title','Editar usuario')
@section('content')
<h1>Editar usuario</h1>

<form method="POST" action="{{ route('admin.users.update', $user) }}">
  @csrf @method('PUT')
  <div class="mb-3">
    <label>Nombre</label>
    <input name="name" class="form-control" value="{{ old('name',$user->name) }}">
  </div>

  <div class="mb-3">
    <label>Email</label>
    <input name="email" type="email" class="form-control" value="{{ old('email',$user->email) }}">
  </div>

  <div class="row">
    <div class="col-md-6 mb-3">
      <label>Nueva contraseña (opcional)</label>
      <input name="password" type="password" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
      <label>Confirmar contraseña</label>
      <input name="password_confirmation" type="password" class="form-control">
    </div>
  </div>

  <div class="mb-3">
    <label>Rol</label>
    <select name="role" class="form-control">
      @foreach($roles as $role)
        <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
      @endforeach
    </select>
  </div>

  <button class="btn btn-primary">Actualizar</button>
</form>
@endsection
