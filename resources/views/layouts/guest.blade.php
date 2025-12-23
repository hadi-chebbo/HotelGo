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
<body class="font-sans text-gray-100">

    <!-- Full-screen background photo with dark overlay -->
    <div class="relative min-h-screen flex items-center justify-center bg-gray-900">
        <img src="/images/home.png" alt="Hotel Background" class="absolute inset-0 w-full h-full object-cover brightness-50">
        
        <!-- Centered Glassmorphism Form -->
        <div class="relative z-10 w-full max-w-md px-2 py-2 bg-white/20 backdrop-blur-md rounded-3xl shadow-2xl border border-white/30">
            <!-- Logo / Title -->
            <h1 class="text-4xl font-bold text-gray-200 text-center mb-3">{{ $title ?? 'Hotel Go' }}</h1>
            
            <!-- Description -->
            <p class="text-center text-white/80 mb-3">{{ $description ?? 'Welcome! Please log in or register to continue.' }}</p>
            
            <!-- Registration Form Slot -->
            <div>
                {{ $slot }}
            </div>
        </div>
    </div>

</body>
</html>
      