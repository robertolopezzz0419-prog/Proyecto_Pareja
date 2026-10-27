<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $leccion->titulo }} - {{ $curso->titulo }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
   
    @include('partials.navbar')

    <div class="container pb-5">
        <a href="{{ route('cursos.show', $curso->id) }}" class="btn btn-secondary mb-3"> <- Volver al curso</a>

        @if(session('exito'))
            <div class="alert alert-success">{{ session('exito') }}</div>
        @endif

        <div class="row">

        
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <strong>{{ $curso->titulo }}</strong>
                    </div>
                    <div class="card-body">
                        <small class="text-muted">Tu progreso: {{ $progreso }}%</small>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" style="width: {{ $progreso }}%"></div>
                        </div>

                        @foreach($curso->modulos as $modulo)
                            <h6 class="mt-3">Modulo {{ $modulo->orden }}: {{ $modulo->titulo }}</h6>
                            <div class="list-group">
                                @foreach($modulo->lecciones as $l)
                                    <a href="{{ route('lecciones.show', $l->id) }}"
                                       class="list-group-item list-group-item-action {{ $l->id == $leccion->id ? 'active' : '' }}">
                                        @if(in_array($l->id, $completadas))
                                            ✔
                                        @else
                                            X
                                        @endif
                                        {{ $l->titulo }}
                                    </a>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

          
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <small class="text-muted">Modulo {{ $leccion->modulo->orden }}: {{ $leccion->modulo->titulo }}</small>
                        <h3 class="mb-3">{{ $leccion->titulo }}</h3>

                        @if($leccion->video_url)
                            <div class="ratio ratio-16x9 mb-3">
                               <iframe src="{{ $leccion->video_embed }}" allowfullscreen></iframe>
                            </div>
                        @endif

                        @if($leccion->contenido)
                            <p style="white-space: pre-line;">{{ $leccion->contenido }}</p>
                        @endif

                        @if(!$leccion->video_url && !$leccion->contenido)
                            <div class="alert alert-secondary">Esta lección todavia no tiene video ni contenido.</div>
                        @endif

                      
                        <form action="{{ route('lecciones.completar', $leccion->id) }}" method="POST" class="mt-4">
                            @csrf
                            @if($estaCompletada)
                                <button type="submit" class="btn btn-outline-secondary"> Completada (clic para marcar como pendiente)</button>
                            @else
                                <button type="submit" class="btn btn-success">Marcar como completada</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>