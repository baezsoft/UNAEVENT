@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>QR de Acceso - {{ $acreditado->nombre }} {{ $acreditado->apellido }}</h2>
    <p>Escanea este QR para acceder directamente a tu perfil.</p>

    <div style="margin: 20px 0;">
        <img src="data:image/png;base64,{{ $qr }}" alt="QR de acceso">
    </div>

    <p>O usa este enlace:</p>
    <a href="{{ route('acreditaciones.show', $acreditado->token) }}">
        {{ route('acreditaciones.show', $acreditado->token) }}
    </a>

    <br><br>
    <a href="{{ route('acreditaciones.index') }}" class="btn btn-secondary">Volver al listado</a>
</div>
@endsection
