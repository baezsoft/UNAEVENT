<div class="container text-center py-5">
    @if($evento)
        <h1 class="mb-3">{{ $evento->nombre }}</h1>
        <p class="lead">{{ $evento->descripcion }}</p>
        <p><strong>📅 Fecha:</strong> {{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</p>
        <p><strong>📍 Lugar:</strong> {{ $evento->lugar }}</p>
        <p><strong>💲 Tarifa:</strong> {{ $evento->tarifa }} USD</p>
        <a href="{{ route('acreditaciones.form') }}" class="btn btn-primary mt-3">Registrarme</a>
    @else
        <h1>No hay eventos próximos</h1>
    @endif
</div>

<style>
/* Contenedor */
.container {
    background-color: #0b3d2e; /* verde oscuro */
    color: #ffffff;
    padding: 40px 20px;
    border-radius: 12px;
    height: 100vh;
    align-items: center;
    display: flex;
    flex-direction: column;
}

/* Encabezados */
.container h1 {
    color: #dfffe0;
    font-weight: bold;
    margin-bottom: 15px;
}

/* Texto descriptivo */
.container p {
    color: #e0f7df;
    margin-bottom: 8px;
}

/* Botón */
.btn-primary {
    background-color: #2e7d32;
    border: none;
    border-radius: 10px;
    color: #fff;
    padding: 10px 20px;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
}
.btn-primary:hover {
    background-color: #1b5e20;
}

/* Responsivo */
@media (max-width: 768px) {
    .container {
        padding: 20px 10px;
    }

    .container h1 {
        font-size: 24px;
    }

    .container p {
        font-size: 14px;
    }

    .btn-primary {
        width: 100%;
        padding: 12px;
        margin-top: 10px;
    }
}
</style>
