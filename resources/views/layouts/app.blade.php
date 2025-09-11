<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UNAEVENT')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Opcional: tus estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        /* Navbar */
.navbar {
    background-color: #0b3d2e !important; /* verde oscuro */
}

/* Marca */
.navbar-brand {
    color: #dfffe0 !important;
    font-weight: bold;
}
.navbar-brand:hover {
    color: #a5d6a7 !important;
}

/* Links */
.navbar-nav .nav-link {
    color: #dfffe0 !important;
    margin-right: 10px;
}
.navbar-nav .nav-link:hover {
    color: #a5d6a7 !important;
}

/* Botón Hamburguesa */
.navbar-toggler {
    border: none;
}
.navbar-toggler:focus {
    box-shadow: none;
}

/* Icono hamburguesa en blanco */
.navbar-dark .navbar-toggler-icon {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30'
    xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='rgba%28255,255,255,1%29'
    stroke-width='2' stroke-linecap='round' stroke-miterlimit='10'
    d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
}

.navbar-collapse {
    background-color: #0b3d2e; /* verde oscuro */
    border-radius: 8px;
    padding: 10px;
}

/* Botón salir */
.btn-danger {
    background-color: #c62828;
    border: none;
    border-radius: 8px;
}
.btn-danger:hover {
    background-color: #8e0000;
}

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">UNAEVENT</a>
            @if (Auth::user())
                

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('salas.index') }}">Salas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('disertantes.index') }}">Disertantes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('disciplinas.index') }}">Disciplinas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('eventos.index') }}">Eventos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('acreditaciones.index') }}">Acreditados</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('actividades.index') }}">Actividades</a>
                    </li>
                    @if(Auth::user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.usuarios') }}">Usuarios</a>
                        </li>
                    @endif
                    @auth
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Salir</button>
                            </form>
                        </li>   
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Ingresar</a>
                        </li>
                    @endauth
                    <!-- Agrega más enlaces aquí -->
                </ul>
            </div>
            @endif
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS + Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Opcional: tus scripts personalizados -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
