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
.form-control {
    border-radius: 10px;
    border: 1px solid #004d40;
    background-color: #ffffff;
    color: #000;
}

/* Botones */
.btn-success {
    background-color: #2e7d32;
    border: none;
    border-radius: 10px;
    color: #fff;
    font-weight: bold;
    padding: 10px 20px;
}
.btn-success:hover {
    background-color: #1b5e20;
}

/* Alertas */
.alert-success {
    background-color: #81c784;
    color: #000;
    border-radius: 10px;
    padding: 10px;
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        padding: 20px 10px;
    }

    .form-control {
        font-size: 14px;
    }

    .btn-success {
        width: 100%;
        padding: 12px;
        margin-top: 10px;
    }
}
</style>
@endsection
