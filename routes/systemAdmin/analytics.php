<?php
    use App\Http\Controllers\HotelController;
    use App\Http\Middleware\SystemAdminMiddleware;
    use Illuminate\Support\Facades\Route;

    Route::prefix('admin')->controller(HotelController::class)->group(function () {
                Route::middleware([SystemAdminMiddleware::class])->group(function () {
                    Route::get('/Analytics','dashboard')->name('admin.dashboard.index');
            
        });
    });

?>