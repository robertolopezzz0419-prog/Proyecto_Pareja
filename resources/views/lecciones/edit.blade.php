<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Lección</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    @include('partials.navbar')

    <div class="container pb-5" style="max-width: 600px;">
        <div class="card shadow-sm p-4">
            <h2 class="mb-1">Editar Leccion</h2>
            <p class="text-muted">Curso: {{ $leccion->modulo->curso->titulo }} | Módulo {{ $leccion->modulo->orden }}: {{ $leccion->modulo->titulo }}</p>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('lecciones.update', $leccion->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Titulo de la leccion</label>
                    <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $leccion->titulo) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Orden</label>
                    <input type="number" min="1" step="1" name="orden" class="form-control"
                           value="{{ old('orden', $leccion->orden) }}"
                           onkeydown="if (['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Link del video (opcional)</label>
                    <input type="text" name="video_url" class="form-control" value="{{ old('video_url', $leccion->video_url) }}" placeholder="https://www.youtube.com/watch?v=...">
                </div>

                <div class="mb-3">
                    <label class="form-label">Contenido (opcional)</label>
                    <textarea name="contenido" class="form-control" rows="5">{{ old('contenido', $leccion->contenido) }}</textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('cursos.show', $leccion->modulo->curso_id) }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Leccion</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>