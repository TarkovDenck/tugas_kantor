<?php

use Illuminate\Support\Facades\Route;

use Kreait\Laravel\Firebase\Facades\Firebase;

Route::get('/test-firebase', function () {
    try {
        $database = Firebase::database();

        // Tulis data dummy
        $database->getReference('testing')->set([
            'status' => 'Firebase berhasil terhubung 🎉',
            'timestamp' => now()->toDateTimeString()
        ]);

        // Ambil kembali datanya
        $data = $database->getReference('testing')->getValue();

        // Pastikan data dalam bentuk array
        if (!is_array($data)) {
            $data = ['value' => $data];
        }

        return response()->json([
            'message' => 'Firebase berhasil terhubung',
            'data' => $data
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Firebase GAGAL terhubung',
            'error' => $e->getMessage()
        ], 500);
    }
});




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

Route::get('/admin', function () {
    return view('pages/admin');
})->name('admindashboard');


Route::get('/log-in', function () {
    return view('login');
})->name('loginuser');
