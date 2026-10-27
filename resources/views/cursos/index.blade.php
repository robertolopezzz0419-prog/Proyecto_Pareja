<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    @include('partials.navbar')

    <div class="container pb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Lista de Cursos</h2>
            <a href="{{ route('cursos.create') }}" class="btn btn-primary">Crear Curso</a>
        </div>

        
        @if(session('exito'))
            <div class="alert alert-success">{{ session('exito') }}</div>
        @endif

        <div class="row">
            
            @forelse($cursos as $curso)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100">
                      
                        @if($curso->imagen)
                            <img src="{{ asset('storage/' . $curso->imagen) }}" class="card-img-top" alt="{{ $curso->titulo }}" style="height: 180px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $curso->titulo }}</h5>
                            <h6 class="text-muted mb-2">Categoría: {{ $curso->categoria->nombre ?? 'Sin categoría' }}</h6>
                            <p class="card-text text-truncate">{{ $curso->descripcion }}</p>
                            <p class="text-success fw-bold mb-3">${{ $curso->precio }}</p>

                          
                            <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-outline-dark mt-auto mb-2">Ver Módulos y Lecciones</a>

                   
                            <div class="d-flex gap-2">
                                <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-sm btn-warning w-50">Editar</a>
                                <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST" class="w-50 m-0"
                                      onsubmit="return confirm('¿Seguro que quieres eliminar este curso?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger w-100">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">No hay cursos registrados todavía.</div>
                </div>
            @endforelse
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>