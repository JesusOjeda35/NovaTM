<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión - {{ config('app.name', 'NovaTM') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            padding: 60px 50px;
            max-width: 400px;
            width: 100%;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-avatar {
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

        .login-avatar img {
            width: 85px;
            height: 85px;
            object-fit: contain;
        }

        .login-title {
            font-size: 28px;
            font-weight: 800;
            color: #14202A;
            margin: 0 0 8px 0;
        }

        .login-subtitle {
            font-size: 14px;
            color: #999;
            margin: 0;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #666;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: none;
            border-bottom: 2px solid #e0e0e0;
            padding: 12px 0;
            font-size: 14px;
            background: transparent;
            transition: border-color 0.3s;
            border-radius: 0;
        }

        .form-control:focus {
            border-bottom-color: #facc15;
            box-shadow: none;
            background: transparent;
            color: #14202A;
        }

        .form-control::placeholder {
            color: #999;
        }

        .btn-login {
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

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(250, 204, 21, 0.3);
            color: #14202A;
            text-decoration: none;
        }

        .login-footer {
            text-align: center;
            margin-top: 30px;
        }

        .login-footer a {
            font-size: 13px;
            color: #999;
            text-decoration: none;
            transition: color 0.3s;
        }

        .login-footer a:hover {
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
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <div class="login-avatar">
                <img src="{{ asset('images/logoNovaTM.png') }}" alt="NovaTM">
            </div>
            <h1 class="login-title">Iniciar Sesión</h1>
            <p class="login-subtitle">Bienvenido a NovaTM</p>
        </div>

        <!-- Messages -->
        @if ($errors->any())
            <div class="error-message">
                <strong><i class="fas fa-exclamation-circle"></i> Error:</strong>
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
        <form method="POST" action="{{ route('login.post') }}">
            @csrf

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
                    autofocus
                >
            </div>

            <!-- Contraseña -->
            <div class="form-group">
                <label for="password">Contraseña *</label>
                <input 
                    type="password" 
                    class="form-control @error('password') error-field @enderror" 
                    id="password" 
                    name="password" 
                    placeholder="Tu contraseña"
                    required
                >
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> INICIAR SESIÓN
            </button>

            <!-- Footer Links -->
            <div class="login-footer">
                ¿No tienes una cuenta?
                <a href="{{ route('register') }}">
                    <i class="fas fa-user-plus"></i> Regístrate aquí
                </a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>