<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Crear Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    @include('partials.navbar')

    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">

                @if(session('exito'))
                    <div class="alert alert-success">{{ session('exito') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card shadow-sm p-4 mb-4">
                    <h3>Crear Categoría</h3>
                    <form action="{{ route('categorias.store') }}" method="POST" class="mt-3">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nombre de la categoría</label>
                            <input type="text" name="nombre" class="form-control" maxlength="100" value="{{ old('nombre') }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Categoría</button>
                        <a href="{{ route('cursos.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>

                <div class="card shadow-sm p-4">
                    <h5>Categorías existentes</h5>
                    <ul class="list-group mt-2">
                        @forelse($categorias as $categoria)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>
                                    {{ $categoria->nombre }}
                                    <small class="text-muted">({{ $categoria->cursos_count }} cursos)</small>
                                </span>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="btn btn-sm btn-outline-warning">Editar</a>
                                    <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" class="m-0"
                                          onsubmit="return confirm('¿Eliminar la categoría {{ addslashes($categoria->nombre) }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">Aún no hay categorías.</li>
                        @endforelse
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>