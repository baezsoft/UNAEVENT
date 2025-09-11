@extends('layouts.app')

<style>
/* Contenedor */
.container {
    background-color: #0b3d2e; /* verde oscuro */
    padding: 20px;
    border-radius: 12px;
    color: #ffffff;
    max-width: 700px;
}

/* Títulos */
.container h1 {
    color: #dfffe0;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Labels */
.form-label {
    font-weight: bold;
    color: #e0f2f1;
}

/* Inputs */
.form-control {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 10px;
}

.form-control:focus {
    border-color: #4caf50;
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
}

/* Checkbox */
.form-check-label {
    color: #e0f2f1;
}

/* Botones */
.btn-primary {
    background-color: #00695c;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
}
.btn-primary:hover {
    background-color: #004d40;
}

.btn-secondary {
    background-color: #757575;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
}
.btn-secondary:hover {
    background-color: #5a5a5a;
}

/* Errores */
.alert-danger {
    border-radius: 10px;
}

/* Responsivo */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    .btn {
        width: 100%;
        margin-bottom: 10px;
    }
}
</style>

@section('content')
<div class="container mt-4">
    <h1>{{ isset($sala) ? 'Editar Sala' : 'Crear Sala' }}</h1>

    <a href="{{ route('salas.index') }}" class="btn btn-secondary mb-3">← Volver</a>

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
