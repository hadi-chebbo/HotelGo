<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title >System Admin - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<div class="w-[95%] max-w-[1200px] mx-auto py-10">
    
    <!-- Hotel Header Section -->
    <div class="mb-10">
        <!-- Hotel Image -->
        @if($hotel->image)
        <div class="w-full h-[400px] rounded-[20px] shadow-[0_10px_30px_rgba(0,0,0,0.2)] mb-8 overflow-hidden">
            <img src="{{ asset('storage/' . $hotel->image) }}" 
                 alt="{{ $hotel->name }}"
                 class="w-full h-full object-cover">
        </div>
        @else
        <div class="w-full h-[400px] rounded-[20px] shadow-[0_10px_30px_rgba(0,0,0,0.2)] mb-8 bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
            <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
        </div>
        @endif

        <!-- Hotel Info -->
        <div class="flex justify-between items-start flex-wrap gap-5">
            <div class="flex-1 min-w-[300px]">
                <h1 class="text-[42px] mb-4 text-blue-900 font-bold">
                    {{ $hotel->name }}
                </h1>
                <p class="text-lg text-gray-600 mb-2.5">
                    📍 <b>{{ $hotel->location }}</b>
                </p>
                @if(isset($hotel->description))
                <p class="text-base text-gray-600 leading-relaxed mb-5">
                    {{ $hotel->description }}
                </p>
                @endif
                
                <!-- Rating Display -->
                <div class="inline-block bg-blue-900 text-white px-5 py-2.5 rounded-[25px] text-lg font-semibold">
                    ⭐ {{ number_format($hotel->rating ?? 0, 1) }} / 5.0
                </div>
            </div>

            <!-- Contact Info -->
            @if(isset($hotel->user->phone) || isset($hotel->email))
            <div class="bg-gray-50 p-6 rounded-2xl min-w-[280px] shadow-md">
                <h3 class="mb-4 text-blue-900 text-xl font-bold">Contact Information</h3>
                @if(isset($hotel->user->phone))
                <p class="mb-2.5 text-[15px]">
                    📞 <b>Phone:</b> {{ $hotel->user->phone }}
                </p>
                @endif
                @if(isset($hotel->email))
                <p class="mb-0 text-[15px]">
                    ✉️ <b>Email:</b> {{ $hotel->email }}
                </p>
                @endif
            </div>
            @endif
        </div>
    </div>

    <!-- Available Rooms Section -->
    <section class="mb-12">
        <h2 class="text-[32px] mb-6 text-blue-900 font-bold">
            Available Rooms
        </h2>

        @if($roomTypes->count() > 0)
        <div class="grid grid-cols-[repeat(auto-fill,minmax(320px,1fr))] gap-6">
            @foreach($roomTypes as $roomType)
            <div class="bg-white rounded-2xl overflow-hidden shadow-lg transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">
                
                <!-- Room Image -->
                <div class="relative">
                    @if($roomType->image)
                    <img src="{{ asset('storage/' . $roomType->image) }}" 
                         alt="{{ $roomType->type }}"
                         class="w-full h-[220px] object-cover">
                    @else
                    <div class="w-full h-[220px] bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center">
                        <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                    </div>
                    @endif
                    
                    <!-- Available Rooms Badge -->
                    <span class="absolute top-3 right-3 bg-green-500/95 text-white px-3.5 py-2 rounded-[20px] text-sm font-semibold">
                        {{ $roomType->available_rooms_count }} Available
                    </span>
                </div>

                <!-- Room Details -->
                <div class="p-5">
                    <h3 class="text-[22px] mb-2.5 text-blue-900 font-bold">
                        {{ ucfirst($roomType->type) }}
                    </h3>
                    
                    @if(isset($roomType->description))
                    <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                        {{ $roomType->description }}
                    </p>
                    @endif

                    <!-- Features -->
                    @if(isset($roomType->capacity) || isset($roomType->amenities))
                    <div class="mb-4">
                        @if(isset($roomType->capacity))
                        <p class="text-sm text-gray-700 mb-1">
                            👥 <b>Capacity:</b> {{ $roomType->capacity }} guests
                        </p>
                        @endif
                        @if(isset($roomType->amenities))
                        <p class="text-sm text-gray-700">
                            ✨ <b>Amenities:</b> {{ $roomType->amenities }}
                        </p>
                        @endif
                    </div>
                    @endif

                    <!-- Price and Button -->
                    <div class="flex justify-between items-center border-t border-gray-200 pt-4">
                        <div>
                            <p class="text-[26px] text-green-500 font-bold m-0">
                                ${{ number_format($roomType->price_per_night, 0) }}
                            </p>
                            <p class="text-[13px] text-gray-500 m-0">per night</p>
                        </div>
                        <a href="/rooms/{{ $roomType->id }}" 
                           class="inline-block px-6 py-3 bg-blue-900 text-white no-underline rounded-xl font-semibold transition-colors hover:bg-blue-800">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-red-50 border-2 border-dashed border-red-500 rounded-2xl p-10 text-center">
            <p class="text-lg text-red-900 m-0">
                🏨 No rooms are currently available at this hotel. Please check back later!
            </p>
        </div>
        @endif
    </section>

    <!-- Reviews Section -->
    <section class="mb-10">
        <h2 class="text-[32px] mb-6 text-blue-900 font-bold">
            Guest Reviews <span class="text-2xl text-gray-600">({{ $reviews->count() }})</span>
        </h2>

        @if($reviews->count() > 0)
        <div class="flex flex-col gap-5">
            @foreach($reviews as $review)
            <div class="bg-white p-6 rounded-2xl shadow-md">
                <!-- Review Header -->
                <div class="flex justify-between items-center mb-4 flex-wrap gap-2.5">
                    <div>
                        <h4 class="text-lg text-blue-900 mb-1 font-bold">
                            {{ $review->user->name ?? 'Anonymous Guest' }}
                        </h4>
                        <p class="text-[13px] text-gray-500 m-0">
                            {{ $review->created_at->format('F j, Y') }}
                        </p>
                    </div>
                    
                    <!-- Star Rating -->
                    <div class="bg-yellow-100 px-4 py-2 rounded-[20px] text-base font-semibold text-yellow-800">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $review->rating)
                                ⭐
                            @else
                                ☆
                            @endif
                        @endfor
                        <span class="ml-1">{{ $review->rating }}/5</span>
                    </div>
                </div>

                <!-- Review Comment -->
                @if(isset($review->comment))
                <p class="text-[15px] text-gray-700 leading-relaxed m-0">
                    "{{ $review->comment }}"
                </p>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="bg-gray-50 rounded-2xl p-10 text-center">
            <p class="text-lg text-gray-600 m-0">
                💬 No reviews yet. Be the first to review this hotel!
            </p>
        </div>
        @endif
    </section>

    <!-- Back Button -->
    {{-- <div class="text-center mt-10">
        <a href="{{ route('home') }}" 
           class="inline-block px-8 py-3.5 bg-gray-100 text-blue-900 no-underline rounded-xl font-semibold transition-colors hover:bg-gray-200">
            ← Back to Home
        </a>
    </div> --}}

</div>
