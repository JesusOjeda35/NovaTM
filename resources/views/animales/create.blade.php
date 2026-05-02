<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Registro - Mi Ganado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', sans-serif; }
        .container-box { max-width: 900px; margin: 30px auto; }
        .card-section {
            background: #fff; border-radius: 12px; padding: 20px 25px;
            margin-bottom: 18px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .section-title { font-weight: 600; font-size: 15px; color: #2d6cdf; margin-bottom: 15px; }
        .form-control { border-radius: 8px; height: 42px; }
        .form-label { font-weight: 600; font-size: 13px; color: #444; }
        .upload-box {
            border: 2px dashed #d0d7e2; padding: 25px; text-align: center;
            border-radius: 10px; font-size: 13px; color: #777;
        }
        .preview-img { width: 100%; height: 160px; border-radius: 10px; object-fit: cover; }
        .footer-buttons { display: flex; justify-content: flex-end; gap: 10px; }
        .btn-cancel { background: #eaeaea; border: none; padding: 10px 18px; border-radius: 8px; cursor: pointer; }
        .btn-save { background: #2d6cdf; color: #fff; border: none; padding: 10px 18px; border-radius: 8px; cursor: pointer; }
        .switch { position: relative; display: inline-block; width: 45px; height: 22px; }
        .switch input { display: none; }
        .slider {
            position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
            background-color: #ccc; transition: .4s; border-radius: 34px;
        }
        .slider:before {
            position: absolute; content: ""; height: 18px; width: 18px; left: 2px; bottom: 2px;
            background-color: white; transition: .4s; border-radius: 50%;
        }
        input:checked + .slider { background-color: #28a745; }
        input:checked + .slider:before { transform: translateX(22px); }
    </style>
</head>
<body>

<div class="container container-box">
    <div class="card-section">
        <h5><i class="fas fa-user-plus"></i> Nuevo Registro</h5>
        <p class="text-muted">Complete la información para registrar un nuevo animal</p>
    </div>

    <form method="POST" action="{{ route('animal.store') }}">
        @csrf

        <!-- 1. Información básica -->
        <div class="card-section">
            <div class="section-title"><i class="fas fa-user"></i> 1. Información básica</div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="form-label">Usuario *</label>
                    <select name="usuarios_id" class="form-control" required>
                        <option value="">Seleccionar usuario</option>
                        @foreach($usuarios as $u)
                            <option value="{{ $u->id }}">{{ $u->nombre_completo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Identificación propia</label>
                <input type="text" name="identificacion_propia" class="form-control" placeholder="Ingrese la identificación">
            </div>
        </div>

        <!-- 2. Datos del animal -->
        <div class="card-section">
            <div class="section-title text-success"><i class="fas fa-paw"></i> 2. Datos del animal</div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="form-label">Especie *</label>
                    <input type="text" name="especie" class="form-control" placeholder="Ej: Bovino" required>
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label">Raza</label>
                    <input type="text" name="raza" class="form-control" placeholder="Ingrese la raza">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="form-label">Edad</label>
                    <input type="text" name="edad" class="form-control" placeholder="Ingrese la edad (ej: 2 años)">
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label">Peso (kg)</label>
                    <input type="number" name="peso" class="form-control" placeholder="Ingrese el peso">
                </div>
            </div>
        </div>

        <!-- 3. Estado y registro -->
        <div class="card-section">
            <div class="section-title text-warning"><i class="fas fa-clipboard-check"></i> 3. Estado y registro</div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="form-label">Estado de salud</label>
                    <input type="text" name="estado_salud" class="form-control" placeholder="Ej: Bueno">
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label">Fecha de registro</label>
                    <input type="date" name="fecha_registro" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
            </div>
        </div>

        <!-- 4. Foto -->
        <div class="card-section">
            <div class="section-title text-primary"><i class="fas fa-image"></i> 4. Foto</div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="form-label">Foto del animal (URL)</label>
                    <input type="text" name="foto_url" class="form-control" placeholder="https://...">
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label">Vista previa</label>
                    <img class="preview-img" src="https://placehold.co/400x200" alt="Preview">
                </div>
            </div>
        </div>

        <!-- 5. Configuración -->
        <div class="card-section">
            <div class="section-title text-purple"><i class="fas fa-cog"></i> 5. Configuración</div>
            <label class="form-label">Sincronizado</label>
            <div>
                <label class="switch">
                    <input type="checkbox" name="sincronizado" value="S">
                    <span class="slider"></span>
                </label>
                <small class="text-muted ml-2">Sí, sincronizado</small>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-buttons">
            <a href="{{ route('productor.animales') }}" class="btn-cancel">Cancelar</a>
            <button type="submit" class="btn-save"><i class="fas fa-save"></i> Guardar registro</button>
        </div>
    </form>
</div>

<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>