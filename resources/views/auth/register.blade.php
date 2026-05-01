<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro - {{ config('app.name', 'NovaTM') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            padding: 40px 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .register-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 60px 50px;
            max-width: 600px;
            margin: 0 auto;
        }

        .register-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .register-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            border: 3px solid #facc15;
        }

        .register-avatar img {
            width: 85px;
            height: 85px;
            object-fit: contain;
            border-radius: 50%;
        }

        .register-title {
            font-size: 32px;
            font-weight: 800;
            color: #14202A;
            margin: 0 0 8px 0;
        }

        .register-subtitle {
            font-size: 14px;
            color: #999;
            margin: 0;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-row-3 {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .form-row-3 {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 576px) {
            .form-row-2,
            .form-row-3 {
                grid-template-columns: 1fr;
            }
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #666;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .form-control,
        .form-select {
            border: none;
            border-bottom: 2px solid #e0e0e0;
            padding: 12px 0;
            font-size: 14px;
            background: transparent;
            transition: border-color 0.3s;
            border-radius: 0;
        }

        .form-control:focus,
        .form-select:focus {
            border-bottom-color: #facc15;
            box-shadow: none;
            background: transparent;
            color: #14202A;
        }

        .form-control::placeholder {
            color: #999;
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23666' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0 center;
            padding-right: 20px;
            cursor: pointer;
        }

        .form-select:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            color: #ccc;
        }

        .btn-register {
            width: 100%;
            background: linear-gradient(135deg, #facc15 0%, #f59e0b 100%);
            color: #14202A;
            border: none;
            padding: 14px 24px;
            border-radius: 25px;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            margin-top: 30px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(250, 204, 21, 0.3);
            color: #14202A;
            text-decoration: none;
        }

        .register-footer {
            text-align: center;
            margin-top: 30px;
        }

        .register-footer a {
            font-size: 13px;
            color: #999;
            text-decoration: none;
            transition: color 0.3s;
        }

        .register-footer a:hover {
            color: #facc15;
        }

        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            border-left: 4px solid #c33;
        }

        .success-message {
            background: #efe;
            color: #3c3;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
            border-left: 4px solid #3c3;
        }

        .error-field {
            border-bottom-color: #c33 !important;
        }

        .form-text {
            font-size: 12px;
            color: #999;
            margin-top: 4px;
        }

        .role-description {
            font-size: 11px;
            color: #999;
            margin-top: 2px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Header -->
        <div class="register-header">
            <div class="register-avatar">
                <img src="{{ asset('images/logoNovaTM.png') }}" alt="NovaTM">
            </div>
            <h1 class="register-title">Crear Cuenta</h1>
            <p class="register-subtitle">Únete a NovaTM hoy</p>
        </div>

        <!-- Messages -->
        @if ($errors->any())
            <div class="error-message">
                <strong><i class="fas fa-exclamation-circle"></i> Error en el registro:</strong>
                <ul style="margin: 8px 0 0 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="success-message">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <!-- Nombre Completo -->
            <div class="form-group">
                <label for="nombre_completo">Nombre Completo *</label>
                <input 
                    type="text" 
                    class="form-control @error('nombre_completo') error-field @enderror" 
                    id="nombre_completo" 
                    name="nombre_completo" 
                    placeholder="Tu nombre completo"
                    value="{{ old('nombre_completo') }}"
                    required
                >
            </div>

            <!-- Email -->
            <div class="form-group">
                <label for="email">Email *</label>
                <input 
                    type="email" 
                    class="form-control @error('email') error-field @enderror" 
                    id="email" 
                    name="email" 
                    placeholder="tu@email.com"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <!-- Documento y Teléfono -->
            <div class="form-row-2">
                <div class="form-group">
                    <label for="documento">Número de Documento *</label>
                    <input 
                        type="text" 
                        class="form-control @error('documento') error-field @enderror" 
                        id="documento" 
                        name="documento" 
                        placeholder="1234567890"
                        value="{{ old('documento') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono *</label>
                    <input 
                        type="tel" 
                        class="form-control @error('telefono') error-field @enderror" 
                        id="telefono" 
                        name="telefono" 
                        placeholder="+57 3001234567"
                        value="{{ old('telefono') }}"
                        required
                    >
                </div>
            </div>

            <!-- Dirección -->
            <div class="form-group">
                <label for="direccion">Dirección *</label>
                <input 
                    type="text" 
                    class="form-control @error('direccion') error-field @enderror" 
                    id="direccion" 
                    name="direccion" 
                    placeholder="Calle 123 # 45-67"
                    value="{{ old('direccion') }}"
                    required
                >
            </div>

            <!-- País, Departamento, Municipio -->
            <div class="form-row-3">
                <div class="form-group">
                    <label for="pais_id">País *</label>
                    <select 
                        class="form-select @error('pais_id') error-field @enderror" 
                        id="pais_id" 
                        name="pais_id"
                        onchange="cargarDepartamentos()"
                        required
                    >
                        <option value="">Selecciona país</option>
                        @foreach($paises as $pais)
                            <option value="{{ $pais->id }}" {{ old('pais_id') == $pais->id ? 'selected' : '' }}>
                                {{ $pais->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="departamento_id">Departamento *</label>
                    <select 
                        class="form-select @error('departamento_id') error-field @enderror" 
                        id="departamento_id" 
                        name="departamento_id"
                        onchange="cargarMunicipios()"
                        required
                        disabled
                    >
                        <option value="">Selecciona departamento</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="municipio_id">Municipio *</label>
                    <select 
                        class="form-select @error('municipio_id') error-field @enderror" 
                        id="municipio_id" 
                        name="municipio_id"
                        required
                        disabled
                    >
                        <option value="">Selecciona municipio</option>
                    </select>
                </div>
            </div>

            <!-- Rol -->
            <div class="form-group">
                <label for="rol">Tipo de Usuario *</label>
                <select 
                    class="form-select @error('rol') error-field @enderror" 
                    id="rol" 
                    name="rol"
                    onchange="toggleProfessionalFields()"
                    required
                >
                    <option value="">Selecciona tu rol</option>
                    <option value="productor" {{ old('rol') == 'productor' ? 'selected' : '' }}>
                        👨‍🌾 Usuario Normal (Productor)
                    </option>
                    <option value="veterinario" {{ old('rol') == 'veterinario' ? 'selected' : '' }}>
                        🩺 Veterinario
                    </option>
                    <option value="especialista" {{ old('rol') == 'especialista' ? 'selected' : '' }}>
                        🔬 Especialista
                    </option>
                </select>
            </div>

            <!-- Especialidad (solo para veterinario y especialista) -->
            <div class="form-group" id="especialidadField" style="display: none;">
                <label for="especialidad">Especialidad *</label>
                <input 
                    type="text" 
                    class="form-control @error('especialidad') error-field @enderror" 
                    id="especialidad" 
                    name="especialidad" 
                    placeholder="Ej: Cirugía, Medicina Interna"
                    value="{{ old('especialidad') }}"
                >
                <small class="form-text">Campo requerido para profesionales</small>
            </div>

            <!-- Tarjeta Profesional (solo para veterinario y especialista) -->
            <div class="form-group" id="tarjetaField" style="display: none;">
                <label for="tarjeta_profesional">Tarjeta Profesional *</label>
                <input 
                    type="text" 
                    class="form-control @error('tarjeta_profesional') error-field @enderror" 
                    id="tarjeta_profesional" 
                    name="tarjeta_profesional" 
                    placeholder="Número de tarjeta profesional"
                    value="{{ old('tarjeta_profesional') }}"
                >
                <small class="form-text">Campo requerido para profesionales</small>
            </div>

            <!-- Contraseña -->
            <div class="form-group">
                <label for="password">Contraseña *</label>
                <input 
                    type="password" 
                    class="form-control @error('password') error-field @enderror" 
                    id="password" 
                    name="password" 
                    placeholder="Mínimo 6 caracteres"
                    required
                >
                <small class="form-text">Debe contener al menos 6 caracteres</small>
            </div>

            <!-- Confirmar Contraseña -->
            <div class="form-group">
                <label for="password_confirmation">Confirmar Contraseña *</label>
                <input 
                    type="password" 
                    class="form-control @error('password_confirmation') error-field @enderror" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    placeholder="Repite tu contraseña"
                    required
                >
            </div>

            <!-- Register Button -->
            <button type="submit" class="btn-register">
                <i class="fas fa-user-plus"></i> CREAR CUENTA
            </button>

            <!-- Footer Link -->
            <div class="register-footer">
                ¿Ya tienes una cuenta? 
                <a href="{{ route('login') }}">
                    <i class="fas fa-sign-in-alt"></i> Inicia sesión aquí
                </a>
            </div>
        </form>
    </div>

    <script>
        // Función para cargar departamentos
        function cargarDepartamentos() {
            const paisId = document.getElementById('pais_id').value;
            const departamentoSelect = document.getElementById('departamento_id');
            const municipioSelect = document.getElementById('municipio_id');

            if (!paisId) {
                departamentoSelect.disabled = true;
                municipioSelect.disabled = true;
                departamentoSelect.innerHTML = '<option value="">Selecciona departamento</option>';
                municipioSelect.innerHTML = '<option value="">Selecciona municipio</option>';
                return;
            }

            fetch(`/api/departamentos/${paisId}`)
                .then(response => response.json())
                .then(data => {
                    departamentoSelect.innerHTML = '<option value="">Selecciona departamento</option>';
                    
                    data.forEach(dept => {
                        const option = document.createElement('option');
                        option.value = dept.id;
                        option.textContent = dept.nombre;
                        departamentoSelect.appendChild(option);
                    });
                    
                    departamentoSelect.disabled = false;
                    municipioSelect.disabled = true;
                    municipioSelect.innerHTML = '<option value="">Selecciona municipio</option>';
                    
                    // Si hay departamento guardado, cargar municipios
                    if ("{{ old('departamento_id') }}") {
                        departamentoSelect.value = "{{ old('departamento_id') }}";
                        setTimeout(() => cargarMunicipios(), 100);
                    }
                })
                .catch(error => {
                    console.error('Error cargando departamentos:', error);
                    departamentoSelect.disabled = true;
                });
        }

        // Función para cargar municipios
        function cargarMunicipios() {
            const departamentoId = document.getElementById('departamento_id').value;
            const municipioSelect = document.getElementById('municipio_id');

            if (!departamentoId) {
                municipioSelect.disabled = true;
                municipioSelect.innerHTML = '<option value="">Selecciona municipio</option>';
                return;
            }

            fetch(`/api/municipios/${departamentoId}`)
                .then(response => response.json())
                .then(data => {
                    municipioSelect.innerHTML = '<option value="">Selecciona municipio</option>';
                    
                    data.forEach(muni => {
                        const option = document.createElement('option');
                        option.value = muni.id;
                        option.textContent = muni.nombre;
                        municipioSelect.appendChild(option);
                    });
                    
                    municipioSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error cargando municipios:', error);
                    municipioSelect.disabled = true;
                });
        }

        // Función para mostrar/ocultar campos profesionales
        function toggleProfessionalFields() {
            const rol = document.getElementById('rol').value;
            const especialidadField = document.getElementById('especialidadField');
            const tarjetaField = document.getElementById('tarjetaField');

            if (rol === 'veterinario' || rol === 'especialista') {
                especialidadField.style.display = 'block';
                tarjetaField.style.display = 'block';
            } else {
                especialidadField.style.display = 'none';
                tarjetaField.style.display = 'none';
            }
        }

        // Inicializar cuando la página carga
        document.addEventListener('DOMContentLoaded', function() {
            // Mostrar campos profesionales si hay rol guardado
            toggleProfessionalFields();
            
            // Cargar departamentos si hay país guardado
            if ("{{ old('pais_id') }}") {
                cargarDepartamentos();
                
                // Cargar municipios si hay departamento guardado
                if ("{{ old('departamento_id') }}") {
                    setTimeout(() => {
                        cargarMunicipios();
                    }, 500);
                }
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>