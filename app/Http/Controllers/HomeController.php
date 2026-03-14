<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function topRatedHotels()
    {
        $hotels = Hotel::with('reviews') 
        ->get()
        ->map(function ($hotel) {
            // calculate average rating for all reviews of the hotel
            $reviews = $hotel->reviews;
            $hotel->average_rating = $reviews->count() ? $reviews->avg('rating') : 0;
            return $hotel;
        })
        ->filter(fn($hotel) => $hotel->average_rating >= 3.5) 
        ->sortByDesc('average_rating') 
        ->values(); 
        $roomTypes = RoomType::inRandomOrder()->limit(8)->get();
        return view('homepage', compact('hotels', 'roomTypes'));
    }

}
