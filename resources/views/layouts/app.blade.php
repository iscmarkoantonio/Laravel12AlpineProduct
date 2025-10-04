<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 12 + Tailwind + Alpine Js - Product Management</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine js --}}
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-200 text-gray-800">

    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold mb-6 border-b-2 border-gray-300 pb-3">Laravel 12 + Tailwind + Alpine Js - Product
            Management</h1>

        @yield('content')
    </div>


    {{-- Lucide Icons --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>

    @stack('scripts')
</body>

</html>
