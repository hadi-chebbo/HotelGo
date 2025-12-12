<?php


use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::prefix('hotel')->controller(HotelController::class)->group(function () {
    Route::get('/index' , 'index');
    Route::get('/{hotel}/show', 'show');
});


require __DIR__.'/auth.php';
require __DIR__.'/systemAdmin/hotel.php';
require __DIR__.'/systemAdmin/user.php';
