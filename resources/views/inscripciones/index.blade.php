<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mis cursos inscritos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    @include('partials.navbar')

    <div class="container pb-5">
        <h2 class="mb-4">Mis cursos inscritos</h2>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            @forelse($cursos as $curso)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        @if($curso->imagen)
                            <img src="{{ asset('storage/' . $curso->imagen) }}" class="card-img-top" alt="{{ $curso->titulo }}" style="height: 180px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $curso->titulo }}</h5>
                            <p class="card-text">{{ $curso->descripcion }}</p>
                            <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-primary w-100 mb-2">Continuar al aula</a>
                            <form action="{{ route('inscripciones.destroy', $curso->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">Salirme del curso</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-warning">Aún no estás inscrito a ningún curso.</div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>