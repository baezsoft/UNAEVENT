@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Detalles del Disertante</h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $disertante->nombre }}</p>
            <p><strong>Apellido:</strong> {{ $disertante->apellido }}</p>
            <p><strong>Correo:</strong> {{ $disertante->correo }}</p>
            <p><strong>Teléfono:</strong> {{ $disertante->telefono ?? 'N/A' }}</p>
            <p><strong>Institución:</strong> {{ $disertante->institucion ?? 'N/A' }}</p>
            <p><strong>Especialidad:</strong> {{ $disertante->especialidad ?? 'N/A' }}</p>
            <p><strong>Currículum:</strong> 
                @if($disertante->cv)
                    <a href="{{ asset('storage/'.$disertante->cv) }}" target="_blank">Descargar CV</a>
                @else
                    No disponible
                @endif
            </p>
            <p><strong>Inhabilitado:</strong> {{ $disertante->inhabilitado ? 'Sí' : 'No' }}</p>
        </div>
    </div>

    <a href="{{ route('disertantes.index') }}" class="btn btn-secondary mt-3">Volver</a>
</div>
@endsection
