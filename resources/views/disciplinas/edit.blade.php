@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Disciplina</h2>

    <form method="POST" action="{{ route('disciplinas.update', $disciplina) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $disciplina->nombre) }}" required>
        </div>
        <div class="mb-3">
            <label>Inhabilitado</label>
            <select name="inhabilitado" class="form-select">
                <option value="0" {{ !$disciplina->inhabilitado ? 'selected' : '' }}>No</option>
                <option value="1" {{ $disciplina->inhabilitado ? 'selected' : '' }}>Sí</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('disciplinas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
