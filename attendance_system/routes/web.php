<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/about-us', function () {
    return view('aboutus');
})->name('about'); // This creates the name 'about'

// This is correct
Route::get('/contact-us', function () {
    return view('contactus');
})->name('contact');
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        // We will create this view in the next step
        return view('profile.edit'); 
    })->name('profile.edit'); // This .name() is the crucial part
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