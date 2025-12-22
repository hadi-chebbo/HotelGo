<?php
    use App\Http\Controllers\ReviewController;
    use Illuminate\Support\Facades\Route;

    Route::prefix('hotels/{hotel}/reviews')->controller(ReviewController::class)->group(function () {
                Route::middleware('auth')->group(function () {
                    Route::post('/create', 'store')->name('review.store');
                    Route::put('{review}/edit','update')->name('review.update');
                    Route::delete('{review}/delete' , 'destroy')->name('review.delete');
        });
    });

?>