@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>{{ isset($sala) ? 'Editar Sala' : 'Crear Sala' }}</h1>

    <a href="{{ route('salas.index') }}" class="btn btn-secondary mb-3">Volver</a>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form 
        action="{{ isset($sala) ? route('salas.update', $sala) : route('salas.store') }}" 
        method="POST"
    >
        @csrf
        @if(isset($sala))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre de la sala</label>
            <input 
                type="text" 
                name="nombre" 
                id="nombre" 
                class="form-control" 
                value="{{ old('nombre', $sala->nombre ?? '') }}" 
                required
            >
        </div>

        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad</label>
            <input 
                type="number" 
                name="capacidad" 
                id="capacidad" 
                class="form-control" 
                value="{{ old('capacidad', $sala->capacidad ?? '') }}" 
                required
                min="1"
            >
        </div>

        @if(isset($sala))
            <div class="mb-3 form-check">
                <input 
                    type="checkbox" 
                    name="inhabilitado" 
                    id="inhabilitado" 
                    class="form-check-input" 
                    value="1" 
                    {{ old('inhabilitado', $sala->inhabilitado) ? 'checked' : '' }}
                >
                <label for="inhabilitado" class="form-check-label">Inhabilitado</label>
            </div>
        @endif

        <button type="submit" class="btn btn-primary">
            {{ isset($sala) ? 'Actualizar Sala' : 'Crear Sala' }}
        </button>
    </form>
</div>
@endsection
