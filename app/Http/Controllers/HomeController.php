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
        ->filter(fn($hotel) => $hotel->average_rating > 4) 
        ->sortByDesc('average_rating') 
        ->values(); 
        $rooms = RoomType::inRandomOrder()->limit(6)->get();
        return view('homepage', compact('hotels', 'rooms'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $hotel_name = Hotel::where('name', 'like', "%{$query}%")->get();
        $hotel_location=Hotel::where('location', 'like', "%{$query}%")->get();
        // Search rooms by name
        

        return view('home', compact('hotels', 'rooms'));
    }
}
