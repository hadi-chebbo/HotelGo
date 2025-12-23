@props([
    'roomType',
    'showAvailableCount' => false,
    'compact' => false,
    'badge' => null,
    'badgeColor' => 'yellow'
])

<div class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
    
    <!-- Room Image -->
    <div class="relative overflow-hidden {{ $compact ? 'h-40' : 'h-48' }}">
        @if($roomType->image)
        <img src="{{ asset('storage/' . $roomType->image) }}" 
             alt="{{ $roomType->type }}"
             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
        @else
        <div class="w-full h-full bg-gradient-to-br from-blue-400 via-purple-500 to-pink-500 flex items-center justify-center">
            <svg class="w-20 h-20 text-white opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
        </div>
        @endif
        
        <!-- Custom Badge (like "Suggested") -->
        @if($badge)
        <div class="absolute top-4 left-4 
            @if($badgeColor === 'yellow') bg-yellow-400
            @elseif($badgeColor === 'blue') bg-blue-500
            @elseif($badgeColor === 'green') bg-green-500
            @elseif($badgeColor === 'red') bg-red-500
            @else bg-yellow-400
            @endif
            text-white px-3 py-1.5 rounded-full text-sm font-semibold shadow-lg">
            {{ $badge }}
        </div>
        @endif
        
        <!-- Available Badge (optional) -->
        @if($showAvailableCount && isset($roomType->available_rooms_count))
        <div class="absolute top-4 right-4 bg-emerald-500 text-white px-3 py-1.5 rounded-full text-sm font-semibold shadow-lg flex items-center gap-1">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            {{ $roomType->available_rooms_count }} Available
        </div>
        @endif
    </div>

    <!-- Room Details -->
    <div class="{{ $compact ? 'p-4' : 'p-6' }}">
        <h3 class="{{ $compact ? 'text-xl' : 'text-2xl' }} font-bold text-gray-800 mb-2">
            {{ ucfirst($roomType->type) }}
        </h3>
        
        @if(isset($roomType->description) && !$compact)
        <p class="text-sm text-gray-600 mb-4 line-clamp-2">
            {{ $roomType->description }}
        </p>
        @endif

        <!-- Features -->
        <div class="space-y-2 mb-5">
            @if(isset($roomType->capacity))
            <div class="flex items-center gap-2 text-sm text-gray-700">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span><strong>Up to {{ $roomType->capacity }}</strong> guests</span>
            </div>
            @endif
            
            @if(isset($roomType->hotel))
            <div class="flex items-center gap-2 text-sm text-gray-700">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span>{{ $roomType->hotel->name }}</span>
            </div>
            @endif
        </div>

        <!-- Price and Button -->
        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
            <div>
                <p class="{{ $compact ? 'text-2xl' : 'text-3xl' }} font-bold text-emerald-600">
                    ${{ number_format($roomType->price_per_night, 0) }}
                </p>
                <p class="text-xs text-gray-500">per night</p>
            </div>
            
            @auth
                <!-- Authenticated Users: Show Book Now Button -->
                <x-reservation-modal :roomType="$roomType" />
            @else
                <!-- Guest Users: Show Login to Book Button -->
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-gray-600 to-gray-700 text-white rounded-xl font-semibold hover:shadow-lg hover:scale-105 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    Login to Book
                </a>
            @endauth
        </div>
    </div>
</div>