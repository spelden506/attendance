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