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
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/attendance', function () {
        return view('attendance');
    })->name('attendance');

    Route::get('/employees', function () {
        return view('employees');
    })->name('employees');

    Route::get('/reports', function () {
        return view('reports');
    })->name('reports');