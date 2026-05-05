<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Ganado - NovaTM')</title>
    
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #facc15;
            --dark: #14202A;
            --light: #FFFFFF;
            --gray: #f9fafb;
        }
        
        body {
            background-color: var(--gray);
            font-family: 'Segoe UI', 'Roboto', sans-serif;
        }
        
        main {
            flex: 1;
            padding: 40px 0;
        }
    </style>
    
    @yield('styles')
</head>
<body style="display: flex; flex-direction: column; min-height: 100vh;">

    @include('layouts.partials.topbar')
    
    <main>
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')

</body>
</html>