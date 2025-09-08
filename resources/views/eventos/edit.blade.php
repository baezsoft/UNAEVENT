@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Evento</h1>
    <form action="{{ route('eventos.update', $evento) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ $evento->nombre }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control">{{ $evento->descripcion }}</textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ $evento->fecha->format('Y-m-d') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Lugar</label>
            <input type="text" name="lugar" class="form-control" value="{{ $evento->lugar }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Tarifa</label>
            <input type="number" step="0.01" name="tarifa" class="form-control" value="{{ $evento->tarifa }}">
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
