@extends('layouts.app')
@section('title','Crear usuario')
@section('content')
<h1>Crear usuario</h1>

<form method="POST" action="{{ route('admin.users.store') }}">
  @csrf
  <div class="mb-3">
    <label>Nombre</label>
    <input name="name" class="form-control" value="{{ old('name') }}">
  </div>

  <div class="mb-3">
    <label>Email</label>
    <input name="email" type="email" class="form-control" value="{{ old('email') }}">
  </div>

  <div class="row">
    <div class="col-md-6 mb-3">
      <label>Contraseña</label>
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
        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
      @endforeach
    </select>
  </div>

  <button class="btn btn-primary">Guardar</button>
</form>
@endsection
