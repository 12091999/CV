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

    // Pengelolaan item katalog (terhubung ke unit bisnis yang dipilih).
    Route::get('/business-catalog/items/create', [BusinessCatalogController::class, 'create'])
        ->name('business-catalog.items.create');
    Route::post('/business-catalog/items', [BusinessCatalogController::class, 'store'])
        ->name('business-catalog.items.store');
    Route::get('/business-catalog/items/{businessItem}/edit', [BusinessCatalogController::class, 'edit'])
        ->name('business-catalog.items.edit');
    Route::put('/business-catalog/items/{businessItem}', [BusinessCatalogController::class, 'update'])
        ->name('business-catalog.items.update');
    Route::delete('/business-catalog/items/{businessItem}', [BusinessCatalogController::class, 'destroy'])
        ->name('business-catalog.items.destroy');

    Route::get('/business/{slug}', [BusinessCatalogController::class, 'show'])
        ->name('business-catalog.show');

    Route::resource('bookings', BookingController::class);

    Route::get('/transactions/history', [TransactionController::class, 'history'])
        ->name('transactions.history');

    Route::resource('transactions', TransactionController::class);

});
