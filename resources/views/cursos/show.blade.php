<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $curso->titulo }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('cursos.index') }}"> LMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cursos.index') }}"> Lista de Cursos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('cursos.create') }}"> Crear Curso</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('inscripciones.index')}}"> Mis Inscripciones (Compañero)</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="#" onclick="alert('Módulo en desarrollo por tu compañero'); return false;">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-info" href="#" onclick="alert('Módulo en desarrollo por tu compañero'); return false;">Registrarse</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container pb-5">
        <a href="{{ route('cursos.index') }}" class="btn btn-secondary mb-3">← Volver a Cursos</a>
        
       
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h2>{{ $curso->titulo }}</h2>
                <p class="text-muted">Categoría: {{ $curso->categoria->nombre ?? 'Sin categoría' }}</p>
                <p>{{ $curso->descripcion }}</p>
                <h4 class="text-success">${{ $curso->precio }}</h4>
                                @if($inscrito)
                    <form action="{{ route('inscripciones.destroy', $curso->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger">Salirme del curso</button>
                    </form>
                @else
                    <form action="{{ route('inscripciones.store', $curso->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button class="btn btn-success">Inscribirme a este curso</button>
                    </form>
                @endif
            </div>
        </div>

        @if(session('exito'))
            <div class="alert alert-success">{{ session('exito') }}</div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">{{ session('error')}}</div>
        @endif

        @if (session('success'))
        <div class="alert alert-success">{{ session('success')}}</div>
        @endif

    
        <h3 class="mb-3">Modulos del Curso</h3>
        
        @forelse($curso->modulos as $modulo)
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <strong>Módulo {{ $modulo->orden }}:</strong> {{ $modulo->titulo }}
                </div>
                <div class="card-body">
                    
                 
                    <ul class="list-group mb-3">
                        @forelse($modulo->lecciones as $leccion)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span> {{ $leccion->titulo }}</span>
                                
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-secondary">Orden: {{ $leccion->orden }}</span>
                                    
                              
                                    <form action="{{ route('lecciones.completar', $leccion->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                            Marcar / Cambiar Estado
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-muted">No hay lecciones registradas en este módulo todavía.</li>
                        @endforelse
                    </ul>

                    <div class="p-3 bg-light border rounded">
                        <small class="fw-bold text-secondary">Agregar lección a este módulo:</small>
                        <form action="{{ route('lecciones.store') }}" method="POST" class="mt-2">
                            @csrf
                            <input type="hidden" name="modulo_id" value="{{ $modulo->id }}">
                            
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="text" name="titulo" class="form-control form-control-sm" placeholder="Título de la lección" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="orden" class="form-control form-control-sm" placeholder="Orden" value="1" required>
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-sm btn-outline-primary w-100">Añadir Lección</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <div class="alert alert-warning">No hay módulos registrados en este curso todavía.</div>
        @endforelse

       
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

        <h3 class="mt-5 mb-3">Reseñas</h3>
          @forelse($curso->resenas as $resena)
          <div class="card mb-2 shadow-sm">
            <div class="card-body">
                <strong>{{ $resena->user->name }}</strong>
                    <span class="text-warning">{{ str_repeat('★', $resena->calificacion) }}{{ str_repeat('☆', 5 - $resena->calificacion) }}</span>
                    <p class="mb-0">{{ $resena->comentario }}</p>
            </div>
          </div>

           @empty
            <p class="text-muted">Aún no hay reseñas.</p>
        @endforelse

        @if (inscrito)
        <div class="card mt-3 p-3 shadow-sm">
              <form action="{{ route('resenas.store', $curso->id) }}" method="POST">
                @csrf
                <div class="mb-2">
                    <label class="form-label">Calicacion</label>
                    <select name="calicacion" class="form-select" required>
                        <option value="5"> 5 estrellas</option>
                        <option value="4">4 estrellas</option>
                        <option value="3">3 estrellas</option>
                        <option value="2">2 estrellas</option>
                        <option value="1">1 estrellas</option>
                    </select>
                </div>
                <div class="mb-2">
                    <textarea name="comentario" class="form-control" rows="3" placeholder="Tu comentario"></textarea>
                </div>
                <button class="btn btn-primary">Enviar reseña</button>
              </form>
        </div>        
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>