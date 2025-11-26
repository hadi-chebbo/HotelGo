<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;

Route::post('/hotel/store',[HotelController::class, 'store']);
Route::get('/hotel/{hotel}/show', [HotelController::class , 'show']);

Route::middleware([SystemAdminMiddleware::class])->group(function () {
    Route::get('/hotel/index',[HotelController::class , 'index']);
    Route::delete('/hotel/{hotel}/delete', [HotelController::class, 'destroy']);
});
