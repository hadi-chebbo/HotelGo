<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RoomTypeController extends Controller
{
    public function index()
    {
        $hotel = Auth::user()->hotel;
        $roomTypes = $hotel->roomTypes;

        return view('hotelAdmin.roomTypes.index', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $hotel = Auth::user()->hotel;

        $validated = $request->validate([
            'type' => 'required|string|unique:room_types,type,NULL,id,hotel_id,'.$hotel->id,
            'description' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $validated['image'] = $request->file('image')->store('room-types', 'public');

        $roomType = $hotel->roomTypes()->create($validated);

        return redirect()->back()->with('success', 'Room type created successfully!');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();

        return redirect()->back()->with('success', 'Room type deleted successfully');
    }

    public function update(Request $request, RoomType $roomType)
    {
        $hotel = Auth::user()->hotel;

        $validated = $request->validate([
            'type' => 'required|string|unique:room_types,type,'.$roomType->id.',id,hotel_id,'.$hotel->id,
            'description' => 'string|max:255',
            'capacity' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif,webp',
        ]);
        // Only update image if a new one is uploaded
        if ($request->hasFile('image')) {
            // Delete old image
            if ($roomType->image && Storage::disk('public')->exists($roomType->image)) {
                Storage::disk('public')->delete($roomType->image);
            }

            // Store new image
            $validated['image'] = $request->file('image')->store('room-types', 'public');
        } else {
            // keep the old image if no new image is uploaded
            $validated['image'] = $roomType->image;
        }

        $roomType->update($validated);

        return redirect()->back()->with('success', 'Room type updated successfully!');
    }
}
