@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Acreditado</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('acreditaciones.update', $acreditado) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>DNI</label>
            <input type="text" name="dni" class="form-control" value="{{ $acreditado->dni }}" readonly>
        </div>

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $acreditado->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $acreditado->apellido) }}" required>
        </div>

        <div class="mb-3">
            <label>Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $acreditado->fecha_nacimiento?->format('Y-m-d')) }}">
        </div>

        <div class="mb-3">
            <label>Género</label>
            <select name="genero" class="form-control">
                <option value="">Seleccione</option>
                <option value="1" {{ $acreditado->genero === true ? 'selected' : '' }}>Masculino</option>
                <option value="0" {{ $acreditado->genero === false ? 'selected' : '' }}>Femenino</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="correo" class="form-control" value="{{ old('correo', $acreditado->correo) }}">
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $acreditado->telefono) }}">
        </div>

        <div class="mb-3">
            <label>Nacionalidad</label>
            <input type="text" name="nacionalidad" class="form-control" value="{{ old('nacionalidad', $acreditado->nacionalidad) }}">
        </div>

        <div class="mb-3">
            <label>Evento</label>
            <select name="id_evento" class="form-control" required>
                @foreach(App\Models\Evento::all() as $evento)
                    <option value="{{ $evento->id }}" {{ $acreditado->id_evento == $evento->id ? 'selected' : '' }}>
                        {{ $evento->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Estado</label>
            <select name="estado" class="form-control" required>
                <option value="pendiente" {{ $acreditado->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="aprobado" {{ $acreditado->estado === 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                <option value="rechazado" {{ $acreditado->estado === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
            </select>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="inhabilitado" class="form-check-input" value="1" {{ $acreditado->inhabilitado ? 'checked' : '' }}>
            <label class="form-check-label">Inhabilitado</label>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="{{ route('acreditaciones.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<style>
/* Contenedor */
.container {
    background-color: #0b3d2e; /* verde oscuro */
    padding: 25px 20px;
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
.form-control, .form-select, .form-check-input {
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
    padding: 8px 16px;
}
.btn-primary:hover {
    background-color: #004d40;
}
.btn-secondary {
    background-color: #a5d6a7;
    color: #000;
    border-radius: 10px;
    border: none;
}
.btn-secondary:hover {
    background-color: #81c784;
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
        padding: 15px 10px;
    }

    .btn-primary, .btn-secondary {
        width: 100%;
        margin-bottom: 10px;
    }

    .form-control, .form-select {
        font-size: 14px;
    }
}
</style>
@endsection
