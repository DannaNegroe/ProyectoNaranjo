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
        return view('houses');
    })->name('dashboard');

    Route::get('/clusters', function () {
        return view('clusters');
    })->name('clusters');

    Route::get('/residents', function () {
        return view('residents');
    })->name('residents');

    Route::get('/guards', function () {
        return view('guards');
    })->name('guards');

    Route::get('/residential-area', function () {
        return view('residential-area');
    })->name('residential-area');

    Route::get('/visitor-record', function () {
        return view('visitor-record');
    })->name('visitor-record');

});
