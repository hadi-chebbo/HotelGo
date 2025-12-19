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
        $promocodes = PromoCode::latest()->get();
        return view('hotelAdmin.promocodes.index', compact('promocodes'));
    }

    // CREATE
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|unique:promo_codes,code',
            'discount_percentage' => 'required|integer|min:1|max:100',
            'usage_limit' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'is_active' => 'sometimes|boolean'
        ]);

        // Default to active if not sent
        $data['is_active'] = $data['is_active'] ?? 1;
        $data['hotel_id'] = Auth::user()->hotel->id;
        $promoCode = PromoCode::create($data);

        return redirect()->back()
            ->with('success', 'The promo code "' . $promoCode->code . '" was created successfully.');
    }

    // UPDATE
    public function update(Request $request, PromoCode $promoCode)
    {
        $data = $request->validate([
            'code' => 'required|string|unique:promo_codes,code,' . $promoCode->id,
            'discount_percentage' => 'required|integer|min:1|max:100',
            'usage_limit' => 'required|integer|min:1',
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
