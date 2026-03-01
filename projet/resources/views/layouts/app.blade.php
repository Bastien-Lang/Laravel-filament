<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'MyEvents')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 text-gray-800">

<header class="bg-white border-b">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <a href="{{ route('events.index') }}" class="text-xl font-bold text-indigo-600">
            MyEvents
        </a>

        <span class="text-sm text-gray-500">
            Plateforme de gestion d’événements
        </span>
    </div>
</header>

<main class="max-w-7xl mx-auto px-6 py-12">
    @yield('content')
</main>

<footer class="border-t bg-white">
    <div class="max-w-7xl mx-auto px-6 py-6 text-sm text-gray-500">
        © {{ date('Y') }} MyEvents — EventPro Solutions
    </div>
</footer>

</body>
</html>