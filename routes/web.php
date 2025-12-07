<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Middleware\SystemAdminMiddleware;

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

    Route::middleware([SystemAdminMiddleware::class])->group(function () {
        Route::post('/create','store');
        Route::delete('/{hotel}/delete', 'destroy');
    });
});

Route::prefix('admin/users')
    ->middleware([SystemAdminMiddleware::class])
    ->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
        Route::post('/{user}/block', [UserController::class, 'block'])->name('admin.users.block');
        Route::post('/{user}/unblock', [UserController::class, 'unblock'])->name('admin.users.unblock');
        Route::put('/{user}', [UserController::class, 'update'])->name('admin.users.update');
});



require __DIR__.'/auth.php';
