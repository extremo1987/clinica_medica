<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; margin: 35px; font-size: 13px; }
        .titulo { text-align: center; font-size: 22px; font-weight: bold; color: #b71540; margin-bottom: 10px; }
        .box { border: 2px solid #b71540; padding: 15px; border-radius: 10px; }
        .footer { margin-top: 20px; text-align:center; font-size: 12px; color: #333; }
    </style>
</head>
<body>

    <div class="titulo">CONSTANCIA DE INCAPACIDAD</div>

    <p><strong>Paciente:</strong> {{ $paciente->nombre }}</p>
    <p><strong>Fecha de emisión:</strong> {{ $fecha->format('d/m/Y') }}</p>

    <div class="box">
        Se otorgan <strong>{{ $dias }}</strong> días de incapacidad médica.<br><br>

        <strong>Desde:</strong> {{ $inicio }} <br>
        <strong>Hasta:</strong> {{ $fin }} <br><br>

        <strong>Motivo:</strong><br>
        {!! nl2br(e($motivo)) !!}
    </div>

    <div class="footer">
        {{ $setting->nombre_clinica ?? '' }} — {{ $setting->doctor ?? '' }}
    </div>

</body>
</html>
