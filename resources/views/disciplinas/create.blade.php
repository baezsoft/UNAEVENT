@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Nueva Disciplina</h2>

    <form method="POST" action="{{ route('disciplinas.store') }}">
        @csrf
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required value="{{ old('nombre') }}">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('disciplinas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<style>
/* Contenedor */
.container {
    background-color: #0b3d2e; /* verde oscuro */
    padding: 20px;
    border-radius: 12px;
    color: #ffffff;
}

/* Encabezado */
.container h2 {
    color: #dfffe0;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Formulario */
form .form-control {
    border-radius: 10px;
    border: 1px solid #004d40;
    background-color: #ffffff;
    color: #000;
}

form .btn-success {
    background-color: #2e7d32;
    border: none;
    border-radius: 10px;
    color: #fff;
}
form .btn-success:hover {
    background-color: #1b5e20;
}

form .btn-secondary {
    background-color: #a5d6a7;
    border: none;
    color: #000;
    border-radius: 10px;
}
form .btn-secondary:hover {
    background-color: #81c784;
}

/* Responsivo */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    form .btn {
        width: 100%;
        margin-bottom: 8px;
    }

    form .mb-3 {
        margin-bottom: 12px;
    }
}
</style>
@endsection
