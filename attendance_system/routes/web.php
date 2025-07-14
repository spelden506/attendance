<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return '<h1>About Us Page</h1>';
})->name('about');

// ADD THIS NEW ROUTE FOR CONTACT
Route::get('/contact', function () {
    return '<h1>Contact Us Page</h1>';
})->name('contact');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});