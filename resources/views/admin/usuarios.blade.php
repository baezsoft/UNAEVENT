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
.container h2 {
    color: #dfffe0;
    font-weight: bold;
    margin-bottom: 20px;
}

/* Botones */
.btn-success {
    background-color: #4caf50;
    border: none;
    border-radius: 10px;
    color: #fff;
}
.btn-success:hover {
    background-color: #388e3c;
}

.btn-primary {
    background-color: #00695c;
    border: none;
    border-radius: 6px;
    color: #fff;
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

    .d-flex {
        flex-wrap: wrap;
    }
}
</style>

@section('content')
<div class="container mt-4">
    <h2>Usuarios Registrados</h2>

    {{-- Botón solo para administradores --}}
    @if(Auth::user() && Auth::user()->isAdmin())
        <div class="mb-3">
            <a href="{{ route('admin.register-user') }}" class="btn btn-success">
                + Nuevo Usuario
            </a>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>CI</th>
                    <th>Cargo</th>
                    <th>Inhabilitado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($usuarios as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->nombre }}</td>
                        <td>{{ $u->apellido }}</td>
                        <td>{{ $u->correo }}</td>
                        <td>{{ $u->ci }}</td>
                        <td>{{ $u->cargo }}</td>
                        <td>{{ $u->inhabilitado ? 'Sí' : 'No' }}</td>
                        <td>
                            {{-- Solo administradores pueden editar o inhabilitar --}}
                            @if(Auth::user() && Auth::user()->isAdmin())
                                <a href="{{ route('admin.edit-usuario', $u->id) }}" class="btn btn-primary btn-sm mb-1">Editar</a>
                                <form action="{{ route('admin.toggle-usuario', $u->id) }}" method="POST" style="display:inline-block">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm mb-1">
                                        {{ $u->inhabilitado ? 'Habilitar' : 'Inhabilitar' }}
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No hay usuarios registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
