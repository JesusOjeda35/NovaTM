<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atención de Emergencia - NovaTM</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        :root {
            --primary-red: #DC2626;
            --primary-yellow: #facc15;
            --dark-blue: #14202A;
            --light-gray: #f8f9fa;
            --text-dark: #1a1a1a;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: var(--light-gray); }
        
        /* HEADER */
        .emergency-header {
            background: linear-gradient(135deg, var(--dark-blue) 0%, #1e2d3d 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        
        .emergency-header h1 {
            font-size: 36px;
            font-weight: 800;
            margin-bottom: 10px;
        }
        
        .emergency-header p {
            font-size: 16px;
            opacity: 0.95;
        }
        
        /* SECCIÓN PRINCIPAL */
        .emergency-section {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* CARD DE ¿ES UNA EMERGENCIA? */
        .emergency-info-card {
            background: white;
            border-left: 5px solid var(--primary-red);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .emergency-info-card h2 {
            color: var(--text-dark);
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .emergency-info-card .bell-icon {
            font-size: 32px;
            color: var(--primary-red);
            animation: ring 1s infinite;
        }
        
        @keyframes ring {
            0%, 100% { transform: rotate(0); }
            10% { transform: rotate(-10deg); }
            20% { transform: rotate(10deg); }
            30% { transform: rotate(-10deg); }
        }
        
        .emergency-info-card p {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .btn-call-now {
            background: var(--primary-red);
            color: white;
            border: none;
            padding: 15px 40px;
            font-size: 16px;
            font-weight: 700;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }
        
        .btn-call-now:hover {
            background: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.3);
            color: white;
        }
        
        /* SÍNTOMAS COMUNES */
        .symptoms-section h3 {
            color: var(--text-dark);
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
        }
        
        .symptoms-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        
        .symptom-card {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            cursor: pointer;
        }
        
        .symptom-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgba(220, 38, 38, 0.15);
        }
        
        .symptom-icon {
            font-size: 36px;
            margin-bottom: 10px;
        }
        
        .symptom-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
        }
        
        /* QUÉ HACER */
        .what-to-do-section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .what-to-do-section h3 {
            color: var(--text-dark);
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            text-align: center;
        }
        
        .steps-list {
            list-style: none;
        }
        
        .steps-list li {
            display: flex;
            gap: 15px;
            margin-bottom: 18px;
            align-items: flex-start;
        }
        
        .step-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: var(--primary-red);
            color: white;
            border-radius: 50%;
            font-weight: 700;
            min-width: 32px;
        }
        
        .step-text {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
        }
        
        /* FORMULARIO */
        .emergency-form-section {
            background: white;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .emergency-form-section h3 {
            color: var(--text-dark);
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 30px;
            border-bottom: 3px solid var(--primary-yellow);
            padding-bottom: 15px;
        }
        
        .form-group label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-size: 14px;
        }
        
        .form-control {
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 12px;
            font-size: 14px;
            transition: all 0.3s;
            width: 100%;
        }
        
        .form-control:focus {
            border-color: var(--primary-red);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
            outline: none;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
        
        .btn-submit {
            background: var(--primary-red);
            color: white;
            border: none;
            padding: 14px 40px;
            font-size: 16px;
            font-weight: 700;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
            margin-top: 20px;
        }
        
        .btn-submit:hover {
            background: #b91c1c;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.3);
        }
        
        /* CLÍNICAS CERCANAS */
        .clinics-section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            margin-top: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .clinics-section h3 {
            color: var(--text-dark);
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
        }
        
        .clinic-card {
            border-left: 4px solid var(--primary-yellow);
            padding: 20px;
            margin-bottom: 18px;
            background: #f9f9f9;
            border-radius: 6px;
        }
        
        .clinic-name {
            font-weight: 700;
            color: var(--text-dark);
            font-size: 16px;
            margin-bottom: 8px;
        }
        
        .clinic-info {
            font-size: 13px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 10px;
        }
        
        .clinic-hours {
            background: var(--primary-yellow);
            color: var(--dark-blue);
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        
        .alert-box {
            background: #FEE2E2;
            border-left: 4px solid var(--primary-red);
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #7F1D1D;
        }
        
        .success-message {
            background: #DBEAFE;
            border-left: 4px solid #2563EB;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            color: #1E40AF;
        }
    </style>
</head>
<body>
    
    @include('layouts.partials.topbar')

    <!-- HEADER -->
    <div class="emergency-header">
        <h1>🚨 Atención de Emergencia</h1>
        <p>Estamos disponibles 24/7 para emergencias veterinarias</p>
    </div>
    
    <!-- CONTENIDO PRINCIPAL -->
    <div class="emergency-section">
        
        <!-- MENSAJES DE ÉXITO/ERROR -->
        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- TARJETA: ¿ES UNA EMERGENCIA? -->
        <div class="emergency-info-card">
            <h2>
                <span class="bell-icon">🔔</span>
                ¿Es una emergencia?
            </h2>
            <p>Si tu mascota presenta una situación crítica, contactáctanos inmediatamente.</p>
            <a href="tel:+5711123456" class="btn-call-now">
                <i class="fas fa-phone"></i>
                Llamar ahora - Atención 24/7
            </a>
        </div>
        
        <!-- SÍNTOMAS COMUNES -->
        <div class="symptoms-section">
            <h3>Síntomas de emergencia comunes</h3>
            <div class="symptoms-grid">
                <div class="symptom-card">
                    <div class="symptom-icon">🏃</div>
                    <div class="symptom-name">Dificultad para respirar</div>
                </div>
                <div class="symptom-card">
                    <div class="symptom-icon">😵</div>
                    <div class="symptom-name">Convulsiones</div>
                </div>
                <div class="symptom-card">
                    <div class="symptom-icon">🤢</div>
                    <div class="symptom-name">Vómito continuo</div>
                </div>
                <div class="symptom-card">
                    <div class="symptom-icon">💧</div>
                    <div class="symptom-name">Sangrado</div>
                </div>
                <div class="symptom-card">
                    <div class="symptom-icon">😞</div>
                    <div class="symptom-name">Apatía total</div>
                </div>
                <div class="symptom-card">
                    <div class="symptom-icon">🤕</div>
                    <div class="symptom-name">Atropellamiento</div>
                </div>
            </div>
        </div>
        
        <!-- QUÉ HACER -->
        <div class="what-to-do-section">
            <h3>¿Qué hacer en caso de emergencia?</h3>
            <ul class="steps-list">
                <li>
                    <div class="step-number">1</div>
                    <div class="step-text">Mantén la calma y evalúa la situación inmediata de tu animal.</div>
                </li>
                <li>
                    <div class="step-number">2</div>
                    <div class="step-text">Comunicate con nuestro equipo de emergencia.</div>
                </li>
                <li>
                    <div class="step-number">3</div>
                    <div class="step-text">Sigue las instrucciones del veterinario disponible.</div>
                </li>
                <li>
                    <div class="step-number">4</div>
                    <div class="step-text">Obliga a la clínica más cercana si es necesario.</div>
                </li>
            </ul>
            
            <div class="alert-box" style="margin-top: 25px;">
                <strong>⚠️ Aviso legal:</strong> Este servicio no sustituye la atención presencial urgente. En caso de emergencia grave, acude inmediatamente a la clínica más cercana.
            </div>
        </div>
        
        <!-- FORMULARIO DE REPORTE -->
        <div class="emergency-form-section">
            <h3>📋 Reportar Emergencia</h3>
            
            <form action="{{ route('emergencia.publica.store') }}" method="POST">
                @csrf
                
                <!-- DATOS DE CONTACTO -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="telefono_contacto">Teléfono de contacto *</label>
                        <input type="tel" name="telefono_contacto" id="telefono_contacto" class="form-control" placeholder="Ej: 3125551234" required>
                        @error('telefono_contacto') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email_contacto">Correo electrónico *</label>
                        <input type="email" name="email_contacto" id="email_contacto" class="form-control" placeholder="tu@email.com" required>
                        @error('email_contacto') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                
                <!-- DATOS DEL ANIMAL -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="nombre_animal">Nombre del animal *</label>
                        <input type="text" name="nombre_animal" id="nombre_animal" class="form-control" placeholder="Ej: Max" required>
                        @error('nombre_animal') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="especie">Especie *</label>
                        <select name="especie" id="especie" class="form-control" required>
                            <option value="">Selecciona especie...</option>
                            <option value="Perro">Perro</option>
                            <option value="Gato">Gato</option>
                            <option value="Caballo">Caballo</option>
                            <option value="Vaca">Vaca</option>
                            <option value="Oveja">Oveja</option>
                            <option value="Cerdo">Cerdo</option>
                            <option value="Otra">Otra</option>
                        </select>
                        @error('especie') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                
                <!-- SÍNTOMAS -->
                <div class="form-group">
                    <label for="sintomas_graves">Síntomas graves presentados *</label>
                    <textarea name="sintomas_graves" id="sintomas_graves" class="form-control" rows="4" placeholder="Describe detalladamente los síntomas que presenta tu animal..." required></textarea>
                    @error('sintomas_graves') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                
                <!-- UBICACIÓN -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="direccion_texto">Dirección (opcional)</label>
                        <input type="text" name="direccion_texto" id="direccion_texto" class="form-control" placeholder="Ej: Cra. 5 #10-20, Bogotá">
                        @error('direccion_texto') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label>Obtener ubicación actual</label>
                        <button type="button" class="btn btn-outline-danger btn-block" onclick="getLocation()">
                            📍 Usar mi ubicación
                        </button>
                    </div>
                </div>
                
                <input type="hidden" name="latitud" id="latitud">
                <input type="hidden" name="longitud" id="longitud">
                
                <button type="submit" class="btn-submit">
                    🚨 Reportar Emergencia Ahora
                </button>
            </form>
        </div>
    </div>

    @include('layouts.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        document.getElementById('latitud').value = position.coords.latitude;
                        document.getElementById('longitud').value = position.coords.longitude;
                        alert('✅ Ubicación obtenida correctamente');
                    },
                    function(error) {
                        alert('❌ Error al obtener ubicación: ' + error.message);
                    }
                );
            } else {
                alert('❌ Tu navegador no soporta geolocalización');
            }
        }
        
        function viewAllClinics() {
            alert('Función de mapa de clínicas próximamente disponible');
        }
    </script>
</body>
</html>