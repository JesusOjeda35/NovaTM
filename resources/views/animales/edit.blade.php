@extends('layouts.app')

@section('title', 'Editar Animal - Mi Ganado')

@section('styles')
<style>
    .container-box {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .card-section {
        background: #FFFFFF;
        border-radius: 16px;
        padding: 28px;
        margin-bottom: 24px;
        box-shadow: 0 2px 12px rgba(20, 32, 42, 0.08);
        border-left: 4px solid #facc15;
    }

    .section-title {
        font-weight: 700;
        font-size: 16px;
        color: #14202A;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .section-title i {
        color: #facc15;
        font-size: 18px;
    }

    .form-label {
        font-weight: 600;
        font-size: 14px;
        color: #14202A;
        margin-bottom: 8px;
    }

    .form-control, .form-control:focus {
        border-radius: 10px;
        height: 44px;
        border: 2px solid #e5e7eb;
        font-size: 14px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #facc15;
        box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.1);
    }

    .form-control[readonly] {
        background-color: #f3f4f6;
        cursor: not-allowed;
    }

    .upload-box {
        border: 2px dashed #facc15;
        padding: 40px;
        text-align: center;
        border-radius: 12px;
        background: #fffbeb;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .upload-box:hover {
        border-color: #14202A;
        background: #fff8dc;
        transform: translateY(-2px);
    }

    .upload-box.active {
        border-color: #14202A;
        background: #fef3c7;
    }

    .upload-box i {
        color: #facc15;
        font-size: 32px;
        margin-bottom: 12px;
    }

    .upload-box p {
        color: #14202A;
        font-weight: 600;
        margin: 12px 0 0 0;
    }

    .upload-box small {
        color: #6b7280;
    }

    .preview-box {
        width: 100%;
        height: 200px;
        border-radius: 12px;
        overflow: hidden;
        background: #f3f4f6;
        cursor: pointer;
        border: 2px solid #e5e7eb;
    }

    .preview-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .preview-img:hover {
        transform: scale(1.08);
    }

    .preview-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #9ca3af;
    }

    .file-name {
        margin-top: 12px;
        font-size: 13px;
        color: #10b981;
        font-weight: 600;
    }

    .footer-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 40px;
    }

    .btn-cancel {
        background: #f3f4f6;
        border: 2px solid #e5e7eb;
        color: #14202A;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
        color: #14202A;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .btn-save {
        background: #facc15;
        border: none;
        color: #14202A;
        padding: 12px 28px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-save:hover {
        background: #eab308;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(250, 204, 21, 0.3);
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 28px;
    }

    .switch input {
        display: none;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #e5e7eb;
        transition: 0.4s;
        border-radius: 28px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 22px;
        width: 22px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.4s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #facc15;
    }

    input:checked + .slider:before {
        transform: translateX(24px);
    }

    #foto_url {
        display: none;
    }

    .modal-backdrop {
        background-color: rgba(20, 32, 42, 0.7);
    }

    .modal-content {
        background: transparent;
        border: none;
        box-shadow: none;
    }

    .modal-body {
        padding: 0;
    }

    .modal-body img {
        width: 100%;
        max-height: 90vh;
        border-radius: 12px;
    }

    .close {
        color: #FFFFFF;
        font-size: 32px;
        position: absolute;
        top: 20px;
        right: 30px;
        cursor: pointer;
        transition: opacity 0.3s ease;
    }

    .close:hover {
        opacity: 0.7;
    }
</style>
@endsection

