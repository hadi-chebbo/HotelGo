@extends('layouts.front')

@section('title', 'Reservations')

@section('content')
<div class="max-w-6xl mx-auto py-12 px-4">
    <h2 class="text-2xl font-bold text-blue-900 mb-12 text-center">Reservations and loyalty points</h2>

    <div class="mb-12">
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-blue-900 via-blue-800 to-blue-700 text-white shadow-xl p-8 flex items-center justify-between">

        {{-- Decorative Circles --}}
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-white/5 rounded-full"></div>

        {{-- Loyalty Points on the Left --}}
        <div class="relative z-10 flex-shrink-0 mr-8 text-center">
            <p class="text-blue-200 uppercase tracking-wide text-sm font-semibold mb-1">Your Points</p>
            <p class="text-5xl font-extrabold text-white">
                {{ Auth::user()->loyalty_points ?? 0 }}
            </p>
        </div>

        {{-- Motivational Message on the Right --}}
        <div class="relative z-10 max-w-2xl">
            <p class="uppercase tracking-widest text-sm text-blue-200 font-semibold mb-2">
                HotelGo Loyalty Program
            </p>

            <h2 class="text-2xl md:text-3xl font-bold mb-3">
                Every Stay Brings You Closer ✨
            </h2>

            <p class="text-blue-100 text-lg leading-relaxed">
                Thank you for choosing <span class="font-semibold text-white">HotelGo</span>.
                Each reservation earns you loyalty points that unlock exclusive discounts,
                special rewards, and unforgettable stays.
                <br class="hidden md:block">
                <span class="font-semibold text-white">
                    Keep booking, keep earning, and let your journey be rewarded.
                </span>
            </p>
        </div>
    </div>
</div>

    {{-- Success & Error Messages --}}
    @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-800 px-5 py-3 rounded shadow">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-800 px-5 py-3 rounded shadow">
            {{ session('error') }}
        </div>
    @endif

    {{-- Confirmed Reservations --}}
    @php
        $confirmed = $reservations->where('status', 'confirmed');
    @endphp
    @if($confirmed->isNotEmpty())
        <h2 class="text-2xl font-semibold text-blue-800 mb-6">Confirmed Reservations</h2>
        <div class="space-y-6">
            @foreach($confirmed as $reservation)
                <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col md:flex-row justify-between items-start md:items-center hover:shadow-2xl transition-shadow duration-300">
                    <div class="flex-1 mb-4 md:mb-0">
                        <h3 class="text-xl font-bold text-blue-900 mb-2">{{ $reservation->hotel->name ?? 'Hotel Name' }}</h3>
                        <p class="text-gray-700 mb-1"><span class="font-semibold">Room Number:</span> {{ $reservation->room->room_number ?? '-' }}</p>
                        <p class="text-gray-700 mb-1">
                            <span class="font-semibold">Room:</span> {{ $reservation->room->roomType->type ?? '-' }}
                            <span class="mx-2">|</span>
                            <span class="font-semibold">Guests:</span> {{ $reservation->room->roomType->capacity ?? '-' }}
                        </p>
                        <p class="text-gray-700 mb-1">
                            <span class="font-semibold">Check-in:</span> {{ $reservation->check_in_date ?? '-' }}
                            <span class="mx-2">|</span>
                            <span class="font-semibold">Check-out:</span> {{ $reservation->check_out_date ?? '-' }}
                        </p>
                        <p class="mt-2">
                            <span class="font-semibold text-blue-600">Status:</span>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </p>
                    </div>

                    <div class="flex-shrink-0">
                        <x-primary-button 
                            class="bg-green-600 hover:bg-green-700"
                            onclick="openModal('cancel-{{ $reservation->id }}')"
                        >
                            Cancel
                        </x-primary-button>

                        <x-confirm-delete-modal
                            id="cancel-{{ $reservation->id }}"
                            title="Cancel Reservation"
                            message="Your reservation will be cancelled. No deposit refund."
                            :route="route('reservations.cancel', $reservation)"
                            method="PATCH"
                            confirm="Cancel"
                        />
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Completed & Cancelled Reservations --}}
    @php
        $otherReservations = $reservations->whereIn('status', ['completed', 'cancelled']);
    @endphp
    @if($otherReservations->isNotEmpty())
        <h2 class="text-2xl font-semibold text-blue-800 mt-12 mb-6">Past Reservations</h2>
        <div class="space-y-6">
            @foreach($otherReservations as $reservation)
                <div class="bg-gray-50 rounded-2xl shadow p-6 flex flex-col md:flex-row justify-between items-start md:items-center hover:shadow-lg transition-shadow duration-300">
                    <div class="flex-1 mb-4 md:mb-0">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $reservation->hotel->name ?? 'Hotel Name' }}</h3>
                        <p class="text-gray-700 mb-1"><span class="font-semibold">Room Number:</span> {{ $reservation->room->room_number ?? '-' }}</p>
                        <p class="text-gray-700 mb-1">
                            <span class="font-semibold">Room:</span> {{ $reservation->room->roomType->type ?? '-' }}
                            <span class="mx-2">|</span>
                            <span class="font-semibold">Guests:</span> {{ $reservation->room->roomType->capacity ?? '-' }}
                        </p>
                        <p class="text-gray-700 mb-1">
                            <span class="font-semibold">Check-in:</span> {{ $reservation->check_in_date ?? '-' }}
                            <span class="mx-2">|</span>
                            <span class="font-semibold">Check-out:</span> {{ $reservation->check_out_date ?? '-' }}
                        </p>
                        <p class="mt-2">
                            <span class="font-semibold text-blue-600">Status:</span>
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                @if($reservation->status === 'cancelled') bg-red-100 text-red-700 
                                @else bg-gray-200 text-gray-800 @endif">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if($reservations->isEmpty())
        <div class="text-center py-20 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10m-7 4h4m-4 4h4m-7 4h10M4 7h16M4 19h16"/>
            </svg>
            <p class="text-lg">You have no reservations yet.</p>
        </div>
    @endif
</div>
@endsection
