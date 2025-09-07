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
@endsection
