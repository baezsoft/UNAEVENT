@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nuevo Evento</h1>
    <form action="{{ route('eventos.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Lugar</label>
            <input type="text" name="lugar" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Tarifa</label>
            <input type="number" step="0.01" name="tarifa" class="form-control" value="0">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
