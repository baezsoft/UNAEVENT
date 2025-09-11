@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Detalles de la Disciplina</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $disciplina->id }}</p>
            <p><strong>Nombre:</strong> {{ $disciplina->nombre }}</p>
            <p><strong>Inhabilitado:</strong> {{ $disciplina->inhabilitado ? 'Sí' : 'No' }}</p>
        </div>
    </div>

    <a href="{{ route('disciplinas.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>

<style>
/* Contenedor */
.container {
    background-color: #0b3d2e; /* verde oscuro */
    padding: 20px;
    border-radius: 12px;
    color: #ffffff;
}

/* Encabezado */
.container h2 {
    color: #dfffe0;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Card */
.card {
    background-color: #ffffff;
    color: #000;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

/* Botones */
.btn-secondary {
    background-color: #a5d6a7;
    border: none;
    color: #000;
    border-radius: 10px;
    padding: 8px 15px;
}
.btn-secondary:hover {
    background-color: #81c784;
}

/* Responsivo */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    .card {
        padding: 12px;
    }

    .btn {
        width: 100%;
        margin-bottom: 8px;
    }
}
</style>
@endsection
