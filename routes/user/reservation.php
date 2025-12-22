<?php

use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::prefix('rooms/{roomType}')->controller(ReservationController::class)->group(function () {

    Route::get('/unavailable-dates', 'getUnavailableDates')->name('reservation.unavailable-dates');
    Route::middleware('auth')->group(function () {
        // Step 1: Preview reservation (AJAX)
        Route::post('/preview', 'previewReservation')->name('reservation.preview');

        // Step 2: Store reservation
        Route::post('/create', 'userStore')->name('reservation.store');
    });
});
