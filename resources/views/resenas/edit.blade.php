<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar reseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    @include('partials.navbar')

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card shadow-sm p-4">
                    <h3>Editar reseña</h3>
                    <p class="text-muted">Curso: {{ $resena->curso->titulo }}</p>

                    <form action="{{ route('resenas.update', $resena->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Calificación</label>
                            <select name="calificacion" class="form-select" required>
                                @foreach([5 => '5 estrellas', 4 => '4 estrellas', 3 => '3 estrellas', 2 => '2 estrellas', 1 => '1 estrella'] as $valor => $texto)
                                    <option value="{{ $valor }}" {{ old('calificacion', $resena->calificacion) == $valor ? 'selected' : '' }}>
                                        {{ $texto }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Comentario</label>
                            <textarea name="comentario" class="form-control" rows="4" maxlength="1000"
                                      placeholder="Tu comentario (máx. 1000 caracteres)">{{ old('comentario', $resena->comentario) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        <a href="{{ route('cursos.show', $resena->curso_id) }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>