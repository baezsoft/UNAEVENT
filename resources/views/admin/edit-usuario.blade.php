@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Editar Usuario</h2>
    <form action="{{ route('admin.update-usuario', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ $usuario->nombre }}" required>
            </div>
            <div class="col">
                <label>Apellido</label>
                <input type="text" name="apellido" class="form-control" value="{{ $usuario->apellido }}" required>
            </div>
        </div>
        <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="correo" class="form-control" value="{{ $usuario->correo }}" required>
        </div>
        <div class="mb-3">
            <label>Contraseña (dejar vacío si no cambia)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="mb-3">
            <label>CI</label>
            <input type="text" name="ci" class="form-control" value="{{ $usuario->ci }}">
        </div>
        <div class="mb-3">
            <label>Cargo</label>
            <select name="cargo" class="form-control">
                <option value="admin" {{ $usuario->cargo === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="usuario" {{ $usuario->cargo === 'usuario' ? 'selected' : '' }}>Usuario</option>
            </select>
        </div>
        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.usuarios') }}" class="btn btn-secondary">Volver</a>
    </form>
</div>
@endsection
