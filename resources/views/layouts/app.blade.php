<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased">

        <!-- Background Image -->
        <div class="fixed inset-0 -z-10">
            <img src="/images/hotel1.jpg"
                 class="w-full h-full object-cover brightness-50"
                 alt="Hotel Background">
        </div>

        <div class="min-h-screen bg-gray-100 bg-opacity-30 dark:bg-gray-900 dark:bg-opacity-30">
           

            <!-- Page Heading -->
            @isset($header)
                <header class="shadow bg-white/20 dark:bg-gray-800/20 backdrop-blur">
                    <div class="max-w-7xl mx-auto py-6 px-4 bg-gray-300 sm:px-6 lg:px-8 flex items-center justify-between">

                        <!-- LEFT: Page Title -->
                        <div>
                            {{ $header }}
                        </div>

                        <!-- RIGHT: Logout Button -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg font-semibold"
                            >
                                Logout
                            </button>
                        </form>

                    </div>
                </header>

            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
