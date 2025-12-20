<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function topRatedHotels()
    {
        $hotels = Hotel::where('rating', '>', 4)
            ->orderByDesc('rating')
            ->get();
        $rooms = Room::inRandomOrder()->limit(6)->get();
        return view('home', compact('hotels', 'rooms'));
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
