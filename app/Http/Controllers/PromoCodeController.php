<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    // READ ALL
    public function index()
    {
        $promocodes = Auth::user()->hotel->promoCodes()->latest()->get();

        return view('hotelAdmin.promocodes.index', compact('promocodes'));
    }

    // CREATE
    public function store(Request $request)
    {
        $hotel = Auth::user()->hotel;
        // Check if the promo code already exists for this hotel
        if ($hotel->promoCodes()->where('code', $request->code)->exists()) {
            return redirect()->back()
                ->withErrors(['code' => 'This promo code already exists for your hotel.'])
                ->withInput();
        }
        
        $data = $request->validate([
            'code' => 'required|string',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data['start_date'] = \Carbon\Carbon::parse($data['start_date'])->format('Y-m-d');
        $data['end_date'] = \Carbon\Carbon::parse($data['end_date'])->format('Y-m-d');

        
        $data['is_active'] = $request->has('is_active');
        $promoCode = $hotel->promoCodes()->create($data);

        return redirect()->back()
            ->with('success', 'The promo code "' . $promoCode->code . '" was created successfully.');
    }

    // UPDATE
    public function update(Request $request, PromoCode $promoCode)
    {
        $hotel = Auth::user()->hotel;

        if ($hotel->promoCodes()
            ->where('code', $request->code)
            ->where('id', '!=', $promoCode->id) // exclude the one being updated
            ->exists()) {
        return redirect()->back()
            ->withErrors(['code' => 'This promo code already exists for your hotel.'])
            ->withInput();
        }
        
        $data = $request->validate([
            'code' => 'required|string',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'sometimes|boolean'
        ]);

        
        $promoCode->update($data);
        
        return redirect()->back()
            ->with('success', 'The promo code "' . $promoCode->code . '" was updated successfully.');
    }

    // DELETE
    public function destroy(PromoCode $promoCode)
    {
        $code = $promoCode->code;
        $promoCode->delete();

        return redirect()->back()
            ->with('success', 'The promo code "' . $code . '" was deleted successfully.');
    }

    // ACTIVATE
    public function activate(PromoCode $promoCode)
    {
        $promoCode->update(['is_active' => 1]);

        return redirect()->back()
            ->with('success', 'The promo code "' . $promoCode->code . '" was activated successfully.');
    }

    // DEACTIVATE
    public function deactivate(PromoCode $promoCode)
    {
        $promoCode->update(['is_active' => 0]);

        return redirect()->back()
            ->with('success', 'The promo code "' . $promoCode->code . '" was deactivated successfully.');
    }
}
