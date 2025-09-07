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
@endsection
