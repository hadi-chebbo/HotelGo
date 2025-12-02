<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Admin - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex h-screen bg-gray-100 font-sans">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow flex flex-col">
        <div class="p-6 text-2xl font-bold border-b">
            Admin Panel
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('systemAdmin.dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                Dashboard
            </a>
            {{-- <a href="{{ route('systemAdmin.hotels.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('systemAdmin.hotels.*') ? 'bg-gray-200 font-semibold' : '' }}">
                Hotels
            </a> --}}
            {{-- <a href="{{ route('systemAdmin.users.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('systemAdmin.users.*') ? 'bg-gray-200 font-semibold' : '' }}">
                Users
            </a> --}}
            {{-- <a href="{{ route('systemAdmin.settings.index') }}" class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('systemAdmin.settings.*') ? 'bg-gray-200 font-semibold' : '' }}">
                Settings
            </a> --}}
        </nav>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        
        <!-- Top Navbar -->
        <header class="flex items-center justify-between bg-white shadow px-6 py-4">
            <div class="text-lg font-semibold">@yield('title')</div>
            <div class="flex items-center space-x-4">
                <span>{{ auth()->user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>

</body>
</html>
