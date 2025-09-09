@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Listado de Actividades</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filtros --}}
    <form action="{{ route('actividades.index') }}" method="GET" class="mb-3 row g-2">
        <div class="col-md-2">
            <input type="date" name="fecha" class="form-control" value="{{ request('fecha') }}" placeholder="Fecha">
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

    {{-- Paginación --}}
    {{ $actividades->links() }}
</div>
@endsection
