<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    @include('partials.navbar')

    <div class="container pb-5" style="max-width: 600px;">
        <div class="card shadow-sm p-4">
            <h2 class="mb-3">Editar Curso</h2>

            <form action="{{ route('cursos.update', $curso->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('cursos._form')

                <div class="d-flex justify-content-between">
                    <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar Curso</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>