<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function index()
    {
        $hotel = Auth::user()->hotel;
        $reservationsOnline = $hotel->reservations()->where('user_id', '!=', Auth::id())->get();
        $reservationsWalkIn = $hotel->reservations()->where('user_id', Auth::id())->get();

        return view('hotelAdmin.reservation.index', compact('reservationsOnline', 'reservationsWalkIn'));
    }

    public function destroy(Reservation $reservation)
    {
        $check_in_date = $reservation->check_in_date;
        $check_out_date = $reservation->check_out_date;
        $room_number = $reservation->room->room_number;

        $reservation->delete();

        return redirect()->back()->with('success', 'reservation from '.$check_in_date.' to '.$check_out_date.' for the room '.$room_number.' deleted successfully');

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'room_number' => 'required',
            'check_in_date' => 'required',
            'check_out_date' => 'required',
            'payment_method' => 'required',
        ]);
        // guest creation
        $guest = Guest::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);
        // hotel for this hotel admin
        $hotel = Auth::user()->hotel;

        // room from the room_number in this hotel
        $room = Room::where('room_number', $validated['room_number'])
            ->where('hotel_id', $hotel->id)
            ->firstOrFail();
        $roomType = $room->roomType;
        // calculating number of days
        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);

        $nbrofdays = $checkIn->diffInDays($checkOut);
        $price = $roomType->price_per_night;
        // creation of a reservation
        $reservation = $guest->reservations()->create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'hotel_id' => $hotel->id,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'total_price' => $price * $nbrofdays,
        ]);

        $deposit = $price * $nbrofdays * 0.25;

        $payment = $reservation->payments()->create([
            'amount' => $deposit,
            'method' => $validated['payment_method'],
            'status' => 'Confirmed',
            'transaction_date' => now(),
        ]);

        return redirect()->back()->with('success', 'reservation from '.$validated['check_in_date'].' to '.$validated['check_out_date'].' for the room '.$validated['room_number'].' created successfully');
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'room_number' => 'required',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'payment_method' => 'required',
        ]);

        // Get the hotel for this hotel admin
        $hotel = Auth::user()->hotel;

        // Find the room from the room_number in this hotel
        $room = Room::where('room_number', $validated['room_number'])
            ->where('hotel_id', $hotel->id)
            ->firstOrFail();

        $roomType = $room->roomType;

        // Calculate number of days
        $checkIn = Carbon::parse($validated['check_in_date']);
        $checkOut = Carbon::parse($validated['check_out_date']);
        $nbrofdays = $checkIn->diffInDays($checkOut);
        $price = $roomType->price_per_night;

        // Update guest information
        $reservation->guest->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
        ]);

        // Update reservation
        $reservation->update([
            'room_id' => $room->id,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'total_price' => $price * $nbrofdays,
        ]);

        // Update payment (deposit)
        $deposit = $price * $nbrofdays * 0.25;

        $reservation->payments()->latest()->first()->update([
            'amount' => $deposit,
            'method' => $validated['payment_method'],
        ]);

        return redirect()->back()->with('success', 'Reservation updated successfully for room '.$room->room_number);
    }
}
