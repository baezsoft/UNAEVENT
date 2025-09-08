@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Eventos</h1>
    <a href="{{ route('eventos.create') }}" class="btn btn-primary">Nuevo Evento</a>
    <table class="table mt-3">
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
            @foreach ($eventos as $evento)
            <tr>
                <td>{{ $evento->nombre }}</td>
                <td>{{ $evento->fecha->format('d/m/Y') }}</td>
                <td>{{ $evento->lugar }}</td>
                <td>{{ number_format($evento->tarifa, 2, ',', '.') }}</td>
                <td>
                    <a href="{{ route('eventos.edit', $evento) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('eventos.destroy', $evento) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro?')">Inhabilitar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $eventos->links() }}
</div>
@endsection
