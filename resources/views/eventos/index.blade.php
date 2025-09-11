@extends('layouts.app')

<style>
/* Contenedor */
.container {
    background-color: #0b3d2e; /* verde oscuro */
    padding: 20px;
    border-radius: 12px;
    color: #ffffff;
}

/* Encabezado */
.container h1 {
    color: #dfffe0;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Botones */
.btn-primary {
    background-color: #00695c;
    border: none;
    border-radius: 10px;
}
.btn-primary:hover {
    background-color: #004d40;
}

.btn-warning {
    background-color: #f9a825;
    border: none;
    border-radius: 6px;
    color: #fff;
}
.btn-warning:hover {
    background-color: #f57f17;
}

.btn-danger {
    background-color: #c62828;
    border: none;
    border-radius: 6px;
}
.btn-danger:hover {
    background-color: #8e0000;
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
    font-size: 13px;
}

.table tbody tr:hover {
    background-color: #f1f8f6;
}

/* Responsivo */
@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto;
    }

    .container {
        padding: 15px;
    }

    .table thead {
        font-size: 11px;
    }

    .table td, .table th {
        font-size: 12px;
        padding: 6px;
    }

    .btn {
        width: 100%;
        margin-bottom: 5px;
    }

    .d-flex {
        flex-wrap: wrap;
    }
}
</style>

@section('content')
<div class="container">
    <h1>Eventos</h1>

    <div class="d-flex justify-content-between mb-3 flex-wrap">
        <a href="{{ route('eventos.create') }}" class="btn btn-primary mb-2">Nuevo Evento</a>
    </div>

    <div class="table-responsive">
        <table class="table mt-3 table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Lugar</th>
                    <th>Tarifa</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($eventos as $evento)
                <tr>
                    <td>{{ $evento->nombre }}</td>
                    <td>{{ $evento->fecha->format('d/m/Y') }}</td>
                    <td>{{ $evento->lugar }}</td>
                    <td>{{ number_format($evento->tarifa, 2, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('eventos.edit', $evento) }}" class="btn btn-warning btn-sm mb-1">Editar</a>
                        <form action="{{ route('eventos.destroy', $evento) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm mb-1" onclick="return confirm('¿Seguro?')">Inhabilitar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay eventos registrados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $eventos->links() }}
    </div>
</div>
@endsection
