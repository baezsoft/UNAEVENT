@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Disertante</h2>

    <form method="POST" action="{{ route('disertantes.update', $disertante) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
    
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $disertante->nombre) }}" required>
        </div>
        <div class="mb-3">
            <label>Apellido</label>
            <input type="text" name="apellido" class="form-control" value="{{ old('apellido', $disertante->apellido) }}" required>
        </div>
        <div class="mb-3">
            <label>Correo</label>
            <input type="email" name="correo" class="form-control" value="{{ old('correo', $disertante->correo) }}" required>
        </div>
        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $disertante->telefono) }}">
        </div>
        <div class="mb-3">
            <label>Institución</label>
            <input type="text" name="institucion" class="form-control" value="{{ old('institucion', $disertante->institucion) }}">
        </div>
        <div class="mb-3">
            <label>Especialidad</label>
            <input type="text" name="especialidad" class="form-control" value="{{ old('especialidad', $disertante->especialidad) }}">
        </div>
        <div class="mb-3">
            <label>Currículum Vitae (PDF, DOC, DOCX)</label>
            <input type="file" name="cv" class="form-control">
        </div>
        @if($disertante->cv)
            <p>Archivo actual: 
                <a href="{{ asset('storage/'.$disertante->cv) }}" target="_blank">Ver CV</a>
            </p>
        @endif

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('disertantes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
