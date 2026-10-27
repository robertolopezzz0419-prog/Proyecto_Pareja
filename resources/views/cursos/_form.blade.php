
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="mb-3">
    <label class="form-label">Titulo del Curso</label>
    <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $curso->titulo ?? '') }}" required>
</div>

<div class="mb-3">
    <label class="form-label">Descripcion</label>
    <textarea name="descripcion" class="form-control" rows="3" required>{{ old('descripcion', $curso->descripcion ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label class="form-label">Precio ($)</label>
    <input type="number" step="0.01" min="0" max="999999.99" name="precio" class="form-control"
       value="{{ old('precio', $curso->precio ?? '') }}"
       onkeydown="if (['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();" required>

<div class="mb-3">
    <label class="form-label">Categoría</label>
   
    <select name="categoria_id" class="form-select" required>
        <option value="">Selecciona una categoria</option>
        @foreach($categorias as $categoria)
            <option value="{{ $categoria->id }}" {{ old('categoria_id', $curso->categoria_id ?? '') == $categoria->id ? 'selected' : '' }}>
                {{ $categoria->nombre }}
            </option>
        @endforeach
    </select>
</div>


<div class="mb-3">
    <label class="form-label">Imagen del curso</label>
    @if(isset($curso) && $curso->imagen)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $curso->imagen) }}" alt="Imagen actual" style="height: 100px;" class="rounded">
            <small class="text-muted d-block">Imagen actual. Sube otra solo si quieres cambiarla.</small>
        </div>
    @endif
    <input type="file" name="imagen" class="form-control" accept="image/*">
</div>