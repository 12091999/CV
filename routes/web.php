<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessUnitController;
use App\Http\Controllers\BusinessCatalogController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::resource('customers', CustomerController::class);

    Route::resource('business-units', BusinessUnitController::class)
        ->except(['show']);

    Route::get('/business/{slug}', [BusinessCatalogController::class, 'show'])
        ->name('business-catalog.show');

    Route::resource('bookings', BookingController::class);
    
    Route::resource('transactions', TransactionController::class);

});
