<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    @include('partials.navbar')
    <div class="container" style="max-width: 480px;">
        <div class="card shadow-sm p-4">
            <h3 class="mb-3">Iniciar Sesión</h3>

            @if(session('exito'))
                <div class="alert alert-success">{{ session('exito') }}</div>
            @endif

            <form action="{{ route('login.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror" required>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" name="recordar" class="form-check-input" id="recordar">
                    <label class="form-check-label" for="recordar">Recordarme</label>
                </div>
                <button class="btn btn-primary w-100">Entrar</button>
            </form>
            <p class="mt-3 mb-0 text-center">¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate</a></p>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>