@extends('layouts.app')

@section('content') 
<div class="container">
    <h2>Movimientos de caja</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-3 p-3">
        <form method="GET" action="{{ route('movimientos.index') }}" class="row g-2">
            <div class="col-md-2">
                <label>Desde</label>
                <input type="date" name="fecha_desde" class="form-control" value="{{ $filtros['fecha_desde'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <label>Hasta</label>
                <input type="date" name="fecha_hasta" class="form-control" value="{{ $filtros['fecha_hasta'] ?? '' }}">
            </div>
            <div class="col-md-2">
                <label>Tipo</label>
                <select name="tipo" class="form-control">
                    <option value="">Todos</option>
                    <option value="entrada" {{ ( $filtros['tipo'] ?? '') == 'entrada' ? 'selected' : '' }}>Entrada</option>
                    <option value="salida" {{ ( $filtros['tipo'] ?? '') == 'salida' ? 'selected' : '' }}>Salida</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Evento</label>
                <select name="id_evento" class="form-control">
                    <option value="">Todos</option>
                    @foreach($eventos as $ev)
                        <option value="{{ $ev->id }}" {{ ( $filtros['id_evento'] ?? '') == $ev->id ? 'selected' : '' }}>
                            {{ $ev->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary me-2">Filtrar</button>
                <a href="{{ route('movimientos.create') }}" class="btn btn-success">Nuevo Movimiento</a>
            </div>
        </form>
    </div>

    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Monto</th>
                <th>Descripción</th>
                <th>Acreditado</th>
                <th>Evento</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($movimientos as $m)
            <tr>
                <td>{{ ucfirst($m->tipo) }}</td>
                <td>{{ number_format($m->monto, 2, ',', '.') }}</td>
                <td>{{ $m->descripcion }}</td>
                <td>{{ $m->acreditado ? ($m->acreditado->nombre . ' ' . $m->acreditado->apellido) : '-' }}</td>
                <td>{{ $m->evento ? $m->evento->nombre : '-' }}</td>
                <td>{{ $m->fecha->format('Y-m-d H:i') }}</td>
                <td>
                    {{-- Edit si querés agregar: <a href="#" class="btn btn-sm btn-primary">Editar</a> --}}
                    <form action="{{ route('movimientos.inhabilitar', $m->id) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Inhabilitar movimiento?')">
                        @csrf
                        <button class="btn btn-sm btn-danger">Inhabilitar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    <div class="mt-3">
        {{ $movimientos->links() }}
    </div>
</div>
@endsection