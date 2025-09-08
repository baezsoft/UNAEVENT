@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Perfil de Acreditado</h2>

    <div class="card mt-3">
        <div class="card-body">
            <p><strong>DNI:</strong> {{ $acreditado->dni }}</p>
            <p><strong>Nombre:</strong> {{ $acreditado->nombre }} {{ $acreditado->apellido }}</p>
            <p><strong>Fecha de Nacimiento:</strong> {{ $acreditado->fecha_nacimiento?->format('d/m/Y') ?? 'N/A' }}</p>
            <p><strong>Género:</strong> {{ $acreditado->genero === true ? 'Masculino' : ($acreditado->genero === false ? 'Femenino' : 'N/A') }}</p>
            <p><strong>Correo:</strong> {{ $acreditado->correo ?? 'N/A' }}</p>
            <p><strong>Teléfono:</strong> {{ $acreditado->telefono ?? 'N/A' }}</p>
            <p><strong>Nacionalidad:</strong> {{ $acreditado->nacionalidad ?? 'N/A' }}</p>
            <p><strong>Evento:</strong> {{ $acreditado->evento->nombre ?? 'N/A' }}</p>
            <p><strong>Estado:</strong> {{ $acreditado->estado }}</p>
        </div>
    </div>

    <br>
    <p>Este perfil se accede mediante un enlace seguro con token, no requiere contraseña.</p>
</div>
@endsection
