@extends('layouts.front')

@section('title', 'Home')

@section('content')
    <!-- Top-Rated Hotels Section -->
<section style="padding:30px 20px;">
    <h2 style="margin-bottom:20px; font-size:28px;" class="text-blue-900"><b>Top-Rated Hotels</b></h2>
    <div style="display:flex; overflow-x:auto; gap:30px; padding-bottom:10px;">
        @foreach($hotels as $hotel)
            <div style="flex: 0 0 auto; width:350px; border:1px solid #ddd; border-radius:12px; overflow:hidden; background-color:white; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <img src="{{ $hotel->image_url ?? 'https://via.placeholder.com/350x200' }}" alt="{{ $hotel->name }}" style="width:100%; height:200px; object-fit:cover;">
                <div style="padding:15px;">
                    <h3 class="text-blue-700 mb-2 text-[20px]"><b>{{ $hotel->name }}</b></h3>
                    <p style="margin:0 0 10px 0; font-size:16px;">Average Rating: {{ number_format($hotel->average_rating, 1) }}</p>
                    <p style="margin:0 0 10px 0; font-size:16px;">Location: {{ $hotel->location }}</p>
                    <a href="/hotels/{{ $hotel->id }}" style="display:inline-block; padding:8px 15px; background-color:#0a1f44; color:white; text-decoration:none; border-radius:6px;">View Hotel</a>
                </div>
            </div>
        @endforeach
    </div>
</section>

<!-- Random Rooms Section -->
<section style="padding:30px 20px; margin-top:40px;">
    <h2 style="margin-bottom:20px; font-size:28px;" class="text-blue-900"><b>Explore Rooms</b></h2>
    <div style="display:flex; overflow-x:auto; gap:25px; padding-bottom:10px;">
        @foreach($rooms as $room)
            <div style="flex: 0 0 auto; width:280px; border:1px solid #ddd; border-radius:12px; overflow:hidden; background-color:white; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                <img src="{{ $room->image_url ?? 'https://via.placeholder.com/280x160' }}" alt="{{ $room->name }}" style="width:100%; height:160px; object-fit:cover;">
                <div style="padding:15px;">
                    <h4 style="margin-bottom:8px; font-size:18px;" class="text-green-500"><b>{{ $room->price_per_night }}$ </b>/night</h4>
                    <p style="margin:0 0 10px 0; font-size:16px;">{{ $room->type}}</p>
                    <a href="/rooms/{{ $room->id }}" style="display:inline-block; padding:8px 15px; background-color:#0a1f44; color:white; text-decoration:none; border-radius:6px;">View Room</a>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection
