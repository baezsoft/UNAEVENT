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
.container h2 {
    color: #dfffe0;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Formularios */
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
    font-size: 13px;
}

.table tbody tr:hover {
    background-color: #f1f8f6;
}

/* Botones en tabla */
.table .btn-info {
    background-color: #00796b;
    border: none;
    border-radius: 6px;
    color: #fff;
}
.table .btn-info:hover {
    background-color: #004d40;
}

.table .btn-warning {
    background-color: #f9a825;
    border: none;
    border-radius: 6px;
    color: #fff;
}
.table .btn-warning:hover {
    background-color: #f57f17;
}

.table .btn-danger {
    background-color: #c62828;
    border: none;
    border-radius: 6px;
}
.table .btn-danger:hover {
    background-color: #8e0000;
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

    form .d-flex {
        flex-wrap: wrap;
    }

    form .form-control, form .btn {
        width: 100%;
        margin-bottom: 5px;
    }
}
</style>

@section('content')
<div class="container mt-4">
    <h2>Lista de Disertantes</h2>

    <div class="d-flex justify-content-between mb-3 flex-wrap">
        <a href="{{ route('disertantes.create') }}" class="btn btn-primary mb-2">Nuevo Disertante</a>
        <form method="GET" action="{{ route('disertantes.index') }}" class="d-flex mb-2 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2 mb-2" placeholder="Buscar...">
            <button type="submit" class="btn btn-secondary mb-2">Filtrar</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Especialidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($disertantes as $disertante)
                <tr>
                    <td>{{ $disertante->id }}</td>
                    <td>{{ $disertante->nombre }}</td>
                    <td>{{ $disertante->apellido }}</td>
                    <td>{{ $disertante->correo }}</td>
                    <td>{{ $disertante->especialidad }}</td>
                    <td>
                        <a href="{{ route('disertantes.show', $disertante) }}" class="btn btn-info btn-sm">Ver</a>
                        <a href="{{ route('disertantes.edit', $disertante) }}" class="btn btn-warning btn-sm">Editar</a>
                        <form action="{{ route('disertantes.destroy', $disertante) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar disertante?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No se encontraron resultados</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $disertantes->links() }}
    </div>
</div>
@endsection
