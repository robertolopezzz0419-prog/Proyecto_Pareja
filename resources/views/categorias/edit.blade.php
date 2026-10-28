<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Categoría</title>
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
                    <h3>Editar Categoría</h3>
                    <form action="{{ route('categorias.update', $categoria->id) }}" method="POST" class="mt-3">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nombre de la categoría</label>
                            <input type="text" name="nombre" class="form-control" maxlength="100"
                                   value="{{ old('nombre', $categoria->nombre) }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        <a href="{{ route('categorias.create') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>