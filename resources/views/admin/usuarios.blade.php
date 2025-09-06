@extends('layouts.app')
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

    <table class="table table-striped">
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
            @foreach($usuarios as $u)
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
                            <a href="{{ route('admin.edit-usuario', $u->id) }}" class="btn btn-sm btn-primary">Editar</a>
                            <form action="{{ route('admin.toggle-usuario', $u->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-warning">
                                    {{ $u->inhabilitado ? 'Habilitar' : 'Inhabilitar' }}
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
