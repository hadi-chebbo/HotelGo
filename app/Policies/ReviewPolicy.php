<?php

namespace App\Policies;

use App\Models\Hotel;
use App\Models\Review;
use App\Models\User;

class ReviewPolicy
{
    /**
     * Create a new policy instance.
     */
    public function create(User $user, Hotel $hotel): bool
    {
        $hasCompletedStay = $user->reservations()
            ->where('hotel_id', $hotel->id)
            ->whereDate('check_out_date', '<=', now())
            ->where('status', 'confirmed')
            ->exists();

        $hasNotReviewed = ! $hotel->reviews()
            ->where('user_id', $user->id)
            ->exists();

        return $hasCompletedStay && $hasNotReviewed;
    }

    public function update(User $user, Review $review): bool
    {
        // User can only update their own review
        return $user->id === $review->user_id;
    }

    /**
     * Determine if the user can delete the review.
     */
    public function delete(User $user, Review $review): bool
    {
        // User can delete their own review OR system admin can delete any review
        return $user->id === $review->user_id || $user->role === 0; // 0 = system admin
    }
}
