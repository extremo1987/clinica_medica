<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clínica Médica – Acceso</title>

    <!-- Tabler Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1e88e5 0%, #42a5f5 50%, #90caf9 100%);
            height: 100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            animation: gradient 8s ease infinite;
            background-size: 400% 400%;
        }

        @keyframes gradient {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .login-wrapper {
            width: 420px;
            background: rgba(255, 255, 255, 0.92);
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 10px 40px rgba(0,0,0,.25);
            backdrop-filter: blur(8px);
        }

        .logo-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #ffffff;
            margin: 0 auto 20px auto;
            display:flex;
            justify-content:center;
            align-items:center;
            box-shadow: 0 5px 20px rgba(0,0,0,.2);
        }

        .logo-circle svg {
            width: 45px;
            height: 45px;
            color: #1e88e5;
        }

        .login-title {
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            color: #206bc4;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <!-- Logo circular profesional -->
        <div class="logo-circle">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-stethoscope" width="45" height="45" viewBox="0 0 24 24" stroke-width="1.5" stroke="#1e88e5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z"/>
                <path d="M6 3v6a6 6 0 1 0 12 0v-6" />
                <path d="M8 3h8" />
                <path d="M9 18v3" />
                <path d="M15 18v3" />
                <circle cx="12" cy="18" r="3" />
            </svg>
        </div>

        <h3 class="login-title">Clínica Médica</h3>
        <p class="text-center text-muted mb-4">Acceso al sistema clínico</p>

        @if ($errors->any())
            <div class="alert alert-danger text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="email" placeholder="ejemplo@correo.com" required autofocus />
            </div>

            <div class="mb-2">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="password" placeholder="********" required />
            </div>

            <button class="btn btn-primary w-100 mt-3" type="submit">
                Ingresar
            </button>
        </form>

    </div>

    <!-- Tabler Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>

</body>
</html>