@section('content')
<div class="container-box">
    <div class="card-section">
        <h5 style="font-size: 24px; color: #14202A; margin: 0; font-weight: 700;">
            <i class="fas fa-edit" style="color: #facc15;"></i> Editar Animal
        </h5>
        <p style="color: #6b7280; margin-top: 8px; margin-bottom: 0;">Modifica la información del animal</p>
    </div>

    <form method="POST" action="{{ route('animal.update', $animal->id_animal) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- 1. Información básica -->
        <div class="card-section">
            <div class="section-title">
                <i class="fas fa-id-card"></i> Información Básica
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="form-label">Usuario *</label>
                    <input type="text" name="usuario_display" class="form-control" value="{{ $animal->usuario->nombre_completo }}" readonly>
                    <input type="hidden" name="usuarios_id" value="{{ $animal->usuarios_id }}">
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label">Nombre del Animal *</label>
                    <input type="text" name="nombre" class="form-control" value="{{ $animal->nombre }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Identificación Propia</label>
                <input type="text" name="identificacion_propia" class="form-control" value="{{ $animal->identificacion_propia }}">
            </div>
        </div>

        <!-- 2. Datos del animal -->
        <div class="card-section">
            <div class="section-title">
                <i class="fas fa-paw"></i> Datos del Animal
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="form-label">Especie *</label>
                    <input type="text" name="especie" class="form-control" value="{{ $animal->especie }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label">Raza</label>
                    <input type="text" name="raza" class="form-control" value="{{ $animal->raza }}">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="form-label">Edad</label>
                    <input type="text" name="edad" class="form-control" value="{{ $animal->edad }}">
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label">Peso (kg)</label>
                    <input type="number" name="peso" class="form-control" value="{{ $animal->peso }}">
                </div>
            </div>
        </div>

        <!-- 3. Estado y registro -->
        <div class="card-section">
            <div class="section-title">
                <i class="fas fa-heart-pulse"></i> Estado y Registro
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="form-label">Estado de Salud</label>
                    <input type="text" name="estado_salud" class="form-control" value="{{ $animal->estado_salud }}">
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label">Fecha de Registro</label>
                    <input type="date" name="fecha_registro" class="form-control" value="{{ $animal->fecha_registro?->format('Y-m-d') }}">
                </div>
            </div>
        </div>

        <!-- 4. Foto -->
        <div class="card-section">
            <div class="section-title">
                <i class="fas fa-image"></i> Foto del Animal
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="form-label">Foto (PNG o JPG)</label>
                    <div class="upload-box" id="uploadBox">
                        <i class="fas fa-cloud-arrow-up"></i>
                        <p>Arrastra tu imagen aquí o haz clic</p>
                        <small>PNG o JPG • Máx 5MB</small>
                    </div>
                    <input type="file" id="foto_url" name="foto_url" accept="image/png,image/jpeg">
                    <div class="file-name" id="fileName"></div>
                </div>
                <div class="form-group col-md-6">
                    <label class="form-label">Vista Previa</label>
                    <div class="preview-box" id="previewBox">
                        <div class="preview-placeholder">
                            @if($animal->foto_url)
                                <img src="{{ asset($animal->foto_url) }}" style="width: 100%; height: 100%; object-fit: cover;" alt="{{ $animal->nombre }}">
                            @else
                                <i class="fas fa-image" style="font-size: 40px;"></i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. Configuración -->
        <div class="card-section">
            <div class="section-title">
                <i class="fas fa-sliders"></i> Configuración
            </div>
            <div style="display: flex; align-items: center; gap: 12px;">
                <label class="switch">
                    <input type="checkbox" name="sincronizado" value="S" @if($animal->sincronizado === 'S') checked @endif>
                    <span class="slider"></span>
                </label>
                <label class="form-label" style="margin-bottom: 0;">Sincronizar con plataforma</label>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-buttons">
            <a href="{{ route('productor.animales') }}" class="btn-cancel">
                <i class="fas fa-times"></i> Cancelar
            </a>
            <button type="submit" class="btn-save">
                <i class="fas fa-check"></i> Guardar Cambios
            </button>
        </div>
    </form>
</div>

<!-- Modal para ver imagen completa -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <img id="modalImage" src="" alt="Imagen ampliada">
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const uploadBox = document.getElementById('uploadBox');
    const fileInput = document.getElementById('foto_url');
    const previewBox = document.getElementById('previewBox');
    const fileName = document.getElementById('fileName');

    uploadBox.addEventListener('click', () => {
        fileInput.click();
    });

    uploadBox.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadBox.style.borderColor = '#14202A';
        uploadBox.style.background = '#fef3c7';
    });

    uploadBox.addEventListener('dragleave', () => {
        uploadBox.style.borderColor = '#facc15';
        uploadBox.style.background = '#fffbeb';
    });

    uploadBox.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadBox.style.borderColor = '#facc15';
        uploadBox.style.background = '#fffbeb';
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect();
        }
    });

    fileInput.addEventListener('change', handleFileSelect);

    function handleFileSelect() {
        const file = fileInput.files[0];
        if (file) {
            if (!['image/png', 'image/jpeg'].includes(file.type)) {
                alert('Por favor selecciona una imagen PNG o JPG');
                fileInput.value = '';
                fileName.textContent = '';
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                alert('El archivo no debe superar 5MB');
                fileInput.value = '';
                fileName.textContent = '';
                return;
            }

            fileName.textContent = `✓ ${file.name}`;

            const reader = new FileReader();
            reader.onload = (e) => {
                previewBox.innerHTML = `<img src="${e.target.result}" class="preview-img" alt="Foto seleccionada">`;
                
                document.querySelector('.preview-img').addEventListener('click', () => {
                    document.getElementById('modalImage').src = e.target.result;
                    $('#imageModal').modal('show');
                });
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection