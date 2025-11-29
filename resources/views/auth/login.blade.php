<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clínica Médica – Acceso</title>

    <!-- Meta viewport: necesario para que todo sea responsivo en móviles -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tabler Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/css/tabler.min.css" rel="stylesheet">

    <style>
        /* box-sizing global para evitar sorpresas con paddings */
        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            height: 100%;
            margin: 0;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        body {
            background: linear-gradient(135deg, #1e88e5 0%, #42a5f5 50%, #90caf9 100%);
            min-height: 100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding: 12px; /* espacio en móviles */
            animation: gradient 8s ease infinite;
            background-size: 400% 400%;
        }

        @keyframes gradient {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Contenedor del login */
        .login-wrapper {
            width: 100%;
            max-width: 360px; /* aun más pequeño por defecto */
            background: rgba(255, 255, 255, 0.96);
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0,0,0,.18);
            backdrop-filter: blur(6px);
        }

        .logo-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #fff;
            margin: 0 auto 14px auto;
            display:flex;
            justify-content:center;
            align-items:center;
            box-shadow: 0 4px 14px rgba(0,0,0,.12);
        }

        .logo-circle svg { width: 34px; height: 34px; }

        .login-title {
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            color: #0f61b6;
            margin: 6px 0 4px;
        }

        .text-muted { text-align:center; margin-bottom: 14px; color: #6b7280; font-size: 13px; }

        /* Forzar tamaños de inputs y botones (importante para sobrescribir Tabler) */
        .form-label { font-size: 13px; margin-bottom: 6px; display:block; color:#374151; }
        input.form-control,
        .form-control {
            height: 40px !important;
            padding: 6px 10px !important;
            font-size: 14px !important;
        }
        button.btn {
            height: 42px !important;
            font-size: 14px !important;
        }

        .field-row {
            position: relative;
        }

        /* Botón pequeño para mostrar contraseña */
        .toggle-pass {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            font-size: 13px;
            cursor: pointer;
            color: #2563eb;
            padding: 4px 6px;
        }

        /* Mensajes de error centrados */
        .alert { font-size: 13px; padding: 8px 12px; }

        /* ===== Ajustes fuertes para pantallas pequeñas ===== */
        @media (max-width: 480px) {
            .login-wrapper {
                padding: 18px;
                max-width: 320px; /* tamaño móvil definitivo */
                border-radius: 12px;
            }
            .logo-circle { width: 50px; height: 50px; margin-bottom: 10px; }
            .logo-circle svg { width: 26px; height: 26px; }
            .login-title { font-size: 15px; }
            .text-muted { font-size: 11.5px; margin-bottom: 10px; }
            .form-label { font-size: 12px; }
            input.form-control, .form-control {
                height: 34px !important;
                font-size: 13px !important;
                padding: 6px 8px !important;
            }
            button.btn { height: 36px !important; font-size: 13px !important; }
        }

        /* Reducir fuente base en pantallas muy pequeñas (por si hay zoom forzado) */
        @media (max-height: 600px) and (max-width: 420px) {
            html { font-size: 14px; }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">

        <!-- Logo circular -->
        <div class="logo-circle" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="#1e88e5" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z"/>
                <path d="M6 3v6a6 6 0 1 0 12 0v-6" />
                <path d="M8 3h8" />
                <path d="M9 18v3" />
                <path d="M15 18v3" />
                <circle cx="12" cy="18" r="3" />
            </svg>
        </div>

        <h3 class="login-title">Clínica Médica</h3>
        <p class="text-muted">Acceso al sistema clínico</p>

        <!-- Mensaje de error (Blade syntax) -->
        @if ($errors->any())
            <div class="alert alert-danger text-center">
                {{ $errors->first() }}
            </div>
        @endif

        <!-- Formulario -->
        <form method="POST" action="{{ route('login.post') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="email">Correo Electrónico</label>
                <input id="email" type="email" class="form-control" name="email" placeholder="ejemplo@correo.com" required autofocus />
            </div>

            <div class="mb-2 field-row">
                <label class="form-label" for="password">Contraseña</label>
                <input id="password" type="password" class="form-control" name="password" placeholder="********" required />
                <button type="button" class="toggle-pass" id="togglePassword" aria-label="Mostrar contraseña">Mostrar</button>
            </div>

            <button class="btn btn-primary w-100 mt-3" type="submit">Ingresar</button>
        </form>

    </div>

    <!-- Tabler Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@latest/dist/js/tabler.min.js"></script>

    <!-- JS pequeño para Mostrar / Ocultar contraseña -->
    <script>
        (function(){
            const toggle = document.getElementById('togglePassword');
            const pwd = document.getElementById('password');
            if (!toggle || !pwd) return;
            toggle.addEventListener('click', function(){
                if (pwd.type === 'password') {
                    pwd.type = 'text';
                    toggle.textContent = 'Ocultar';
                } else {
                    pwd.type = 'password';
                    toggle.textContent = 'Mostrar';
                }
            });
        })();
    </script>

</body>
</html>