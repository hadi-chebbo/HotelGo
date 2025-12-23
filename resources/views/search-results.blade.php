@extends('layouts.front')

@section('title', 'Search Results')

@section('content')
<section style="padding: 40px 20px; max-width: 1200px; margin: auto;">

    {{-- Page Title --}}
    <h1 class="text-blue-900 text-center mb-6 text-3xl font-bold">
        Search Results
    </h1>

    <div style="width:95%; max-width:1200px; margin:0 auto; margin-bottom:30px;">
        <!-- Search Bar -->
        <form method="GET" action="{{ route('search') }}" style="
            background:#f8fafc;
            padding:20px;
            border-radius:14px;
            display:flex;
            flex-wrap:wrap;
            gap:15px;
            align-items:end;
          ">
            <!-- Search text -->
            <div style="flex:1; min-width:200px;">
                <label style="font-size:14px; font-weight:600;">Search</label>
                <input type="text" name="q" placeholder="Hotel, city, location" value="{{ request('q') }}"
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
            </div>

            <!-- Price from -->
            <div style="width:140px;">
                <label style="font-size:14px; font-weight:600;">Price from</label>
                <input type="number" name="price_from" value="{{ request('price_from') }}" min="0"
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
            </div>

            <!-- Price to -->
            <div style="width:140px;">
                <label style="font-size:14px; font-weight:600;">Price to</label>
                <input type="number" name="price_to" value="{{ request('price_to') }}" min="0"
                    style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
            </div>

            <!-- Room type -->
            <div style="width:180px;">
                <label style="font-size:14px; font-weight:600;">Room type</label>
                <select name="room_type" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
                    <option value="">All types</option>
                    @foreach($roomTypes->unique('type') as $roomType)
                    <option value="{{ $roomType->type }}" {{ request('room_type')==$roomType->type ? 'selected' : '' }}>
                        {{ ucfirst($roomType->type) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Button -->
            <div>
                <x-primary-button type="submit" style="
                        padding:15px 20px;
                        background:#FF8C00;
                        color:white;
                        border:none;
                        border-radius:10px;
                        font-weight:600;
                        cursor:pointer;
                    ">
                    Search
                </x-primary-button>
            </div>
        </form>
    </div>

    {{-- Exact Search Results Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">

        @forelse($searchResults as $roomType)
        <div style="flex: 0 0 auto; width: 320px;">
            <x-room-card :roomType="$roomType" :compact="true" />
        </div>
        @empty
        <p class="col-span-full text-center text-gray-500">
            No room types found exact matching your search.
        </p>
        @endforelse

    </div>

    {{-- Suggested RoomTypes Section --}}
    @if(isset($suggestedRooms) && $suggestedRooms->count() > 0)
    <h2 class="text-2xl font-bold text-blue-600 mb-6">
        You Might Also Like
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($suggestedRooms as $roomType)
        <x-room-card :roomType="$roomType" badge="Suggested" badgeColor="yellow" />
        @endforeach
    </div>
    @endif


</section>
@endsection