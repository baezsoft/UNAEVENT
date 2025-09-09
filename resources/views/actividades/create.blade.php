@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Actividad</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('actividades.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
        </div>

        <div class="mb-3">
            <label>Usuario</label>
            <select name="id_usuario" class="form-control" required>
                <option value="">Seleccione un usuario</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ old('id_usuario') == $usuario->id ? 'selected' : '' }}>{{ $usuario->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Disertante</label>
            <select name="id_disertante" class="form-control">
                <option value="">Seleccione un disertante</option>
                @foreach($disertantes as $disertante)
                    <option value="{{ $disertante->id }}" {{ old('id_disertante') == $disertante->id ? 'selected' : '' }}>{{ $disertante->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Sala</label>
            <select name="id_sala" class="form-control">
                <option value="">Seleccione una sala</option>
                @foreach($salas as $sala)
                    <option value="{{ $sala->id }}" {{ old('id_sala') == $sala->id ? 'selected' : '' }}>{{ $sala->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Disciplina</label>
            <select name="id_disciplina" class="form-control">
                <option value="">Seleccione una disciplina</option>
                @foreach($disciplinas as $disciplina)
                    <option value="{{ $disciplina->id }}" {{ old('id_disciplina') == $disciplina->id ? 'selected' : '' }}>{{ $disciplina->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Evento</label>
            <select name="id_evento" class="form-control">
                <option value="">Seleccione un evento</option>
                @foreach($eventos as $evento)
                    <option value="{{ $evento->id }}" {{ old('id_evento') == $evento->id ? 'selected' : '' }}>{{ $evento->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ old('fecha') }}" required>
        </div>

        <div class="mb-3">
            <label>Hora Inicio</label>
            <input type="time" name="hora_inicio" class="form-control" value="{{ old('hora_inicio') }}" required>
        </div>

        <div class="mb-3">
            <label>Hora Fin</label>
            <input type="time" name="hora_fin" class="form-control" value="{{ old('hora_fin') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
