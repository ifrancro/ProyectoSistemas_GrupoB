<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credencial Electoral</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .credencial {
            background-color: white;
            border: 3px solid #2563eb;
            border-radius: 15px;
            padding: 30px;
            max-width: 400px;
            margin: 0 auto;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }
        .titulo {
            font-size: 18px;
            color: #374151;
            font-weight: 600;
        }
        .subtitulo {
            font-size: 14px;
            color: #6b7280;
        }
        .info-persona {
            margin-bottom: 25px;
        }
        .campo {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            padding: 5px 0;
        }
        .campo-label {
            font-weight: 600;
            color: #374151;
        }
        .campo-valor {
            color: #6b7280;
        }
        .rol-section {
            text-align: center;
            margin: 25px 0;
            padding: 20px;
            background-color: #f9fafb;
            border-radius: 10px;
        }
        .rol-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            margin: 10px 0;
        }
        .rol-jurado {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .rol-veedor {
            background-color: #dcfce7;
            color: #166534;
        }
        .rol-delegado {
            background-color: #f3e8ff;
            color: #7c3aed;
        }
        .footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            font-size: 12px;
            color: #6b7280;
        }
        .fecha {
            font-size: 12px;
            color: #9ca3af;
            text-align: right;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="credencial">
        <div class="header">
            <div class="logo">SISTEMA ELECTORAL</div>
            <div class="titulo">CREDENCIAL ELECTORAL</div>
            <div class="subtitulo">Documento Oficial de Identificación</div>
        </div>

        <div class="info-persona">
            <div class="campo">
                <span class="campo-label">Cédula de Identidad:</span>
                <span class="campo-valor">{{ $persona->ci }}</span>
            </div>
            <div class="campo">
                <span class="campo-label">Nombre Completo:</span>
                <span class="campo-valor">{{ $persona->nombre }} {{ $persona->apellido }}</span>
            </div>
            <div class="campo">
                <span class="campo-label">Ciudad:</span>
                <span class="campo-valor">{{ $persona->ciudad ?? 'N/A' }}</span>
            </div>
        </div>

        <div class="rol-section">
            <div class="rol-badge {{ strtolower($rol) == 'jurado' ? 'rol-jurado' : (strtolower($rol) == 'veedor' ? 'rol-veedor' : 'rol-delegado') }}">
                @if(strtolower($rol) == 'jurado')
                    JURADO ELECTORAL
                @elseif(strtolower($rol) == 'veedor')
                    VEEDOR ELECTORAL
                @else
                    DELEGADO ELECTORAL
                @endif
            </div>
            
            <div style="text-align: center; margin-top: 20px; padding: 15px; background-color: #f9fafb; border-radius: 8px;">
                <div style="font-size: 14px; color: #374151; font-weight: 600;">
                    Documento Oficial Válido
                </div>
                <div style="font-size: 12px; color: #6b7280; margin-top: 5px;">
                    Presente esta credencial en el lugar asignado
                </div>
            </div>
        </div>

        <div class="footer">
            <div>Este documento es válido únicamente para las elecciones</div>
            <div style="margin-top: 5px;">Generado el {{ now()->format('d/m/Y H:i') }}</div>
        </div>

        <div class="fecha">
            ID: {{ $persona->ci }}_{{ $rol }}_{{ now()->format('Ymd') }}
        </div>
    </div>
</body>
</html>