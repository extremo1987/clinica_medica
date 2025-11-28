<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        @page { size: 5.5in 8.5in; margin: 25px 35px; }

        body {
            font-family: DejaVu Sans, sans-serif;
            color: #222;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #0d47a1;
            padding-bottom: 8px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            color: #0d47a1;
        }

        .sub {
            font-size: 11px;
            margin-top: 3px;
        }

        .info-table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 6px;
            border: 1px solid #ccc;
            font-size: 11px;
        }

        .rx-title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 18px;
            color: #0d47a1;
        }

        .contenido {
            margin-top: 5px;
            font-size: 13px;
            white-space: pre-line;
        }

        .firma {
            margin-top: 60px;
            text-align: right;
            font-size: 12px;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>

    <!-- ENCABEZADO -->
    <div class="header">
        @if($setting->mostrar_logo_recetas && !empty($setting->logo))
            <img src="{{ public_path('storage/'.$setting->logo) }}" height="60"><br>
        @endif

        <h2>{{ $setting->nombre_clinica }}</h2>

        <div class="sub">
            Dr(a). {{ $setting->doctor }} — {{ $setting->especialidad }}<br>
            Registro Médico: {{ $setting->registro_medico }}<br>

            @if($setting->telefono)
                Tel: {{ $setting->telefono }}
            @endif

            @if($setting->direccion)
                • {{ $setting->direccion }}
            @endif

            @if($setting->email)
                • {{ $setting->email }}
            @endif
        </div>
    </div>

    <!-- TABLA DE DATOS DEL PACIENTE -->
    <table class="info-table">
        <tr>
            <td><strong>Paciente:</strong> {{ $paciente->nombre }}</td>
            <td><strong>Edad:</strong> {{ $paciente->edad }} años</td>
        </tr>
        <tr>
            <td><strong>Sexo:</strong> {{ $paciente->sexo ?? '---' }}</td>
            <td><strong>Fecha:</strong> {{ $fecha }}</td>
        </tr>
    </table>

    <!-- RX -->
    <div class="rx-title">R<span style="text-decoration: underline;">x</span>:</div>

    <!-- CONTENIDO DE LA RECETA -->
    <div class="contenido">
        {{ $receta }}
    </div>

    <!-- FIRMA -->
    <div class="firma">
        ____________________________<br>
        Dr(a). {{ $setting->doctor }}<br>
        {{ $setting->especialidad }}
    </div>

    <!-- PIE DE PÁGINA CONFIGURABLE -->
    @if(!empty($setting->footer_pdf))
        <div class="footer">{{ $setting->footer_pdf }}</div>
    @endif

</body>
</html>
