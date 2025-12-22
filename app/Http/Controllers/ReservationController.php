<?php

namespace App\Http\Controllers;

use App\Mail\ReservationCancel;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

        return redirect()->back()->with('success', 'reservation from ' . $check_in_date . ' to ' . $check_out_date . ' for the room ' . $room_number . ' deleted successfully');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|min:8|max:20',
            'room_number' => 'required|integer',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'payment_method' => 'required',
        ]);

        try {
            DB::beginTransaction();

            // Guest creation
            $guest = Guest::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
            ]);

            // Hotel for this hotel admin
            $hotel = Auth::user()->hotel;

            // Room from the room_number in this hotel
            $room = Room::where('room_number', $validated['room_number'])
                ->where('hotel_id', $hotel->id)
                ->firstOrFail();

            if ($room->status !== 'available') {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['room_number' => 'Room ' . $validated['room_number'] . ' is not available. Current status: ' . $room->status]);
            }

            // Check for date conflicts with existing reservations
            $hasConflict = Reservation::where('room_id', $room->id)
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('check_in_date', [$validated['check_in_date'], $validated['check_out_date']])
                        ->orWhereBetween('check_out_date', [$validated['check_in_date'], $validated['check_out_date']])
                        ->orWhere(function ($q) use ($validated) {
                            $q->where('check_in_date', '<=', $validated['check_in_date'])
                                ->where('check_out_date', '>=', $validated['check_out_date']);
                        });
                })
                ->whereNotIn('status', ['cancelled', 'checked_out'])
                ->exists();

            if ($hasConflict) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['check_in_date' => 'Room ' . $validated['room_number'] . ' is already booked for the selected dates.']);
            }

            $roomType = $room->roomType;

            // Calculating number of days
            $checkIn = Carbon::parse($validated['check_in_date']);
            $checkOut = Carbon::parse($validated['check_out_date']);
            $nbrofdays = $checkIn->diffInDays($checkOut);
            $price = $roomType->price_per_night;

            // Creation of a reservation
            $reservation = $guest->reservations()->create([
                'user_id' => Auth::id(),
                'room_id' => $room->id,
                'hotel_id' => $hotel->id,
                'check_in_date' => $validated['check_in_date'],
                'check_out_date' => $validated['check_out_date'],
                'total_price' => $price * $nbrofdays,
            ]);

            $deposit = $price * $nbrofdays * 0.25;

            // Create payment
            $payment = $reservation->payments()->create([
                'amount' => $deposit,
                'method' => $validated['payment_method'],
                'status' => 'Confirmed',
                'transaction_date' => now(),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'reservation from ' . $validated['check_in_date'] . ' to ' . $validated['check_out_date'] . ' for the room ' . $validated['room_number'] . ' created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create reservation: ' . $e->getMessage()]);
        }
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

        try {
            DB::beginTransaction();

            // Get the hotel for this hotel admin
            $hotel = Auth::user()->hotel;

            // Find the room from the room_number in this hotel
            $room = Room::where('room_number', $validated['room_number'])
                ->where('hotel_id', $hotel->id)
                ->firstOrFail();

            // Check if room is available (only if changing to a different room)
            if ($room->id !== $reservation->room_id && $room->status !== 'available') {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['room_number' => 'Room ' . $validated['room_number'] . ' is not available. Current status: ' . $room->status]);
            }

            // Check for date conflicts with existing reservations (excluding current reservation)
            $hasConflict = Reservation::where('room_id', $room->id)
                ->where('id', '!=', $reservation->id)
                ->where(function ($query) use ($validated) {
                    $query->whereBetween('check_in_date', [$validated['check_in_date'], $validated['check_out_date']])
                        ->orWhereBetween('check_out_date', [$validated['check_in_date'], $validated['check_out_date']])
                        ->orWhere(function ($q) use ($validated) {
                            $q->where('check_in_date', '<=', $validated['check_in_date'])
                                ->where('check_out_date', '>=', $validated['check_out_date']);
                        });
                })
                ->whereNotIn('status', ['cancelled', 'checked_out'])
                ->exists();

            if ($hasConflict) {
                DB::rollBack();
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['check_in_date' => 'Room ' . $validated['room_number'] . ' is already booked for the selected dates.']);
            }

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

            $payment = $reservation->payments()->latest()->first();

            if ($payment) {
                $payment->update([
                    'amount' => $deposit,
                    'method' => $validated['payment_method'],
                ]);
            } else {
                // Create a new payment if none exists
                $reservation->payments()->create([
                    'amount' => $deposit,
                    'method' => $validated['payment_method'],
                    'status' => 'Confirmed',
                    'transaction_date' => now(),
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Reservation updated successfully for room ' . $room->room_number);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update reservation: ' . $e->getMessage()]);
        }
    }

    public function myReservations()
    {
        $reservations = Auth::user()
            ->reservations
            ->sortByDesc('created_at');

        return view('reservations', compact('reservations'));
    }


    public function cancelReservation(Reservation $reservation)
    {
        
        if ($reservation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        if ($reservation->status === 'cancelled') {
            return back()->with('error', 'This reservation is already cancelled.');
        }
        $reservation->update([
            'status' => 'cancelled',
        ]);

        // Send email to the hotel (assuming reservation has hotel relationship and hotel has email)
        if ($reservation->hotel && $reservation->hotel->email) {
            Mail::to($reservation->hotel->email)->send(new ReservationCancel($reservation));
        }

        return back()->with('success', 'Reservation cancelled successfully.');
    }
}
