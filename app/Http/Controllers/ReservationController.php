<?php

namespace App\Http\Controllers;

use App\Mail\ReservationCancel;
use App\Models\Guest;
use App\Models\PromoCode;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    // ************************ */
    // methods for hotel admin
    // ************************ */
    public function index()
    {
        $hotel = Auth::user()->hotel;

        $reservationsOnline = $hotel->reservations()
            ->where('user_id', '!=', Auth::id())
            ->with('payments')
            ->get();

        $reservationsWalkIn = $hotel->reservations()
            ->where('user_id', Auth::id())
            ->with('payments')
            ->get();

        $reservationsNotFullyPaid = [];
        $reservationsFullyPaid = [];
        $reservationsWalkInNotFullyPaid = [];
        $reservationsWalkInFullyPaid = [];

        foreach ($reservationsOnline as $reservation) {
            if ($reservation->payments->sum('amount') < $reservation->total_price) {
                $reservationsNotFullyPaid[] = $reservation;
            } else {
                $reservationsFullyPaid[] = $reservation;
            }
        }
        foreach ($reservationsWalkIn as $reservation) {
            if ($reservation->payments->sum('amount') < $reservation->total_price) {
                $reservationsWalkInNotFullyPaid[] = $reservation;
            } else {
                $reservationsWalkInFullyPaid[] = $reservation;
            }
        }

        return view(
            'hotelAdmin.reservation.index',
            compact('reservationsFullyPaid', 'reservationsNotFullyPaid', 'reservationsWalkInNotFullyPaid','reservationsWalkInFullyPaid')
        );
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
                    ->withErrors(['room_number' => 'Room '.$validated['room_number'].' is not available. Current status: '.$room->status]);
            }

            // Check for date conflicts - REFACTORED
            if ($this->hasDateConflict($room->id, $validated['check_in_date'], $validated['check_out_date'])) {
                DB::rollBack();

                return redirect()->back()
                    ->withInput()
                    ->withErrors(['check_in_date' => 'Room '.$validated['room_number'].' is already booked for the selected dates.']);
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

            return redirect()->back()->with('success', 'reservation from '.$validated['check_in_date'].' to '.$validated['check_out_date'].' for the room '.$validated['room_number'].' created successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to create reservation: '.$e->getMessage()]);
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
                    ->withErrors(['room_number' => 'Room '.$validated['room_number'].' is not available. Current status: '.$room->status]);
            }

            // Check for date conflicts - REFACTORED (exclude current reservation)
            if ($this->hasDateConflict($room->id, $validated['check_in_date'], $validated['check_out_date'], $reservation->id)) {
                DB::rollBack();

                return redirect()->back()
                    ->withInput()
                    ->withErrors(['check_in_date' => 'Room '.$validated['room_number'].' is already booked for the selected dates.']);
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

            return redirect()->back()->with('success', 'Reservation updated successfully for room '.$room->room_number);
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update reservation: '.$e->getMessage()]);
        }
    }

    public function completePayment(Reservation $reservation)
    {
        $payments = $reservation->payments;
        $paid_amount = $payments->sum('amount');

        $complete_amount = $reservation->total_price - $paid_amount;

        $payment = $reservation->payments()->create([
            'amount' => $complete_amount,
            'method' => 'cash',
            'status' => 'confirmed',
            'transaction_date' => now(),
        ]);

        return redirect()->back()->with('success','Reservation for guest '.$reservation->user->name.'is fully paid');
    }
    // ************************** */
    // methods for normal user
    // ************************** */

    public function previewReservation(Request $request, RoomType $roomType)
    {
        try {
            $validated = $request->validate([
                'check_in_date' => 'required|date|after_or_equal:today',
                'check_out_date' => 'required|date|after:check_in_date',
                'promo_code' => 'nullable|string',
                'loyalty' => 'required|boolean',
            ]);

            $room = $roomType->rooms()
                ->where('status', 'available')
                ->whereDoesntHave('reservations', function ($query) use ($validated) {
                    $query->where(function ($q) use ($validated) {
                        $q->where('check_in_date', '<', $validated['check_out_date'])
                            ->where('check_out_date', '>', $validated['check_in_date']);
                    })
                        ->whereNotIn('status', ['cancelled', 'checked_out']);
                })
                ->first();

            if (! $room) {
                return response()->json(['error' => 'No available room for these dates.'], 422);
            }

            $promoCode = ! empty($validated['promo_code'])
                ? PromoCode::where('code', $validated['promo_code'])
                    ->where('hotel_id', $roomType->hotel_id)
                    ->first()
                : null;

            $result = $this->calculatePrice($roomType, $validated['check_in_date'], $validated['check_out_date'], $promoCode, $validated['loyalty']);

            return response()->json($result);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong: '.$e->getMessage()], 500);
        }
    }

    public function userStore(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'payment_method' => 'required',
            'promo_code' => 'nullable|string',
            'loyalty' => 'required|boolean',
            'card_number' => 'required|string|digits_between:13,19',
            'card_holder' => 'required|string|max:255',
            'expiry_date' => 'required|string',
            'cvv' => 'required|string|size:3',
        ]);

        $room = $roomType->rooms()
            ->where('status', 'available')
            ->whereDoesntHave('reservations', function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    $q->where('check_in_date', '<', $validated['check_out_date'])
                        ->where('check_out_date', '>', $validated['check_in_date']);
                });
            })
            ->first();

        if (! $room) {
            return response()->json(['error' => 'No available room for selected dates.'], 422);
        }

        $promoCode = ! empty($validated['promo_code'])
            ? PromoCode::where('code', $validated['promo_code'])
                ->where('hotel_id', $roomType->hotel_id)
                ->first()
            : null;

        $hotel = $roomType->hotel;
        $result = $this->calculatePrice($roomType, $validated['check_in_date'], $validated['check_out_date'], $promoCode, $validated['loyalty']);

        try {
            DB::beginTransaction();

            $reservation = Auth::user()->reservations()->create([
                'room_id' => $room->id,
                'hotel_id' => $hotel->id,
                'promo_code_id' => $promoCode ? $promoCode->id : null,
                'check_in_date' => $validated['check_in_date'],
                'check_out_date' => $validated['check_out_date'],
                'total_price' => $result['total_price'],
                'status' => 'confirmed',
            ]);

            $payment = $reservation->payments()->create([
                'amount' => $result['deposit'],
                'method' => $validated['payment_method'],
                'status' => 'confirmed',
                'transaction_date' => now(),
            ]);

            if ($validated['loyalty'] && Auth::user()->loyalty_points >= 500) {
                Auth::user()->decrement('loyalty_points', 500);
            }

            Auth::user()->increment('loyalty_points', round($result['total_price'] * 0.05));

            // deduce loyalty points if used

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Reservation confirmed successfully!',
                'reservation_id' => $reservation->id,
            ]);

        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => 'Reservation failed: '.$e->getMessage()], 500);
        }
    }

    public function getUnavailableDates(RoomType $roomType)
    {
        // Get all reservations for all rooms of this type
        $reservations = Reservation::whereHas('room', function ($query) use ($roomType) {
            $query->where('room_type_id', $roomType->id);
        })
            ->where('status', '!=', 'cancelled')
            ->where('check_out_date', '>=', now()->format('Y-m-d'))
            ->get(['check_in_date', 'check_out_date']);

        $unavailableDates = [];

        foreach ($reservations as $reservation) {
            $start = Carbon::parse($reservation->check_in_date);
            $end = Carbon::parse($reservation->check_out_date);

            while ($start->lessThan($end)) {
                $unavailableDates[] = $start->format('Y-m-d');
                $start->addDay();
            }
        }

        return response()->json([
            'unavailable_dates' => array_unique($unavailableDates),
        ]);
    }

    private function calculatePrice(RoomType $roomType, $checkIn, $checkOut, $promoCode, $loyalty)
    {
        $days = Carbon::parse($checkIn)->diffInDays($checkOut);
        $price = $roomType->price_per_night * $days;

        if ($promoCode) {
            $price *= (1 - $promoCode->discount_percentage / 100);
        }

        if (Auth::user()->loyalty_points >= 500 && $loyalty) {
            $price *= 0.8;
        }

        return [
            'days' => $days,
            'total_price' => round($price, 2),
            'deposit' => round($price * 0.25, 2),
        ];
    }

    /**
     * Check if a room has date conflicts with existing reservations
     *
     * @param  int  $roomId
     * @param  string  $checkInDate
     * @param  string  $checkOutDate
     * @param  int|null  $excludeReservationId  - Reservation ID to exclude from check (for updates)
     * @return bool
     */
    private function hasDateConflict($roomId, $checkInDate, $checkOutDate, $excludeReservationId = null)
    {
        $query = Reservation::where('room_id', $roomId)
            ->where(function ($query) use ($checkInDate, $checkOutDate) {
                $query->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                    ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                    ->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                        $q->where('check_in_date', '<=', $checkInDate)
                            ->where('check_out_date', '>=', $checkOutDate);
                    });
            })
            ->whereNotIn('status', ['cancelled', 'checked_out']);

        // Exclude current reservation when updating
        if ($excludeReservationId) {
            $query->where('id', '!=', $excludeReservationId);
        }

        return $query->exists();
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
