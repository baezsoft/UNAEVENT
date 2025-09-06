@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Registrar Usuario</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('admin.register-user') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <label>Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="col">
                <label>Apellido</label>
                <input type="text" name="apellido" class="form-control" required>
            </div>
        </div>
        <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="correo" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>CI</label>
            <input type="text" name="ci" class="form-control">
        </div>
        <div class="mb-3">
            <label>Cargo</label>
            <select name="cargo" class="form-control">
                <option value="admin">Admin</option>
                <option value="usuario">Usuario</option>
            </select>
        </div>
        <button class="btn btn-success">Registrar</button>
    </form>
</div>
@endsection
