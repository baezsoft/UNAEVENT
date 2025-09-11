@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-primary">👨‍🏫 Detalles del Disertante</h2>

    <div class="card shadow-lg border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <tbody>
                    <tr>
                        <th class="bg-light w-25">Nombre</th>
                        <td>{{ $disertante->nombre }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Apellido</th>
                        <td>{{ $disertante->apellido }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Correo</th>
                        <td>{{ $disertante->correo }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Teléfono</th>
                        <td>{{ $disertante->telefono ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Institución</th>
                        <td>{{ $disertante->institucion ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Especialidad</th>
                        <td>{{ $disertante->especialidad ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Currículum</th>
                        <td>
                            @if($disertante->cv)
                                <a href="{{ asset('storage/'.$disertante->cv) }}" 
                                   class="btn btn-sm btn-outline-primary" 
                                   target="_blank">
                                   📄 Descargar CV
                                </a>
                            @else
                                <span class="text-muted">No disponible</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="bg-light">Inhabilitado</th>
                        <td>
                            @if($disertante->inhabilitado)
                                <span class="badge bg-danger">Sí</span>
                            @else
                                <span class="badge bg-success">No</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <a href="{{ route('disertantes.index') }}" class="btn btn-secondary">
             Volver
        </a>
        <a href="{{ route('disertantes.edit', $disertante) }}" class="btn btn-warning">
             Editar
        </a>
    </div>
</div>
@endsection
