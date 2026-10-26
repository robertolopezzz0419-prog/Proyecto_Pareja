<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $curso->titulo }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="{{ route('cursos.index') }}" class="btn btn-secondary mb-3">← Volver a Cursos</a>
        
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2>{{ $curso->titulo }}</h2>
                <p class="text-muted">Categoría: {{ $curso->categoria->nombre ?? 'Sin categoría' }}</p>
                <p>{{ $curso->descripcion }}</p>
                <h4 class="text-success">${{ $curso->precio }}</h4>
            </div>
        </div>

        @if(session('exito'))
            <div class="alert alert-success">{{ session('exito') }}</div>
        @endif

        <h3 class="mb-3">Módulos del Curso</h3>
        
        @foreach($curso->modulos as $modulo)
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <strong>Módulo {{ $modulo->orden }}:</strong> {{ $modulo->titulo }}
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @forelse($modulo->lecciones as $leccion)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>📖 {{ $leccion->titulo }}</span>
                                <span class="badge bg-primary">Orden: {{ $leccion->orden }}</span>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">No hay lecciones registradas en este módulo todavía.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        @endforeach

      
        <div class="card mt-4 p-4 shadow-sm">
            <h4>Agregar Nuevo Módulo</h4>
            <form action="{{ route('modulos.store') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="curso_id" value="{{ $curso->id }}">
                
                <div class="mb-3">
                    <label class="form-label">Título del Módulo</label>
                    <input type="text" name="titulo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Orden</label>
                    <input type="number" name="orden" class="form-control" value="1" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar Módulo</button>
            </form>
        </div>
    </div>
</body>
</html>