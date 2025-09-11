@extends('layouts.app')

<style>
.container {
    background-color: #0b3d2e; /* Verde oscuro */
    padding: 20px;
    border-radius: 12px;
    color: #ffffff;
    max-width: 800px;
}

/* Título */
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

/* Inputs y textarea */
.form-control {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 10px;
}

.form-control:focus {
    border-color: #4caf50;
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
}

/* Botones */
.btn-success {
    background-color: #00695c;
    border: none;
    border-radius: 8px;
    padding: 10px 20px;
}
.btn-success:hover {
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
    <h1>Nuevo Evento</h1>

    {{-- Mostrar errores de validación --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('eventos.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input 
                type="text" 
                name="nombre" 
                class="form-control" 
                value="{{ old('nombre') }}" 
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea 
                name="descripcion" 
                class="form-control"
                rows="3"
            >{{ old('descripcion') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input 
                type="date" 
                name="fecha" 
                class="form-control" 
                value="{{ old('fecha') }}" 
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Lugar</label>
            <input 
                type="text" 
                name="lugar" 
                class="form-control" 
                value="{{ old('lugar') }}"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Tarifa</label>
            <input 
                type="number" 
                step="0.01" 
                name="tarifa" 
                class="form-control" 
                value="{{ old('tarifa', 0) }}"
            >
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
