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
})->name('request');

Route::get('/history', function () {
    return view('pages/historyreq');
})->name('history'); 

Route::get('/users', function () {
    return view('pages/users');
})->name('users');

Route::get('/change', function () {
    return view('pages/changepw');
})->name('changepassword');

Route::get('/profile', function () {
    return view('pages/profile');
})->name('profileacct');

Route::get('/profile-user', function () {
    return view('pages/admin-userprofile');
})->name('profileacctuser');
