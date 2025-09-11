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

<style>
/* Contenedor */
.container {
    background-color: #0b3d2e; /* verde oscuro */
    color: #ffffff;
    padding: 30px 20px;
    border-radius: 12px;
}

/* Encabezado */
.container h2 {
    color: #dfffe0;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Inputs y selects */
.form-control, .form-select {
    border-radius: 10px;
    border: 1px solid #004d40;
    background-color: #ffffff;
    color: #000;
}

/* Botones */
.btn-primary {
    background-color: #00695c;
    border: none;
    border-radius: 10px;
    color: #fff;
    font-weight: bold;
    padding: 10px 20px;
}
.btn-primary:hover {
    background-color: #004d40;
}

.btn-secondary {
    background-color: #a5d6a7;
    border: none;
    color: #000;
    border-radius: 10px;
    font-weight: bold;
}
.btn-secondary:hover {
    background-color: #81c784;
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        padding: 20px 10px;
    }

    .form-control, .form-select {
        font-size: 14px;
    }

    .btn-primary, .btn-secondary {
        width: 100%;
        margin-bottom: 10px;
        padding: 12px;
    }
}
</style>
@endsection
