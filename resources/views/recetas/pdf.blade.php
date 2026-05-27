<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receta Médica - {{ $receta->animal->nombre }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px solid #00a651;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 28px;
            color: #00a651;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 12px;
            color: #666;
        }
        
        .profesional-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
            background: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #00a651;
        }
        
        .profesional-info div {
            font-size: 12px;
        }
        
        .profesional-info strong {
            display: block;
            color: #00a651;
            margin-bottom: 5px;
        }
        
        .animal-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .section-title {
            background: #00a651;
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 3px;
        }
        
        .animal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .animal-item {
            font-size: 12px;
            background: #f9f9f9;
            padding: 10px;
            border-left: 3px solid #00a651;
        }
        
        .animal-item strong {
            display: block;
            color: #00a651;
            margin-bottom: 3px;
        }
        
        .diagnostico, .indicaciones, .notas {
            margin-bottom: 20px;
            font-size: 12px;
            line-height: 1.8;
        }
        
        .diagnostico p, .indicaciones p, .notas p {
            text-align: justify;
            margin-bottom: 10px;
        }
        
        .medicamentos-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 11px;
        }
        
        .medicamentos-table th {
            background: #00a651;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        
        .medicamentos-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .medicamentos-table tr:nth-child(even) {
            background: #f9f9f9;
        }
        
        .footer {
            margin-top: 40px;
            border-top: 2px solid #00a651;
            padding-top: 20px;
            text-align: center;
            font-size: 11px;
            color: #666;
        }
        
        .firma-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
        }
        
        .firma-line {
            border-top: 1px solid #000;
            margin-top: 50px;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🐾 RECETA MÉDICA VETERINARIA</h1>
            <p>Sistema de Gestión Veterinaria NovaTM</p>
        </div>

        <!-- Información del Profesional -->
        <div class="profesional-info">
            <div>
                <strong>👨‍⚕️ Profesional Veterinario</strong>
                <p>{{ $receta->User->nombre_completo }}</p>
                <p>Tarjeta Profesional: {{ $receta->User->tarjeta_profesional }}</p>
            </div>
            <div>
                <strong>📅 Fecha de Emisión</strong>
                <p>{{ $receta->fecha_emision->format('d/m/Y H:i') }}</p>
                <p>ID Receta: {{ $receta->id_receta }}</p>
            </div>
        </div>

        <!-- Datos del Animal -->
        <div class="animal-section">
            <div class="section-title">📊 DATOS DEL ANIMAL</div>
            <div class="animal-grid">
                <div class="animal-item">
                    <strong>Nombre:</strong>
                    {{ $receta->animal->nombre }}
                </div>
                <div class="animal-item">
                    <strong>Especie:</strong>
                    {{ $receta->animal->especie }}
                </div>
                <div class="animal-item">
                    <strong>Raza:</strong>
                    {{ $receta->animal->raza ?? 'N/A' }}
                </div>
                <div class="animal-item">
                    <strong>Peso:</strong>
                    {{ $receta->animal->peso }} kg
                </div>
                <div class="animal-item">
                    <strong>Edad:</strong>
                    {{ $receta->animal->edad }}
                </div>
                <div class="animal-item">
                    <strong>Identificación:</strong>
                    {{ $receta->animal->identificacion_propia ?? 'N/A' }}
                </div>
            </div>
        </div>

        <!-- Datos del Dueño -->
        <div class="animal-section">
            <div class="section-title">👤 DATOS DEL DUEÑO/PRODUCTOR</div>
            <div class="animal-grid">
                <div class="animal-item">
                    <strong>Nombre:</strong>
                    {{ $receta->animal->user->nombre_completo }}
                </div>
                <div class="animal-item">
                    <strong>Email:</strong>
                    {{ $receta->animal->user->email }}
                </div>
                <div class="animal-item">
                    <strong>Teléfono:</strong>
                    {{ $receta->animal->user->telefono ?? 'N/A' }}
                </div>
            </div>
        </div>

        <!-- Diagnóstico -->
        <div class="animal-section">
            <div class="section-title">🩺 DIAGNÓSTICO</div>
            <div class="diagnostico">
                <p>{{ $receta->diagnostico }}</p>
            </div>
        </div>

        <!-- Indicaciones Generales -->
        @if ($receta->indicaciones_generales)
            <div class="animal-section">
                <div class="section-title">📋 INDICACIONES GENERALES</div>
                <div class="indicaciones">
                    <p>{{ $receta->indicaciones_generales }}</p>
                </div>
            </div>
        @endif

        <!-- Medicamentos -->
        <div class="animal-section">
            <div class="section-title">💊 MEDICAMENTOS RECETADOS</div>
            @if ($receta->medicamentos->isNotEmpty())
                <table class="medicamentos-table">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Medicamento</th>
                            <th style="width: 15%;">Dosis</th>
                            <th style="width: 15%;">Vía</th>
                            <th style="width: 20%;">Frecuencia</th>
                            <th style="width: 15%;">Duración</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($receta->medicamentos as $med)
                            <tr>
                                <td><strong>{{ $med->nombre_medicamento }}</strong></td>
                                <td>{{ $med->dosis }}</td>
                                <td>{{ $med->via_administracion ?? '-' }}</td>
                                <td>{{ $med->frecuencia }}</td>
                                <td>{{ $med->duracion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="font-size: 12px;">No hay medicamentos registrados en esta receta.</p>
            @endif
        </div>

        <!-- Notas Adicionales -->
        @if ($receta->notas_adicionales)
            <div class="animal-section">
                <div class="section-title">📝 NOTAS ADICIONALES</div>
                <div class="notas">
                    <p>{{ $receta->notas_adicionales }}</p>
                </div>
            </div>
        @endif

        <!-- Firma y Datos Finales -->
        <div class="firma-section">
            <div>
                <strong>Firma del Profesional</strong>
                <div class="firma-line"></div>
                <p style="margin-top: 10px;">{{ $receta->User->nombre_completo }}<br>Tarjeta Prof: {{ $receta->User->tarjeta_profesional }}</p>
            </div>
            <div>
                <strong>Sello/Huella del Productor</strong>
                <div class="firma-line"></div>
                <p style="margin-top: 10px;">{{ $receta->animal->user->nombre_completo }}</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Este documento fue generado electrónicamente por el Sistema NovaTM - Gestión Veterinaria</p>
            <p>Fecha de impresión: {{ now()->format('d/m/Y H:i') }}</p>
            <p>© 2026 NovaTM - Todos los derechos reservados</p>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>
</html>