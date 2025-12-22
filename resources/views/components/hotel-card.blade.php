@extends('layouts.front')

@section('title', "$hotel->name")

@section('content')
<div class="bg-gradient-to-br from-slate-50 via-blue-50 to-purple-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Hero Section with Hotel Image -->
        <div class="relative mb-12 rounded-3xl overflow-hidden shadow-2xl">
            @if($hotel->image)
            <div class="relative h-[500px] w-full">
                <img src="{{ asset('storage/' . $hotel->image) }}" 
                     alt="{{ $hotel->name }}"
                     class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
            </div>
            @else
            <div class="relative h-[500px] bg-gradient-to-br from-blue-600 via-purple-600 to-pink-500 flex items-center justify-center">
                <svg class="w-32 h-32 text-white opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
            </div>
            @endif
            
            <!-- Hotel Info Overlay -->
            <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                <div class="max-w-4xl">
                    <h1 class="text-5xl font-bold mb-4 drop-shadow-lg">
                        {{ $hotel->name }}
                    </h1>
                    <div class="flex items-center gap-6 flex-wrap mb-4">
                        <div class="flex items-center gap-2 text-lg">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">{{ $hotel->location }}</span>
                        </div>
                        <div class="flex items-center gap-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full">
                            <svg class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="font-bold text-lg">{{ number_format($hotel->reviews()->avg('rating') ?? 0, 1) }}</span>
                        </div>
                    </div>
                    @if(isset($hotel->description))
                    <p class="text-lg text-white/90 leading-relaxed max-w-3xl">
                        {{ $hotel->description }}
                    </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contact Card -->
        @if(isset($hotel->user->phone) || isset($hotel->email))
        <div class="glass-effect rounded-2xl p-6 shadow-lg mb-12 border border-white/20">
            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Contact Information
            </h3>
            <div class="grid md:grid-cols-2 gap-4">
                @if(isset($hotel->user->phone))
                <a href="tel:{{ $hotel->user->phone }}" class="flex items-center gap-3 p-4 bg-white rounded-xl hover:shadow-md transition-all group">
                    <div class="bg-blue-100 p-3 rounded-full group-hover:bg-blue-200 transition-colors">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Phone</p>
                        <p class="text-gray-800 font-semibold">{{ $hotel->user->phone }}</p>
                    </div>
                </a>
                @endif
                @if(isset($hotel->email))
                <a href="mailto:{{ $hotel->email }}" class="flex items-center gap-3 p-4 bg-white rounded-xl hover:shadow-md transition-all group">
                    <div class="bg-purple-100 p-3 rounded-full group-hover:bg-purple-200 transition-colors">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Email</p>
                        <p class="text-gray-800 font-semibold">{{ $hotel->email }}</p>
                    </div>
                </a>
                @endif
            </div>
        </div>
        @endif

        <!-- Available Rooms Section -->
        <section class="mb-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-4xl font-bold text-gray-800">
                    Available Rooms
                </h2>
                @if($roomTypes->count() > 0)
                <span class="text-sm font-medium text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm">
                    {{ $roomTypes->count() }} room types
                </span>
                @endif
            </div>

            @if($roomTypes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($roomTypes as $roomType)
                <div class="group bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                    
                    <!-- Room Image -->
                    <div class="relative overflow-hidden h-56">
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
                        
                        <!-- Available Badge -->
                        <div class="absolute top-4 right-4 bg-emerald-500 text-white px-3 py-1.5 rounded-full text-sm font-semibold shadow-lg flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            {{ $roomType->available_rooms_count }} Available
                        </div>
                    </div>

                    <!-- Room Details -->
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">
                            {{ ucfirst($roomType->type) }}
                        </h3>
                        
                        @if(isset($roomType->description))
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
                            @if(isset($roomType->amenities))
                            <div class="flex items-start gap-2 text-sm text-gray-700">
                                <svg class="w-5 h-5 text-purple-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                </svg>
                                <span class="line-clamp-2">{{ $roomType->amenities }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Price and Button -->
                        <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                            <div>
                                <p class="text-3xl font-bold text-emerald-600">
                                    ${{ number_format($roomType->price_per_night, 0) }}
                                </p>
                                <p class="text-xs text-gray-500">per night</p>
                            </div>
                            <a href="/rooms/{{ $roomType->id }}" 
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold transition-all hover:shadow-lg hover:scale-105">
                                View
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="bg-gradient-to-r from-red-50 to-orange-50 border-2 border-dashed border-red-300 rounded-2xl p-12 text-center">
                <svg class="w-16 h-16 text-red-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <p class="text-xl text-red-900 font-semibold">
                    No rooms currently available
                </p>
                <p class="text-gray-600 mt-2">Please check back later for availability</p>
            </div>
            @endif
        </section>

        <!-- Reviews Section -->
        <section class="mb-12">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-4xl font-bold text-gray-800">
                    Guest Reviews
                </h2>
                <span class="text-sm font-medium text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm">
                    {{ $reviews->count() }} reviews
                </span>
            </div>

            <!-- Write Review Section -->
            @auth
            <div class="mb-8 relative group">
                @if($canReview)
                <!-- Review Form - Enabled -->
                <div class="bg-white p-6 rounded-2xl shadow-md border-2 border-blue-200">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Write Your Review
                    </h3>
                    
                    <form action="{{ route('review.store', $hotel->id) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <!-- Star Rating Input -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Your Rating</label>
                            <div class="flex gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                <label class="cursor-pointer">
                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                    <svg class="w-10 h-10 text-gray-300 peer-checked:text-yellow-500 hover:text-yellow-400 transition-colors" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </label>
                                @endfor
                            </div>
                            @error('rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Comment Textarea -->
                        <div>
                            <label for="comment" class="block text-sm font-semibold text-gray-700 mb-2">Your Review</label>
                            <textarea 
                                id="comment" 
                                name="comment" 
                                rows="4" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                                placeholder="Share your experience at {{ $hotel->name }}..."></textarea>
                            @error('comment')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Submit Review
                        </button>
                    </form>
                </div>
                @else
                <!-- Review Form - Disabled with Blur -->
                <div class="relative">
                    <div class="bg-white p-6 rounded-2xl shadow-md border-2 border-gray-200 blur-sm pointer-events-none select-none">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Write Your Review
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Your Rating</label>
                                <div class="flex gap-2">
                                    @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-10 h-10 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    @endfor
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Your Review</label>
                                <textarea 
                                    rows="4" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl resize-none"
                                    placeholder="Share your experience..."></textarea>
                            </div>

                            <button type="button" class="inline-flex items-center gap-2 px-6 py-3 bg-gray-400 text-white rounded-xl font-semibold">
                                Submit Review
                            </button>
                        </div>
                    </div>
                    
                    <!-- Overlay Message -->
                    <div class="absolute inset-0 flex items-center justify-center bg-white/80 backdrop-blur-sm rounded-2xl">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white p-6 rounded-xl shadow-2xl max-w-md text-center">
                            <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <h4 class="text-xl font-bold mb-2">Reservation Required</h4>
                            <p class="text-sm text-white/90">
                                You must have a completed stay at this hotel within the last 30 days to write a review.
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @else
            <!-- Not Logged In Message -->
            <div class="bg-gradient-to-r from-gray-50 to-blue-50 border-2 border-blue-200 rounded-2xl p-8 mb-8 text-center">
                <svg class="w-12 h-12 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Want to Share Your Experience?</h3>
                <p class="text-gray-600 mb-4">Please log in to write a review</p>
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    Log In
                </a>
            </div>
            @endauth

            @if($reviews->count() > 0)
            <div id="reviews-container" class="space-y-4">
                @foreach($reviews as $index => $review)
                <div class="review-item bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition-shadow {{ $index >= 2 ? 'hidden' : '' }}" data-index="{{ $index }}">
                    <div class="flex justify-between items-start gap-4 mb-4">
                        <div class="flex items-center gap-4">
                            <!-- Avatar -->
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                                {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-800">
                                    {{ $review->user->name ?? 'Anonymous Guest' }}
                                </h4>
                                <p class="text-sm text-gray-500 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ $review->created_at->format('M j, Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Star Rating -->
                        <div class="bg-gradient-to-r from-yellow-100 to-orange-100 px-4 py-2 rounded-xl flex items-center gap-1 shadow-sm">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endif
                            @endfor
                            <span class="ml-1 font-bold text-gray-700">{{ $review->rating }}</span>
                        </div>
                    </div>

                    <!-- Review Comment -->
                    @if(isset($review->comment))
                    <p class="text-gray-700 leading-relaxed pl-16">
                        "{{ $review->comment }}"
                    </p>
                    @endif
                </div>
                @endforeach
            </div>

            @if($reviews->count() > 2)
            <div class="text-center mt-8">
                <button id="load-more-btn" 
                        class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-105">
                    <span>Load More Reviews</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <button id="show-less-btn" 
                        class="hidden inline-flex items-center gap-2 px-8 py-3 bg-gray-200 text-gray-700 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-105">
                    <span>Show Less</span>
                    <svg class="w-5 h-5 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            </div>
            @endif
            @else
            <div class="bg-gradient-to-r from-gray-50 to-blue-50 rounded-2xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <p class="text-xl text-gray-600 font-semibold">
                    No reviews yet
                </p>
                <p class="text-gray-500 mt-2">Be the first to share your experience!</p>
            </div>
            @endif
        </section>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadMoreBtn = document.getElementById('load-more-btn');
            const showLessBtn = document.getElementById('show-less-btn');
            const reviews = document.querySelectorAll('.review-item');
            let currentlyShowing = 2;

            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    const toShow = Math.min(currentlyShowing + 3, reviews.length);
                    
                    for (let i = currentlyShowing; i < toShow; i++) {
                        reviews[i].classList.remove('hidden');
                        reviews[i].classList.add('fade-in');
                    }
                    
                    currentlyShowing = toShow;
                    
                    if (currentlyShowing >= reviews.length) {
                        loadMoreBtn.classList.add('hidden');
                    }
                    
                    showLessBtn.classList.remove('hidden');
                    showLessBtn.classList.add('inline-flex');
                });
            }

            if (showLessBtn) {
                showLessBtn.addEventListener('click', function() {
                    for (let i = 2; i < reviews.length; i++) {
                        reviews[i].classList.add('hidden');
                    }
                    
                    currentlyShowing = 2;
                    loadMoreBtn.classList.remove('hidden');
                    showLessBtn.classList.remove('inline-flex');
                    showLessBtn.classList.add('hidden');
                    
                    // Scroll to reviews section
                    document.querySelector('#reviews-container').scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                });
            }
        });
    </script>
</div>
@endsection