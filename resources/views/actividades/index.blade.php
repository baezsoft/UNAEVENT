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
.btn-success {
    background-color: #2e7d32;
    border: none;
    border-radius: 10px;
}
.btn-success:hover {
    background-color: #1b5e20;
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
.table .btn-primary {
    background-color: #00796b;
    border: none;
    border-radius: 6px;
}
.table .btn-primary:hover {
    background-color: #004d40;
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

    form .col-md-2, form .col-md-3, form .col-md-1 {
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
    <h2>Listado de Actividades</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filtros --}}
    <form action="{{ route('actividades.index') }}" method="GET" class="mb-3 row g-2">
        <div class="col-md-2">
            <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}">
        </div>
        <div class="col-md-3">
            <select name="evento" class="form-control">
                <option value="">Todos los eventos</option>
                @foreach(\App\Models\Evento::all() as $evento)
                    <option value="{{ $evento->id }}" {{ request('evento') == $evento->id ? 'selected' : '' }}>{{ $evento->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="sala" class="form-control">
                <option value="">Todas las salas</option>
                @foreach(\App\Models\Sala::all() as $sala)
                    <option value="{{ $sala->id }}" {{ request('sala') == $sala->id ? 'selected' : '' }}>{{ $sala->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="text" name="nombre" class="form-control" value="{{ request('nombre') }}" placeholder="Nombre actividad">
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <a href="{{ route('actividades.create') }}" class="btn btn-success mb-3">Crear Actividad</a>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Usuario</th>
                    <th>Disertante</th>
                    <th>Sala</th>
                    <th>Disciplina</th>
                    <th>Evento</th>
                    <th>Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($actividades as $actividad)
                    <tr>
                        <td>{{ $actividad->id }}</td>
                        <td>{{ $actividad->nombre }}</td>
                        <td>{{ $actividad->usuario->nombre ?? '-' }}</td>
                        <td>{{ $actividad->disertante->nombre ?? '-' }}</td>
                        <td>{{ $actividad->sala->nombre ?? '-' }}</td>
                        <td>{{ $actividad->disciplina->nombre ?? '-' }}</td>
                        <td>{{ $actividad->evento->nombre ?? '-' }}</td>
                        <td>{{ $actividad->fecha }}</td>
                        <td>{{ $actividad->hora_inicio }}</td>
                        <td>{{ $actividad->hora_fin }}</td>
                        <td>
                            <a href="{{ route('actividades.edit', $actividad) }}" class="btn btn-sm btn-primary">Editar</a>
                            <form action="{{ route('actividades.destroy', $actividad) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar esta actividad?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No hay actividades registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    {{ $actividades->links() }}
</div>
@endsection
