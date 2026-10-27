<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('cursos.index') }}">LMS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('cursos.index') }}">Lista de Cursos</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('cursos.create') }}">Crear Curso</a></li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-lg-center">
                @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('inscripciones.index') }}">Mis Inscripciones</a></li>
                    <li class="nav-item"><span class="navbar-text me-3">Hola, {{ auth()->user()->name }}</span></li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button class="btn btn-sm btn-outline-light">Salir</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link text-warning" href="{{ route('login') }}">Iniciar Sesión</a></li>
                    <li class="nav-item"><a class="nav-link text-info" href="{{ route('registro') }}">Registrarse</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>