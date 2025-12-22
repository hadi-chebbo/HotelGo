<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\SearchController;
use App\Http\Middleware\CheckIfBlocked;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified',CheckIfBlocked::class])->name('dashboard');

Route::middleware(['auth',CheckIfBlocked::class])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::prefix('hotel')->controller(HotelController::class)->middleware([CheckIfBlocked::class])->group(function () {
    Route::get('/index' , 'index');
    Route::get('/{hotel}/show', 'show');
});
Route::get('/', [HomeController::class, 'topRatedHotels'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');


require __DIR__.'/auth.php';
require __DIR__.'/systemAdmin/hotel.php';
require __DIR__.'/systemAdmin/user.php';
require __DIR__.'/hotelAdmin/roomType.php';
require __DIR__.'/hotelAdmin/promocode.php';
require __DIR__.'/hotelAdmin/room.php';
require __DIR__.'/hotelAdmin/reservation.php';
require __DIR__. '/systemAdmin/analytics.php';
