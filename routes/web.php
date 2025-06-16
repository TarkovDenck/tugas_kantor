<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dasboard');
})->name('dashboard');

Route::get('/request', function () {
    return view('pages/request');
})->name('dashboard');