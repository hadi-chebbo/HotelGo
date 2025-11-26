<?php  

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\User;

class HotelController extends Controller 
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:25',
            'description'=> 'nullable|string',
            'email' => 'required|email|max:100',
            'location' => 'required|string',
            'social_links' => 'required',
            'image' => 'nullable|image',
            'admin_phone' => 'required|string|max:10',
        ]);

        // 1) Create hotel admin
        $admin = User::create([
            'name' => $validated['name'] . " Admin",
            'email'=> strtolower($validated['name']) . "@hotel.com",
            'password' => bcrypt($validated['name'] . "_password"),
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

        return response()->json([
            'message' => 'Hotel and hotel admin created successfully',
        ]);
    }

    public function destroy(Hotel $hotel){
        $hotel_delete = Hotel::findOrFail($hotel->id);

        $hotel_delete->user()->delete();

        $hotel_delete->delete();

        return response()->json([
            'message' => 'hotel deleted successfully',
        ]);   
    }

   public function index()
    {
        $hotels = Hotel::all();

        return response()->json([
            'status' => 'success',
            'count' => $hotels->count(),
            'data' => $hotels
        ]);
    }

    public function show(Hotel $hotel){
        $hotel_find = Hotel::findOrFail($hotel->id);
        return response()->json([
            'status' => 'success',
            'data' => $hotel_find,
        ]);
    }
}
