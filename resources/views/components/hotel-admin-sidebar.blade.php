@section('sidebar')
<div>
    <div class="p-6 border-b">
        <div class="text-2xl font-bold text-gray-800 tracking-tight">
            <span class="text-blue-600">Your Home</span><span class="text-blue-900"> - Hotel</span><span
                class="text-blue-600">Go</span>
        </div>
    </div>

    <nav class="flex-1 p-4 space-y-2">
        <a href="{{ route('hotelAdmin.promocode.index') }}"
            class="group flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all
                {{ request()->routeIs('hotelAdmin.promocode.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 7h6m-6 4h6m-6 4h6M5.25 6.75A2.25 2.25 0 017.5 4.5h9a2.25 2.25 0 012.25 2.25v10.5A2.25 2.25 0 0116.5 19.5h-9a2.25 2.25 0 01-2.25-2.25v-1.125a1.875 1.875 0 010-3.75V11a1.875 1.875 0 010-3.75V6.75z" />
            </svg>
            <span class="font-medium">Promo Codes</span>
        </a>
        <a href="{{ route('hotelAdmin.room_types.index') }}"
            class="group flex items-center gap-3 px-4 py-2.5 rounded-xl transition-all
                {{ request()->routeIs('hotelAdmin.room_types.*') ? 'bg-blue-600 text-white shadow-md' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 4.5h10.5a1.5 1.5 0 011.5 1.5v12a1.5 1.5 0 01-1.5 1.5H4M4 4.5v15M19 12h.01" />
            </svg>
            <span class="font-medium">Room Types</span>
        </a>
    </nav>
</div>
@endsection