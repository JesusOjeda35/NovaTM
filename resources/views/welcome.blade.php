<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="m-0 p-0 bg-gray-100">
    @include('layouts.partials.topbar')

    <main class="min-h-screen">
        <div class="container py-10 text-center">
            <h1 class="text-4xl font-bold">NovaTM</h1>
        </div>
    </main>

    @include('layouts.partials.footer')
</body>
</html>