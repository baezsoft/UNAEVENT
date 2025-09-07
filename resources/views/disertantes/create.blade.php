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
@endsection
