@extends('layouts.front')

@section('title', 'Home')

@section('content')
<!-- Hero Image Section -->
<section style="
    width: 90%;        /* not full width */
    max-width: 1200px;  /* optional max width */
    height: 400px;
    margin: 40px auto; /* center horizontally with some margin */
    background: url('/images/home.png') no-repeat center center;
    background-size: cover;
    border-radius: 20px;     /* rounded corners */
    box-shadow: 0 10px 30px rgba(0,0,0,0.3); /* soft shadow */
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    overflow: hidden; /* make sure content respects rounded corners */
">
    <div style="
        background-color: rgba(238, 231, 231, 0.47);
        padding: 40px 40px;
        border-radius: 15px;
        text-align: center;
        backdrop-filter: blur(5px); /* optional: nice frosted effect */
    ">
        <h1 style="font-size: 48px; margin-bottom: 10px;"><i>Welcome to HotelGo</i></h1>
        <p style="font-size: 18px;">Don’t wait, your perfect stay is waiting for you!</p>
    </div> 
</section>

<div style="width:95%; max-width:1200px; margin:0 auto; margin-bottom:30px;">
    <!-- Search Bar -->
    <form method="GET" action="{{ route('search') }}"
          style="
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
            <input type="text" name="q"
                   placeholder="Hotel, city, location"
                   value="{{ request('q') }}"
                   style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
        </div>

        <!-- Price from -->
        <div style="width:140px;">
            <label style="font-size:14px; font-weight:600;">Price from</label>
            <input type="number" name="price_from"
                   value="{{ request('price_from') }}"
                   min="0"
                   style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
        </div>

        <!-- Price to -->
        <div style="width:140px;">
            <label style="font-size:14px; font-weight:600;">Price to</label>
            <input type="number" name="price_to"
                   value="{{ request('price_to') }}"
                   min="0"
                   style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
        </div>

        <!-- Room type -->
        <div style="width:180px;">
            <label style="font-size:14px; font-weight:600;">Room type</label>
            <select name="room_type" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;">
                <option value="">All types</option>
                @foreach($roomTypes->unique('type') as $roomType)
                    <option value="{{ $roomType->type }}" 
                        {{ request('room_type') == $roomType->type ? 'selected' : '' }}>
                        {{ ucfirst($roomType->type) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Button -->
        <div>
            <x-primary-button type="submit"
                    style="
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

<!-- Top-Rated Hotels Section -->
<section style="width:95%; max-width:1200px; margin:0 auto; padding-bottom:30px;">
    <h2 style="margin-bottom:20px; font-size:28px;" class="text-blue-900">
        <b>Top-Rated Hotels</b>
    </h2>

    <div style="display:flex; overflow-x:auto; gap:30px; padding-bottom:15px;">
       @foreach($hotels as $hotel)
    <a href="" style="text-decoration:none; color:inherit;">
        <div style="
            flex: 0 0 auto;
            width:350px;
            border-radius:14px;
            overflow:hidden;
            background-color:white;
            box-shadow:0 8px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        "
        onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 28px rgba(0,0,0,0.12)'"
        onmouseout="this.style.transform='none'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.08)'"
        >
            <div style="position:relative;">
                <img src="{{ $hotel->image_url ?? 'https://via.placeholder.com/350x200' }}"
                     alt="{{ $hotel->name }}"
                     style="width:100%; height:200px; object-fit:cover;">
                <span style="
                    position:absolute;
                    top:12px;
                    right:12px;
                    background:rgba(0,0,0,0.75);
                    color:white;
                    padding:6px 10px;
                    border-radius:20px;
                    font-size:14px;
                    font-weight:600;
                ">
                    ⭐ {{ number_format($hotel->average_rating, 1) }}
                </span>
            </div>

            <div style="padding:18px;">
                <h3 style="margin-bottom:6px; font-size:20px; color:#1e3a8a;">
                    <b>{{ $hotel->name }}</b>
                </h3>
                <p style="margin:0 0 14px 0; font-size:15px; color:#2563eb;">
                   <b> 📍 {{ $hotel->location }}</b>
                </p>
                <p style="margin:0 0 14px 0; font-size:15px; color:#555;">
                     {{ $hotel->description }}
                </p>
            </div>
        </div>
    </a>
@endforeach

    </div>
</section>

<section style="padding:50px 20px; text-align:center; background-color:#fafafa;">
    <h1 class="text-blue-900" style="font-size:36px; margin-bottom:40px;">How it works</h1>    
    <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:50px; max-width:1000px; margin:auto; align-items:flex-start;">
        
        <!-- Step 1 -->
        <div style="flex:1 1 220px; display:flex; flex-direction:column; align-items:center;">
            <img src="/images/search.png" alt="Search" style="width:120px; height:120px; object-fit:contain;">
            <h3 style="font-size:20px; margin:8px 0 6px;" class="text-blue-900"><b>Search Simply</b></h3>
            <p style="font-size:16px; color:#555; margin:0;">Easily find hotels or rooms based on your location and preferences.</p>
        </div>

        <!-- Step 2 -->
        <div style="flex:1 1 220px; display:flex; flex-direction:column; align-items:center;">
            <img src="/images/compare.png" alt="Discover Rooms" style="width:120px; height:120px; object-fit:contain;">
            <h3 style="font-size:20px; margin:8px 0 6px;" class="text-blue-900"><b>Discover Rooms</b></h3>
            <p style="font-size:16px; color:#555; margin:0;">Browse through a variety of room types and choose the one that suits you.</p>
        </div>

        <!-- Step 3 -->
        <div style="flex:1 1 220px; display:flex; flex-direction:column; align-items:center;">
            <img src="/images/price.png" alt="Best Prices" style="width:120px; height:120px; object-fit:contain;">
            <h3 style="font-size:20px; margin:8px 0 6px;" class="text-blue-900"><b>Best Prices</b></h3>
            <p style="font-size:16px; color:#555; margin:0;">Compare prices and book your perfect stay with confidence.</p>
        </div>

    </div>
</section>

<!-- Random Rooms Section -->
<section style="width:95%; max-width:1200px; margin:0 auto; padding-top:40px; padding-bottom:40px;">
    <h2 style="margin-bottom:20px; font-size:28px;" class="text-blue-900">
        <b>Explore Rooms</b>
    </h2>

    <div class="rooms-slider">
        <div class="rooms-track">
            @foreach($roomTypes as $room)
            <a href="/rooms/{{ $room->id }}">
                <div class="room-card">
                    <img src="{{ $room->image_url ?? 'https://via.placeholder.com/280x160' }}" alt="{{ $room->name }}">
                    <div class="room-content">
                        <h4 class="price"><b>{{ $room->price_per_night }}$</b> / night</h4>
                         <p><b class="text-blue-900">Type: </b>{{ $room->type }}</p>
                        <p><b class="text-blue-900">Hotel: </b>{{$room->hotel->name}}</p>
                    </div>
                </div>
            </a>
            @endforeach
            @foreach($roomTypes as $room)
                <a href="/rooms/{{ $room->id }}" >

                <div class="room-card">
                    <img src="{{ $room->image_url ?? 'https://via.placeholder.com/280x160' }}">
                    <div class="room-content">
                        <h4 class="price"><b>{{ $room->price_per_night }}$</b> / night</h4>
                        <p>{{ $room->type }}</p>
                        <p>{{$room->hotel->name}}</p>
                    </div>
                </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

@endsection


<style>
    .rooms-slider {
    overflow: hidden;
    width: 100%;
}

.rooms-track {
    display: flex;
    gap: 25px;
    animation: scroll-left 20s linear infinite;
}

/* Stop animation on hover */
.rooms-slider:hover .rooms-track {
    animation-play-state: paused;
}

@keyframes scroll-left {
    from {
        transform: translateX(0);
    }
    to {
        transform: translateX(-50%);
    }
}

.room-card {
    flex: 0 0 auto;
    width: 280px;
    height: 300px;
    border: 1px solid #ddd;
    border-radius: 12px;
    overflow: hidden;
    justify-content: space-between;
    background-color: white;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.room-card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
}

.room-content {
    padding: 15px;
}

.price {
    font-size: 18px;
    color: #22c55e;
    margin-bottom: 8px;
}

.btn-view {
    display: inline-block;
    padding: 8px 15px;
    background-color: #0a1f44;
    color: white;
    text-decoration: none;
    border-radius: 6px;
}

</style>