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
}
</style>

@section('content')
<div class="container mt-4">
    <h1>Salas</h1>
    <a href="{{ route('salas.create') }}" class="btn btn-primary mb-3">Crear Sala</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Capacidad</th>
                    <th>Inhabilitado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salas as $sala)
                    <tr>
                        <td>{{ $sala->id }}</td>
                        <td>{{ $sala->nombre }}</td>
                        <td>{{ $sala->capacidad }}</td>
                        <td>{{ $sala->inhabilitado ? 'Sí' : 'No' }}</td>
                        <td>
                            <a href="{{ route('salas.edit', $sala) }}" class="btn btn-warning btn-sm mb-1">Editar</a>
                            <form action="{{ route('salas.destroy', $sala) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm mb-1" onclick="return confirm('¿Seguro que desea eliminar?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay salas registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
