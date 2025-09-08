@extends('layouts.app')

@section('content')
<div class="container">
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
@endsection
