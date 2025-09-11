@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Nuevo Disertante</h2>

    <form method="POST" action="{{ route('disertantes.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required value="{{ old('nombre') }}">
        </div>
        <div class="mb-3">
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" required value="{{ old('apellido') }}">
        </div>
        <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="correo" class="form-control" required value="{{ old('correo') }}">
        </div>
        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
        </div>
        <div class="mb-3">
            <label>Institución</label>
            <input type="text" name="institucion" class="form-control" value="{{ old('institucion') }}">
        </div>
        <div class="mb-3">
            <label>Especialidad</label>
            <input type="text" name="especialidad" class="form-control" value="{{ old('especialidad') }}">
        </div>
        <div class="mb-3">
            <label>Currículum Vitae (PDF, DOC, DOCX)</label>
            <input type="file" name="cv" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('disertantes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

{{-- Estilos personalizados --}}
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

/* Inputs */
form .form-control {
    border-radius: 10px;
    border: 1px solid #004d40;
    background-color: #ffffff;
    color: #000;
    padding: 10px;
}
form .form-control:focus {
    border-color: #00695c;
    box-shadow: 0 0 5px rgba(0, 105, 92, 0.4);
}

/* Botones */
.btn-success {
    background-color: #00695c;
    border: none;
    border-radius: 10px;
    color: #fff;
}
.btn-success:hover {
    background-color: #004d40;
}
.btn-secondary {
    background-color: #a5d6a7;
    border: none;
    color: #000;
    border-radius: 10px;
}
.btn-secondary:hover {
    background-color: #81c784;
}

/* Responsivo */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    .btn {
        width: 100%;
        margin-bottom: 8px;
    }

    .form-control {
        font-size: 14px;
        padding: 8px;
    }
}
</style>
@endsection
