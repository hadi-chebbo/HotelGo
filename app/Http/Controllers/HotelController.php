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
            'email'=> strtolower((str_replace(' ', '', $validated['name']))) . "@hotel.com",
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

        return redirect()->back()->with('success', 'Hotel created successfully');
    }

    public function update(Request $request, Hotel $hotel)
    {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description'=> 'nullable|string',
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


    public function destroy(Hotel $hotel){

        $hotel->delete();
        //deletine the hotel and the associated user because of cascade
        return redirect()->back()->with('success', 'Hotel deleted successfully'); 
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

    public function adminIndex(){
        $hotels = Hotel::with('user')->get();

        return view('systemAdmin.hotels.index')->with('hotels', $hotels);
    }


    public function show(Hotel $hotel){
        return response()->json([
            'status' => 'success',
            'data' => $hotel,
        ]);
    }
}
