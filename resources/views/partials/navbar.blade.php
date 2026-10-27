<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('cursos.index') }}">LMS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
                  <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cursos.index') }}">Lista de Cursos</a>
                </li>

                
                @can('gestionar')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cursos.create') }}">Crear Curso</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categorias.create') }}">Crear Categoría</a>
                    </li>
                @endcan
            </ul>
            <ul class="navbar-nav ms-auto">
    @guest
        <li class="nav-item">
            <a class="nav-link text-warning" href="{{ route('login') }}">Iniciar Sesión</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-info" href="{{ route('registro') }}">Registrarse</a>
        </li>
    @endguest

    @auth
    <li class="nav-item">
    <span class="navbar-text text-white me-3">
        {{ auth()->user()->name }} ({{ auth()->user()->roles->pluck('nombre')->join(', ') }})
    </span>
</li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('inscripciones.index') }}">Mis Inscripciones</a>
        </li>
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link btn btn-link">Cerrar Sesión</button>
            </form>
        </li>
    @endauth
</ul>
        </div>
    </div>
</nav>