<?php
    use App\Http\Controllers\HotelController;
    use App\Http\Middleware\SystemAdminMiddleware;

    Route::prefix('system')->controller(HotelController::class)->group(function () {
            Route::prefix('hotel')->group(function() {
                Route::middleware([SystemAdminMiddleware::class])->group(function () {
                    Route::get('/index', 'adminIndex');
                    Route::post('/create', 'store');
                    Route::post('{hotel}/edit','update');
                    Route::delete('{hotel}/delete' , 'destroy');
            });
        });
    });