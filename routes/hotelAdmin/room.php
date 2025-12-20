<?php
    use App\Http\Controllers\RoomController;
    use App\Http\Middleware\HotelAdminMiddleware;
    use Illuminate\Support\Facades\Route;

    Route::prefix('hotelAdmin/roomTypes/{roomType}/rooms')
    ->middleware(['auth',HotelAdminMiddleware::class])
    ->controller(RoomController::class)
    ->group(function () {
        Route::get('/', 'index')->name('hotelAdmin.room.index');
        Route::post('/create', 'store')->name('hotelAdmin.room.store');
        Route::put('{room}/edit', 'update')->name('hotelAdmin.room.update');
        Route::delete('{room}/delete', 'destroy')->name('hotelAdmin.room.delete');
    });
?>