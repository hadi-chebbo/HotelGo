<?php
    use App\Http\Controllers\ReservationController;
    use App\Http\Middleware\HotelAdminMiddleware;
    use Illuminate\Support\Facades\Route;

    Route::prefix('hotelAdmin/reservations')
    ->middleware(['auth',HotelAdminMiddleware::class])
    ->controller(ReservationController::class)
    ->group(function () {
        Route::get('/', 'index')->name('hotelAdmin.reservation.index');
        Route::post('/create', 'store')->name('hotelAdmin.reservation.store');
        Route::post('{reservation}/complete', 'completePayment')->name('hotelAdmin.reservation.completePayment');
        Route::put('{reservation}/edit', 'update')->name('hotelAdmin.reservation.update');
        Route::delete('{reservation}/delete', 'destroy')->name('hotelAdmin.reservation.delete');
    });
?>