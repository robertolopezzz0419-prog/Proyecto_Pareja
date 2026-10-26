<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ $curso->titulo }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
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
    </div>
</body>
</html>