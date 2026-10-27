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
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cursos.create') }}">Crear Curso</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-muted disabled" href="#">Mis Inscripciones (Compañero)</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-warning" href="#" onclick="alert('Modulo del roberto'); return false;">Iniciar Sesión</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-info" href="#" onclick="alert('Modulo del roberto'); return false;">Registrarse</a>
                </li>
            </ul>
        </div>
    </div>
</nav>