<?php
    use App\Http\Controllers\HotelController;
    use App\Http\Middleware\SystemAdminMiddleware;
    use Illuminate\Support\Facades\Route;

    Route::prefix('admin')->controller(HotelController::class)->group(function () {
            Route::prefix('hotels')->group(function() {
                Route::middleware([SystemAdminMiddleware::class])->group(function () {
                    Route::get('/', 'adminIndex')->name('admin.hotel.index');
                    Route::post('/create', 'store')->name('admin.hotel.store');
                    Route::put('{hotel}/edit','update')->name('admin.hotel.update');
                    Route::delete('{hotel}/delete' , 'destroy')->name('admin.hotel.delete');
            });
        });
    });

?>