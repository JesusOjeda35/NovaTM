@extends('layouts.app')

@section('title', 'Animal Registrado - Mi Ganado')

@section('styles')
<style>
    .container-box {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .success-card {
        background: linear-gradient(135deg, #FFFFFF 0%, #f9fafb 100%);
        border-radius: 16px;
        padding: 48px;
        box-shadow: 0 4px 20px rgba(20, 32, 42, 0.08);
        text-align: center;
        margin-bottom: 40px;
        border-top: 4px solid #facc15;
    }

    .success-icon {
        font-size: 72px;
        color: #10b981;
        margin-bottom: 24px;
        animation: bounce 0.6s ease-in-out;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .success-title {
        font-size: 32px;
        font-weight: 700;
        color: #14202A;
        margin-bottom: 12px;
    }

    .success-message {
        font-size: 16px;
        color: #6b7280;
        margin-bottom: 40px;
    }

    .animal-details {
        background: #FFFFFF;
        border-radius: 12px;
        padding: 28px;
        margin-bottom: 32px;
        text-align: left;
        border-left: 4px solid #facc15;
        box-shadow: 0 2px 8px rgba(20, 32, 42, 0.05);
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #14202A;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .detail-label i {
        color: #facc15;
    }

    .detail-value {
        color: #6b7280;
        font-weight: 500;
    }

    .animal-photo {
        width: 100%;
        max-width: 320px;
        border-radius: 12px;
        margin: 24px auto;
        box-shadow: 0 4px 16px rgba(20, 32, 42, 0.1);
        border: 3px solid #facc15;
    }

    .footer-buttons {
        display: flex;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .btn-custom {
        padding: 14px 32px;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        border: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
    }

    .btn-primary-custom {
        background: #facc15;
        color: #14202A;
    }

    .btn-primary-custom:hover {
        background: #eab308;
        color: #14202A;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .btn-secondary-custom {
        background: #14202A;
        color: #facc15;
    }

    .btn-secondary-custom:hover {
        background: #1f2937;
        color: #facc15;
        text-decoration: none;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .success-card {
            padding: 32px 20px;
        }

        .success-title {
            font-size: 24px;
        }

        .footer-buttons {
            flex-direction: column;
        }

        .btn-custom {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<div class="container-box">
    <div class="success-card">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1 class="success-title">¡Animal Registrado Exitosamente!</h1>
        <p class="success-message">Tu nuevo animal ha sido agregado a tu rebaño.</p>

        <div class="animal-details">
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-paw"></i> Nombre:</span>
                <span class="detail-value">{{ $animal->nombre }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-tag"></i> Especie:</span>
                <span class="detail-value">{{ $animal->especie }}</span>
            </div>
            @if($animal->raza)
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-list"></i> Raza:</span>
                <span class="detail-value">{{ $animal->raza }}</span>
            </div>
            @endif
            @if($animal->edad)
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-cake-candles"></i> Edad:</span>
                <span class="detail-value">{{ $animal->edad }}</span>
            </div>
            @endif
            @if($animal->peso)
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-weight-scale"></i> Peso:</span>
                <span class="detail-value">{{ $animal->peso }} kg</span>
            </div>
            @endif
            @if($animal->identificacion_propia)
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-barcode"></i> Identificación:</span>
                <span class="detail-value">{{ $animal->identificacion_propia }}</span>
            </div>
            @endif
            @if($animal->estado_salud)
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-heart-pulse"></i> Estado de Salud:</span>
                <span class="detail-value">{{ $animal->estado_salud }}</span>
            </div>
            @endif
            <div class="detail-row">
                <span class="detail-label"><i class="fas fa-calendar"></i> Fecha de Registro:</span>
                <span class="detail-value">{{ \Carbon\Carbon::parse($animal->fecha_registro)->format('d/m/Y') }}</span>
            </div>
        </div>

        @if($animal->foto_url)
        <img src="{{ asset($animal->foto_url) }}" alt="{{ $animal->nombre }}" class="animal-photo">
        @endif

        <div class="footer-buttons">
            <a href="{{ route('animal.create') }}" class="btn-custom btn-primary-custom">
                <i class="fas fa-plus"></i> Crear Otro Animal
            </a>
            <a href="{{ route('productor.animales') }}" class="btn-custom btn-secondary-custom">
                <i class="fas fa-list"></i> Ver Mis Animales
            </a>
        </div>
    </div>
</div>
@endsection