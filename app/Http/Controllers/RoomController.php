<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index(RoomType $roomType)
    {
        $hotel = auth()->user()->hotel;
        abort_unless($roomType->hotel_id === $hotel->id, 403);

        $rooms = $roomType->rooms()->get();

        return view('hoteleAdmin.room.index')->with('rooms', $rooms);
    }

    public function store(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'floor' => 'required|integer|min:0',
            'nbrOfRooms' => 'required|integer|min:1|max:100',
            'startingRoomNbr' => 'required|integer|min:0',
        ]);
        $hotel = auth()->user()->hotel;
        abort_unless($roomType->hotel_id === $hotel->id, 403);

        

        $floor = $validated['floor'];
        $nbrOfRooms = $validated['nbrOfRooms'];
        $startingRoomNbr = $validated['startingRoomNbr'];

        $this->validateRoomNumberRange($startingRoomNbr,$nbrOfRooms,$hotel->id);

        for ($i = 0; $i < $nbrOfRooms; $i++) {
            $room = $roomType->rooms()->create([
                'room_number' => $startingRoomNbr + $i,
                'floor' => $floor,
                'status' => 'available',
                'hotel_id' => $hotel->id,
            ]);
        }

        return redirect()->back()->with('success', 'rooms created successfully');
    }

    //function to validate if the room_numbers in creation intersect with other room numbers
    private function validateRoomNumberRange($startingRoomNbr, $nbrOfRooms, $hotelId)
    {
        $endRoomNbr = $startingRoomNbr + $nbrOfRooms - 1;

        $conflictingRooms = Room::where('hotel_id', $hotelId)
            ->whereBetween('room_number', [$startingRoomNbr, $endRoomNbr])
            ->pluck('room_number')
            ->toArray();

        if (! empty($conflictingRooms)) {
            $roomList = implode(', ', $conflictingRooms);
            throw ValidationException::withMessages([
                'startingRoomNbr' => "Room numbers already exist: {$roomList}",
            ]);
        }
    }

    public function destroy(Room $room)
    {
        $hotel = auth()->user()->hotel;
        abort_unless($roomType->hotel_id === $hotel->id, 403);

        $roomNbr = $room->room_number;
        $room->delete();

        return redirect()->back()->with('success', 'room number '.$roomNbr.' was deleted successfully');
    }

    public function update(Request $request, Room $room)
    {
        $hotel = auth()->user()->hotel;
        abort_unless($room->hotel_id === $hotel->id, 403);
        $validated = $request->validate([
            'room_number' => [
                'required',
                'integer',
                'min:0',
                Rule::unique('rooms')->ignore($room->id)->where('hotel_id', $hotel->id)
            ],
            'floor' => 'required|integer|min:0',
            'status' => 'required',
        ]);

        $room->update($validated);

        return redirect()->back()->with('success', 'room updated successfully');
    }

    
}
