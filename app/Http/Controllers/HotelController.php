<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Review;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    // ************************* */
    // functions for system administrator
    // ************************* */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:25',
            'description' => 'nullable|string',
            'email' => 'required|email|max:100',
            'location' => 'required|string',
            'social_links' => 'required',
            'image' => 'nullable|image',
            'admin_phone' => 'required|string|max:10',
        ]);

        // 1) Create hotel admin
        $admin = User::create([
            'name' => $validated['name'].' Admin',
            'email' => strtolower((str_replace(' ', '', $validated['name']))).'@hotel.com',
            'password' => bcrypt($validated['name'].'_password'),
            'phone' => $validated['admin_phone'],
            'role' => 2,
        ]);

        // 2) Handle image if exists
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hotels', 'public');
            $validated['image'] = $path;
        }

        // 3) Remove admin_phone before creating hotel
        unset($validated['admin_phone']);

        // 4) Create hotel linked to the admin user
        $hotel = $admin->hotel()->create($validated);

        return redirect()->back()->with('success', 'Hotel created successfully');
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'email' => 'required|email|max:100',
            'location' => 'required|string',
            'social_links' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'image' => 'nullable|image',
            'admin_phone' => 'required|string|max:15',
        ]);

        // Handle image if uploaded
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotels', 'public');
            $validated['image'] = $imagePath;
        }

        // Convert social_links string (from textarea) to array or JSON
        if (isset($validated['social_links'])) {
            $links = array_filter(array_map('trim', explode("\n", $validated['social_links'])));
            $validated['social_links'] = $links;
        }

        $hotel->update($validated);

        return redirect()->back()->with('success', 'Hotel updated successfully');
    }

    public function destroy(Hotel $hotel)
    {

        $hotel->delete();

        // deletine the hotel and the associated user because of cascade
        return redirect()->back()->with('success', 'Hotel deleted successfully');
    }

    public function adminIndex()
    {
        $hotels = Hotel::with('user')->get();

        return view('systemAdmin.hotels.index')->with('hotels', $hotels);
    }

    // ************************* */
    // functions for normal user
    // ************************* */

    public function show(Hotel $hotel)
    {
        // gathring available room types
        $availableRoomTypes = $hotel->roomTypes()
            ->withCount(['rooms as available_rooms_count' => function ($query) {
                $query->where('status', 'available');
            }])
            ->having('available_rooms_count', '>', 0)
            ->get();

        // collecting hotel reviews
        $reviews = $hotel->reviews()->with('user')->get();

        if (auth()->check()) {
            $reviews = $reviews->sortByDesc(function ($review) {
                return $review->user_id === auth()->id() ? 1 : 0;
            })->values(); // ->values() resets the keys
        }
        // checking if the user can write a review (rules:had a reservation and didnt make a review before)
        if (auth()->check()) {
            // user
            $canReview = auth()->user()->can('create', [Review::class, $hotel]);
        } else {
            // guest
            $canReview = false;
        }

        return view('components.hotel-card')->with([
            'hotel' => $hotel,
            'roomTypes' => $availableRoomTypes,
            'reviews' => $reviews,
            'canReview' => $canReview,
        ]);

    }

    
    public function dashboard()
    {
        // All hotels
        $hotels = Hotel::with('reviews')->get();

        // Calculate average rating per hotel
        $hotels = $hotels->map(function ($hotel) {
            $hotel->average_rating = $hotel->reviews->avg('rating');
            return $hotel;
        });

        // Metrics for cards
        $averageRating = $hotels->avg('average_rating');
        $totalHotels = $hotels->count();
        $totalReviews = Review::count();

        return view('systemAdmin.dashboard.index', compact(
            'hotels',
            'averageRating',
            'totalHotels',
            'totalReviews'
        ));
    }
}
