<?php

use App\Http\Controllers\PromoCodeController;
use App\Http\Middleware\HotelAdminMiddleware;
use Illuminate\Support\Facades\Route;

use function Pest\Laravel\get;

Route::prefix('hotelAdmin/promocodes')
    ->middleware([HotelAdminMiddleware::class])
    ->controller(PromoCodeController::class)
    ->group(function () {
        // READ ALL
        Route::get('/', 'index')->name('hotelAdmin.promocode.index');
        // CREATE
        Route::post('/create', 'store')->name('hotelAdmin.promocode.store');
        // UPDATE
        Route::put('/{promoCode}', 'update')->name('hotelAdmin.promocode.update');
        // DELETE
        Route::delete('/{promoCode}', 'destroy')->name('hotelAdmin.promocode.destroy');
        // ACTIVATE
        Route::patch('/{promoCode}/activate', 'activate')->name('hotelAdmin.promocode.activate');
        // DEACTIVATE
        Route::patch('/{promoCode}/deactivate', 'deactivate')->name('hotelAdmin.promocode.deactivate');
    });