<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'price_per_night' => 'required|numeric',
            'status' => 'required|string',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('rooms', 'public');
            $validated['image'] = $path;
        }

        Room::create($validated);

        return response()->json([
            'message' => 'Room created successfully',
        ]);
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'price_per_night' => 'required|numeric',
            'status' => 'required|string',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('rooms', 'public');
            $validated['image'] = $path;
        }

        $room->update($validated);

        return response()->json([
            'message' => 'Room updated successfully',
        ]);
    }

    public function show(Room $room)
    {
        return view('Room', ['room' => $room]);
    }

    public function index()
    {
        $hotels = Room::all();
        return view('HotelAdmin', compact('hotels'));
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json([
            'message' => 'Room deleted successfully!',
        ]);
    }
}
