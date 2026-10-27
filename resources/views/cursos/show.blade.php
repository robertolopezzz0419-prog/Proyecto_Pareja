<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $curso->titulo }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
   
    @include('partials.navbar')

    <div class="container pb-5">
        <a href="{{ route('cursos.index') }}" class="btn btn-secondary mb-3">← Volver a Cursos</a>

        <div class="card shadow-sm mb-4">
       
            @if($curso->imagen)
                <img src="{{ asset('storage/' . $curso->imagen) }}" class="card-img-top" alt="{{ $curso->titulo }}" style="max-height: 260px; object-fit: cover;">
            @endif
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <h2>{{ $curso->titulo }}</h2>
                 
                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-warning btn-sm">Editar curso</a>
                </div>
                <p class="text-muted">Categoria: {{ $curso->categoria->nombre ?? 'Sin categoria' }}</p>
                <p>{{ $curso->descripcion }}</p>
                <h4 class="text-success">${{ $curso->precio }}</h4>
            </div>
        </div>

        @if(session('exito'))
            <div class="alert alert-success">{{ session('exito') }}</div>
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

        <h3 class="mb-3">Modulos del Curso</h3>

        @forelse($curso->modulos as $modulo)
            <div class="card mb-3 shadow-sm">
              <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
    <span><strong>Módulo {{ $modulo->orden }}:</strong> {{ $modulo->titulo }}</span>

    <form action="{{ route('modulos.destroy', $modulo->id) }}" method="POST" class="m-0"
          onsubmit="return confirm('¿Eliminar este módulo y todas sus lecciones?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">Eliminar modulo</button>
    </form>
</div>
                <div class="card-body">

                    <ul class="list-group mb-3">
                        @forelse($modulo->lecciones as $leccion)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $leccion->orden }}. {{ $leccion->titulo }}</span>

                             <div class="d-flex gap-1">
    <a href="{{ route('lecciones.show', $leccion->id) }}" class="btn btn-sm btn-outline-success">Ver leccion</a>
    <a href="{{ route('lecciones.edit', $leccion->id) }}" class="btn btn-sm btn-outline-warning">Editar</a>
    <form action="{{ route('lecciones.destroy', $leccion->id) }}" method="POST" class="m-0"
          onsubmit="return confirm('¿Eliminar esta leccion?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
    </form>
</div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">No hay lecciones registradas en este modulo todavia.</li>
                        @endforelse
                    </ul>

                    <div class="p-3 bg-light border rounded">
                        <small class="fw-bold text-secondary">Agregar leccion a este modulo:</small>
                        <form action="{{ route('lecciones.store') }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="modulo_id" value="{{ $modulo->id }}">

                            <div class="row g-2">
                                <div class="col-md-8">
                                    <input type="text" name="titulo" class="form-control form-control-sm" placeholder="Título de la lección" required>
                                </div>
                                <div class="col-md-4">
                                 
                                 <input type="number" min="1" step="1" name="orden" class="form-control form-control-sm" placeholder="Orden"
       value="{{ $modulo->lecciones->count() + 1 }}"
       onkeydown="if (['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" required>
                                </div>
                              
                                <div class="col-12">
                                    <input type="text" name="video_url" class="form-control form-control-sm" placeholder="Link del video (opcional) ej: https://www.youtube.com/watch?v=...">
                                </div>
                              
                                <div class="col-12">
                                    <textarea name="contenido" class="form-control form-control-sm" rows="2" placeholder="Contenido o texto de la lección (opcional)"></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-sm btn-outline-primary w-100">Añadir Leccion</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <div class="alert alert-warning">No hay modulos registrados en este curso todavia.</div>
        @endforelse

        <div class="card mt-4 p-4 shadow-sm">
            <h4>Agregar Nuevo Modulo</h4>
            <form action="{{ route('modulos.store') }}" method="POST" class="mt-3">
                @csrf
                <input type="hidden" name="curso_id" value="{{ $curso->id }}">

                <div class="mb-3">
                    <label class="form-label">Titulo del Modulo</label>
                    <input type="text" name="titulo" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Orden</label>
                    
                   <input type="number" min="1" step="1" name="orden" class="form-control"
       value="{{ $curso->modulos->count() + 1 }}"
       onkeydown="if (['e', 'E', '+', '-', '.', ','].includes(event.key)) event.preventDefault();" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar Modulo</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>