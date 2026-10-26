<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lista de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class = "bg-light">
    <div class = "container mt-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Lista de Cursos</h1>
            <a href="{{ route('cursos.create') }}" class="btn btn-primary">Crear Curso</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="row"> @foreach($cursos as $curso)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $curso->titulo }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">Categoría: {{ $curso->categoria->nombre ?? 'Sin categoría' }}</h6>
                            <p class="card-text">{{ $curso->descripcion }}</p>
                           <p class="fw-bold text-success">${{ $curso->precio }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>