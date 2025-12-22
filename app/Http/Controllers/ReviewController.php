<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Hotel;
use App\Models\User;
use App\Policies\ReviewPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends Controller
{
    public function store(Request $request,Hotel $hotel)
    {
        $this->authorize('create',[Review::class, $hotel]);
        $validated = $request->validate([
            'comment' => 'required|string|max:255',
            'rating' => 'required|min:1|max:5|integer'
        ]);

        $review = Auth::user()->reviews()->make($validated);
        $review->hotel()->associate($hotel);
        $review->save();

        return redirect()->back()->with('success','Thank you for your review,hope we see you again!');
    }

    public function update(Request $request,Review $review){
        $this->authorize('update',$review);
        $validated = $request->validate([
            'comment' => 'required|string|max:255',
            'rating' => 'required|min:1|max:5|integer'
        ]);

        $review->update($validated);
        
        return redirect()->back()->with('success','Review updated successfully');
    }

    public function destroy(Review $review){
        $this->authorize('delete',$review);

        $review->delete();

        return redirect()->back()->with('success','Review deleted successfully');
    }
}
