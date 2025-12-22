<?php
    use App\Http\Controllers\RoomTypeController;
    use App\Http\Middleware\HotelAdminMiddleware;
    use Illuminate\Support\Facades\Route;

    Route::prefix('hotelAdmin/roomTypes')->controller(RoomTypeController::class)->group(function () {
        Route::middleware(['auth',HotelAdminMiddleware::class])->group(function () {
            Route::get('/', 'index')->name('hotelAdmin.room_types.index');
            Route::post('/create', 'store')->name('hotelAdmin.room_types.store');
            Route::put('{roomType}/edit','update')->name('hotelAdmin.room_types.update');
            Route::delete('{roomType}/delete' , 'destroy')->name('hotelAdmin.room_types.delete');
             Route::get('/dashboard', [RoomTypeController::class, 'dashboard'])
        ->name('admin.dashboard');
        });
    });
?>