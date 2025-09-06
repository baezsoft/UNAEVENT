@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Salas</h1>
    <a href="{{ route('salas.create') }}" class="btn btn-primary mb-3">Crear Sala</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Capacidad</th>
                <th>Inhabilitado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salas as $sala)
                <tr>
                    <td>{{ $sala->id }}</td>
                    <td>{{ $sala->nombre }}</td>
                    <td>{{ $sala->capacidad }}</td>
                    <td>{{ $sala->inhabilitado ? 'Sí' : 'No' }}</td>
                    <td>
                        <a href="{{ route('salas.edit', $sala) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('salas.destroy', $sala) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que desea eliminar?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection