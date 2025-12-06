<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Hotel Go</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
       <div class="min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-white-900">
            <!-- Creative Paragraph -->
            <div class="max-w-xl text-center px-4 sm:px-0 mt-6 mb-6" >
                <h2 class="text-2xl sm:text-3xl font-semibold text-blue-900">
                   {{ $title ?? 'Welcome' }}
                </h2>
                <p class="mt-2 text-blue-900">
                    {{ $description ?? 'Please log in or register to continue.' }}
                </p>
            </div>

            <!-- Registration Form Slot -->
            <div class="w-full sm:max-w-md px-6 py-6 bg-gray-300 shadow-md rounded-lg mb-6">
                {{ $slot }}
            </div>
        </div>

    </body>
</html>
