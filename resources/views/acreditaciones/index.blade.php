@extends('layouts.app')

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

    <!-- Paginación -->
    {{ $acreditados->links() }}
</div>
@endsection
