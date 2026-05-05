@extends('layouts.app')

@section('title', 'Mis Animales - Mi Ganado')

@section('styles')
<style>
    .container-box {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .header-section {
        background: linear-gradient(135deg, #facc15 0%, #fbbf24 100%);
        border-radius: 16px;
        padding: 40px;
        margin-bottom: 40px;
        box-shadow: 0 4px 20px rgba(250, 204, 21, 0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-title {
        font-size: 32px;
        font-weight: 700;
        color: #14202A;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-title i {
        font-size: 36px;
    }

    .btn-new {
        background: #14202A;
        color: #facc15;
        padding: 14px 28px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 2px solid #14202A;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-new:hover {
        background: transparent;
        color: #14202A;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .alert {
        border-radius: 12px;
        border: none;
        padding: 16px 20px;
        margin-bottom: 30px;
    }

    .alert-success {
        background: #d1fae5;
        color: #065f46;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.1);
    }

    .animal-card {
        background: #FFFFFF;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(20, 32, 42, 0.08);
        margin-bottom: 24px;
        transition: all 0.3s ease;
        border-top: 4px solid #facc15;
    }

    .animal-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 24px rgba(20, 32, 42, 0.12);
    }

    .card-img {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    }

    .card-body {
        padding: 24px;
    }

    .animal-name {
        font-size: 22px;
        font-weight: 700;
        color: #14202A;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .animal-name i {
        color: #facc15;
    }

    .animal-info {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
    }

    .animal-info:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: #14202A;
    }

    .info-value {
        color: #6b7280;
    }

    .card-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-action {
        flex: 1;
        padding: 12px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        text-align: center;
        cursor: pointer;
        border: none;
        font-size: 14px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-view {
        background: #14202A;
        color: #facc15;
    }

    .btn-view:hover {
        background: #1f2937;
        color: #facc15;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .btn-edit {
        background: #facc15;
        color: #14202A;
    }

    .btn-edit:hover {
        background: #eab308;
        color: #14202A;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .btn-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-delete:hover {
        background: #fecaca;
        color: #dc2626;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: #FFFFFF;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(20, 32, 42, 0.08);
    }

    .empty-icon {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 20px;
    }

    .empty-message {
        font-size: 20px;
        color: #6b7280;
        margin-bottom: 24px;
    }

    .empty-link {
        color: #facc15;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: #fffbeb;
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .empty-link:hover {
        background: #fef3c7;
        text-decoration: none;
    }

    .pagination {
        justify-content: center;
        margin-top: 40px;
    }

    .pagination .page-link {
        color: #facc15;
        border-color: #e5e7eb;
    }

    .pagination .page-link:hover {
        color: #14202A;
        background-color: #facc15;
        border-color: #facc15;
    }

    .pagination .page-item.active .page-link {
        background-color: #facc15;
        border-color: #facc15;
        color: #14202A;
    }

    .modal-backdrop {
        background-color: rgba(20, 32, 42, 0.7);
    }

    .modal-content {
        border-radius: 16px;
        border: none;
        box-shadow: 0 20px 40px rgba(20, 32, 42, 0.2);
    }

    .modal-header {
        background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
        color: #FFFFFF;
        border: none;
        border-radius: 16px 16px 0 0;
        padding: 28px;
    }

    .modal-header .close {
        color: #FFFFFF;
        opacity: 0.8;
    }

    .modal-header .close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 32px;
        text-align: center;
    }

    .modal-icon {
        font-size: 64px;
        color: #dc2626;
        margin-bottom: 16px;
    }

    .modal-title {
        font-size: 24px;
        font-weight: 700;
        color: #14202A;
        margin: 0;
    }

    .modal-message {
        font-size: 16px;
        color: #6b7280;
        margin-top: 12px;
        line-height: 1.6;
    }

    .modal-footer {
        border: none;
        padding: 20px 28px;
        background: #f9fafb;
        border-radius: 0 0 16px 16px;
        display: flex;
        gap: 12px;
        justify-content: flex-end;
    }

    .btn-modal-cancel {
        background: #f3f4f6;
        color: #14202A;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-modal-cancel:hover {
        background: #e5e7eb;
        color: #14202A;
    }

    .btn-modal-delete {
        background: #dc2626;
        color: #FFFFFF;
        border: none;
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-modal-delete:hover {
        background: #b91c1c;
        color: #FFFFFF;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .header-section {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }

        .header-title {
            justify-content: center;
            font-size: 24px;
        }

        .btn-new {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="container-box">
    <div class="header-section">
        <h1 class="header-title">
            <i class="fas fa-list"></i> Mis Animales
        </h1>
        <a href="{{ route('animal.create') }}" class="btn-new">
            <i class="fas fa-plus"></i> Nuevo Animal
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div style="display: flex; align-items: center;">
                <i class="fas fa-check-circle" style="margin-right: 12px; font-size: 18px;"></i>
                <span style="flex: 1;">{{ session('success') }}</span>
            </div>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($animales->count() > 0)
        <div class="row">
            @foreach($animales as $animal)
                <div class="col-md-6 col-lg-4">
                    <div class="animal-card">
                        @if($animal->foto_url)
                            <img src="{{ asset($animal->foto_url) }}" alt="{{ $animal->nombre }}" class="card-img">
                        @else
                            <div class="card-img" style="display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                <i class="fas fa-image" style="font-size: 48px;"></i>
                            </div>
                        @endif

                        <div class="card-body">
                            <h5 class="animal-name">
                                <i class="fas fa-paw"></i> {{ $animal->nombre }}
                            </h5>

                            <div class="animal-info">
                                <span class="info-label">Especie:</span>
                                <span class="info-value">{{ $animal->especie }}</span>
                            </div>

                            @if($animal->raza)
                                <div class="animal-info">
                                    <span class="info-label">Raza:</span>
                                    <span class="info-value">{{ $animal->raza }}</span>
                                </div>
                            @endif

                            @if($animal->edad)
                                <div class="animal-info">
                                    <span class="info-label">Edad:</span>
                                    <span class="info-value">{{ $animal->edad }}</span>
                                </div>
                            @endif

                            @if($animal->peso)
                                <div class="animal-info">
                                    <span class="info-label">Peso:</span>
                                    <span class="info-value">{{ $animal->peso }} kg</span>
                                </div>
                            @endif

                            @if($animal->identificacion_propia)
                                <div class="animal-info">
                                    <span class="info-label">ID:</span>
                                    <span class="info-value">{{ $animal->identificacion_propia }}</span>
                                </div>
                            @endif

                            @if($animal->estado_salud)
                                <div class="animal-info">
                                    <span class="info-label">Salud:</span>
                                    <span class="info-value">{{ $animal->estado_salud }}</span>
                                </div>
                            @endif

                            <div class="card-actions">
                                <a href="{{ route('animal.show', $animal->id_animal) }}" class="btn-action btn-view">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="{{ route('animal.edit', $animal->id_animal) }}" class="btn-action btn-edit">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <button type="button" class="btn-action btn-delete" data-toggle="modal" data-target="#deleteModal{{ $animal->id_animal }}">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deleteModal{{ $animal->id_animal }}" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirmar Eliminación</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-icon">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                                <p class="modal-message">
                                    ¿Estás seguro de que deseas eliminar a <strong>{{ $animal->nombre }}</strong>?<br>
                                    <small style="color: #9ca3af;">Esta acción no se puede deshacer.</small>
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn-modal-cancel" data-dismiss="modal">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                                <form action="{{ route('animal.destroy', $animal->id_animal) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-modal-delete">
                                        <i class="fas fa-trash"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center">
            {{ $animales->links('pagination::bootstrap-4') }}
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-inbox"></i>
            </div>
            <p class="empty-message">Aún no tienes animales registrados</p>
            <a href="{{ route('animal.create') }}" class="empty-link">
                <i class="fas fa-plus"></i> Crear tu primer animal
            </a>
        </div>
    @endif
</div>
@endsection