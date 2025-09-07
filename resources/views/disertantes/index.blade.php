@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Lista de Disertantes</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('disertantes.create') }}" class="btn btn-primary">Nuevo Disertante</a>
        <form method="GET" action="{{ route('disertantes.index') }}" class="d-flex">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Buscar...">
            <button type="submit" class="btn btn-secondary">Filtrar</button>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th><th>Nombre</th><th>Apellido</th><th>Correo</th><th>Especialidad</th><th>Acciones</th>
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
            <tr><td colspan="6" class="text-center">No se encontraron resultados</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $disertantes->links() }}
    </div>
</div>
@endsection
