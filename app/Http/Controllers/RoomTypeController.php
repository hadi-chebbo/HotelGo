<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index()
    {
        $hotel = auth()->user()->hotel;
        $roomTypes = $hotel->roomTypes;
        return view('room_types.index', compact('roomTypes')); 
    }

    public function store(Request $request)
    {
        $hotel = auth()->user()->hotel;

        $validated =$request->validate([
                'type' => 'required|string|unique:room_types,type,NULL,id,hotel_id,' . $hotel->id,
                'description' => 'string|max:255',
                'capacity' => 'required|integer|min:1',
                'price_per_night' => 'required|numeric|min:0',
                'image' => 'image|max:2048',
            ]);
        $validated['image'] = $request->file('image')->store('room-types', 'public');

        $roomType = $hotel->roomTypes()->create($validated);

        return redirect()->route('room-types.index')->with('success', 'Room type created successfully!');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();
        return redirect()->route('room-types.index')->with('success', 'Room type deleted successfully');
    }

    public function update(Request $request, RoomType $roomType)
    {
        $hotel = auth()->user()->hotel;

        $validated = $request->validate([
            'type' => 'required|string|unique:room_types,type,' . $roomType->id . ',id,hotel_id,' . $hotel->id,
            'description' => 'string|max:255',
            'capacity' => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'image' => 'image|max:2048',
        ]);

        $validated['image'] = $request->file('image')->store('room-types', 'public');
        

        $roomType->update($validated);

        return redirect()->route('room-types.index')->with('success', 'Room type updated successfully!');
    }

}