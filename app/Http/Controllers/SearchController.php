<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // -------------------------
        // 1. Exact search results
        // -------------------------
        $query = RoomType::query()->with(['rooms.hotel']);

        // Search by hotel name or location
        if ($request->filled('q')) {
            $query->whereHas('rooms.hotel', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('location', 'like', '%' . $request->q . '%');
            });
        }

        // Price range (RoomType directly)
        if ($request->filled('price_from')) {
            $query->where('price_per_night', '>=', $request->price_from);
        }

        if ($request->filled('price_to')) {
            $query->where('price_per_night', '<=', $request->price_to);
        }

        // Room type filter
        if ($request->filled('room_type')) {
            $query->where('type', $request->room_type);
        }

        $searchResults = $query->paginate(9);

        // -------------------------
        // 2. Suggested rooms
        // -------------------------
        $suggestedQuery = RoomType::query()->with(['rooms.hotel'])
    ->whereNotIn('id', $searchResults->pluck('id'))
    ->where(function ($q) use ($request) {

        $q->where(function($sub) use ($request) {
            // Match hotel name/location
            if ($request->filled('q')) {
                $sub->whereHas('rooms.hotel', function($hq) use ($request) {
                    $hq->where('name', 'like', '%' . $request->q . '%')
                       ->orWhere('location', 'like', '%' . $request->q . '%');
                });
            }
        })
        ->orWhere(function($sub) use ($request) {
            // Match price range
            if ($request->filled('price_from')) {
                $sub->where('price_per_night', '>=', $request->price_from);
            }
            if ($request->filled('price_to')) {
                $sub->where('price_per_night', '<=', $request->price_to);
            }
        })
        ->orWhere(function($sub) use ($request) {
            // Match room type
            if ($request->filled('room_type')) {
                $sub->where('type', $request->room_type);
            }
        });

    });

$suggestedRooms = $suggestedQuery->take(6)->get();


        // -------------------------
        // 3. Room types for filter dropdown
        // -------------------------
        $roomTypes = RoomType::select('type')->distinct()->get();

        return view('search-results', compact(
            'searchResults',
            'suggestedRooms',
            'roomTypes'
        ));
    }
}
