<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title >System Admin - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-screen flex bg-gray-100 font-sans antialiased">

    <!-- Sidebar -->
<aside class="w-64 bg-white/90 backdrop-blur-xl border-r flex flex-col shadow-sm">
    @hasSection('sidebar')
        {{-- If the child page defines a sidebar, use it --}}
        @yield('sidebar')
    @else
        {{-- Default System Admin Sidebar --}}
        <div class="p-6 border-b">
            <div class="text-2xl font-bold text-gray-800 tracking-tight">
               <span class="text-blue-600">Admin</span><span class="text-blue-900">Panel</span> 
            </div>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3.75 3h7.5v7.5h-7.5V3zm0 10.5h7.5V21h-7.5v-7.5zm10.5-10.5h7.5v4.5h-7.5V3zm0 6h7.5V21h-7.5V9z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <!-- Hotels -->
            <a href="{{ route('admin.hotel.index') }}" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('systemAdmin.hotels.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 21v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21m0 0h4.5V3.545M12.75 21h7.5V10.75M2.25 21h1.5m18 0h-18M2.25 9l4.5-1.636M18.75 3l-1.5.545m0 6.205 3 1m1.5.5-1.5-.5M6.75 7.364V3h-3v18m3-13.636 10.5-3.819" />
                </svg>
                <span class="font-medium">Hotels</span>
            </a>

            <!-- Users -->
            <a href="{{ route('admin.users.index') }}" class="group flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all {{ request()->routeIs('systemAdmin.users.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0zM4.5 21a7.5 7.5 0 0115 0v-1.5a6 6 0 00-12 0V21z" />
                </svg>
                <span class="font-medium">Users</span>
            </a>
        </nav>
    @endif
</aside>


    <!-- Main Content -->
    <div class="flex-1 flex flex-col">

        <!-- Top Navbar -->
        <header class="flex items-center justify-between bg-white/80 backdrop-blur-lg border-b px-6 py-4 shadow-sm">
            <h1 class="text-xl font-semibold text-gray-800">@yield('title')</h1>

            <div class="flex items-center gap-4">

                <!-- User Profile Circle -->
                <a href="{{ route('profile.edit') }}">
                    <div class="flex items-center gap-2">
                        <div class="w-9 h-9 rounded-full bg-blue-500 text-white flex items-center justify-center font-semibold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span class="font-medium text-gray-800">{{ auth()->user()->name }}</span>
                    </div>
                </a>

                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm shadow-sm transition">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-8 bg-gray-100">
            @yield('content')
        </main>

    </div>

</body>
</html>
