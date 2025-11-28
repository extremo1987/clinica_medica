<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 35px; font-size: 13px; }
        .titulo { text-align: center; font-size: 22px; font-weight: bold; color:#0a3d62; margin-bottom: 10px; }
        .box { border: 2px solid #0a3d62; padding: 15px; border-radius: 10px; }
        .footer { margin-top: 20px; text-align:center; font-size: 12px; color: #333; }
    </style>
</head>
<body>

    <div class="titulo">REMISIÓN / REFERENCIA MÉDICA</div>

    <p><strong>Paciente:</strong> {{ $paciente->nombre }}</p>
    <p><strong>Fecha:</strong> {{ $fecha->format('d/m/Y') }}</p>

    <div class="box">

        <strong>Centro / Hospital Destino:</strong><br>
        {{ $hospital }} <br><br>

        <strong>Motivo:</strong><br>
        {!! nl2br(e($motivo)) !!} <br><br>

        <strong>Diagnóstico Presuntivo:</strong><br>
        {{ $diagnostico }}

    </div>

    <div class="footer">
        {{ $setting->nombre_clinica ?? '' }} — {{ $setting->doctor ?? '' }}
    </div>

</body>
</html>
