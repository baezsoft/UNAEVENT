@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2>QR de Acceso - {{ $acreditado->nombre }} {{ $acreditado->apellido }}</h2>
    <p>Escanea este QR para acceder directamente a tu perfil.</p>

    <div style="margin: 20px 0;">
        <img src="data:image/png;base64,{{ $qr }}" alt="QR de acceso">
    </div>

    <p>O usa este enlace:</p>
    <a href="http://localhost:8000/acreditaciones/perfil/{{ $acreditado->token }}" class="qr-link">
        http://localhost:8000/acreditaciones/perfil/{{ $acreditado->token }}
    </a>
    
    <br><br>
    <a href="{{ route('acreditaciones.index') }}" class="btn btn-secondary">Volver al listado</a>
</div>

<style>
/* Contenedor */
.container {
    background-color: #0b3d2e; /* verde oscuro */
    padding: 25px 20px;
    border-radius: 12px;
    color: #ffffff;
}

/* Encabezado */
.container h2 {
    color: #dfffe0;
    font-weight: bold;
    margin-bottom: 15px;
}

/* QR Imagen */
img {
    border: 2px solid #004d40;
    border-radius: 8px;
    max-width: 250px;
    width: 100%;
}

/* Enlace QR */
.qr-link {
    color: #a5d6a7;
    word-break: break-all;
    display: inline-block;
    margin-top: 10px;
}
.qr-link:hover {
    color: #81c784;
    text-decoration: underline;
}

/* Botón */
.btn-secondary {
    background-color: #a5d6a7;
    border: none;
    color: #000;
    border-radius: 10px;
    padding: 8px 16px;
}
.btn-secondary:hover {
    background-color: #81c784;
    color: #000;
}

/* Responsive */
@media (max-width: 768px) {
    .container {
        padding: 15px 10px;
    }

    img {
        max-width: 100%;
        margin: 15px 0;
    }

    .qr-link {
        font-size: 14px;
    }
}
</style>
@endsection
