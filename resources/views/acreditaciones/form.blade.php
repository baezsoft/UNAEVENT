@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registro de Acreditados</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('acreditaciones.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>DNI</label>
            <input type="text" name="dni" class="form-control" required value="{{ old('dni') }}">
        </div>
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required value="{{ old('nombre') }}">
        </div>
        <div class="mb-3">
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" required value="{{ old('apellido') }}">
        </div>
        <div class="mb-3">
            <label>Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}">
        </div>
        <div class="mb-3">
            <label>Género</label>
            <select name="genero" class="form-control">
                <option value="">Seleccione</option>
                <option value="1" {{ old('genero') === '1' ? 'selected' : '' }}>Masculino</option>
                <option value="0" {{ old('genero') === '0' ? 'selected' : '' }}>Femenino</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="correo" class="form-control" value="{{ old('correo') }}">
        </div>
        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}">
        </div>
        <div class="mb-3">
            <label>Nacionalidad</label>
            <input type="text" name="nacionalidad" class="form-control" value="{{ old('nacionalidad') }}">
        </div>
        <div class="mb-3">
            <label>Evento</label>
            <select name="id_evento" class="form-control" required>
                @foreach(App\Models\Evento::all() as $evento)
                    <option value="{{ $evento->id }}">{{ $evento->nombre }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>
@endsection
