<h1>Mis cursos inscritos</h1>

@if(session('success'))
    <p style="color: green">{{ session('success') }}</p>
@endif

@forelse($cursos as $curso)
    <div>
        <h3><a href="{{ route('cursos.show', $curso) }}">{{ $curso->titulo }}</a></h3>
        <p>{{ $curso->descripcion }}</p>

        <form action="{{ route('inscripciones.destroy', $curso) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Salirme del curso</button>
        </form>
    </div>
@empty
    <p>Aun no estas inscrito a ningun curso.</p>
@endforelse