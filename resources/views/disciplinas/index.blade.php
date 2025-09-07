@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Lista de Disciplinas</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('disciplinas.create') }}" class="btn btn-primary">Nueva Disciplina</a>
        <form method="GET" action="{{ route('disciplinas.index') }}" class="d-flex">
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
                <th>ID</th><th>Nombre</th><th>Inhabilitado</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($disciplinas as $disciplina)
            <tr>
                <td>{{ $disciplina->id }}</td>
                <td>{{ $disciplina->nombre }}</td>
                <td>{{ $disciplina->inhabilitado ? 'Sí' : 'No' }}</td>
                <td>
                    <a href="{{ route('disciplinas.show', $disciplina) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('disciplinas.edit', $disciplina) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('disciplinas.destroy', $disciplina) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar disciplina?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center">No se encontraron resultados</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $disciplinas->links() }}
    </div>
</div>
@endsection
