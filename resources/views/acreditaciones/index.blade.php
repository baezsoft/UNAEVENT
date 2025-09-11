@extends('layouts.app')

<style>
    /* Contenedor */
.container {
    background-color: #0b3d2e; /* verde oscuro */
    padding: 20px;
    border-radius: 12px;
    color: #ffffff;
}

/* Encabezado principal */
.container h2 {
    color: #dfffe0;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Formulario */
form .form-control {
    border-radius: 10px;
    border: 1px solid #004d40;
    background-color: #ffffff;
    color: #000;
}

form .btn-primary {
    background-color: #00695c;
    border: none;
    border-radius: 10px;
}
form .btn-primary:hover {
    background-color: #004d40;
}
form .btn-secondary {
    background-color: #a5d6a7;
    border: none;
    color: #000;
    border-radius: 10px;
}
form .btn-secondary:hover {
    background-color: #81c784;
}

/* Tabla */
.table {
    background-color: #ffffff;
    border-radius: 12px;
    overflow: hidden;
}

.table thead {
    background-color: #004d40;
    color: #ffffff;
    text-transform: uppercase;
    font-size: 14px;
}

.table tbody tr:hover {
    background-color: #f1f8f6;
}

/* Botones en tabla */
.table .btn-warning {
    background-color: #f9a825;
    border: none;
}
.table .btn-warning:hover {
    background-color: #f57f17;
}

.table .btn-info {
    background-color: #00796b;
    border: none;
    color: #fff;
}
.table .btn-info:hover {
    background-color: #004d40;
}

/* Responsivo: tabla en scroll horizontal en móviles */
@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto;
    }

    .container {
        padding: 15px;
    }

    .table thead {
        font-size: 12px;
    }

    .table td, .table th {
        font-size: 13px;
        padding: 8px;
    }

    form .col-md-2 {
        margin-bottom: 10px;
    }

    .btn {
        width: 100%;
        margin-bottom: 5px;
    }
}

</style>
@section('content')
<div class="container">
    <h2>Acreditados</h2>

    <!-- Formulario de búsqueda -->
    <form method="GET" action="{{ route('acreditaciones.index') }}" class="row mb-4">
        <div class="col-md-2">
            <input type="text" name="nombre" class="form-control" placeholder="Nombre" value="{{ request('nombre') }}">
        </div>
        <div class="col-md-2">
            <input type="text" name="apellido" class="form-control" placeholder="Apellido" value="{{ request('apellido') }}">
        </div>
        <div class="col-md-2">
            <input type="text" name="dni" class="form-control" placeholder="DNI" value="{{ request('dni') }}">
        </div>
        <div class="col-md-2">
            <select name="evento_id" class="form-control">
                <option value="">-- Evento --</option>
                @foreach(\App\Models\Evento::all() as $evento)
                    <option value="{{ $evento->id }}" {{ request('evento_id') == $evento->id ? 'selected' : '' }}>
                        {{ $evento->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="estado" class="form-control">
                <option value="">-- Estado --</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                <option value="rechazado" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Buscar</button>
            <a href="{{ route('acreditaciones.index') }}" class="btn btn-secondary">Limpiar</a>
        </div>
    </form>

<!-- Tabla de acreditados -->
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>DNI</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Evento</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($acreditados as $acreditado)
            <tr>
                <td>{{ $acreditado->dni }}</td>
                <td>{{ $acreditado->nombre }}</td>
                <td>{{ $acreditado->apellido }}</td>
                <td>{{ $acreditado->evento->nombre ?? '-' }}</td>
                <td>{{ $acreditado->estado }}</td>
                <td>
                    <a href="{{ route('acreditaciones.edit', $acreditado->id) }}" class="btn btn-sm btn-warning">Editar</a>
                    <a href="{{ route('acreditaciones.qr', $acreditado->id) }}" class="btn btn-sm btn-info">QR</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

    <!-- Paginación -->
    {{ $acreditados->links() }}
</div>
@endsection
