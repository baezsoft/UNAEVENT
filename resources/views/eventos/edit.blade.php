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
    <h1>Editar Evento</h1>

    <form action="{{ route('eventos.update', $evento) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input 
                type="text" 
                name="nombre" 
                class="form-control" 
                value="{{ old('nombre', $evento->nombre) }}" 
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea 
                name="descripcion" 
                class="form-control"
                rows="3"
            >{{ old('descripcion', $evento->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input 
                type="date" 
                name="fecha" 
                class="form-control" 
                value="{{ old('fecha', $evento->fecha->format('Y-m-d')) }}" 
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Lugar</label>
            <input 
                type="text" 
                name="lugar" 
                class="form-control" 
                value="{{ old('lugar', $evento->lugar) }}"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Tarifa</label>
            <input 
                type="number" 
                step="0.01" 
                name="tarifa" 
                class="form-control" 
                value="{{ old('tarifa', $evento->tarifa) }}"
            >
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('eventos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
